<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use App\Models\Reservation;
use App\Models\Fine;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get borrowed books count
        $borrowedBooksCount = Borrow::where('user_id', $user->user_id)
            ->where('status', 'active')
            ->count();
            
        // Get overdue books count
        $overdueBooksCount = Borrow::where('user_id', $user->user_id)
            ->where('status', 'overdue')
            ->count();
            
        // Get active reservations count
        $reservationsCount = Reservation::where('user_id', $user->user_id)
            ->where('status', 'active')
            ->count();
            
        // Get unpaid fines total amount
        $unpaidFines = Fine::whereHas('borrow', function($query) use ($user) {
                $query->where('user_id', $user->user_id);
            })
            ->where('status', 'unpaid')
            ->get();
            
        $finesDue = $unpaidFines->sum('total_amount');
        
        // Get currently borrowed books
        $currentBorrowings = Borrow::with(['inventory.book.author'])
            ->where('user_id', $user->user_id)
            ->whereIn('status', ['active', 'overdue'])
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();
            
        // Get recent notifications
        $notifications = Notification::where('user_id', $user->user_id)
            ->orderBy('sent_date', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.member.index', compact(
            'user',
            'borrowedBooksCount',
            'overdueBooksCount',
            'reservationsCount',
            'finesDue',
            'currentBorrowings',
            'notifications'
        ));
    }
}