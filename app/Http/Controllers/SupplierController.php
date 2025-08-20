<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    // Display all suppliers
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);
        return view('dashboard.admin.suppliers.index', compact('suppliers'));
    }

    // Show create form
    public function create()
    {
        return view('dashboard.admin.suppliers.create');
    }

    // Store new supplier
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_name' => 'required|string|max:100',
            'contact_person' => 'required|string|max:100',
            'phone' => 'required|string|max:20|regex:/^[0-9]+$/',
            'email' => 'required|email|max:100',
            'address' => 'nullable|string',
            'discount_rate' => 'nullable|numeric|between:0,100',
        ], [
            'phone.regex' => 'The phone number must contain only numbers.',
            'phone.required' => 'The phone number field is required.',
            'email.required' => 'The email field is required.',
            'contact_person.required' => 'The contact person field is required.',
        ]);

        Supplier::create($validated);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier created successfully!');
    }

    // Show edit form
    public function edit(Supplier $supplier)
    {
        return view('dashboard.admin.suppliers.edit', compact('supplier'));
    }

    // Update supplier
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'supplier_name' => 'required|string|max:100',
            'contact_person' => 'required|string|max:100',
            'phone' => 'required|string|max:20|regex:/^[0-9]+$/',
            'email' => 'required|email|max:100',
            'address' => 'nullable|string',
            'discount_rate' => 'nullable|numeric|between:0,100',
        ], [
            'phone.regex' => 'The phone number must contain only numbers.',
            'phone.required' => 'The phone number field is required.',
            'email.required' => 'The email field is required.',
            'contact_person.required' => 'The contact person field is required.',
        ]);

        $supplier->update($validated);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier updated successfully!');
    }

    // Delete supplier
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier deleted successfully!');
    }
}
