<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class KidReservationController extends Controller
{
    // Show all reservations for the logged-in kid
    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())
                            ->with('book.author') // eager load book info and author
                            ->get();

        return view('dashboard.kid.kidreservation', compact('reservations'));
    }

    // Create a new reservation for a specific book
    public function create(Book $book)
    {
        // Check if the book is already reserved by this user
        $exists = Reservation::where('user_id', Auth::id())
                    ->where('book_id', $book->book_id) // use correct column
                    ->first();

        if ($exists) {
            return redirect()->back()->with('error', 'You have already reserved this book.');
        }

        Reservation::create([
            'user_id' => Auth::id(),
            'book_id' => $book->book_id,
            'reservation_date' => now(), // correct column name
            'status' => 'active',        // default status
        ]);

        return redirect()->route('kid.kidreservation.index')->with('success', 'Book reserved successfully!');
    }

    // Cancel a reservation
    public function cancel($reservation_id)
    {
        $reservation = Reservation::where('reservation_id', $reservation_id) // correct column
                            ->where('user_id', Auth::id())
                            ->firstOrFail();

        $reservation->delete();

        return redirect()->route('kid.kidreservation.index')->with('success', 'Reservation cancelled successfully!');
    }
}
