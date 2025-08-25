@extends('dashboard.admin.index')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Manage Books</h1>
        <a href="{{ route('admin.books.create') }}" 
           class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded">
            Add New Book
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Bar -->
    <div class="mb-6">
        <form action="{{ route('admin.books.index') }}" method="GET" class="flex items-center">
            <div class="relative flex-1">
                <input type="text" name="search" id="search" 
                       class="bg-slate-700 text-white border border-gray-600 rounded-l-lg w-full py-2 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                       placeholder="Search by title, author, category, or publisher..."
                       value="{{ request('search') }}">
                @if(request('search'))
                    <a href="{{ route('admin.books.index') }}" 
                       class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white">
                        <i class="fa-solid fa-times"></i>
                    </a>
                @endif
            </div>
            <button type="submit" 
                    class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded-r-lg">
                <i class="fa-solid fa-search"></i>
            </button>
        </form>
    </div>

    <!-- Results Count -->
    @if(request('search'))
        <div class="mb-4">
            <p class="text-gray-300">
                Found {{ $books->total() }} result(s) for "{{ request('search') }}"
                <a href="{{ route('admin.books.index') }}" class="text-yellow-400 hover:text-yellow-500 ml-4">
                    Clear search
                </a>
            </p>
        </div>
    @endif

    <div class="bg-slate-800 rounded-lg shadow overflow-hidden">
        @if($books->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-slate-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Publisher</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-slate-800 divide-y divide-gray-700">
                    @foreach($books as $book)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $book->book_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">{{ $book->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $book->author->fullname }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $book->category->category_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $book->publisher->publisher_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">${{ number_format($book->pricing, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.books.edit', $book) }}" 
                                   class="text-yellow-400 hover:text-yellow-500"><i class="fa-solid fa-pen-to-square"></i></a>
                                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this book?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
            
        @else
            <div class="p-8 text-center">
                <p class="text-gray-400 text-lg">
                    @if(request('search'))
                        No books found for "{{ request('search') }}". 
                        <a href="{{ route('admin.books.index') }}" class="text-yellow-400 hover:text-yellow-500">
                            View all books
                        </a>
                    @else
                        No books available. 
                        <a href="{{ route('admin.books.create') }}" class="text-yellow-400 hover:text-yellow-500">
                            Add your first book
                        </a>
                    @endif
                </p>
            </div>
        @endif
    </div>

    @if($books->count() > 0)
        <div class="mt-4">
            {{ $books->appends(['search' => request('search')])->links() }}
        </div>
    @endif
</div>
@endsection