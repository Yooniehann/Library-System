@extends('layouts.master')

@section('title', 'Browse Your Desired Books')

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

    /* Category Section Styling */
    .category-section {
        margin-bottom: 3rem;
        padding: 0 15px;
    }

    .category-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--yellow-300);
    }

    .category-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--yellow-300);
        margin: 0;
    }

    .see-all-btn {
        background: transparent;
        color: var(--yellow-300);
        border: 1px solid var(--yellow-300);
        padding: 0.5rem 1rem;
        border-radius: 4px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .see-all-btn:hover {
        background: var(--yellow-300);
        color: var(--slate-800);
    }

    /* Book Card Styling */
    .book-card {
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 10px;
        border: 1px solid var(--glass-border);
        box-shadow: var(--glass-shadow);
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        border-color: var(--yellow-300);
    }

    .book-cover-container {
        height: 250px;
        overflow: hidden;
        position: relative;
    }

    .book-cover {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .book-card:hover .book-cover {
        transform: scale(1.05);
    }

    .badge-available {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(40, 167, 69, 0.9);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .card-body {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        height: calc(100% - 250px);
    }

    .card-title {
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        color: var(--text-light);
        line-height: 1.3;
    }

    .card-text {
        color: #cbd5e1;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .card-author {
        color: var(--yellow-300);
        font-weight: 500;
    }

    .card-actions {
        margin-top: auto;
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-view {
        background: transparent;
        border: 1px solid var(--yellow-300);
        color: var(--yellow-300);
        padding: 0.4rem 0.8rem;
        border-radius: 4px;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        flex-grow: 1;
        text-align: center;
    }

    .btn-view:hover {
        background: var(--yellow-300);
        color: var(--slate-800);
    }

    .btn-borrow {
        background: var(--yellow-300);
        color: var(--slate-800);
        border: none;
        padding: 0.4rem 0.8rem;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
        flex-grow: 1;
    }

    .btn-borrow:hover {
        background: var(--yellow-400);
        transform: translateY(-2px);
    }

    /* Custom Slider Styling */
    .books-slider {
        position: relative;
        padding: 0 40px;
    }

    .slider-container {
        display: flex;
        overflow-x: auto;
        scroll-behavior: smooth;
        gap: 20px;
        padding: 10px 0;
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* IE and Edge */
    }

    .slider-container::-webkit-scrollbar {
        display: none; /* Chrome, Safari and Opera */
    }

    .slider-item {
        flex: 0 0 calc(20% - 20px);
        min-width: 220px;
    }

    .slider-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: var(--slate-700);
        border: 1px solid var(--yellow-300);
        color: var(--yellow-300);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
    }

    .slider-btn:hover {
        background: var(--yellow-300);
        color: var(--slate-800);
    }

    .slider-btn-prev {
        left: 0;
    }

    .slider-btn-next {
        right: 0;
    }

    /* Search Bar */
    .search-section {
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 10px;
        padding: 2rem;
        margin-bottom: 3rem;
        border: 1px solid var(--glass-border);
    }

    .page-title {
        font-weight: 700;
        color: var(--yellow-300);
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .search-container {
        position: relative;
        max-width: 600px;
        margin: 0 auto;
    }

    .search-input {
        width: 100%;
        padding: 0.75rem 1.5rem;
        padding-right: 50px;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid var(--glass-border);
        border-radius: 50px;
        color: var(--text-light);
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--yellow-300);
        box-shadow: 0 0 0 3px rgba(253, 230, 138, 0.3);
    }

    .search-btn {
        position: absolute;
        right: 5px;
        top: 5px;
        background: var(--yellow-300);
        color: var(--slate-800);
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .search-btn:hover {
        background: var(--yellow-400);
        transform: rotate(15deg);
    }

    /* Login Prompt */
    .login-prompt {
        font-size: 0.8rem;
        color: #94a3b8;
        text-align: center;
        margin-top: 0.5rem;
        width: 100%;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
    }

    .page-item {
        list-style: none;
    }

    .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: rgba(30, 41, 59, 0.7);
        color: var(--yellow-300);
        text-decoration: none;
        border: 1px solid var(--glass-border);
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background: var(--yellow-300);
        color: var(--slate-800);
    }

    .page-item.active .page-link {
        background: var(--yellow-300);
        color: var(--slate-800);
        border-color: var(--yellow-300);
    }

    /* Responsive Adjustments */
    @media (max-width: 1200px) {
        .slider-item {
            flex: 0 0 calc(25% - 20px);
        }
    }

    @media (max-width: 992px) {
        .category-title {
            font-size: 1.5rem;
        }

        .book-cover-container {
            height: 220px;
        }

        .slider-item {
            flex: 0 0 calc(33.333% - 20px);
        }
    }

    @media (max-width: 768px) {
        .category-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .book-cover-container {
            height: 200px;
        }

        .slider-item {
            flex: 0 0 calc(50% - 20px);
        }

        .books-slider {
            padding: 0 30px;
        }
    }

    @media (max-width: 576px) {
        .card-actions {
            flex-direction: column;
        }

        .book-cover-container {
            height: 180px;
        }

        .slider-item {
            flex: 0 0 calc(100% - 20px);
        }

        .books-slider {
            padding: 0 20px;
        }

        .slider-btn {
            width: 30px;
            height: 30px;
        }
    }

    /* Animation for page load */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .category-section {
        animation: fadeIn 0.6s ease forwards;
    }
</style>
@endpush

@section('content')
<div class="page-container">
    <div class="container py-4">
        <!-- Search Section -->
        <div class="search-section">
            <h1 class="page-title">Explore Our Library Collection</h1>
            <div class="search-container">
                <form action="{{ route('books.index') }}" method="GET">
                    <input type="text" name="search" class="search-input" placeholder="Search by title, author, or category..." value="{{ $search }}">
                    <button class="search-btn" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Books by Category -->
        @if($categories->count() > 0)
            @foreach($categories as $category)
                @if($category->books->count() > 0)
                    <div class="category-section">
                        <div class="category-header">
                            <h2 class="category-title">{{ $category->category_name }}</h2>
                            <button class="see-all-btn">See All</button>
                        </div>

                        <div class="books-slider">
                            <button class="slider-btn slider-btn-prev">
                                <i class="fas fa-chevron-left"></i>
                            </button>

                            <div class="slider-container" id="slider-{{ $category->category_id }}">
                                @foreach($category->books as $book)
                                    <div class="slider-item">
                                        <div class="book-card">
                                            <div class="book-cover-container">
                                                <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/default-book-cover.jpg') }}"
                                                     class="book-cover"
                                                     alt="Cover of {{ $book->title }}"
                                                     onerror="this.onerror=null; this.src='{{ asset('images/default-book-cover.jpg') }}'">
                                                <span class="badge-available">Available</span>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">{{ Str::limit($book->title, 40) }}</h5>
                                                <p class="card-text card-author">By: {{ $book->author->fullname }}</p>
                                                <p class="card-text">Published: {{ $book->publication_year }}</p>
                                                <div class="card-actions">
                                                    <a href="#" class="btn-view">View Details</a>
                                                    @auth
                                                        <a href="#" class="btn-borrow">Borrow</a>
                                                    @else
                                                        <span class="login-prompt">Login to borrow</span>
                                                    @endauth
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button class="slider-btn slider-btn-next">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                @endif
            @endforeach

            <!-- Category Pagination -->
            @if($categories->hasPages())
                <div class="pagination-container">
                    <ul class="pagination">
                        @if($categories->onFirstPage())
                            <li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-left"></i></span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $categories->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a></li>
                        @endif

                        @foreach(range(1, $categories->lastPage()) as $i)
                            <li class="page-item {{ $categories->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $categories->url($i) }}">{{ $i }}</a>
                            </li>
                        @endforeach

                        @if($categories->hasMorePages())
                            <li class="page-item"><a class="page-link" href="{{ $categories->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a></li>
                        @else
                            <li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-right"></i></span></li>
                        @endif
                    </ul>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-book-open fa-3x mb-3" style="color: var(--yellow-300);"></i>
                <h3>No books found</h3>
                <p>We couldn't find any books in our collection.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize sliders for each category
        document.querySelectorAll('.books-slider').forEach(slider => {
            const container = slider.querySelector('.slider-container');
            const prevBtn = slider.querySelector('.slider-btn-prev');
            const nextBtn = slider.querySelector('.slider-btn-next');
            const itemWidth = container.querySelector('.slider-item').offsetWidth + 20; // width + gap

            prevBtn.addEventListener('click', () => {
                container.scrollBy({ left: -itemWidth * 2, behavior: 'smooth' });
            });

            nextBtn.addEventListener('click', () => {
                container.scrollBy({ left: itemWidth * 2, behavior: 'smooth' });
            });

            // Hide arrows if there's nothing to scroll
            const checkArrows = () => {
                prevBtn.style.display = container.scrollLeft <= 10 ? 'none' : 'flex';
                nextBtn.style.display = container.scrollLeft >= container.scrollWidth - container.offsetWidth - 10 ? 'none' : 'flex';
            };

            checkArrows();
            container.addEventListener('scroll', checkArrows);

            // Initial check
            setTimeout(checkArrows, 100);
        });

        // Add animation to elements
        const searchSection = document.querySelector('.search-section');
        searchSection.style.opacity = '0';
        searchSection.style.transform = 'translateY(20px)';

        setTimeout(() => {
            searchSection.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            searchSection.style.opacity = '1';
            searchSection.style.transform = 'translateY(0)';
        }, 300);
    });
</script>
@endpush
