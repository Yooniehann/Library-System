@extends('layouts.master')

@section('title', 'Welcome to Our Library')

@push('styles')
    <style>
        /* Color Definitions */
        .bg-primary-orange {
            background-color: #EEBA30 !important;
        }

        .text-primary-orange {
            color: #EEBA30 !important;
        }

        .bg-dark-orange {
            background-color: #D3A625 !important;
        }

        .text-dark-orange {
            color: #D3A625 !important;
        }

        .from-primary-orange {
            --tw-gradient-from: #EEBA30 !important;
        }

        .to-dark-orange {
            --tw-gradient-to: #D3A625 !important;
        }

        /* Book Grid */
        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 2rem;
        }

        /* Book Card */
        .book-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        /* Section Styling */
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #EEBA30;
            display: inline-block;
        }

        /* Buttons */
        .btn-primary {
            background-color: #EEBA30;
            color: black;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #D3A625;
        }

        .btn-outline {
            border: 2px solid rgb(255, 255, 255);
            color: rgb(255, 255, 255);
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            background-color: #eef0f4;
            color: black;
        }

        /* Testimonial */
        .testimonial-card {
            background: linear-gradient(145deg, #1a1a1a 0%, #2d2d2d 100%);
            border-radius: 12px;
            padding: 2rem;
            position: relative;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border-left: 4px solid #EEBA30;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        .testimonial-quote {
            position: relative;
            font-size: 1.1rem;
            line-height: 1.8;
            padding-left: 1.5rem;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        .testimonial-quote:before {
            content: '"';
            position: absolute;
            left: 0;
            top: -0.5rem;
            font-size: 3rem;
            color: rgba(238, 186, 48, 0.2);
            font-family: serif;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            margin-top: auto;
            /* Pushes author to bottom */
            padding-top: 1.5rem;
            border-top: 1px solid rgba(238, 186, 48, 0.2);
        }

        .testimonial-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #EEBA30;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: black;
            font-weight: bold;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .testimonial-author-info {
            text-align: left;
        }

        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            align-items: stretch;
        }

    /* Membership Carousel Styles */
    .membership-carousel {
        position: relative;
        padding: 0 50px;
        margin: 0 auto;
        max-width: 1200px;
    }

    .membership-cards-container {
        display: flex;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding: 20px 0;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
        scrollbar-width: none; /* Hide scrollbar Firefox */
        -ms-overflow-style: none; /* Hide scrollbar IE/Edge */
    }

    .membership-cards-container::-webkit-scrollbar {
        display: none; /* Hide scrollbar Chrome/Safari */
    }

    .membership-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        flex: 0 0 calc(100% - 2rem); /* Full width on mobile */
        margin: 0 1rem;
        transform: scale(0.95);
        opacity: 0.9;
        scroll-snap-align: center;
        position: relative;
        min-width: 280px; /* Minimum width for cards */
    }

    /* Medium screens */
    @media (min-width: 768px) {
        .membership-card {
            flex: 0 0 calc(50% - 2rem); /* 2 cards per row on tablets */
        }
    }

    /* Large screens */
    @media (min-width: 1024px) {
        .membership-card {
            flex: 0 0 calc(33.333% - 2rem); /* 3 cards per row on desktop */
        }
    }

    .membership-card.active {
        transform: scale(1);
        opacity: 1;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        z-index: 2;
    }

    .membership-card:hover {
        transform: scale(1.02) !important;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
    }

    .membership-header {
        background-color: #EEBA30;
        padding: 1.5rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .membership-popular {
        width: 200px;
        background-color: #D3A625;
        color: black;
        font-size: 0.9rem;
        position: absolute;
        top: 20px;
        right: -50px;
        transform: rotate(30deg);
        text-align: center;
        padding: 0.25rem 0;
        font-weight: 600;
    }

    .carousel-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        background: #EEBA30;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        border: none;
        color: black;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .carousel-nav:hover {
        background: #D3A625;
    }

    .carousel-prev {
        left: 10px;
    }

    .carousel-next {
        right: 10px;
    }

    .membership-features {
        min-height: 180px;
    }

    /* Hide navigation buttons on mobile */
    @media (max-width: 767px) {
        .carousel-nav {
            /* display: none; */
        }
        
        .membership-carousel {
            padding: 0 20px;
        }
        
        .membership-card {
            margin: 0 0.5rem;
            flex: 0 0 calc(100% - 1rem);
        }
    }
    </style>
@endpush

@section('content')
    <!-- Success Message Alert -->
    @if (session('status') === 'success')
        <div class="fixed top-4 right-4 z-50">
            <div
                class="bg-black text-yellow-300 px-6 py-3 rounded-lg shadow-lg flex items-center justify-between min-w-[300px]">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('message') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-white hover:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-primary-orange to-dark-orange text-white py-20 px-4">
        <div class="container mx-auto text-center max-w-6xl">
            <h1 class="text-4xl md:text-6xl font-bold mb-6" style="font-family: 'Playfair Display', serif;">Welcome to Our
                Library</h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto leading-relaxed">
                Discover your next great read from our collection of 50,000+ books
            </p>
            <form action="{{ route('books.index') }}" method="GET" class="relative max-w-xl mx-auto">
                <input type="text" name="search" placeholder="Search by title, author, or ISBN..."
                    class="w-full py-4 px-6 rounded-full text-gray-800 shadow-lg focus:outline-none focus:ring-2 focus:ring-black">
                <button type="submit"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-black text-primary-orange p-2 rounded-full hover:bg-gray-800 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>
    </section>


    <!-- Library Introduction -->
    <section class="py-16">
        <div class="text-white container mx-auto px-4 max-w-6xl">
            <div class="flex flex-col md:flex-row gap-12 items-center">
                <div class="md:w-1/2">
                    <h2 class="section-title">About Asta Library</h2>
                    <p class="text-lg mb-6">
                        Founded in 1995, Asta Library serves as a cultural hub for our community with:
                    </p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-start">
                            <span class="text-primary-orange mr-3 text-xl">✓</span>
                            <span class="text-lg">50,000+ books across all genres</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary-orange mr-3 text-xl">✓</span>
                            <span class="text-lg">State-of-the-art study spaces</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary-orange mr-3 text-xl">✓</span>
                            <span class="text-lg">Weekly community events</span>
                        </li>
                    </ul>
                    <div class="flex flex-wrap gap-4">
                        <a href="#membership-plans" class="btn-primary">Become a Member</a>
                        <a href="{{ route('about')}}" class="btn-outline">Take a Tour</a>
                    </div>
                </div>
                <div class="md:w-1/2">
                    <img src="https://images.unsplash.com/photo-1589998059171-988d887df646?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                        alt="Library interior" class="rounded-xl shadow-xl w-full h-auto">
                </div>
            </div>
        </div>
    </section>

    <!-- Membership Plans Carousel -->
    <section id="membership-plans" class="py-16">
        <div class="container mx-auto px-4 max-w-6xl">
            <h2 class="section-title text-white">Membership Plans</h2>
            <p class="text-lg text-center mb-12 max-w-3xl mx-auto text-primary-orange">
                Choose the perfect membership plan for your reading needs
            </p>

            <div class="membership-carousel">
                <button class="carousel-nav carousel-prev">❮</button>
                <div class="membership-cards-container">
                    <!-- Kids Membership -->
                    <div class="membership-card active">
                        <div class="membership-popular">Best for Kids</div>
                        <div class="membership-header text-black">
                            <h3 class="text-xl font-bold">Kids</h3>
                            <p>For children under 13</p>
                        </div>
                        <div class="p-6">
                            <div class="text-center mb-6">
                                <span class="text-4xl font-bold text-black">$2</span>
                                <span class="text-gray-600">/month</span>
                                <p class="text-gray-600 mt-2">or $20 annually (save $4)</p>
                            </div>
                            <ul class="space-y-3 mb-6 membership-features">
                                <li class="flex items-start">
                                    <span class="text-primary-orange mr-2">✓</span>
                                    <span>Borrow up to 5 books</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-primary-orange mr-2">✓</span>
                                    <span>Weekly story time sessions</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-primary-orange mr-2">✓</span>
                                    <span>Child-friendly reading areas</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-primary-orange mr-2">✓</span>
                                    <span>Educational activities</span>
                                </li>
                            </ul>
                            <a href="{{ route('membership.select', ['type' => 1]) }}" class="w-full btn-primary">Get Started</a>
                        </div>
                    </div>

                    <!-- Student Membership -->
                    <div class="membership-card">
                        <div class="membership-header">
                            <h3 class="text-xl font-bold text-black">Student</h3>
                            <p class="text-gray-800">For learners of all ages</p>
                        </div>
                        <div class="p-6">
                            <div class="text-center mb-6">
                                <span class="text-4xl font-bold text-black">$5</span>
                                <span class="text-gray-600">/month</span>
                                <p class="text-gray-600 mt-2">or $50 annually (save $10)</p>
                            </div>
                            <ul class="space-y-3 mb-6 membership-features">
                                <li class="flex items-start">
                                    <span class="text-primary-orange mr-2">✓</span>
                                    <span>Borrow up to 10 books</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-primary-orange mr-2">✓</span>
                                    <span>Access to study rooms</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-primary-orange mr-2">✓</span>
                                    <span>Extended loan periods</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-primary-orange mr-2">✓</span>
                                    <span>Free printing (50 pages/month)</span>
                                </li>
                            </ul>
                            <a href="{{ route('membership.select', ['type' => 2]) }}" class="w-full btn-primary">Get Started</a>
                        </div>
                    </div>

                    <!-- Public Membership -->
                    <div class="membership-card">
                        <div class="membership-popular">Most Popular</div>
                        <div class="membership-header">
                            <h3 class="text-xl font-bold text-black">Public</h3>
                            <p class="text-gray-800">For avid readers</p>
                        </div>
                        <div class="p-6">
                            <div class="text-center mb-6">
                                <span class="text-4xl font-bold text-black">$10</span>
                                <span class="text-gray-600">/month</span>
                                <p class="text-gray-600 mt-2">or $100 annually (save $20)</p>
                            </div>
                            <ul class="space-y-3 mb-6 membership-features">
                                <li class="flex items-start">
                                    <span class="text-primary-orange mr-2">✓</span>
                                    <span>Borrow up to 20 books</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-primary-orange mr-2">✓</span>
                                    <span>Priority access to new releases</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-primary-orange mr-2">✓</span>
                                    <span>Free event tickets</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-primary-orange mr-2">✓</span>
                                    <span>Premium online resources</span>
                                </li>
                            </ul>
                            <a href="{{ route('membership.select', ['type' => 3]) }}" class="w-full btn-primary">Get Started</a>
                        </div>
                    </div>

                    <!-- Family Membership -->
                    <div class="membership-card">
                        <div class="membership-header">
                            <h3 class="text-xl font-bold text-black">Family</h3>
                            <p class="text-gray-800">Perfect for households</p>
                        </div>
                        <div class="p-6">
                            <div class="text-center mb-6">
                                <span class="text-4xl font-bold text-black">$15</span>
                                <span class="text-gray-600">/month</span>
                                <p class="text-gray-600 mt-2">or $150 annually (save $30)</p>
                            </div>
                            <ul class="space-y-3 mb-6 membership-features">
                                <li class="flex items-start">
                                    <span class="text-primary-orange mr-2">✓</span>
                                    <span>Borrow up to 30 books</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-primary-orange mr-2">✓</span>
                                    <span>Cards for 4 family members</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-primary-orange mr-2">✓</span>
                                    <span>Free children's programs</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-primary-orange mr-2">✓</span>
                                    <span>Discounted event tickets</span>
                                </li>
                            </ul>
                            <a href="{{ route('membership.select', ['type' => 4]) }}" class="w-full btn-primary">Get Started</a>
                        </div>
                    </div>
                </div>
                <button class="carousel-nav carousel-next">❯</button>
            </div>
        </div>
    </section>

    <!-- New Arrivals Section -->
    <section class="py-16">
        <div class="text-white container mx-auto px-4 max-w-6xl">
            <h2 class="section-title">New Arrivals</h2>
            <div class="book-grid">
                <!-- Book 1 -->
                <div class="book-card">
                    <img src="https://m.media-amazon.com/images/I/71FTb9X6wsL._AC_UF1000,1000_QL80_.jpg"
                        alt="The Great Gatsby" class="w-full h-72 object-cover">
                    <div class="p-5">
                        <h3 class="font-bold text-lg text-gray-700 mb-1">The Great Gatsby</h3>
                        <p class="text-gray-600 mb-3">F. Scott Fitzgerald</p>
                        <div class="flex justify-between items-center">
                            <span class="text-primary-orange text-sm font-medium">New Release</span>
                            <button class="btn-primary text-sm px-3 py-1">View</button>
                        </div>
                    </div>
                </div>

                <!-- Book 2 -->
                <div class="book-card">
                    <img src="https://m.media-amazon.com/images/I/81af+MCATTL._AC_UF1000,1000_QL80_.jpg"
                        alt="Atomic Habits" class="w-full h-72 object-cover">
                    <div class="p-5">
                        <h3 class="font-bold text-lg text-gray-700 mb-1">Atomic Habits</h3>
                        <p class="text-gray-600 mb-3">James Clear</p>
                        <div class="flex justify-between items-center">
                            <span class="text-primary-orange text-sm font-medium">New Release</span>
                            <button class="btn-primary text-sm px-3 py-1">View</button>
                        </div>
                    </div>
                </div>

                <!-- Book 3 -->
                <div class="book-card">
                    <img src="https://m.media-amazon.com/images/I/71UwSHSZRnS._AC_UF1000,1000_QL80_.jpg" alt="Educated"
                        class="w-full h-72 object-cover">
                    <div class="p-5">
                        <h3 class="font-bold text-lg text-gray-700 mb-1">Educated</h3>
                        <p class="text-gray-600 mb-3">Tara Westover</p>
                        <div class="flex justify-between items-center">
                            <span class="text-primary-orange text-sm font-medium">New Release</span>
                            <button class="btn-primary text-sm px-3 py-1">View</button>
                        </div>
                    </div>
                </div>

                <!-- Book 4 -->
                <div class="book-card">
                    <img src="https://m.media-amazon.com/images/I/81bsw6fnUiL._AC_UF1000,1000_QL80_.jpg"
                        alt="The Silent Patient" class="w-full h-72 object-cover">
                    <div class="p-5">
                        <h3 class="font-bold text-lg text-gray-700 mb-1">The Silent Patient</h3>
                        <p class="text-gray-600 mb-3">Alex Michaelides</p>
                        <div class="flex justify-between items-center">
                            <span class="text-primary-orange text-sm font-medium">New Release</span>
                            <button class="btn-primary text-sm px-3 py-1">View</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-10">
                <a href="#" class="btn-outline inline-block">View All New Arrivals</a>
            </div>
        </div>
    </section>

    <!-- Bestsellers Section -->
    <section class="py-16">
        <div class="text-white container mx-auto px-4 max-w-6xl">
            <h2 class="section-title">Bestsellers</h2>
            <div class="book-grid">
                <!-- Book 1 -->
                <div class="book-card">
                    <img src="https://m.media-amazon.com/images/I/71FxgtFKcQL._AC_UF1000,1000_QL80_.jpg"
                        alt="To Kill a Mockingbird" class="w-full h-72 object-cover">
                    <div class="p-5">
                        <h3 class="font-bold text-lg text-gray-700 mb-1">To Kill a Mockingbird</h3>
                        <p class="text-gray-600 mb-3">Harper Lee</p>
                        <div class="flex justify-between items-center">
                            <span class="text-primary-orange text-sm font-medium">#1 Bestseller</span>
                            <button class="btn-primary text-sm px-3 py-1">View</button>
                        </div>
                    </div>
                </div>

                <!-- Book 2 -->
                <div class="book-card">
                    <img src="https://m.media-amazon.com/images/I/61ZewDE3beL._AC_UF1000,1000_QL80_.jpg" alt="1984"
                        class="w-full h-72 object-cover">
                    <div class="p-5">
                        <h3 class="font-bold text-lg text-gray-700 mb-1">1984</h3>
                        <p class="text-gray-600 mb-3">George Orwell</p>
                        <div class="flex justify-between items-center">
                            <span class="text-primary-orange text-sm font-medium">Top 10</span>
                            <button class="btn-primary text-sm px-3 py-1">View</button>
                        </div>
                    </div>
                </div>

                <!-- Book 3 -->
                <div class="book-card">
                    <img src="https://m.media-amazon.com/images/I/71Q1tPupKjL._AC_UF1000,1000_QL80_.jpg"
                        alt="Pride and Prejudice" class="w-full h-72 object-cover">
                    <div class="p-5">
                        <h3 class="font-bold text-lg text-gray-700 mb-1">Pride and Prejudice</h3>
                        <p class="text-gray-600 mb-3">Jane Austen</p>
                        <div class="flex justify-between items-center">
                            <span class="text-primary-orange text-sm font-medium">Top 10</span>
                            <button class="btn-primary text-sm px-3 py-1">View</button>
                        </div>
                    </div>
                </div>

                <!-- Book 4 -->
                <div class="book-card">
                    <img src="https://m.media-amazon.com/images/I/71X1p4TGlxL._AC_UF1000,1000_QL80_.jpg" alt="The Hobbit"
                        class="w-full h-72 object-cover">
                    <div class="p-5">
                        <h3 class="font-bold text-lg text-gray-700 mb-1">The Hobbit</h3>
                        <p class="text-gray-600 mb-3">J.R.R. Tolkien</p>
                        <div class="flex justify-between items-center">
                            <span class="text-primary-orange text-sm font-medium">Top 10</span>
                            <button class="btn-primary text-sm px-3 py-1">View</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-10">
                <a href="#" class="btn-outline inline-block">View All Bestsellers</a>
            </div>
        </div>
    </section>

    <!-- Staff Picks Section -->
    <section class="py-16">
        <div class="text-white container mx-auto px-4 max-w-6xl">
            <h2 class="section-title">Staff Picks</h2>
            <p class="text-lg text-primary-orange text-center mb-12 max-w-3xl mx-auto">
                Our librarians personally recommend these outstanding reads
            </p>

            <div class="book-grid">
                <!-- Book 1 -->
                <div class="book-card">
                    <img src="https://m.media-amazon.com/images/I/81bsw6fnUiL._AC_UF1000,1000_QL80_.jpg"
                        alt="The Silent Patient" class="w-full h-72 object-cover">
                    <div class="p-5">
                        <h3 class="font-bold text-lg text-gray-700 mb-1">The Silent Patient</h3>
                        <p class="text-gray-600 mb-4">Alex Michaelides</p>
                        <div class="bg-gray-100 p-3 rounded-lg">
                            <p class="text-sm italic text-gray-700">
                                "The twist left me speechless - couldn't put it down!"
                            </p>
                            <p class="text-primary-orange text-sm font-medium mt-2">- Sarah, Head Librarian</p>
                        </div>
                    </div>
                </div>

                <!-- Book 2 -->
                <div class="book-card">
                    <img src="https://m.media-amazon.com/images/I/71UwSHSZRnS._AC_UF1000,1000_QL80_.jpg" alt="Educated"
                        class="w-full h-72 object-cover">
                    <div class="p-5">
                        <h3 class="font-bold text-lg text-gray-700 mb-1">Educated</h3>
                        <p class="text-gray-600 mb-4">Tara Westover</p>
                        <div class="bg-gray-100 p-3 rounded-lg">
                            <p class="text-sm italic text-gray-700">
                                "A powerful memoir about resilience and self-discovery"
                            </p>
                            <p class="text-primary-orange text-sm font-medium mt-2">- David, Reference</p>
                        </div>
                    </div>
                </div>

                <!-- Book 3 -->
                <div class="book-card">
                    <img src="https://m.media-amazon.com/images/I/81af+MCATTL._AC_UF1000,1000_QL80_.jpg"
                        alt="Atomic Habits" class="w-full h-72 object-cover">
                    <div class="p-5">
                        <h3 class="font-bold text-lg text-gray-700 mb-1">Atomic Habits</h3>
                        <p class="text-gray-600 mb-4">James Clear</p>
                        <div class="bg-gray-100 p-3 rounded-lg">
                            <p class="text-sm italic text-gray-700">
                                "Changed how I approach personal growth - highly practical!"
                            </p>
                            <p class="text-primary-orange text-sm font-medium mt-2">- Michael, Tech</p>
                        </div>
                    </div>
                </div>

                <!-- Book 4 -->
                <div class="book-card">
                    <img src="https://m.media-amazon.com/images/I/71X1p4TGlxL._AC_UF1000,1000_QL80_.jpg"
                        alt="Where the Crawdads Sing" class="w-full h-72 object-cover">
                    <div class="p-5">
                        <h3 class="font-bold text-lg text-gray-700 mb-1">Where the Crawdads Sing</h3>
                        <p class="text-gray-600 mb-4">Delia Owens</p>
                        <div class="bg-gray-100 p-3 rounded-lg">
                            <p class="text-sm italic text-gray-700">
                                "Beautiful prose with a mystery that keeps you guessing"
                            </p>
                            <p class="text-primary-orange text-sm font-medium mt-2">- Emily, Fiction</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="bg-black text-white py-20">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="text-center">
                <h2 class="text-3xl font-bold mb-6" style="font-family: 'Playfair Display', serif;">What Our Readers Say
                </h2>
                <p class="text-xl text-primary-orange mb-12 max-w-3xl mx-auto">
                    Don't just take our word for it - hear from our community
                </p>
            </div>

            <div class="testimonial-grid">
                <!-- Testimonial 1 -->
                <div class="testimonial-card">
                    <div class="testimonial-quote">
                        This library has completely transformed my reading habits. The staff recommendations are always spot
                        on! I've discovered so many new favorites.
                    </div>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">
                            <img src="https://i.pinimg.com/736x/14/29/ec/1429ec25b7b2a7110d4432cb1b2e61fa.jpg"
                                alt="July Moe" class="w-full h-full rounded-full object-cover">
                        </div>
                        <div class="testimonial-author-info">
                            <div class="text-primary-orange font-bold">July Moe</div>
                            <div class="text-gray-400 text-sm">Member since 2018</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="testimonial-card">
                    <div class="testimonial-quote">
                        The perfect quiet space to study, with an incredible selection of resources. My second home! The
                        membership is worth every penny.
                    </div>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">
                            <img src="data:image/jpeg;base64,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"
                                alt="Khun Zin Yell" class="w-full h-full rounded-full object-cover">
                        </div>
                        <div class="testimonial-author-info">
                            <div class="text-primary-orange font-bold">Khun Zin Yell</div>
                            <div class="text-gray-400 text-sm">Student Member</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="testimonial-card">
                    <div class="testimonial-quote">
                        As a family, we've saved hundreds on books and activities. The children's programs are exceptional
                        and my kids love story time every weekend.
                    </div>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTDdPsb_rCwM3y_I2NpDmYqMx5U7DiFWCP6HA&s"
                                alt="U Htun Kyi" class="w-full h-full rounded-full object-cover">
                        </div>
                        <div class="testimonial-author-info">
                            <div class="text-primary-orange font-bold">U Htun Kyi</div>
                            <div class="text-gray-400 text-sm">Family Member</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-gradient-to-r from-primary-orange to-dark-orange py-16">
        <div class="container mx-auto px-4 max-w-4xl text-center text-white">
            <h2 class="text-3xl font-bold mb-6" style="font-family: 'Playfair Display', serif;">Ready to Join Our
                Community?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Become a member today and unlock access to our vast collection of resources and services.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#membership-plans" class="btn-primary">Become a Member</a>
                <a href="#faq-section" class="btn-outline">Browse Questions</a>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq-section" class="py-16 ">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="section-title text-white text-center">Frequently Asked Questions</h2>
            <p class="text-lg text-center mb-12 max-w-2xl mx-auto text-primary-orange">
                Find answers to common questions about our library services
            </p>

            <div class="space-y-6">
                <!-- FAQ Item 1 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full text-left p-6 focus:outline-none">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-bold">How do I become a library member?</h3>
                            <svg class="w-6 h-6 text-primary-orange transform transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div class="faq-answer px-6 pb-6 hidden">
                        <p class="text-gray-700">You can become a member by visiting any of our branches with a valid ID
                            and proof of
                            address or by registering online through our website. Membership requires payment based on the
                            membership
                            type you select; see our Membership Fees page for full details.</p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full text-left p-6 focus:outline-none">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-bold">What are your opening hours?</h3>
                            <svg class="w-6 h-6 text-primary-orange transform transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div class="faq-answer px-6 pb-6 hidden">
                        <p class="text-gray-700">Our main branch is open Monday to Friday from 9am to 8pm, and Saturday to
                            Sunday from 10am to 6pm.
                            Some services may have different hours - please check our website for specific department hours.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full text-left p-6 focus:outline-none">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-bold">How many books can I borrow at once?</h3>
                            <svg class="w-6 h-6 text-primary-orange transform transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div class="faq-answer px-6 pb-6 hidden">
                        <p class="text-gray-700">Standard members can borrow up to 10 items at a time. Premium members can
                            borrow up to 20 items.
                            Some special collections may have additional restrictions.</p>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full text-left p-6 focus:outline-none">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-bold">Do you offer digital resources?</h3>
                            <svg class="w-6 h-6 text-primary-orange transform transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div class="faq-answer px-6 pb-6 hidden">
                        <p class="text-gray-700">Yes! We offer a wide range of digital resources including e-books,
                            audiobooks, digital magazines
                            and research databases. All you need is your library card to access these resources from home.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full text-left p-6 focus:outline-none">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-bold">What if I return a book late?</h3>
                            <svg class="w-6 h-6 text-primary-orange transform transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div class="faq-answer px-6 pb-6 hidden">
                        <p class="text-gray-700">We charge a small daily fine for overdue items. However, we offer a 3-day
                            grace period.
                            Fines max out after 14 days. You can renew items online if no one else has requested them.</p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <p class="text-gray-200 mb-4">Didn't find what you were looking for?</p>
                <a href="/contact" class="btn-primary inline-block">Contact Our Support Team</a>
            </div>
        </div>
    </section>

@endsection


@push('scripts')
    <!-- Any page-specific scripts would go here -->
    <script>
        // Auto-dismiss success message after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.querySelector('.bg-green-500');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.remove();
                }, 5000);
            }
        });

        // Membership Cards
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.membership-cards-container');
            const cards = document.querySelectorAll('.membership-card');
            const prevBtn = document.querySelector('.carousel-prev');
            const nextBtn = document.querySelector('.carousel-next');
            let currentIndex = 0;
            const cardCount = cards.length;

            // Set initial active card (center of viewport)
            function setActiveCard() {
                const containerRect = container.getBoundingClientRect();
                const containerCenter = containerRect.left + containerRect.width / 2;

                cards.forEach((card, index) => {
                    const cardRect = card.getBoundingClientRect();
                    const cardCenter = cardRect.left + cardRect.width / 2;

                    // Check if card is near the center of the container
                    if (Math.abs(cardCenter - containerCenter) < cardRect.width / 2) {
                        card.classList.add('active');
                        currentIndex = index;
                    } else {
                        card.classList.remove('active');
                    }
                });
            }

            // Scroll to card at specific index
            function scrollToCard(index) {
                if (index < 0) index = 0;
                if (index > cardCount - 1) index = cardCount - 1;

                const card = cards[index];
                const containerRect = container.getBoundingClientRect();
                const cardRect = card.getBoundingClientRect();

                const scrollPosition = card.offsetLeft - (containerRect.width / 2 - cardRect.width / 2);

                container.scrollTo({
                    left: scrollPosition,
                    behavior: 'smooth'
                });

                // Update active card after scroll completes
                setTimeout(setActiveCard, 500);
            }

            // Navigation handlers
            nextBtn.addEventListener('click', () => {
                scrollToCard(currentIndex + 1);
            });

            prevBtn.addEventListener('click', () => {
                scrollToCard(currentIndex - 1);
            });

            // Initialize
            setActiveCard();

            // Handle scroll events for manual dragging
            container.addEventListener('scroll', setActiveCard);

            // Handle window resize
            window.addEventListener('resize', setActiveCard);
        });

        // FAQ Accordion Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const faqQuestions = document.querySelectorAll('.faq-question');

            faqQuestions.forEach(question => {
                question.addEventListener('click', () => {
                    const answer = question.nextElementSibling;
                    const icon = question.querySelector('svg');

                    // Toggle answer visibility
                    answer.classList.toggle('hidden');
                    answer.classList.toggle('block');

                    // Rotate icon
                    icon.classList.toggle('rotate-180');

                    // Close other open FAQs
                    faqQuestions.forEach(otherQuestion => {
                        if (otherQuestion !== question) {
                            otherQuestion.nextElementSibling.classList.add('hidden');
                            otherQuestion.querySelector('svg').classList.remove(
                                'rotate-180');
                        }
                    });
                });
            });
        });
    </script>
@endpush
