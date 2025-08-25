<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function create($bookId)
    {
        $user = Auth::user();

        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user is a guest
        if ($user->role === 'Guest') {
            return redirect()->back()->with('error', 'You need to upgrade your membership to reserve books.');
        }

        $book = Book::findOrFail($bookId);

        // Check if user already has an active reservation for this book
        $existingReservation = Reservation::where('user_id', $user->user_id)
            ->where('book_id', $bookId)
            ->whereIn('status', ['active'])
            ->first();

        if ($existingReservation) {
            return redirect()->back()->with('error', 'You already have an active reservation for this book.');
        }

        // Get the next priority number for this book (only count active reservations)
        $lastReservation = Reservation::where('book_id', $bookId)
            ->where('status', 'active')
            ->orderBy('priority_number', 'desc')
            ->first();

        $priorityNumber = $lastReservation ? $lastReservation->priority_number + 1 : 1;

        // Create reservation with correct status
        $reservation = Reservation::create([
            'user_id' => $user->user_id,
            'book_id' => $bookId,
            'reservation_date' => now(),
            'status' => 'active',
            'expiry_date' => now()->addDays(3),
            'priority_number' => $priorityNumber,
            'notification_sent' => false
        ]);

        return redirect()->back()->with('success', 'Book reserved successfully! You are position #' . $priorityNumber . ' in the queue. The reservation will expire on ' . $reservation->expiry_date->format('M d, Y'));
    }
}
