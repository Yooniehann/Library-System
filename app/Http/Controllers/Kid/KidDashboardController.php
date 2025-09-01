<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Reservation;
use App\Models\Fine;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class KidDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Borrowed books count
        $borrowedCount = $user->activeBorrows()->count();

        // Overdue books count
        $overdueCount = $user->borrows()
                             ->whereIn('status', ['active', 'overdue'])
                             ->where('due_date', '<', now())
                             ->count();

        // Total unpaid fines
        $finesTotal = $user->unpaidFines()->sum('amount_per_day');

        // Recommended Books (example: top 5 latest books)
        $recommendedBooks = Book::with('author')
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();

        // Top Picks (example: top 5 most borrowed books)
        $topPicks = Book::with('author')
                        ->withCount(['inventories as borrow_count' => function ($query) {
                            $query->join('borrows', 'inventories.inventory_id', '=', 'borrows.inventory_id');
                        }])
                        ->orderByDesc('borrow_count')
                        ->take(5)
                        ->get();

        // My Borrowed Books (active)
        $myBorrowedBooks = $user->activeBorrows()->with(['inventory.book.author'])->get();

        // Latest notifications
        $notifications = $user->notifications()
                              ->orderBy('created_at', 'desc')
                              ->take(5)
                              ->get();

        return view('dashboard.kid.index', compact(
            'user',
            'borrowedCount',
            'overdueCount',
            'finesTotal',
            'recommendedBooks',
            'topPicks',
            'myBorrowedBooks',
            'notifications'
        ));
    }
}
