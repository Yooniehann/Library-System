<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * List all books or search books by title/author.
     */
    public function index(Request $request)
    {
        $query = Book::with(['author', 'category', 'publisher', 'availableInventories']);

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhereHas('author', function($q) use ($search) {
                      $q->where('fullname', 'like', "%{$search}%");
                  });
        }

        $books = $query->orderBy('title')->get();

        return response()->json($books);
    }

    /**
     * Get top picks books (most borrowed or newest).
     */
    public function topPicks()
    {
        // Example: Most borrowed books
        $books = Book::with(['author', 'category', 'publisher'])
            ->select('books.*', DB::raw('(SELECT COUNT(*) FROM borrows WHERE borrows.inventory_id IN
                  (SELECT inventory_id FROM inventories WHERE inventories.book_id = books.book_id)) AS borrow_count'))
            ->orderByDesc('borrow_count')
            ->take(10)
            ->get();

        return response()->json($books);
    }

    /**
     * Recommended books: random available books
     */
    public function recommended()
    {
        $books = Book::with(['author', 'category', 'publisher'])
            ->whereHas('availableInventories')
            ->inRandomOrder()
            ->take(10)
            ->get();

        return response()->json($books);
    }

    /**
     * Show single book details (optional, for future use)
     */
    public function show($id)
    {
        $book = Book::with(['author', 'category', 'publisher', 'availableInventories'])
                    ->findOrFail($id);

        return response()->json($book);
    }
}
