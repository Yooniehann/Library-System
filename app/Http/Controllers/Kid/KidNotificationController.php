<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KidNotificationController extends Controller
{
    /**
     * Display the kid's notifications.
     */
    public function index()
    {
        $user = Auth::user();

        // Initialize notifications collection
        $notifications = collect();

        // 1. Due soon borrows (due within 3 days)
        $dueSoonBorrows = $user->activeBorrows()
            ->whereBetween('due_date', [now(), now()->addDays(3)])
            ->get()
            ->map(function($borrow) {
                return (object)[
                    'type' => 'borrow_due',
                    'message' => "The book '{$borrow->inventory->book->title}' is due on {$borrow->due_date->format('M d, Y')}.",
                    'date' => $borrow->due_date,
                ];
            });

        // 2. Unpaid fines
        $unpaidFines = $user->unpaidFines()
            ->get()
            ->map(function($fine) {
                return (object)[
                    'type' => 'fine',
                    'message' => "You have an unpaid fine: {$fine->description}, amount: {$fine->amount_per_day}.",
                    'date' => $fine->fine_date,
                ];
            });

        // 3. Reservations ready for pickup (notification_sent = true)
        $readyReservations = $user->activeReservations()
            ->where('notification_sent', true)
            ->get()
            ->map(function($reservation) {
                return (object)[
                    'type' => 'reservation',
                    'message' => "Your reserved book '{$reservation->book->title}' is ready for pickup. Please collect it within 7 days.",
                    'date' => $reservation->reservation_date,
                ];
            });

        // Merge all notifications
        $notifications = $dueSoonBorrows
            ->merge($unpaidFines)
            ->merge($readyReservations)
            ->sortByDesc('date')
            ->values(); // reset keys

        // Return view with notifications
        return view('dashboard.kid.kidnoti', compact('notifications'));
    }
}
