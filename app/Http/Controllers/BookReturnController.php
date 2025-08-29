<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\BookReturn;
use App\Models\Fine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookReturnController extends Controller
{
    public function returnBook($borrowId)
    {
        $borrow = Borrow::where('user_id', Auth::id())
            ->findOrFail($borrowId);

        // Check if book is already returned
        if ($borrow->status === 'returned') {
            return redirect()->back()->with('error', 'This book has already been returned.');
        }

        // Calculate fine if overdue
        $fineAmount = 0;
        if ($borrow->due_date->isPast()) {
            $daysOverdue = $borrow->due_date->diffInDays(now());
            $fineAmount = $daysOverdue * 0.50; // $0.50 per day overdue
        }

        // Create return record
        $bookReturn = BookReturn::create([
            'borrow_id' => $borrow->borrow_id,
            'staff_id' => null, // Admin will set this
            'return_date' => now(),
            'condition' => 'good', // Default condition
            'fine_amount' => $fineAmount,
<<<<<<< HEAD
           // 'notes' => 'Returned by user'
=======
            // 'notes' => 'Returned by user'
>>>>>>> 76a310bf383cdeedbec1527bc5504a1adb7fca6d
        ]);

        // Update borrow status
        $borrow->update(['status' => 'returned']);

        // Update inventory status
        $borrow->inventory->update(['status' => 'available']);

        // Create fine record if applicable
        if ($fineAmount > 0) {
            Fine::create([
                'borrow_id' => $borrow->borrow_id,
                'fine_type' => 'overdue',
                'amount_per_day' => 0.50,
                'description' => 'Overdue fine for ' . $daysOverdue . ' days',
                'fine_date' => now(),
                'status' => 'unpaid'
            ]);

            return redirect()->back()->with('warning', 'Book returned with overdue fine of $' . number_format($fineAmount, 2) . '. Please pay the fine.');
        }

        return redirect()->back()->with('success', 'Book returned successfully!');
    }
}
