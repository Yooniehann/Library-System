<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Book;

class CatalogController extends Controller
{
    /**
     * Display a listing of the books for the public catalog.
     */
    public function books(Request $request)
    {
        $search = $request->input('search');

        // If there's a search query, show search results
        if ($search) {
            $books = Book::with(['author', 'category'])
                ->where('title', 'like', '%' . $search . '%')
                ->orWhereHas('author', function ($q) use ($search) {
                    $q->where('fullname', 'like', '%' . $search . '%');
                })
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('category_name', 'like', '%' . $search . '%');
                })
                ->paginate(12)
                ->appends(['search' => $search]);

            return view('books.index', compact('books', 'search'));
        }

        // Otherwise, show categories with their books (5 categories per page)
        $categories = Category::with(['books' => function ($query) {
            $query->with('author')->limit(10); // Limit books per category
        }])
        ->whereHas('books') // Only include categories that have books
        ->paginate(5, ['*'], 'cat_page')
        ->appends(['search' => $search]);

        return view('books.index', compact('categories', 'search'));
    }
}
