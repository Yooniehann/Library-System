<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    // Display all categories
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('dashboard.admin.categories.index', compact('categories'));
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
