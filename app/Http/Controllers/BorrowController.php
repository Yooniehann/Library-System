<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Inventory;
use App\Models\Borrow;
use App\Models\Reservation;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    public function create($bookId)
    {
        $user = Auth::user();

        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user is an admin (admins cannot borrow books)
        if ($user->role === 'Admin') {
            return redirect()->back()->with('error', 'Administrators cannot borrow books.');
        }

        // Check if user is a guest
        if ($user->role === 'Guest') {
            return redirect()->back()->with('error', 'You need to upgrade your membership to borrow books.');
        }

        // Find the book
        $book = Book::findOrFail($bookId);

        // Find an available inventory copy
        $availableInventory = Inventory::where('book_id', $bookId)
            ->where('status', 'available')
            ->first();

        if (!$availableInventory) {
            return redirect()->back()->with('error', 'No available copies of this book.');
        }

        // Check if user has reached borrowing limit
        /** @var User $user */
        $user = Auth::user();
        if (!$user->canBorrowMoreBooks()) {
            return redirect()->back()->with('error', 'You have reached the maximum borrowing limit.');
        }

        // Check if user has any unpaid fines
        if ($user->hasUnpaidFines()) {
            return redirect()->back()->with('error', 'You have unpaid fines. Please clear them before borrowing.');
        }

        // Check if user already has this book borrowed
        $alreadyBorrowed = Borrow::where('user_id', $user->user_id)
            ->whereHas('inventory', function ($query) use ($bookId) {
                $query->where('book_id', $bookId);
            })
            ->where('status', 'active')
            ->exists();

        if ($alreadyBorrowed) {
            return redirect()->back()->with('error', 'You already have this book borrowed.');
        }

        // Get system staff or first available staff member
        $systemStaff = Staff::where('email', 'system@library.com')->first();

        if (!$systemStaff) {
            // Fallback: get first active staff member
            $systemStaff = Staff::where('status', 'active')->first();
        }

        if (!$systemStaff) {
            return redirect()->back()->with('error', 'System error. Please contact administrator.');
        }

        // Create the borrow record
        $borrow = Borrow::create([
            'user_id' => $user->user_id,
            'inventory_id' => $availableInventory->inventory_id,
            'staff_id' => $systemStaff->staff_id,
            'borrow_date' => now(),
            'due_date' => now()->addDays(14),
            'renewal_count' => 0,
            'status' => 'active'
        ]);

        // Update the inventory status
        $availableInventory->update(['status' => 'borrowed']);

        // Check if user had a reservation for this book
        $reservation = Reservation::where('user_id', $user->user_id)
            ->where('book_id', $bookId)
            ->where('status', 'active')
            ->first();

        if ($reservation) {
            $reservation->update(['status' => 'fulfilled']);
        }

        // Redirect based on user role
        $redirectRoute = $user->role === 'Kid' ? 'kid.dashboard' : 'member.dashboard';

        return redirect()->route('books.index')->with([
            'success' => 'Book borrowed successfully! Due date: '
                . $borrow->due_date->format('M d, Y')
                . '. Please return on time to avoid fines.',
            'redirect_to' => route($redirectRoute),
        ]);
    }

    /**
     * Renew a borrowed book
     */
    public function renew($borrowId)
    {
        $user = Auth::user();

        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user is an admin (admins cannot renew books)
        if ($user->role === 'Admin') {
            return redirect()->back()->with('error', 'Administrators cannot renew books.');
        }

        // Check if user is a guest
        if ($user->role === 'Guest') {
            return redirect()->back()->with('error', 'You need to upgrade your membership to renew books.');
        }

        $borrow = Borrow::where('user_id', $user->user_id)
            ->findOrFail($borrowId);

        // Check if already renewed maximum times (e.g., 2 times)
        if ($borrow->renewal_count >= 2) {
            return redirect()->back()->with('error', 'Maximum renewals reached for this book.');
        }

        // Check if book is overdue
        if ($borrow->due_date->isPast()) {
            return redirect()->back()->with('error', 'Cannot renew overdue book. Please return it.');
        }

        // Renew for another 2 weeks
        $borrow->update([
            'due_date' => now()->addDays(14),
            'renewal_count' => $borrow->renewal_count + 1
        ]);

        return redirect()->back()->with('success', 'Book renewed successfully! New due date: ' . $borrow->due_date->format('M d, Y'));
    }

    /**
     * Display a listing of the user's borrowed books.
     */
    public function index(Request $request)
    {
        // Get the authenticated user
        $user = auth()->user();

        // Start building the query
        $query = $user->borrows()
                    ->with(['inventory.book', 'inventory.book.author']);

        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            
            $query->where(function($q) use ($searchTerm) {
                // Search by borrow ID
                $q->where('borrow_id', 'LIKE', "%{$searchTerm}%")
                // Search by book title
                ->orWhereHas('inventory.book', function($bookQuery) use ($searchTerm) {
                    $bookQuery->where('title', 'LIKE', "%{$searchTerm}%");
                })
                // Search by author name
                ->orWhereHas('inventory.book.author', function($authorQuery) use ($searchTerm) {
                    $authorQuery->where('fullname', 'LIKE', "%{$searchTerm}%");
                })
                // Search by status
                ->orWhere('status', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Order and get results
        $borrows = $query->orderBy('borrow_date', 'desc')->get();
        $searchTerm = $request->search;

        return view('dashboard.member.borrowed', compact('borrows', 'searchTerm'));
    }

    /**
     * Display details of a specific borrowed book.
     */
    public function show($id)
    {
        $user = auth()->user();
        
        // Get the specific borrow record for this user with all related data
        $borrow = $user->borrows()
                    ->with([
                        'inventory.book', 
                        'inventory.book.author',
                        'inventory.book.publisher',
                        'inventory.book.category',
                        'staff'
                    ])
                    ->findOrFail($id);

        return view('dashboard.member.borrowed-details', compact('borrow'));
    }
}