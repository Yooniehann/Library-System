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
        $book = Book::findOrFail($bookId);
        
        // Check if user already has a reservation for this book
        $existingReservation = Reservation::where('user_id', Auth::id())
            ->where('book_id', $bookId)
            ->whereIn('status', ['pending', 'active'])
            ->first();
            
        if ($existingReservation) {
            return redirect()->back()->with('error', 'You already have a reservation for this book.');
        }
        
        // Get the next priority number for this book
        $lastReservation = Reservation::where('book_id', $bookId)
            ->orderBy('priority_number', 'desc')
            ->first();
            
        $priorityNumber = $lastReservation ? $lastReservation->priority_number + 1 : 1;
        
        // Create reservation
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'book_id' => $bookId,
            'reservation_date' => now(),
            'status' => 'pending',
            'expiry_date' => now()->addDays(3),
            'priority_number' => $priorityNumber,
            'notification_sent' => false
        ]);
        
        return redirect()->back()->with('success', 'Book reserved successfully! You are position #' . $priorityNumber . ' in the queue.');
    }
}