<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    // Display all categories with optional search
    public function index(Request $request)
    {
        $query = Category::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;

            $query->where(function ($q) use ($searchTerm) {
                $q->where('category_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        $categories = $query->latest()->paginate(10);

        // Pass search term to view to maintain it in the search input
        return view('dashboard.admin.categories.index', compact('categories'))
            ->with('searchTerm', $request->search);
    }

    // Show create form
    public function create()
    {
        return view('dashboard.admin.categories.create');
    }

    // Store new category
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:50|unique:categories',
            'description' => 'nullable|string',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    // Show edit form
    public function edit(Category $category)
    {
        return view('dashboard.admin.categories.edit', compact('category'));
    }

    // Update category
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'category_name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('categories')->ignore($category->category_id, 'category_id')
            ],
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    // Delete category
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}
