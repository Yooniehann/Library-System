<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Reservation;
use App\Models\Fine;
use App\Models\Payment;
use App\Models\Category;
use App\Models\Author;
use App\Models\StockIn;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Total counts
        $totalUsers = User::count();
        $totalBooks = Book::count();
        $totalBorrows = Borrow::count();
        $activeBorrows = Borrow::where('status', 'active')->count();
        $overdueBorrows = Borrow::where('status', 'overdue')->count();
        $totalReservations = Reservation::count();
        $totalFines = Fine::where('status', 'unpaid')->sum('amount_per_day');
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');

        // Recent activities
        $recentBorrows = Borrow::with(['user', 'inventory.book'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentUsers = User::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Category distribution
        $categories = Category::withCount('books')
            ->orderBy('books_count', 'desc')
            ->take(8)
            ->get();

        // Monthly borrow statistics
        $monthlyBorrows = Borrow::select(
            DB::raw('MONTH(borrow_date) as month'),
            DB::raw('YEAR(borrow_date) as year'),
            DB::raw('COUNT(*) as count')
        )
        ->where('borrow_date', '>=', Carbon::now()->subMonths(6))
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();

        // Format monthly data for chart
        $monthlyData = [];
        foreach ($monthlyBorrows as $stat) {
            $monthName = Carbon::create()->month($stat->month)->format('M');
            $monthlyData[] = [
                'month' => $monthName . ' ' . $stat->year,
                'count' => $stat->count
            ];
        }

        // User role distribution
        $userRoles = User::select('role', DB::raw('COUNT(*) as count'))
            ->groupBy('role')
            ->get();

        // Top authors
        $topAuthors = Author::withCount('books')
            ->orderBy('books_count', 'desc')
            ->take(5)
            ->get();

        // Recent stock ins
        $recentStockIns = StockIn::with(['supplier', 'staff'])
            ->orderBy('stockin_date', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.admin.dashboard', compact(
            'totalUsers',
            'totalBooks',
            'totalBorrows',
            'activeBorrows',
            'overdueBorrows',
            'totalReservations',
            'totalFines',
            'totalRevenue',
            'recentBorrows',
            'recentUsers',
            'categories',
            'monthlyData',
            'userRoles',
            'topAuthors',
            'recentStockIns'
        ));
    }
}
