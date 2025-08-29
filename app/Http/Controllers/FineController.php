<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Fine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\DateHelper;

class FineController extends Controller
{
    /**
     * Display a listing of the member's fines.
     */
    public function index()
    {
        $fines = Fine::with(['borrow', 'borrow.inventory.book'])
            ->whereHas('borrow', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('fine_id', 'desc')
            ->paginate(10);

        // Calculate totals
        $totalFines = Fine::whereHas('borrow', function($query) {
            $query->where('user_id', Auth::id());
        })->get();

        $unpaidFines = $totalFines->where('status', 'unpaid');

        $stats = [
            'total' => $totalFines->count(),
            'unpaid' => $unpaidFines->count(),
            'total_amount' => $totalFines->sum('total_amount'),
            'unpaid_amount' => $unpaidFines->sum('total_amount'),
        ];

        return view('dashboard.member.fines.index', compact('fines', 'stats'));
    }

    /**
     * Display the specified fine.
     */
    public function show($id)
    {
        $fine = Fine::with(['borrow', 'borrow.inventory.book', 'borrow.bookReturn', 'payment'])
            ->whereHas('borrow', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($id);

        return view('dashboard.member.fines.show', compact('fine'));
    }
}