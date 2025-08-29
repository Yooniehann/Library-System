<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fine;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KidFineController extends Controller
{
    /**
     * Display the list of fines & payments for the logged-in kid.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        $query = Fine::with(['borrow.book', 'payment'])
                     ->whereHas('borrow', fn($q) => $q->where('user_id', $userId));

        // Optional search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('fine_type', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('borrow_id', 'like', "%{$search}%")
                  ->orWhereHas('borrow.book', fn($q2) => $q2->where('title', 'like', "%{$search}%"));
            });
        }

        $fines = $query->orderBy('fine_date', 'desc')->get();

        return view('dashboard.kid.kidfinepay', compact('fines'));
    }

    /**
     * Process the payment for a fine.
     */
    public function pay(Fine $fine)
    {
        $userId = Auth::id();

        // Ensure this fine belongs to the logged-in kid
        if ($fine->borrow->user_id != $userId) {
            abort(403, 'Unauthorized action.');
        }

        if ($fine->status === 'paid') {
            return redirect()->back()->with('success', 'This fine is already paid.');
        }

        // Create a payment record
        $payment = Payment::create([
    'user_id' => $userId,
    'membership_type_id' => $fine->borrow->user->membership_type_id ?? null,
    'fine_id' => $fine->fine_id,
    'amount' => $fine->total_amount,
    'payment_type' => 'Fine',   // shortened to fit DB
    'payment_method' => 'Online',
    'payment_date' => now(),
    'transaction_id' => null,
    'notes' => 'Payment for fine #' . $fine->fine_id,
    'status' => 'completed',
]);

        // Update fine status and link to payment
        $fine->status = 'paid';
        $fine->payment_id = $payment->payment_id;
        $fine->save();

        return redirect()->back()->with('success', 'Payment successful!');
    }
}
