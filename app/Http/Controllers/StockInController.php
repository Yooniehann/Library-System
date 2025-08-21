<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\Supplier;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StockInController extends Controller
{
    // Display all stockins with search/filter
    public function index(Request $request)
    {
        $query = StockIn::with(['supplier', 'staff']);

        // Search by supplier name
        if ($request->has('supplier') && !empty($request->supplier)) {
            $query->whereHas('supplier', function ($q) use ($request) {
                $q->where('supplier_name', 'like', '%' . $request->supplier . '%');
            });
        }

        // Search by staff name
        if ($request->has('staff') && !empty($request->staff)) {
            $query->whereHas('staff', function ($q) use ($request) {
                $q->where('fullname', 'like', '%' . $request->staff . '%');
            });
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('from_date') && !empty($request->from_date)) {
            $query->whereDate('stockin_date', '>=', $request->from_date);
        }

        if ($request->has('to_date') && !empty($request->to_date)) {
            $query->whereDate('stockin_date', '<=', $request->to_date);
        }

        $stockins = $query->latest()->paginate(10);

        return view('dashboard.admin.stockins.index', compact('stockins'));
    }

    // Show create form
    public function create()
    {
        $suppliers = Supplier::all();
        $staff = Staff::all();

        return view('dashboard.admin.stockins.create', compact('suppliers', 'staff'));
    }

    // Store new stockin
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'staff_id' => 'required|exists:staff,staff_id',
            'stockin_date' => 'required|date',
            'status' => 'required|in:Pending,Received,Canceled'
        ]);

        $validated['total_books'] = 0; // Initialize with 0 books

        StockIn::create($validated);

        return redirect()->route('admin.stockins.index')
            ->with('success', 'StockIn created successfully!');
    }

    // In StockInController show method
    public function show(StockIn $stockin)
    {
        $stockin->load(['supplier', 'staff', 'details.book', 'details.inventories']);

        return view('dashboard.admin.stockins.show', compact('stockin'));
    }


    // Show edit form
    public function edit(StockIn $stockin)
    {
        $suppliers = Supplier::all();
        $staff = Staff::all();

        return view('dashboard.admin.stockins.edit', compact('stockin', 'suppliers', 'staff'));
    }

    // Update stockin
    public function update(Request $request, StockIn $stockin)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'staff_id' => 'required|exists:staff,staff_id',
            'stockin_date' => 'required|date',
            'status' => 'required|in:Pending,Received,Canceled'
        ]);

        $stockin->update($validated);

        return redirect()->route('admin.stockins.index')
            ->with('success', 'StockIn updated successfully!');
    }

    // Delete stockin
    public function destroy(StockIn $stockin)
    {
        // Prevent deletion if there are details
        if ($stockin->details()->count() > 0) {
            return redirect()->route('admin.stockins.index')
                ->with('error', 'Cannot delete StockIn with associated details!');
        }

        $stockin->delete();

        return redirect()->route('admin.stockins.index')
            ->with('success', 'StockIn deleted successfully!');
    }
}
