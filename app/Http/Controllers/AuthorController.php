<?php
 
namespace App\Http\Controllers;
 
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
 
class AuthorController extends Controller
{
    // Display all authors
    public function index()
    {
        $authors = Author::latest()->paginate(10);
        return view('dashboard.admin.authors.index', compact('authors'));
    }
 
    // Show create form
    public function create()
    {
        return view('dashboard.admin.authors.create');
    }
 
    // Store new author
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:100|unique:authors',
            'biography' => 'nullable|string',
            'nationality' => 'nullable|string|max:50',
            'birth_year' => 'nullable|integer|min:1000|max:' . date('Y'),
        ]);
 
        Author::create($validated);
 
        return redirect()->route('admin.authors.index')
            ->with('success', 'Author created successfully!');
    }
 
    // Show edit form
    public function edit(Author $author)
    {
        return view('dashboard.admin.authors.edit', compact('author'));
    }
 
    // Update author
    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'fullname' => [
                'required',
                'string',
                'max:100',
                Rule::unique('authors')->ignore($author->author_id, 'author_id')
            ],
            'biography' => 'nullable|string',
            'nationality' => 'nullable|string|max:50',
            'birth_year' => 'nullable|integer|min:1000|max:' . date('Y'),
        ]);
 
        $author->update($validated);
 
        return redirect()->route('admin.authors.index')
            ->with('success', 'Author updated successfully!');
    }
 
    // Delete author
    public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->route('admin.authors.index')
            ->with('success', 'Author deleted successfully!');
    }
}