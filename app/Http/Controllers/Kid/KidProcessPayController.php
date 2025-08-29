<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fine;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class KidProcessPayController extends Controller
{
    /**
     * Display the process payment page for a specific fine.
     *
     * @param int $fine_id
     * @return \Illuminate\View\View
     */
    public function index($fine_id)
    {
        $fine = Fine::where('fine_id', $fine_id)
                    ->whereHas('borrow', fn($q) => $q->where('user_id', Auth::id()))
                    ->firstOrFail();

        return view('dashboard.kid.kidprocesspay', compact('fine'));
    }

    /**
     * Handle the payment submission for a specific fine.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $fine_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pay(Request $request, $fine_id)
    {
        $fine = Fine::where('fine_id', $fine_id)
                    ->whereHas('borrow', fn($q) => $q->where('user_id', Auth::id()))
                    ->firstOrFail();

        if ($fine->status === 'paid') {
            return redirect()->route('kid.kidfinepay.index')
                             ->with('message', 'This fine has already been paid.');
        }

        // Create payment record with all required columns
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


        // Link payment to fine and mark as paid
        $fine->payment_id = $payment->payment_id;
        $fine->status = 'paid';
        $fine->save();

        return redirect()->route('kid.kidfinepay.index')
                         ->with('success', 'The fine has been successfully paid!');
    }
}
