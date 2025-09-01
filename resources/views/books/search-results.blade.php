@extends('layouts.master')

@section('title', 'Search Results')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
            --yellow-300: #fde68a;
            --yellow-400: #fbbf24;
            --text-light: #f8fafc;
            --text-dark: #1e293b;
            --glass-border: rgba(255, 255, 255, 0.1);
            --glass-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        body {
            background: linear-gradient(to bottom, var(--slate-800), var(--slate-900));
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-light);
        }

        .page-container {
            min-height: 100vh;
            padding: 2rem 0;
        }

        /* Book Card Styling */
        .book-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            border: 1px solid var(--glass-border);
            box-shadow: var(--glass-shadow);
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25);
            border-color: var(--yellow-300);
        }

        .book-cover-container {
            height: 280px;
            overflow: hidden;
            position: relative;
            background: linear-gradient(45deg, #1e293b, #334155);
        }

        .book-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .book-card:hover .book-cover {
            transform: scale(1.08);
        }

        .badge-available {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(40, 167, 69, 0.95);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .badge-unavailable {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(239, 68, 68, 0.95);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            height: calc(100% - 280px);
        }

        .card-title {
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 0.75rem;
            color: var(--text-light);
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-text {
            color: #cbd5e1;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .card-author {
            color: var(--yellow-300);
            font-weight: 600;
            font-size: 0.95rem;
        }

        .card-price {
            color: var(--yellow-300);
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0.75rem 0;
        }

        .card-actions {
            margin-top: auto;
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn-view {
            background: transparent;
            border: 2px solid var(--yellow-300);
            color: var(--yellow-300);
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
            flex-grow: 1;
            text-align: center;
        }

        .btn-view:hover {
            background: var(--yellow-300);
            color: var(--slate-800);
            transform: translateY(-2px);
        }

        .btn-borrow {
            background: var(--yellow-300);
            color: var(--slate-800);
            border: none;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 700;
            transition: all 0.3s ease;
            flex-grow: 1;
        }

        .btn-borrow:hover {
            background: var(--yellow-400);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
        }

        .btn-reserve {
            background: #8b5cf6;
            color: white;
            border: none;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 700;
            transition: all 0.3s ease;
            flex-grow: 1;
        }

        .btn-reserve:hover {
            background: #7c3aed;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        }

        /* Search Results Section */
        .search-results-section {
            margin: 2rem 0;
            padding: 0 15px;
        }

        .search-results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--yellow-300);
        }

        .search-results-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--yellow-300);
            margin: 0;
        }

        .results-count {
            font-size: 1.1rem;
            color: #cbd5e1;
            background: rgba(30, 41, 59, 0.7);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            border: 1px solid var(--glass-border);
        }

        .search-results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 1rem;
        }

        /* Search Bar */
        .search-section {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2.5rem;
            margin-bottom: 3rem;
            border: 1px solid var(--glass-border);
            text-align: center;
        }

        .page-title {
            font-weight: 800;
            color: var(--yellow-300);
            margin-bottom: 1.5rem;
            text-align: center;
            font-size: 2.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .search-container {
            position: relative;
            max-width: 700px;
            margin: 0 auto;
        }

        .search-input {
            width: 100%;
            padding: 1rem 2rem;
            padding-right: 60px;
            background: rgba(15, 23, 42, 0.7);
            border: 2px solid var(--glass-border);
            border-radius: 50px;
            color: var(--text-light);
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--yellow-300);
            box-shadow: 0 0 0 4px rgba(253, 230, 138, 0.2);
            background: rgba(15, 23, 42, 0.9);
        }

        .search-btn {
            position: absolute;
            right: 8px;
            top: 8px;
            background: var(--yellow-300);
            color: var(--slate-800);
            border: none;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(251, 191, 36, 0.3);
        }

        .search-btn:hover {
            background: var(--yellow-400);
            transform: rotate(15deg) scale(1.1);
            box-shadow: 0 6px 15px rgba(251, 191, 36, 0.4);
        }

        /* Login Prompt */
        .login-prompt {
            font-size: 0.85rem;
            color: #94a3b8;
            text-align: center;
            margin-top: 0.75rem;
            width: 100%;
            padding: 0.5rem;
            background: rgba(30, 41, 59, 0.5);
            border-radius: 6px;
            border: 1px solid var(--glass-border);
        }

        .admin-prompt {
            font-size: 0.85rem;
            color: #fbbf24;
            text-align: center;
            margin-top: 0.75rem;
            width: 100%;
            padding: 0.5rem;
            background: rgba(251, 191, 36, 0.1);
            border-radius: 6px;
            border: 1px solid rgba(251, 191, 36, 0.3);
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
        }

        .pagination {
            display: flex;
            gap: 0.75rem;
        }

        .page-item {
            list-style: none;
        }

        .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            border-radius: 10px;
            background: rgba(30, 41, 59, 0.7);
            color: var(--yellow-300);
            text-decoration: none;
            border: 2px solid var(--glass-border);
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .page-link:hover {
            background: var(--yellow-300);
            color: var(--slate-800);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
        }

        .page-item.active .page-link {
            background: var(--yellow-300);
            color: var(--slate-800);
            border-color: var(--yellow-300);
            box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
        }

        /* No Results Styling */
        .no-results {
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(30, 41, 59, 0.5);
            border-radius: 15px;
            border: 1px solid var(--glass-border);
            margin: 2rem 0;
        }

        .no-results-icon {
            font-size: 4rem;
            color: var(--yellow-300);
            margin-bottom: 1.5rem;
            opacity: 0.8;
        }

        .no-results h3 {
            font-size: 1.8rem;
            color: var(--yellow-300);
            margin-bottom: 1rem;
        }

        .no-results p {
            color: #cbd5e1;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .btn-browse {
            background: var(--yellow-300);
            color: var(--slate-800);
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 8px;
            font-weight: 700;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-browse:hover {
            background: var(--yellow-400);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(251, 191, 36, 0.3);
        }

        /* Responsive Adjustments */
        @media (max-width: 1200px) {
            .search-results-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 992px) {
            .search-results-title {
                font-size: 1.8rem;
            }

            .book-cover-container {
                height: 250px;
            }

            .search-results-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            }

            .page-title {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 768px) {
            .search-results-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .book-cover-container {
                height: 220px;
            }

            .search-results-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 20px;
            }

            .search-section {
                padding: 2rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .search-input {
                padding: 0.875rem 1.5rem;
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .card-actions {
                flex-direction: column;
            }

            .book-cover-container {
                height: 200px;
            }

            .search-results-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .search-section {
                padding: 1.5rem;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .search-results-title {
                font-size: 1.6rem;
            }

            .card-body {
                padding: 1.25rem;
            }
        }

        /* Animation for page load */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .search-results-section {
            animation: fadeIn 0.6s ease forwards;
        }

        /* Book card animation */
        @keyframes cardAppear {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(10px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .book-card {
            animation: cardAppear 0.5s ease forwards;
        }

        /* Stagger animation for cards */
        .search-results-grid .book-card:nth-child(1) { animation-delay: 0.1s; }
        .search-results-grid .book-card:nth-child(2) { animation-delay: 0.2s; }
        .search-results-grid .book-card:nth-child(3) { animation-delay: 0.3s; }
        .search-results-grid .book-card:nth-child(4) { animation-delay: 0.4s; }
        .search-results-grid .book-card:nth-child(5) { animation-delay: 0.5s; }
    </style>
@endpush

@section('content')
    <div class="page-container">
        <div class="container py-4">
            <!-- Search Section -->
            <div class="search-section">
                <h1 class="page-title">Search Results</h1>
                <div class="search-container">
                    <form action="{{ route('books.index') }}" method="GET">
                        <input type="text" name="search" class="search-input"
                            placeholder="Search by title, author, or category..." value="{{ $search }}">
                        <button class="search-btn" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Search Results -->
            <div class="search-results-section">
                <div class="search-results-header">
                    <h2 class="search-results-title">Results for "{{ $search }}"</h2>
                    <span class="results-count">{{ $books->total() }} result(s) found</span>
                </div>

                @if ($books->count() > 0)
                    <div class="search-results-grid">
                        @foreach ($books as $book)
                            <div class="book-card">
                                <div class="book-cover-container">
                                    <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/default-book-cover.jpg') }}"
                                        class="book-cover" alt="Cover of {{ $book->title }}"
                                        onerror="this.onerror=null; this.src='{{ asset('images/default-book-cover.jpg') }}'">
                                    @if ($book->inventories->count() > 0)
                                        <span class="badge-available">{{ $book->inventories->count() }} Available</span>
                                    @else
                                        <span class="badge-unavailable">Out of Stock</span>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $book->title }}</h5>
                                    <p class="card-text card-author">By: {{ $book->author->fullname }}</p>
                                    <p class="card-text">Published: {{ $book->publication_year }}</p>
                                    <p class="card-price">${{ number_format($book->pricing, 2) }}</p>
                                    <div class="card-actions">
                                        <a href="{{ route('books.show', $book->book_id) }}" class="btn-view">View Details</a>
                                        @auth
                                            @if (Auth::user()->role === 'Guest')
                                                <span class="login-prompt">Upgrade membership to borrow</span>
                                            @elseif (Auth::user()->role === 'Member' || Auth::user()->role === 'Kid')
                                                @if ($book->inventories->count() > 0)
                                                    <form action="{{ route('borrow.create', $book->book_id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn-borrow">Borrow</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('reservations.create', $book->book_id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn-reserve">Reserve</button>
                                                    </form>
                                                @endif
                                            @else
                                                <span class="admin-prompt">Admins cannot borrow books</span>
                                            @endif
                                        @else
                                            <span class="login-prompt">Login to borrow</span>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($books->hasPages())
                        <div class="pagination-container">
                            {{ $books->links() }}
                        </div>
                    @endif
                @else
                    <div class="no-results">
                        <i class="fas fa-book-open no-results-icon"></i>
                        <h3>No books found</h3>
                        <p>We couldn't find any books matching "{{ $search }}". Try different keywords or browse our collection.</p>
                        <a href="{{ route('books.index') }}" class="btn-browse">Browse All Books</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection