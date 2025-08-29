<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use App\Models\BookReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowedController extends Controller
{
    // Display all borrowed books for the logged-in kid
    public function index(Request $request)
    {
        $userId = Auth::id();
        $searchTerm = $request->get('search');

        $borrows = Borrow::with(['inventory.book.author', 'fines', 'bookReturn'])
            ->where('user_id', $userId)
            ->when($searchTerm, function($query, $searchTerm) {
                $query->where('borrow_id', 'like', "%{$searchTerm}%")
                      ->orWhere('status', 'like', "%{$searchTerm}%")
                      ->orWhereHas('inventory.book', function($q) use ($searchTerm) {
                          $q->where('title', 'like', "%{$searchTerm}%")
                            ->orWhereHas('author', function($qa) use ($searchTerm) {
                                $qa->where('fullname', 'like', "%{$searchTerm}%");
                            });
                      });
            })
            ->orderBy('borrow_date', 'desc')
            ->get();

        return view('dashboard.kid.kidborrowed', compact('borrows', 'searchTerm'));
    }

    // Renew a borrowed book
    public function renew(Borrow $borrow)
    {
        // Only active or overdue books can be renewed
        if ($borrow->user_id !== Auth::id() || !in_array($borrow->status, ['active', 'overdue'])) {
            abort(403, 'Unauthorized action.');
        }

        $borrow->renewal_count += 1;
        $borrow->due_date = $borrow->due_date->addDays(7);
        $borrow->save();

        return redirect()->back()->with('success', 'Book renewed successfully!');
    }

    // Return a borrowed book
    public function return(Borrow $borrow, Request $request)
    {
        // Only allow return if the user owns it
        if ($borrow->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow return if active, overdue, or has a paid fine
        $hasPaidFine = $borrow->fines->firstWhere('status', 'paid') !== null;
        if (!in_array($borrow->status, ['active', 'overdue']) && !$hasPaidFine) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the request
        $request->validate([
            'condition_on_return' => 'required|in:Good,Fair,Poor',
            'notes' => 'nullable|string|max:500'
        ]);

        // Mark borrow as returned
        $borrow->status = 'returned';
        $borrow->save();

        // Always create BookReturn entry if it doesn't exist
        if (!$borrow->bookReturn) {
            BookReturn::create([
                'borrow_id' => $borrow->borrow_id,
                'staff_id' => null, // no staff since kid returned
                'return_date' => Carbon::now(),
                'condition_on_return' => $request->input('condition_on_return', 'Good'),
                'late_days' => max(0, Carbon::now()->diffInDays($borrow->due_date)),
                'fine_amount' => 0, // can calculate later if needed
                'notes' => $request->input('notes', null),
            ]);
        }

        return redirect()->back()->with('success', 'Book returned successfully!');
    }
}
