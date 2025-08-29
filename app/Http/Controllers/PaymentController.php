<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Fine;
use App\Models\MembershipType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the payments for the authenticated user.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $searchTerm = $request->input('search');
        
        $payments = Payment::with(['fine', 'membershipType', 'fine.borrow.book'])
            ->where('user_id', $user->user_id)
            ->when($searchTerm, function($query) use ($searchTerm) {
                $query->where(function($q) use ($searchTerm) {
                    $q->where('payment_type', 'like', "%{$searchTerm}%")
                      ->orWhere('status', 'like', "%{$searchTerm}%")
                      ->orWhere('transaction_id', 'like', "%{$searchTerm}%")
                      ->orWhere('payment_method', 'like', "%{$searchTerm}%")
                      ->orWhereHas('fine.borrow.book', function($q) use ($searchTerm) {
                          $q->where('title', 'like', "%{$searchTerm}%");
                      })
                      ->orWhereHas('membershipType', function($q) use ($searchTerm) {
                          $q->where('name', 'like', "%{$searchTerm}%");
                      });
                });
            })
            ->orderBy('payment_date', 'desc')
            ->paginate(10);

        return view('member.payments.index', compact('payments', 'searchTerm'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create($fine_id = null)
    {
        $user = Auth::user();
        
        $fine = null;
        if ($fine_id) {
            $fine = Fine::with(['borrow', 'borrow.book'])
                ->where('fine_id', $fine_id)
                ->whereHas('borrow', function($query) use ($user) {
                    $query->where('user_id', $user->user_id);
                })
                ->where('status', 'unpaid')
                ->first();
            
            if (!$fine) {
                return redirect()->route('member.payments.create')
                    ->with('error', 'Fine not found or already paid.');
            }
        }

        $unpaidFines = $user->unpaidFines()
            ->with(['borrow', 'borrow.book'])
            ->get();

        $membershipTypes = MembershipType::where('status', 'active')->get();

        return view('member.payments.create', compact('unpaidFines', 'fine', 'membershipTypes'));
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'payment_type' => 'required|in:fine,membership_fee',
            'fine_id' => 'required_if:payment_type,fine|nullable|exists:fines,fine_id',
            'membership_type_id' => 'required_if:payment_type,membership_fee|nullable|exists:membership_types,membership_type_id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,card,online',
            'notes' => 'nullable|string|max:500',
        ]);

        // Verify fine belongs to user if paying a fine
        if ($validated['payment_type'] === 'fine' && $validated['fine_id']) {
            $fine = Fine::where('fine_id', $validated['fine_id'])
                ->whereHas('borrow', function($query) use ($user) {
                    $query->where('user_id', $user->user_id);
                })
                ->where('status', 'unpaid')
                ->first();
            
            if (!$fine) {
                return back()->with('error', 'Fine not found or already paid.');
            }
        }

        DB::beginTransaction();

        try {
            $payment = Payment::create([
                'user_id' => $user->user_id,
                'fine_id' => $validated['payment_type'] === 'fine' ? $validated['fine_id'] : null,
                'membership_type_id' => $validated['payment_type'] === 'membership_fee' ? $validated['membership_type_id'] : null,
                'amount' => $validated['amount'],
                'payment_type' => $validated['payment_type'],
                'payment_method' => $validated['payment_method'],
                'notes' => $validated['notes'] ?? null,
                'status' => 'completed',
                'payment_date' => now(),
            ]);

            // If paying a fine, update the fine status
            if ($validated['payment_type'] === 'fine' && $validated['fine_id']) {
                Fine::where('fine_id', $validated['fine_id'])->update([
                    'status' => 'paid',
                    'payment_id' => $payment->payment_id
                ]);
            }

            DB::commit();

            return redirect()->route('member.payments.show', $payment->payment_id)
                ->with('success', 'Payment completed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified payment.
     */
    public function show($payment_id)
    {
        $user = Auth::user();
        
        $payment = Payment::with(['fine', 'fine.borrow', 'fine.borrow.book', 'membershipType'])
            ->where('payment_id', $payment_id)
            ->where('user_id', $user->user_id)
            ->firstOrFail();

        return view('dashboard.member.payments.show', compact('payment'));
    }
}