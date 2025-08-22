<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    // Show borrow history for authenticated user
    public function index()
    {
        $borrows = Borrow::with(['inventory.book', 'fine'])
            ->where('user_id', Auth::id())
            ->orderBy('borrow_date', 'desc')
            ->paginate(10);

        return view('dashboard.member.borrow.history', compact('borrows'));
    }

    // Show borrow confirmation page
    public function confirm(Book $book)
    {
        /** @var User $user */
        $user = Auth::user();

        // Check if user can borrow more books
        if (!$user->canBorrowMoreBooks()) {
            return redirect()->back()
                ->with('error', 'You have reached your borrowing limit. You can borrow up to ' . $user->membershipType->max_books_allowed . ' books.');
        }

        // Check if book is available
        if (!$book->isAvailable()) {
            return redirect()->back()
                ->with('error', 'This book is currently not available.');
        }

        return view('dashboard.member.borrow.confirm', compact('book'));
    }

    // Process a new borrow request
    public function store(Request $request, Book $book)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->canBorrowMoreBooks()) {
            return redirect()->back()
                ->with(
                    'error',
                    'You have reached your borrowing limit. You can borrow up to '
                    . $user->membershipType->max_books_allowed . ' books.'
                );
        }

        // Check if book is available
        $availableInventory = Inventory::where('book_id', $book->book_id)
            ->where('status', 'available')
            ->first();

        if (!$availableInventory) {
            return redirect()->back()
                ->with('error', 'This book is currently not available.');
        }

        try {
            DB::beginTransaction();

            // Create the borrow record
            $borrow = Borrow::create([
                'user_id' => Auth::id(),
                'inventory_id' => $availableInventory->inventory_id,
                'borrow_date' => now(),
                'due_date' => now()->addWeeks(2), // 2 weeks borrowing period
                'renewal_count' => 0,
                'status' => 'borrowed'
            ]);

            // Update inventory status
            $availableInventory->update(['status' => 'borrowed']);

            DB::commit();

            return redirect()->route('member.borrow.success', $borrow)
                ->with('success', 'Book borrowed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'An error occurred while processing your request.');
        }
    }

    // Show borrow success page
    public function success(Borrow $borrow)
    {
        // Check if user owns this borrow record
        if ($borrow->user_id !== Auth::id()) {
            return redirect()->route('member.borrow.history')
                ->with('error', 'Unauthorized access.');
        }

        return view('dashboard.member.borrow.success', compact('borrow'));
    }

    // Renew a borrowed book
    public function renew(Borrow $borrow)
    {
        // Check if user owns this borrow record
        if ($borrow->user_id !== Auth::id()) {
            return redirect()->back()
                ->with('error', 'Unauthorized action.');
        }

        // Check if renewal is allowed (max 1 renewal)
        if ($borrow->renewal_count >= 1) {
            return redirect()->back()
                ->with('error', 'You have already renewed this book the maximum number of times.');
        }

        // Check if book is overdue
        if ($borrow->due_date->isPast()) {
            return redirect()->back()
                ->with('error', 'Cannot renew an overdue book. Please return it and pay any applicable fines.');
        }

        try {
            DB::beginTransaction();
            
            // Renew the book (extend due date by 1 week)
            $borrow->update([
                'due_date' => $borrow->due_date->addWeek(),
                'renewal_count' => $borrow->renewal_count + 1
            ]);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Book renewed successfully! New due date: ' . $borrow->due_date->format('M d, Y'));
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'An error occurred while renewing the book.');
        }
    }

    // Return a borrowed book
    public function return(Borrow $borrow)
    {
        // Check if user owns this borrow record
        if ($borrow->user_id !== Auth::id()) {
            return redirect()->back()
                ->with('error', 'Unauthorized action.');
        }

        // Check if book is already returned
        if ($borrow->status === 'returned') {
            return redirect()->back()
                ->with('error', 'This book has already been returned.');
        }

        try {
            DB::beginTransaction();

            // Update borrow status
            $borrow->update([
                'status' => 'returned',
                'return_date' => now()
            ]);

            // Update inventory status
            $borrow->inventory->update(['status' => 'available']);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Book returned successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'An error occurred while returning the book.');
        }
    }
}