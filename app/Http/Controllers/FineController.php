<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FineController extends Controller
{
    /**
     * Display a listing of the fines for the authenticated user.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $searchTerm = $request->input('search');
        
        $fines = Fine::with(['borrow', 'borrow.book', 'payment'])
            ->whereHas('borrow', function($query) use ($user) {
                $query->where('user_id', $user->user_id);
            })
            ->when($searchTerm, function($query) use ($searchTerm) {
                $query->where(function($q) use ($searchTerm) {
                    $q->where('fine_type', 'like', "%{$searchTerm}%")
                      ->orWhere('status', 'like', "%{$searchTerm}%")
                      ->orWhere('description', 'like', "%{$searchTerm}%")
                      ->orWhereHas('borrow.book', function($q) use ($searchTerm) {
                          $q->where('title', 'like', "%{$searchTerm}%");
                      });
                });
            })
            ->orderBy('fine_date', 'desc')
            ->paginate(10);

        $totalUnpaidFines = $user->unpaidFines()->sum('amount_per_day');
        $totalPaidFines = $user->fines()->where('fines.status', 'paid')->sum('amount_per_day');

        return view('dashboard.member.fines.index', compact('fines', 'totalUnpaidFines', 'totalPaidFines', 'searchTerm'));
    }

    /**
     * Display the specified fine.
     */
    public function show($fine_id)
    {
        $user = Auth::user();
        $fine = Fine::with(['borrow', 'borrow.book', 'borrow.inventory', 'payment'])
            ->where('fine_id', $fine_id)
            ->whereHas('borrow', function($query) use ($user) {
                $query->where('user_id', $user->user_id);
            })
            ->firstOrFail();

        return view('dashboard.member.fines.show', compact('fine'));
    }
}