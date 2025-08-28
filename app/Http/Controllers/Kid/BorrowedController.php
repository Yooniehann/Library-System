<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowedController extends Controller
{
    // Display all borrowed books for the logged-in kid
    public function index(Request $request)
    {
        $userId = Auth::id(); // Get the logged-in user's ID
        $searchTerm = $request->get('search'); // Get search term from query string

        // Load borrows with inventory and related book + author
        $borrows = Borrow::with(['inventory.book.author'])
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
        if ($borrow->user_id !== Auth::id() || $borrow->status !== 'active') {
            abort(403, 'Unauthorized action.');
        }

        $borrow->renewal_count += 1;
        $borrow->due_date = $borrow->due_date->addDays(7);
        $borrow->save();

        return redirect()->back()->with('success', 'Book renewed successfully!');
    }

    // Return a borrowed book
    public function create(Borrow $borrow)
    {
        if ($borrow->user_id !== Auth::id() || $borrow->status !== 'active') {
            abort(403, 'Unauthorized action.');
        }

        $borrow->status = 'returned';
        $borrow->save();

        return redirect()->back()->with('success', 'Book returned successfully!');
    }
}
