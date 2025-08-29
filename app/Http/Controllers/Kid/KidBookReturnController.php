<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use App\Models\BookReturn;
use App\Models\Fine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KidBookReturnController extends Controller
{
    /**
     * Handle returning a borrowed book by a kid.
     */
    public function returnBook(Borrow $borrow, Request $request)
    {
        // Check ownership
        if ($borrow->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if already returned
        if ($borrow->status === 'returned') {
            return redirect()->back()->with('error', 'This book has already been returned.');
        }

        // Mark borrow as returned
        $borrow->status = 'returned';
        $borrow->save();

        // Calculate overdue fine
        $lateDays = max(0, Carbon::now()->diffInDays($borrow->due_date));
        $fineAmount = $lateDays * 0.50; // $0.50 per day

        // Create BookReturn record
        BookReturn::create([
            'borrow_id' => $borrow->borrow_id,
            'staff_id' => null, // admin will handle staff later
            'return_date' => Carbon::now(),
            'condition_on_return' => $request->input('condition_on_return', 'good'),
            'late_days' => $lateDays,
            'fine_amount' => $fineAmount,
            // 'notes' => $request->input('notes', null),
        ]);

        // Create Fine record if overdue
        if ($fineAmount > 0) {
            Fine::create([
                'borrow_id' => $borrow->borrow_id,
                'fine_type' => 'overdue',
                'amount_per_day' => 0.50,
                'description' => 'Overdue fine for ' . $lateDays . ' day(s)',
                'fine_date' => Carbon::now(),
                'status' => 'unpaid',
            ]);
            return redirect()->back()->with('warning', 'Book returned with overdue fine of $' . number_format($fineAmount, 2));
        }

        return redirect()->back()->with('success', 'Book returned successfully!');
    }
}
