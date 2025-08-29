<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class KidReservationController extends Controller
{
    // Show all reservations for the logged-in kid with search functionality
    public function index(Request $request)
    {
        $userId = Auth::id();
        $searchTerm = $request->get('search');

        $reservations = Reservation::with(['book.author'])
            ->where('user_id', $userId)
            ->when($searchTerm, function($query, $searchTerm) {
                $query->where('reservation_id', 'like', "%{$searchTerm}%")
                      ->orWhere('status', 'like', "%{$searchTerm}%")
                      ->orWhereHas('book', function($q) use ($searchTerm) {
                          $q->where('title', 'like', "%{$searchTerm}%")
                            ->orWhereHas('author', function($qa) use ($searchTerm) {
                                $qa->where('fullname', 'like', "%{$searchTerm}%");
                            });
                      });
            })
            ->orderBy('reservation_date', 'desc')
            ->get();

        return view('dashboard.kid.kidreservation', compact('reservations', 'searchTerm'));
    }

    // Create a new reservation for a specific book
    public function create(Book $book)
    {
        $exists = Reservation::where('user_id', Auth::id())
                    ->where('book_id', $book->book_id)
                    ->first();

        if ($exists) {
            return redirect()->back()->with('error', 'You have already reserved this book.');
        }

        Reservation::create([
            'user_id' => Auth::id(),
            'book_id' => $book->book_id,
            'reservation_date' => now(),
            'status' => 'active',
        ]);

        return redirect()->route('kid.kidreservation.index')->with('success', 'Book reserved successfully!');
    }

    // Cancel a reservation
    public function cancel($reservation_id)
    {
        $reservation = Reservation::where('reservation_id', $reservation_id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();

        $reservation->delete();

        return redirect()->route('kid.kidreservation.index')->with('success', 'Reservation cancelled successfully!');
    }
}
