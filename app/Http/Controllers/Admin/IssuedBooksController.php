<?php

namespace App\Http\Controllers\Admin;

use App\Models\Borrow;
use App\Models\BookReturn;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IssuedBooksController extends Controller
{
    /**
     * Display a listing of all issued books.
     */
    public function index(Request $request)
    {
        // Start building the query
        $query = Borrow::with(['user', 'inventory.book', 'inventory.book.author', 'staff'])
            ->whereIn('status', ['active', 'overdue']);

        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;

            $query->where(function($q) use ($searchTerm) {
                // Search by borrow ID
                $q->where('borrow_id', 'LIKE', "%{$searchTerm}%")
                // Search by user name - FIXED: changed 'name' to 'fullname'
                ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                    $userQuery->where('fullname', 'LIKE', "%{$searchTerm}%") // Changed from 'name' to 'fullname'
                             ->orWhere('email', 'LIKE', "%{$searchTerm}%");
                })
                // Search by book title
                ->orWhereHas('inventory.book', function($bookQuery) use ($searchTerm) {
                    $bookQuery->where('title', 'LIKE', "%{$searchTerm}%");
                })
                // Search by author name
                ->orWhereHas('inventory.book.author', function($authorQuery) use ($searchTerm) {
                    $authorQuery->where('fullname', 'LIKE', "%{$searchTerm}%");
                })
                // Search by ISBN
                ->orWhereHas('inventory.book', function($bookQuery) use ($searchTerm) {
                    $bookQuery->where('isbn', 'LIKE', "%{$searchTerm}%");
                })
                // Search by status
                ->orWhere('status', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Handle status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Order and paginate results
        $borrows = $query->orderBy('borrow_date', 'desc')
                        ->paginate(20)
                        ->appends($request->except('page'));

        $searchTerm = $request->search;
        $statusFilter = $request->status;

        // Get statistics
        $stats = [
            'total_issued' => Borrow::whereIn('status', ['active', 'overdue'])->count(),
            'active' => Borrow::where('status', 'active')->count(),
            'overdue' => Borrow::where('status', 'overdue')->count(),
            'total_fines' => Borrow::where('status', 'overdue')
                ->select(DB::raw('SUM(DATEDIFF(NOW(), due_date) * 0.50) as total_fines'))
                ->first()->total_fines ?? 0
        ];

        return view('dashboard.admin.issued-books.index', compact('borrows', 'searchTerm', 'statusFilter', 'stats'));
    }

    /**
     * Display details of a specific issued book.
     */
    public function show($id)
    {
        $borrow = Borrow::with([
            'user',
            'inventory.book',
            'inventory.book.author',
            'inventory.book.publisher',
            'inventory.book.category',
            'staff'
        ])->findOrFail($id);

        // Calculate overdue days and fine if applicable
        $overdueDays = 0;
        $fineAmount = 0;

        if ($borrow->status === 'overdue' || $borrow->due_date->isPast()) {
            $overdueDays = $borrow->due_date->diffInDays(now());
            $fineAmount = $overdueDays * 0.50; // $0.50 per day
        }

        return view('dashboard.admin.issued-books.show', compact('borrow', 'overdueDays', 'fineAmount'));
    }

    /**
     * Mark a book as returned.
     */
    public function markReturned(Request $request, $id)
    {
        $request->validate([
            'condition' => 'required|in:excellent,good,fair,poor,damaged',
            'notes' => 'nullable|string|max:500'
        ]);

        $borrow = Borrow::findOrFail($id);

        // Check if already returned
        if ($borrow->status === 'returned') {
            return redirect()->back()->with('error', 'This book has already been returned.');
        }

        // Calculate fine if overdue
        $fineAmount = 0;
        $lateDays = 0;

        if ($borrow->due_date->isPast()) {
            $lateDays = $borrow->due_date->diffInDays(now());
            $fineAmount = $lateDays * 0.50; // $0.50 per day
        }

        // Get system staff or use null if not available
        $systemStaff = Staff::where('email', 'system@library.com')->first();
        $staffId = $systemStaff ? $systemStaff->staff_id : null;

        // If staffId is still null and we have a logged-in user who is staff, use that
        if (!$staffId && Auth::check()) {
            $user = Auth::user();
            // Check if the user has a staff record
            if (method_exists($user, 'staff') && $user->staff) {
                $staffId = $user->staff->staff_id;
            }
        }

        // Create return record - allow null staff_id if needed
        BookReturn::create([
            'borrow_id' => $borrow->borrow_id,
            'staff_id' => $staffId, // Use the resolved staff ID
            'return_date' => now(),
            'condition_on_return' => $request->condition,
            'late_days' => $lateDays,
            'fine_amount' => $fineAmount,
            'notes' => $request->notes
        ]);

        // Update borrow status
        $borrow->update(['status' => 'returned']);

        // Update inventory status
        $borrow->inventory->update(['status' => 'available']);

        $message = 'Book marked as returned successfully!';
        if ($fineAmount > 0) {
            $message .= ' Fine amount: $' . number_format($fineAmount, 2);
        }

        return redirect()->route('admin.issued-books.index')->with('success', $message);
    }

    /**
     * Renew a borrowed book (admin override).
     */
    public function renew($id)
    {
        $borrow = Borrow::findOrFail($id);

        // Check if already renewed maximum times
        if ($borrow->renewal_count >= 3) {
            return redirect()->back()->with('error', 'Maximum renewals (3) reached for this book.');
        }

        // Renew for another 2 weeks
        $borrow->update([
            'due_date' => now()->addDays(14),
            'renewal_count' => $borrow->renewal_count + 1,
            'status' => 'active' // Reset status to active if it was overdue
        ]);

        return redirect()->back()->with('success', 'Book renewed successfully! New due date: ' . $borrow->due_date->format('M d, Y'));
    }

    /**
     * Mark a book as overdue.
     */
    public function markOverdue($id)
    {
        $borrow = Borrow::findOrFail($id);

        if ($borrow->status === 'overdue') {
            return redirect()->back()->with('error', 'Book is already marked as overdue.');
        }

        $borrow->update(['status' => 'overdue']);

        return redirect()->back()->with('success', 'Book marked as overdue.');
    }

    /**
     * Get issued books statistics for dashboard.
     */
    public function getStats()
    {
        $stats = [
            'total_issued' => Borrow::whereIn('status', ['active', 'overdue'])->count(),
            'active' => Borrow::where('status', 'active')->count(),
            'overdue' => Borrow::where('status', 'overdue')->count(),
            'total_fines' => Borrow::where('status', 'overdue')
                ->select(DB::raw('SUM(DATEDIFF(NOW(), due_date) * 0.50) as total_fines'))
                ->first()->total_fines ?? 0
        ];

        return response()->json($stats);
    }
}
