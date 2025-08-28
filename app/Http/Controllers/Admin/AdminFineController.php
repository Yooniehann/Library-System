<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fine;
use App\Models\Borrow;
use Illuminate\Http\Request;
use App\Helpers\DateHelper;

class AdminFineController extends Controller
{
    /**
     * Display a listing of fines.
     */
    public function index(Request $request)
    {
        // Automatically generate overdue fines first
        $this->generateOverdueFines();

        $query = Fine::with(['borrow', 'borrow.user', 'borrow.inventory.book', 'payment']);

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('fine_id', 'LIKE', "%{$searchTerm}%")
                    ->orWhereHas('borrow.user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('fullname', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('email', 'LIKE', "%{$searchTerm}%");
                    })
                    ->orWhereHas('borrow.inventory.book', function ($bookQuery) use ($searchTerm) {
                        $bookQuery->where('title', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('isbn', 'LIKE', "%{$searchTerm}%");
                    });
            });
        }

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Type filter
        if ($request->has('type') && !empty($request->type)) {
            $query->where('fine_type', $request->type);
        }

        $fines = $query->orderBy('fine_date', 'desc')
            ->paginate(20)
            ->appends($request->except('page'));

        // Calculate total amounts including days overdue
        $stats = [
            'total' => Fine::count(),
            'unpaid' => Fine::unpaid()->count(),
            'paid' => Fine::paid()->count(),
            'waived' => Fine::waived()->count(),
            'total_amount' => Fine::with('borrow')->get()->sum(function ($fine) {
                return $this->calculateTotalFineAmount($fine);
            }),
            'unpaid_amount' => Fine::unpaid()->with('borrow')->get()->sum(function ($fine) {
                return $this->calculateTotalFineAmount($fine);
            }),
        ];

        return view('dashboard.admin.fines.index', compact('fines', 'stats'));
    }

    /**
     * Calculate total fine amount based on days overdue
     */
    private function calculateTotalFineAmount($fine)
    {
        if ($fine->fine_type !== 'overdue') {
            return $fine->amount_per_day;
        }

        $currentDate = DateHelper::now();
        $dueDate = $fine->borrow->due_date;

        // Calculate whole days overdue (ceil to ensure we count partial days as full days)
        $daysOverdue = max(0, ceil($currentDate->diffInHours($dueDate, false) / 24 * -1));

        return $daysOverdue * $fine->amount_per_day;
    }

    /**
     * Automatically generate overdue fines
     */
    private function generateOverdueFines()
    {
        $currentDate = DateHelper::now();

        $overdueBooks = Borrow::with(['user', 'inventory.book'])
            ->where('due_date', '<', $currentDate)
            ->where('status', '!=', 'returned')
            ->whereDoesntHave('fines', function ($query) {
                // Changed from checking only unpaid fines to checking ANY fines
                $query->where('fine_type', 'overdue');
            })
            ->get();

        foreach ($overdueBooks as $borrow) {
            // Calculate whole days overdue (ceil to ensure we count partial days as full days)
            $daysOverdue = max(0, ceil($currentDate->diffInHours($borrow->due_date, false) / 24 * -1));

            // Check if ANY overdue fine exists for this borrow (regardless of status)
            $existingFine = Fine::where('borrow_id', $borrow->borrow_id)
                ->where('fine_type', 'overdue')
                ->first();

            if (!$existingFine) {
                Fine::create([
                    'borrow_id' => $borrow->borrow_id,
                    'fine_type' => 'overdue',
                    'amount_per_day' => 1.00,
                    'description' => "Overdue fine for '{$borrow->inventory->book->title}'. " .
                    ($daysOverdue == 1 ? "1 day overdue." : "{$daysOverdue} days overdue."),
                    'fine_date' => $currentDate,
                    'status' => 'unpaid',
                ]);
            }
        }
    }

    /**
     * Display the specified fine.
     */
    public function show($id)
    {
        $fine = Fine::with(['borrow', 'borrow.user', 'borrow.inventory.book', 'payment'])
            ->findOrFail($id);

        // Calculate total amount for overdue fines
        $totalAmount = $this->calculateTotalFineAmount($fine);

        return view('dashboard.admin.fines.show', compact('fine', 'totalAmount'));
    }

    /**
     * Waive a fine (mark as waived).
     */
    public function waive($id)
    {
        $fine = Fine::findOrFail($id);
        $fine->update(['status' => 'waived']);

        return redirect()->route('admin.fines.index')->with('success', 'Fine waived successfully!');
    }
}
