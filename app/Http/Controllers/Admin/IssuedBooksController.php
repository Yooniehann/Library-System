<?php

namespace App\Http\Controllers\Admin;

use App\Models\Borrow;
use App\Models\BookReturn;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\DateHelper;

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

            $query->where(function ($q) use ($searchTerm) {
                // Search by borrow ID
                $q->where('borrow_id', 'LIKE', "%{$searchTerm}%")
                    // Search by user name - FIXED: changed 'name' to 'fullname'
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('fullname', 'LIKE', "%{$searchTerm}%") // Changed from 'name' to 'fullname'
                            ->orWhere('email', 'LIKE', "%{$searchTerm}%");
                    })
                    // Search by book title
                    ->orWhereHas('inventory.book', function ($bookQuery) use ($searchTerm) {
                        $bookQuery->where('title', 'LIKE', "%{$searchTerm}%");
                    })
                    // Search by author name
                    ->orWhereHas('inventory.book.author', function ($authorQuery) use ($searchTerm) {
                        $authorQuery->where('fullname', 'LIKE', "%{$searchTerm}%");
                    })
                    // Search by ISBN
                    ->orWhereHas('inventory.book', function ($bookQuery) use ($searchTerm) {
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

        // Get statistics - Updated to use DateHelper
        $currentDate = DateHelper::now();
        $stats = [
            'total_issued' => Borrow::whereIn('status', ['active', 'overdue'])->count(),
            'active' => Borrow::where('status', 'active')->count(),
            'overdue' => Borrow::where('status', 'overdue')->count(),
            'total_fines' => Borrow::where('status', 'overdue')
                ->get()
                ->sum(function ($borrow) use ($currentDate) {
                    $daysOverdue = $currentDate->diffInDays($borrow->due_date, false) * -1;
                    return max(0, $daysOverdue) * 0.50;
                })
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

        // Only calculate if book is not returned
        if ($borrow->status !== 'returned') {
            if ($borrow->status === 'overdue' || DateHelper::isPast($borrow->due_date)) {
                $overdueDays = DateHelper::diffInDays($borrow->due_date);
                // Convert to whole number for display
                $overdueDays = max(0, ceil($overdueDays));
                $fineAmount = max(0, $overdueDays) * 0.50;
            }
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

        // Calculate fine if overdue - Updated to use DateHelper
        $fineAmount = 0;
        $lateDays = 0;

        if (DateHelper::isPast($borrow->due_date)) {
            $lateDays = DateHelper::diffInDays($borrow->due_date);
            $fineAmount = max(0, $lateDays) * 0.50; // $0.50 per day
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

        // Create return record - allow null staff_id if needed - Updated to use DateHelper
        BookReturn::create([
            'borrow_id' => $borrow->borrow_id,
            'staff_id' => $staffId, // Use the resolved staff ID
            'return_date' => DateHelper::now(),
            'condition_on_return' => $request->condition,
            'late_days' => max(0, $lateDays),
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

        // Renew for another 2 weeks - Updated to use DateHelper
        $borrow->update([
            'due_date' => DateHelper::now()->addDays(14),
            'renewal_count' => $borrow->renewal_count + 1,
            'status' => 'active' // Reset status to active if it was overdue
        ]);

        // Redirect back to the previous page with success message
        if (request()->headers->get('referer') && str_contains(request()->headers->get('referer'), 'overdue-books')) {
            return redirect()->route('admin.overdue-books.index')->with('success', 'Book renewed successfully! New due date: ' . $borrow->due_date->format('M d, Y'));
        }

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
        // Updated to use DateHelper
        $currentDate = DateHelper::now();
        $stats = [
            'total_issued' => Borrow::whereIn('status', ['active', 'overdue'])->count(),
            'active' => Borrow::where('status', 'active')->count(),
            'overdue' => Borrow::where('status', 'overdue')->count(),
            'total_fines' => Borrow::where('status', 'overdue')
                ->get()
                ->sum(function ($borrow) use ($currentDate) {
                    $daysOverdue = $currentDate->diffInDays($borrow->due_date, false) * -1;
                    return max(0, $daysOverdue) * 0.50;
                })
        ];

        return response()->json($stats);
    }

    public function returnedIndex(Request $request)
    {
        // Start building the query
        $query = Borrow::with(['user', 'inventory.book', 'bookReturn'])
            ->where('status', 'returned');

        // Handle search term
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;

            $query->where(function ($q) use ($searchTerm) {
                // Search by borrow ID
                $q->where('borrow_id', 'LIKE', "%{$searchTerm}%")
                    // Search by user name
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('fullname', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('email', 'LIKE', "%{$searchTerm}%");
                    })
                    // Search by book title
                    ->orWhereHas('inventory.book', function ($bookQuery) use ($searchTerm) {
                        $bookQuery->where('title', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('isbn', 'LIKE', "%{$searchTerm}%");
                    })
                    // Search by author name
                    ->orWhereHas('inventory.book.author', function ($authorQuery) use ($searchTerm) {
                        $authorQuery->where('fullname', 'LIKE', "%{$searchTerm}%");
                    });
            });
        }

        // Handle date range filter
        if ($request->has('date_range') && !empty($request->date_range)) {
            $dates = explode(' - ', $request->date_range);

            if (count($dates) === 2) {
                $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();

                $query->whereHas('bookReturn', function ($returnQuery) use ($startDate, $endDate) {
                    $returnQuery->whereBetween('return_date', [$startDate, $endDate]);
                });
            }
        }

        // Handle condition filter
        if ($request->has('condition') && !empty($request->condition)) {
            $query->whereHas('bookReturn', function ($returnQuery) use ($request) {
                $returnQuery->where('condition_on_return', $request->condition);
            });
        }

        // Order and paginate results
        $returnedBooks = $query->orderBy('updated_at', 'desc')
            ->paginate(10)
            ->appends($request->except('page'));

        $searchTerm = $request->search;
        $dateRange = $request->date_range;
        $conditionFilter = $request->condition;

        return view('dashboard.admin.returned-books.index', compact(
            'returnedBooks',
            'searchTerm',
            'dateRange',
            'conditionFilter'
        ));
    }

    /**
     * Display the specified returned book.
     */
    public function returnedShow($id)
    {
        $borrow = Borrow::with(['user', 'inventory.book', 'bookReturn'])
            ->where('status', 'returned')
            ->findOrFail($id);

        return view('dashboard.admin.returned-books.show', compact('borrow'));
    }

    /**
     * Display a listing of overdue books.
     */
    public function overdueIndex(Request $request)
    {
        $currentDate = DateHelper::now();

        // Start building the query - show books that are overdue by date AND not returned
        $query = Borrow::with(['user', 'inventory.book', 'inventory.book.author', 'staff'])
            ->where('due_date', '<', $currentDate)
            ->where('status', '!=', 'returned'); // Exclude returned books

        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;

            $query->where(function ($q) use ($searchTerm) {
                // Search by borrow ID
                $q->where('borrow_id', 'LIKE', "%{$searchTerm}%")
                    // Search by user name
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('fullname', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('email', 'LIKE', "%{$searchTerm}%");
                    })
                    // Search by book title
                    ->orWhereHas('inventory.book', function ($bookQuery) use ($searchTerm) {
                        $bookQuery->where('title', 'LIKE', "%{$searchTerm}%");
                    })
                    // Search by author name
                    ->orWhereHas('inventory.book.author', function ($authorQuery) use ($searchTerm) {
                        $authorQuery->where('fullname', 'LIKE', "%{$searchTerm}%");
                    })
                    // Search by ISBN
                    ->orWhereHas('inventory.book', function ($bookQuery) use ($searchTerm) {
                        $bookQuery->where('isbn', 'LIKE', "%{$searchTerm}%");
                    });
            });
        }

        // Handle date range filter for due date
        if ($request->has('due_date_range') && !empty($request->due_date_range)) {
            $dates = explode(' - ', $request->due_date_range);

            if (count($dates) === 2) {
                $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();

                $query->whereBetween('due_date', [$startDate, $endDate]);
            }
        }

        // Order and paginate results
        $overdueBooks = $query->orderBy('due_date', 'asc')
            ->paginate(20)
            ->appends($request->except('page'));

        $searchTerm = $request->search;
        $dateRange = $request->due_date_range;

        // Calculate total fines
        $totalFines = $overdueBooks->sum(function ($borrow) use ($currentDate) {
            $daysOverdue = $currentDate->diffInDays($borrow->due_date, false) * -1;
            return max(0, $daysOverdue) * 0.50;
        });

        return view('dashboard.admin.overdue-books.index', compact(
            'overdueBooks',
            'searchTerm',
            'dateRange',
            'totalFines'
        ));
    }

    /**
     * Display details of a specific overdue book.
     */
    public function overdueShow($id)
    {
        $currentDate = DateHelper::now();

        $borrow = Borrow::with([
            'user',
            'inventory.book',
            'inventory.book.author',
            'inventory.book.publisher',
            'inventory.book.category',
            'staff'
        ])->where('due_date', '<', $currentDate)
            ->where('status', '!=', 'returned') // Exclude returned books
            ->findOrFail($id);

        // Calculate whole days overdue
        $overdueDays = $currentDate->diffInDays($borrow->due_date, false) * -1;
        $displayDaysOverdue = max(0, ceil($overdueDays)); // Ensure positive whole number
        $fineAmount = max(0, $displayDaysOverdue) * 0.50;

        return view('dashboard.admin.overdue-books.show', compact('borrow', 'displayDaysOverdue', 'fineAmount'));
    }

    // overdue
    public function updateOverdueStatus()
    {
        $currentDate = DateHelper::now();

        // Find active books where due date has passed
        $overdueBooks = Borrow::where('status', 'active')
            ->where('due_date', '<', $currentDate)
            ->get();

        $count = $overdueBooks->count();

        if ($count > 0) {
            // Update status to overdue
            Borrow::where('status', 'active')
                ->where('due_date', '<', $currentDate)
                ->update(['status' => 'overdue']);

            return redirect()->back()->with('success', "Updated {$count} books to overdue status.");
        }

        return redirect()->back()->with('info', "No books need to be updated to overdue status.");
    }
}
