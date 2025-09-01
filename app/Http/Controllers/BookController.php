<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $books = Book::with(['author', 'publisher', 'category'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                        ->orWhereHas('author', function ($q) use ($search) {
                            $q->where('fullname', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('category', function ($q) use ($search) {
                            $q->where('category_name', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('publisher', function ($q) use ($search) {
                            $q->where('publisher_name', 'like', '%' . $search . '%');
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]); // Keep search parameter in pagination links

        return view('dashboard.admin.books.index', compact('books', 'search'));
    }

    // Welcome page with new arrivals and bestsellers
    public function welcome()
    {
        $newArrivals = Book::with(['author', 'inventories'])
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $bestsellers = Book::with(['author', 'inventories'])
            ->withCount('borrows')
            ->orderBy('borrows_count', 'desc')
            ->take(4)
            ->get();

        return view('welcome', compact('newArrivals', 'bestsellers'));
    }

    // Show create form
    public function create()
    {
        $authors = Author::orderBy('fullname')->get();
        $publishers = Publisher::orderBy('publisher_name')->get();
        $categories = Category::orderBy('category_name')->get();

        return view('dashboard.admin.books.create', compact('authors', 'publishers', 'categories'));
    }

    // Store new book
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|max:20|unique:books',
            'author_id' => 'required|exists:authors,author_id',
            'publisher_id' => 'required|exists:publishers,publisher_id',
            'category_id' => 'required|exists:categories,category_id',
            'publication_year' => 'required|integer|min:1000|max:' . (date('Y') + 1),
            'language' => 'required|string|max:50',
            'pages' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'pricing' => 'required|numeric|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif,jfif|max:2048',
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('book-covers', 'public');
            $validated['cover_image'] = $imagePath;
        }

        Book::create($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Book created successfully!');
    }

    // Show edit form
    public function edit(Book $book)
    {
        $authors = Author::orderBy('fullname')->get();
        $publishers = Publisher::orderBy('publisher_name')->get();
        $categories = Category::orderBy('category_name')->get();

        return view('dashboard.admin.books.edit', compact('book', 'authors', 'publishers', 'categories'));
    }

    // Update book
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => [
                'required',
                'string',
                'max:20',
                Rule::unique('books')->ignore($book->book_id, 'book_id')
            ],
            'author_id' => 'required|exists:authors,author_id',
            'publisher_id' => 'required|exists:publishers,publisher_id',
            'category_id' => 'required|exists:categories,category_id',
            'publication_year' => 'required|integer|min:1000|max:' . (date('Y') + 1),
            'language' => 'required|string|max:50',
            'pages' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'pricing' => 'required|numeric|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }

            $imagePath = $request->file('cover_image')->store('book-covers', 'public');
            $validated['cover_image'] = $imagePath;
        }

        $book->update($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Book updated successfully!');
    }

    // Delete book
    public function destroy(Book $book)
    {
        // Delete cover image if exists
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Book deleted successfully!');
    }

    public function show($bookId)
    {
        $book = Book::with(['author', 'category', 'inventories'])
            ->findOrFail($bookId);

        return view('books.show', compact('book'));
    }
}
