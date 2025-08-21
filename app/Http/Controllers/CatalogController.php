<?php

namespace App\Http\Controllers;

use App\Models\Book; // Import the Book model
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Display a listing of the books for the public catalog.
     */
    public function books(Request $request)
    {
        // You can keep the search functionality for users too!
        $search = $request->input('search');

        $books = Book::with(['author', 'publisher', 'category'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhereHas('author', function ($q) use ($search) {
                          $q->where('fullname', 'like', '%' . $search . '%');
                      });
                });
            })
            ->latest()
            ->paginate(12) // Show 12 books per page for a nice grid
            ->appends(['search' => $search]);

        // Pass the data to a view located in 'books/index.blade.php'
        return view('books.index', compact('books', 'search'));
    }
}