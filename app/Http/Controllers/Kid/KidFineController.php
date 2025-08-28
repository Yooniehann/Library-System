<?php

namespace App\Http\Controllers\Kid; // <-- correct namespace

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fine;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KidFineController extends Controller

{
    // Show fines & payments page
    public function index(Request $request)
    {
        $userId = Auth::id(); // Logged-in kid ID

        $query = Fine::with(['borrow.book', 'payment'])
                     ->whereHas('borrow', function ($q) use ($userId) {
                         $q->where('user_id', $userId);
                     });

        // Optional search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('fine_type', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('borrow.book', function($q2) use ($search) {
                      $q2->where('title', 'like', "%{$search}%");
                  })
                  ->orWhere('borrow_id', 'like', "%{$search}%");
            });
        }

        $fines = $query->orderBy('fine_date', 'desc')->get();

        return view('dashboard.kid.kidfinepay', compact('fines'));
    }

    // Mark fine as paid
    public function pay(Fine $fine)
    {
        $userId = Auth::id();

        // Check if this fine belongs to the logged-in kid
        if ($fine->borrow->user_id != $userId) {
            abort(403, 'Unauthorized action.');
        }

        if ($fine->status == 'paid') {
            return redirect()->back()->with('message', 'This fine is already paid.');
        }

        // Create a payment record
        $payment = Payment::create([
            'user_id' => $userId,
            'fine_id' => $fine->fine_id,
            'amount' => $fine->amount_per_day, // You can adjust if needed
            'payment_type' => 'Fine Payment',
            'payment_method' => 'Online', // Or 'Cash' if you prefer
            'payment_date' => Carbon::now(),
            'status' => 'completed'
        ]);

        // Update fine status
        $fine->status = 'paid';
        $fine->payment_id = $payment->payment_id;
        $fine->save();

        return redirect()->back()->with('success', 'Payment successful!');
    }
}
