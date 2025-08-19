<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\User;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Search in multiple models
        $books = Book::where('title', 'like', "%{$query}%")
                    ->orWhere('isbn', 'like', "%{$query}%")
                    ->paginate(10);

        $authors = Author::where('name', 'like', "%{$query}%")
                        ->paginate(10);

        $members = User::where('name', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%")
                        ->paginate(10);

        return view('dashboard.admin.search-results', [
            'books' => $books,
            'authors' => $authors,
            'members' => $members,
            'searchQuery' => $query
        ]);
    }
}
