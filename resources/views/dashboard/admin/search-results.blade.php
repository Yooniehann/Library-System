@extends('dashboard.admin.layouts.index')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Search Results for "{{ $searchQuery }}"</h2>

    @if($books->count() > 0)
        <div class="mb-8">
            <h3 class="text-lg font-medium mb-3">Books</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($books as $book)
                    <!-- Book search result item -->
                    <div class="border rounded-lg p-4 hover:bg-gray-50">
                        <h4 class="font-medium">{{ $book->title }}</h4>
                        <p class="text-sm text-gray-600">{{ $book->author->name }}</p>
                        <p class="text-xs text-gray-500 mt-2">ISBN: {{ $book->isbn }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($authors->count() > 0)
        <div class="mb-8">
            <h3 class="text-lg font-medium mb-3">Authors</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($authors as $author)
                    <!-- Author search result item -->
                    <div class="border rounded-lg p-4 hover:bg-gray-50">
                        <h4 class="font-medium">{{ $author->name }}</h4>
                        <p class="text-sm text-gray-600">{{ $author->books_count }} books</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($members->count() > 0)
        <div class="mb-8">
            <h3 class="text-lg font-medium mb-3">Members</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($members as $member)
                    <!-- Member search result item -->
                    <div class="border rounded-lg p-4 hover:bg-gray-50">
                        <h4 class="font-medium">{{ $member->name }}</h4>
                        <p class="text-sm text-gray-600">{{ $member->email }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($books->count() === 0 && $authors->count() === 0 && $members->count() === 0)
        <div class="text-center py-8">
            <p class="text-gray-500">No results found for "{{ $searchQuery }}"</p>
        </div>
    @endif
</div>
@endsection
