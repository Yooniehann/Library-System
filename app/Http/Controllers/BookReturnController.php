<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\BookReturn;
use App\Models\Fine;
use Illuminate\Http\Request;

class BookReturnController extends Controller
{
    public function returnBook($borrowId)
    {
        $borrow = Borrow::with('inventory', 'bookReturn')->findOrFail($borrowId);

        // Make sure the current user owns the borrow (if not admin)
        if (auth()->user()->role !== 'Admin' && $borrow->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if already returned
        if ($borrow->status === 'returned') {
            return redirect()->back()->with('error', 'This book has already been returned.');
        }

        // Avoid duplicate BookReturn
        if (!$borrow->bookReturn) {
            $lateDays = max(0, now()->diffInDays($borrow->due_date));
            $fineAmount = $lateDays * 0.50; // your overdue fine per day

            BookReturn::create([
                'borrow_id' => $borrow->borrow_id,
                'staff_id' => auth()->user()->role === 'Admin' ? auth()->id() : null,
                'return_date' => now(),
                'condition_on_return' => 'good',
                'late_days' => $lateDays,
                'fine_amount' => $fineAmount,
                'notes' => 'Returned by ' . auth()->user()->role,
            ]);

            // Create fine if overdue
            if ($fineAmount > 0) {
                Fine::create([
                    'borrow_id' => $borrow->borrow_id,
                    'fine_type' => 'overdue',
                    'amount_per_day' => 0.50,
                    'description' => 'Overdue fine for ' . $lateDays . ' day(s)',
                    'fine_date' => now(),
                    'status' => 'unpaid',
                ]);

                $message = 'Book returned with overdue fine of $' . number_format($fineAmount, 2);
                $borrow->update(['status' => 'returned']);
                $borrow->inventory->update(['status' => 'available']);

                return redirect()->back()->with('warning', $message);
            }
        }

        // Update borrow and inventory
        $borrow->update(['status' => 'returned']);
        $borrow->inventory->update(['status' => 'available']);

        return redirect()->back()->with('success', 'Book returned successfully!');
    }
}
