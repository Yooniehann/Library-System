<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Fine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\DateHelper;

class PaymentController extends Controller
{
    /**
     * Display a listing of the member's payments.
     */
    public function index()
    {
        $payments = Payment::with(['fine', 'fine.borrow.inventory.book', 'membershipType'])
            ->where('user_id', Auth::id())
            ->orderBy('payment_date', 'desc')
            ->paginate(10);

        $stats = [
            'total' => Payment::where('user_id', Auth::id())->count(),
            'total_amount' => Payment::where('user_id', Auth::id())->sum('amount'),
            'fines_amount' => Payment::where('user_id', Auth::id())->fines()->sum('amount'),
        ];

        return view('dashboard.member.payments.index', compact('payments', 'stats'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create($fineId = null)
    {
        $fine = null;
        $unpaidFines = Fine::with(['borrow.inventory.book'])
            ->unpaid()
            ->whereHas('borrow', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->get();

        if ($fineId) {
            $fine = Fine::with(['borrow.inventory.book'])
                ->whereHas('borrow', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->findOrFail($fineId);
        }

        return view('dashboard.member.payments.create', compact('fine', 'unpaidFines'));
    }

    /**
     * Store a newly created payment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fine_id' => 'required|exists:fines,fine_id',
            'payment_method' => 'required|in:cash,card,online',
            'amount' => 'required|numeric|min:0.01',
        ]);

        // Verify the fine belongs to the authenticated user
        $fine = Fine::with('borrow')
            ->whereHas('borrow', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($request->fine_id);

        // Validate amount doesn't exceed remaining fine amount
        $remainingAmount = $fine->total_amount - ($fine->payment ? $fine->payment->amount : 0);
        $request->validate([
            'amount' => "numeric|min:0.01|max:{$remainingAmount}",
        ]);

        DB::transaction(function () use ($request, $fine, $remainingAmount) {
            // Create payment
            $payment = Payment::create([
                'user_id' => Auth::id(),
                'fine_id' => $request->fine_id,
                'payment_type' => 'fine',
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'payment_date' => DateHelper::now(),
                'transaction_id' => $request->transaction_id,
                'notes' => $request->notes,
                'status' => 'completed',
            ]);

            // Update fine status if fully paid
            if ($request->amount >= $remainingAmount) {
                $fine->update(['status' => 'paid']);
            }
            // For partial payments, status remains unpaid
        });

        return redirect()->route('member.payments.index')
            ->with('success', 'Payment processed successfully!');
    }

    /**
     * Display the specified payment.
     */
    public function show($id)
    {
        $payment = Payment::with(['fine', 'fine.borrow.inventory.book'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('dashboard.member.payments.show', compact('payment'));
    }

    public function print($id)
    {
        $payment = Payment::with(['fine', 'fine.borrow.inventory.book'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('dashboard.member.payments.print', compact('payment'));
    }
}