<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\StockInDetail;
use App\Models\Inventory;
use App\Models\Book;
use Illuminate\Http\Request;

class StockInDetailController extends Controller
{
    // Show create form for stockin detail
    public function create(StockIn $stockin)
    {
        $books = Book::all();
        
        return view('dashboard.admin.stockins.details.create', compact('stockin', 'books'));
    }

    // Store new stockin detail
    public function store(Request $request, StockIn $stockin)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,book_id',
            'received_quantity' => 'required|integer|min:1',
            'price_per_unit' => 'required|numeric|min:0',
            'condition' => 'required|in:New,Good,Fair,Damaged',
            'remarks' => 'nullable|string|max:255'
        ]);

        // Create the StockInDetail
        $detailData = [
            'stockin_id' => $stockin->stockin_id,
            'price_per_unit' => $validated['price_per_unit'],
            'condition' => $validated['condition'],
            'remarks' => $validated['remarks'],
            'received_quantity' => $validated['received_quantity']
        ];
        
        $detail = StockInDetail::create($detailData);
        
        // Create inventory records for each book
        for ($i = 0; $i < $validated['received_quantity']; $i++) {
            Inventory::create([
                'book_id' => $validated['book_id'],
                'stockin_detail_id' => $detail->stockin_detail_id,
                'status' => 'Available',
                'condition' => $validated['condition']
            ]);
        }
        
        // Update the total_books in stockin
        $stockin->total_books += $validated['received_quantity'];
        $stockin->save();

        return redirect()->route('admin.stockins.show', $stockin)
            ->with('success', 'Book added to StockIn successfully!');
    }

    // Show edit form for stockin detail
    public function edit(StockIn $stockin, StockInDetail $detail)
    {
        $books = Book::all();
        
        // Get the book from the first inventory item associated with this detail
        $inventoryItem = $detail->inventories->first();
        $selectedBookId = $inventoryItem ? $inventoryItem->book_id : null;
        
        return view('dashboard.admin.stockins.details.edit', compact('stockin', 'detail', 'books', 'selectedBookId'));
    }

    // Update stockin detail
    public function update(Request $request, StockIn $stockin, StockInDetail $detail)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,book_id',
            'received_quantity' => 'required|integer|min:1',
            'price_per_unit' => 'required|numeric|min:0',
            'condition' => 'required|in:New,Good,Fair,Damaged',
            'remarks' => 'nullable|string|max:255'
        ]);

        // Calculate the difference in quantity for updating total_books
        $oldQuantity = $detail->received_quantity;
        $newQuantity = $validated['received_quantity'];
        $quantityDiff = $newQuantity - $oldQuantity;
        
        // Update the detail
        $detail->update([
            'price_per_unit' => $validated['price_per_unit'],
            'condition' => $validated['condition'],
            'remarks' => $validated['remarks'],
            'received_quantity' => $newQuantity
        ]);
        
        // Update inventory records if book_id changed or quantity changed
        $inventoryItems = $detail->inventories;
        
        if ($inventoryItems->isNotEmpty() && $inventoryItems->first()->book_id != $validated['book_id']) {
            // Book changed - update all inventory items
            foreach ($inventoryItems as $item) {
                $item->update(['book_id' => $validated['book_id']]);
            }
        }
        
        // Handle quantity changes
        if ($quantityDiff > 0) {
            // Add more inventory items
            for ($i = 0; $i < $quantityDiff; $i++) {
                Inventory::create([
                    'book_id' => $validated['book_id'],
                    'stockin_detail_id' => $detail->stockin_detail_id,
                    'status' => 'Available',
                    'condition' => $validated['condition']
                ]);
            }
        } elseif ($quantityDiff < 0) {
            // Remove some inventory items (remove the latest ones)
            $itemsToRemove = abs($quantityDiff);
            $inventoryItems->take($itemsToRemove)->each->delete();
        }
        
        // Update the total_books in stockin
        $stockin->total_books += $quantityDiff;
        $stockin->save();

        return redirect()->route('admin.stockins.show', $stockin)
            ->with('success', 'StockIn detail updated successfully!');
    }

    // Delete stockin detail
    public function destroy(StockIn $stockin, StockInDetail $detail)
    {
        // Update the total_books in stockin before deletion
        $stockin->total_books -= $detail->received_quantity;
        $stockin->save();
        
        // Delete associated inventory items
        $detail->inventories()->delete();
        
        // Delete the detail
        $detail->delete();

        return redirect()->route('admin.stockins.show', $stockin)
            ->with('success', 'StockIn detail deleted successfully!');
    }
}