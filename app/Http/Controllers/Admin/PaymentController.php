<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Fine;
use App\Models\User;
use App\Models\MembershipType;
use Illuminate\Http\Request;
use App\Helpers\DateHelper;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'fine', 'fine.borrow', 'membershipType']);

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('payment_id', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('transaction_id', 'LIKE', "%{$searchTerm}%")
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('fullname', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('email', 'LIKE', "%{$searchTerm}%");
                    });
            });
        }

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Type filter
        if ($request->has('type') && !empty($request->type)) {
            $query->where('payment_type', $request->type);
        }

        $payments = $query->orderBy('payment_date', 'desc')
            ->paginate(20)
            ->appends($request->except('page'));

        $stats = [
            'total' => Payment::count(),
            'completed' => Payment::completed()->count(),
            'pending' => Payment::pending()->count(),
            'total_amount' => Payment::sum('amount'),
            'fines_amount' => Payment::fines()->sum('amount'),
            'membership_amount' => Payment::membershipFees()->sum('amount'),
        ];

        return view('dashboard.admin.payments.index', compact('payments', 'stats'));
    }

    /**
     * Show the form for creating a payment.
     */
    public function create()
    {
        $users = User::whereIn('role', ['Member', 'Kid'])->get();
        $membershipTypes = MembershipType::all();

        return view('dashboard.admin.payments.create', compact('users', 'membershipTypes'));
    }

    /**
     * Store a newly created payment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'payment_type' => 'required|in:fine,membership_fee',
            'fine_id' => 'required_if:payment_type,fine|nullable|exists:fines,fine_id',
            'membership_type_id' => 'required_if:payment_type,membership_fee|nullable|exists:membership_types,membership_type_id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,online',
            'transaction_id' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        $paymentData = [
            'user_id' => $request->user_id,
            'payment_type' => $request->payment_type,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_date' => DateHelper::now(),
            'transaction_id' => $request->transaction_id,
            'notes' => $request->notes,
            'status' => 'completed',
        ];

        if ($request->payment_type === 'fine' && $request->fine_id) {
            $paymentData['fine_id'] = $request->fine_id;

            // Update the fine status to paid
            $fine = Fine::find($request->fine_id);
            if ($fine) {
                $fine->update(['status' => 'paid']);
            }
        }

        if ($request->payment_type === 'membership_fee' && $request->membership_type_id) {
            $paymentData['membership_type_id'] = $request->membership_type_id;
        }

        Payment::create($paymentData);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment recorded successfully!');
    }

    /**
     * Display the specified payment.
     */
    public function show($id)
    {
        $payment = Payment::with(['user', 'fine', 'fine.borrow', 'fine.borrow.inventory.book', 'membershipType'])
            ->findOrFail($id);
        return view('dashboard.admin.payments.show', compact('payment'));
    }

    /**
     * Update payment status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:completed,pending,failed,refunded',
        ]);

        $payment = Payment::findOrFail($id);
        $payment->update(['status' => $request->status]);

        // If status changed to refunded and it was a fine payment, revert fine status
        if ($request->status === 'refunded' && $payment->fine_id) {
            $payment->fine->update(['status' => 'unpaid']);
        }

        return redirect()->back()->with('success', 'Payment status updated successfully!');
    }

    /**
     * Get user's unpaid fines for payment creation.
     */
    public function getUserFines($userId)
    {
        $fines = Fine::unpaid()
            ->whereHas('borrow', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with('borrow.inventory.book')
            ->get()
            ->map(function ($fine) {
                // Calculate total amount for display
                $totalAmount = 0;
                if ($fine->fine_type === 'overdue') {
                    $currentDate = DateHelper::now();
                    $dueDate = $fine->borrow->due_date;
                    $daysOverdue = max(0, ceil($currentDate->diffInHours($dueDate, false) / 24 * -1));
                    $totalAmount = $daysOverdue * $fine->amount_per_day;
                } else {
                    $totalAmount = $fine->amount_per_day;
                }

                return [
                    'fine_id' => $fine->fine_id,
                    'amount_per_day' => $fine->amount_per_day,
                    'total_amount' => $totalAmount,
                    'description' => $fine->description,
                    'borrow' => [
                        'inventory' => [
                            'book' => [
                                'title' => $fine->borrow->inventory->book->title
                            ]
                        ]
                    ]
                ];
            });

        return response()->json($fines);
    }

    /**
     * Process fine payment directly from fine details
     */
    public function processFinePayment(Request $request, $fineId)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,card,online',
            'transaction_id' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        $fine = Fine::with('borrow.user', 'borrow.fines')->findOrFail($fineId);

        // Calculate total amount
        $totalAmount = 0;
        if ($fine->fine_type === 'overdue') {
            $currentDate = DateHelper::now();
            $dueDate = $fine->borrow->due_date;
            $daysOverdue = max(0, ceil($currentDate->diffInHours($dueDate, false) / 24 * -1));
            $totalAmount = $daysOverdue * $fine->amount_per_day;
        } else {
            $totalAmount = $fine->amount_per_day;
        }

        // Create payment
        $payment = Payment::create([
            'user_id' => $fine->borrow->user_id,
            'fine_id' => $fine->fine_id,
            'payment_type' => 'fine',
            'amount' => $totalAmount,
            'payment_method' => $request->payment_method,
            'payment_date' => DateHelper::now(),
            'transaction_id' => $request->transaction_id,
            'notes' => $request->notes,
            'status' => 'completed',
        ]);

        // Update fine status
        $fine->update(['status' => 'paid']);

        // Check if all fines for this borrow are paid and update borrow status if needed
        $unpaidFines = $fine->borrow->fines->where('status', 'unpaid');
        if ($unpaidFines->count() === 0 && $fine->borrow->status === 'overdue') {
            // All fines paid, but book is still overdue - change status back to active
            $fine->borrow->update(['status' => 'active']);
        }

        return redirect()->route('admin.fines.index')
            ->with('success', 'Fine payment processed successfully!');
    }

    /**
     * Show the form for processing a fine payment
     */
    public function showProcessFine($fineId)
    {
        $fine = Fine::with(['borrow', 'borrow.user', 'borrow.inventory.book'])->findOrFail($fineId);

        // Calculate total amount
        $totalAmount = 0;
        if ($fine->fine_type === 'overdue') {
            $currentDate = DateHelper::now();
            $dueDate = $fine->borrow->due_date;
            $daysOverdue = max(0, ceil($currentDate->diffInHours($dueDate, false) / 24 * -1));
            $totalAmount = $daysOverdue * $fine->amount_per_day;
        } else {
            $totalAmount = $fine->amount_per_day;
        }

        return view('dashboard.admin.payments.process-fine', compact('fine', 'totalAmount'));
    }
}
