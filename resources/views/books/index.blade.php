@extends('layouts.master')

@section('title', 'Browse Your Desired Books')

{{-- Include any specific CSS for this page --}}
@push('styles')
    <style>
        .book-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%; /* Makes cards in a row the same height */
        }
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .book-cover {
            height: 250px;
            object-fit: cover; /* This ensures the image covers the area without stretching */
            object-position: center;
        }
        .card-body {
            display: flex;
            flex-direction: column;
        }
        .card-text {
            flex-grow: 1; /* Pushes the button to the bottom */
        }
    </style>
@endpush

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Our Library Collection</h1>

    {{-- Search Bar --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <form action="{{ route('books.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search by title or author..." value="{{ $search }}">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Book Grid --}}
    @if($books->count() > 0)
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($books as $book)
                <div class="col">
                    <div class="card h-100 book-card">
                        {{-- Display the book cover image --}}
                        <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/default-book-cover.jpg') }}"
                             class="card-img-top book-cover"
                             alt="Cover of {{ $book->title }}"
                             onerror="this.onerror=null; this.src='{{ asset('images/default-book-cover.jpg') }}'">
                        <div class="card-body">
                            <h5 class="card-title">{{ Str::limit($book->title, 30) }}</h5>
                            <p class="card-text text-muted">
                                <strong>By:</strong> {{ $book->author->fullname }}<br>
                                <strong>Published:</strong> {{ $book->publication_year }}
                            </p>
                            {{-- Buttons for Borrow/Reserve --}}
                            <div class="mt-auto"> 
                                <a href="#" class="btn btn-outline-primary btn-sm">View Details</a>
                                @auth <!-- Show these buttons only if user is logged in -->
                                    <a href="#" class="btn btn-primary btn-sm ms-1">Borrow</a>
                                    <a href="#" class="btn btn-secondary btn-sm ms-1">Reserve</a>
                                @else
                                    <p class="text-muted mt-2"><small>Login to borrow or reserve.</small></p>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination Links --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $books->links() }}
        </div>
    @else
        <div class="alert alert-info" role="alert">
            No books found in our collection.
        </div>
    @endif
</div>
@endsection

@push('scripts')
    <!-- Any page-specific scripts would go here -->
@endpush