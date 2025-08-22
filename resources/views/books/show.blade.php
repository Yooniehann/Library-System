@extends('layouts.master')

@section('title', $book->title)

@push('styles')
    <style>
        :root {
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
            --yellow-300: #fde68a;
            --yellow-400: #fbbf24;
            --text-light: #f8fafc;
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        .book-detail-container {
            background: linear-gradient(to bottom, var(--slate-800), var(--slate-900));
            min-height: 100vh;
            padding: 2rem 0;
            color: var(--text-light);
        }

        .book-card {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid var(--glass-border);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            margin-left: 70px
        }

        .book-image-container {
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: rgba(0, 0, 0, 0.2);
        }

        .book-image {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .book-info {
            padding: 2rem;
        }

        .book-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--yellow-300);
            margin-bottom: 0.5rem;
        }

        .book-author {
            font-size: 1.2rem;
            color: #cbd5e1;
            margin-bottom: 1.5rem;
        }

        .book-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .meta-badge {
            background: rgba(253, 230, 138, 0.2);
            border: 1px solid var(--yellow-300);
            color: var(--yellow-300);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .book-price {
            font-size: 1.5rem;
            color: var(--yellow-300);
            font-weight: 600;
            margin: 1rem 0;
        }

        .book-description {
            line-height: 1.6;
            margin-bottom: 2rem;
            color: #cbd5e1;
        }

        .availability-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 1.5rem 0;
            font-size: 1.1rem;
        }

        .available {
            color: #4ade80;
        }

        .unavailable {
            color: #f87171;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .btn-borrow {
            background: var(--yellow-300);
            color: var(--slate-800);
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-borrow:hover {
            background: var(--yellow-400);
            transform: translateY(-2px);
        }

        .btn-reserve {
            background: #8b5cf6;
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-reserve:hover {
            background: #7c3aed;
            transform: translateY(-2px);
        }

        .btn-back {
            background: transparent;
            border: 1px solid var(--yellow-300);
            color: var(--yellow-300);
            padding: 0.8rem 2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: var(--yellow-300);
            color: var(--slate-800);
        }

        /* Success Message */
        .alert-success {
            background: rgba(40, 167, 69, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(40, 167, 69, 0.5);
            color: white;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 2rem;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(239, 68, 68, 0.5);
            color: white;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 2rem;
        }


        @media (max-width: 768px) {
            .book-image-container {
                height: 300px;
                padding: 1rem;
            }

            .book-title {
                font-size: 1.8rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-borrow,
            .btn-reserve,
            .btn-back {
                width: 100%;
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="book-detail-container">
        <div class="container">
            <!-- Success Message -->
            @if (session('success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="book-card">
                <div class="row">
                    <div class="col-md-4">
                        <div class="book-image-container">
                            <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/default-book-cover.jpg') }}"
                                class="book-image" alt="{{ $book->title }}"
                                onerror="this.onerror=null; this.src='{{ asset('images/default-book-cover.jpg') }}'">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="book-info">
                            <h1 class="book-title">{{ $book->title }}</h1>
                            <p class="book-author">by {{ $book->author->fullname }}</p>

                            <div class="book-meta">
                                <span class="meta-badge">{{ $book->category->category_name }}</span>
                                <span class="meta-badge">Published: {{ $book->publication_year }}</span>
                                <span class="meta-badge">ISBN: {{ $book->isbn }}</span>
                            </div>

                            <div class="book-price">${{ number_format($book->pricing, 2) }}</div>

                            @if ($book->description)
                                <div class="book-description">
                                    <h5>Description</h5>
                                    <p>{{ $book->description }}</p>
                                </div>
                            @endif

                            <div class="availability-status">
                                @if ($book->inventories->where('status', 'available')->count() > 0)
                                    <i class="fas fa-check-circle available"></i>
                                    <span>{{ $book->inventories->where('status', 'available')->count() }} copies
                                        available</span>
                                @else
                                    <i class="fas fa-times-circle unavailable"></i>
                                    <span>Currently unavailable</span>
                                @endif
                            </div>

                            <div class="action-buttons">
                                <a href="{{ route('books.index') }}" class="btn-back">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Catalog
                                </a>

                                @auth
                                    @if ($book->inventories->where('status', 'available')->count() > 0)
                                        <form action="{{ route('borrow.create', $book->book_id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-borrow">
                                                <i class="fas fa-book me-2"></i>Borrow This Book
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('reservations.create', $book->book_id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-reserve">
                                                <i class="fas fa-clock me-2"></i>Reserve This Book
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <p class="text-muted">Please log in to borrow or reserve this book.</p>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto-hide success messages after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert-success, .alert-danger');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
@endpush
