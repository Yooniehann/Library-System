@extends('layouts.master')

@section('title', 'Welcome to Our Library')

@push('styles')
    <!-- Any page-specific styles would go here -->
    <style>
        
    </style>
@endpush

@section('content')

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-primary-orange to-dark-orange text-white py-20 px-4 mb-16">
        <div class="container mx-auto text-center max-w-6xl">
            <h1 class="text-4xl md:text-6xl font-playfair mb-6 font-bold">Welcome to Our Library</h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto leading-relaxed">
                Where stories come to life and knowledge finds its home. Explore our vast collection of over 50,000 books, from timeless classics to cutting-edge research.
            </p>
            <div class="relative max-w-xl mx-auto">
                <input type="text" placeholder="Search by title, author, or ISBN..." 
                       class="w-full py-4 px-6 rounded-full text-gray-800 shadow-lg focus:outline-none focus:ring-2 focus:ring-black">
                <button class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-black text-primary-orange p-2 rounded-full hover:bg-gray-800 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <!-- Library Introduction -->
    <section class="container mx-auto px-4 mb-16 max-w-6xl">
        <div class="bg-white p-8 md:p-12 rounded-xl shadow-lg">
            <h2 class="text-3xl font-playfair mb-6 text-center font-bold">About Our Library</h2>
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <p class="mb-4 text-lg leading-relaxed">
                        Founded in 1985, our libray has grown from a small community library to one of the region's premier knowledge centers. We serve over 10,000 members annually with:
                    </p>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start">
                            <span class="text-primary-orange mr-2">✓</span>
                            <span>50,000+ physical books across all genres</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary-orange mr-2">✓</span>
                            <span>15,000 e-books and audiobooks</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary-orange mr-2">✓</span>
                            <span>Quiet study areas and collaborative spaces</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary-orange mr-2">✓</span>
                            <span>Weekly events for all age groups</span>
                        </li>
                    </ul>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-black text-primary-orange px-6 py-3 rounded-lg font-medium hover:bg-gray-800 transition">Become a Member</a>
                        <a href="#" class="border-2 border-black px-6 py-3 rounded-lg font-medium hover:bg-gray-100 transition">Take a Virtual Tour</a>
                    </div>
                </div>
                <div class="hidden md:block">
                    <img src="https://images.unsplash.com/photo-1589998059171-988d887df646?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                         alt="Library interior" 
                         class="rounded-lg shadow-xl w-full h-auto object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Sections -->
    <section class="container mx-auto px-4 mb-16 max-w-6xl">
        <h2 class="text-3xl font-playfair mb-8 text-center font-bold">Explore Our Collection</h2>
        
        <div class="grid md:grid-cols-3 gap-8 mb-12">
            <!-- New Arrivals -->
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                <div class="flex items-center mb-4">
                    <div class="bg-primary-orange w-2 h-8 mr-3 rounded-full"></div>
                    <h3 class="text-2xl font-playfair font-bold">New Arrivals</h3>
                </div>
                <p class="mb-4 text-gray-700">
                    Discover our latest additions to the collection, updated weekly by our expert librarians.
                </p>
                <div class="space-y-4">
                    <div class="flex items-start space-x-4">
                        <img src="https://m.media-amazon.com/images/I/71FTb9X6wsL._AC_UF1000,1000_QL80_.jpg" 
                             alt="Book cover" 
                             class="w-16 h-20 object-cover rounded shadow">
                        <div>
                            <h4 class="font-semibold">The Great Gatsby</h4>
                            <p class="text-sm text-gray-600">F. Scott Fitzgerald</p>
                            <div class="text-xs text-primary-orange mt-1">Just added</div>
                        </div>
                    </div>
                    <!-- More books... -->
                </div>
                <a href="#" class="mt-4 inline-block text-black font-medium hover:text-dark-orange transition">
                    View all new arrivals →
                </a>
            </div>
            
            <!-- Bestsellers -->
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                <div class="flex items-center mb-4">
                    <div class="text-primary-orange w-2 h-8 mr-3 rounded-full"></div>
                    <h3 class="text-2xl font-playfair font-bold">Bestsellers</h3>
                </div>
                <p class="mb-4 text-gray-700">
                    The books our members can't put down. Updated monthly based on borrowing statistics.
                </p>
                <div class="space-y-4">
                    <div class="flex items-start space-x-4">
                        <img src="https://m.media-amazon.com/images/I/71FxgtFKcQL._AC_UF1000,1000_QL80_.jpg" 
                             alt="Book cover" 
                             class="w-16 h-20 object-cover rounded shadow">
                        <div>
                            <h4 class="font-semibold">To Kill a Mockingbird</h4>
                            <p class="text-sm text-gray-600">Harper Lee</p>
                            <div class="text-xs text-primary-orange mt-1">#1 this month</div>
                        </div>
                    </div>
                    <!-- More books... -->
                </div>
                <a href="#" class="mt-4 inline-block text-black font-medium hover:text-dark-orange transition">
                    View all bestsellers →
                </a>
            </div>
            
            <!-- Events -->
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                <div class="flex items-center mb-4">
                    <div class="bg-primary-orange w-2 h-8 mr-3 rounded-full"></div>
                    <h3 class="text-2xl font-playfair font-bold">Upcoming Events</h3>
                </div>
                <p class="mb-4 text-gray-700">
                    Join our vibrant community of readers and thinkers at these upcoming events.
                </p>
                <div class="space-y-4">
                    <div class="border-l-4 border-primary-orange pl-4 py-2">
                        <h4 class="font-semibold">Author Talk: Margaret Atwood</h4>
                        <p class="text-sm text-gray-600">June 15 | 6:00 PM</p>
                        <p class="text-sm mt-1">The award-winning author discusses her latest work.</p>
                    </div>
                    <!-- More events... -->
                </div>
                <a href="#" class="mt-4 inline-block text-black font-medium hover:text-dark-orange transition">
                    View all events →
                </a>
            </div>
        </div>
    </section>

    <!-- Staff Picks -->
    <section class="container mx-auto px-4 mb-16 max-w-6xl">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-playfair font-bold mb-2">Staff Picks</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Curated selections from our librarians who know our collection best. Updated seasonally with thematic recommendations.
            </p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Book 1 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="relative pb-[150%] overflow-hidden">
                    <img src="https://m.media-amazon.com/images/I/61ZewDE3beL._AC_UF1000,1000_QL80_.jpg" 
                         alt="1984 book cover" 
                         class="absolute w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-4">
                        <span class="bg-primary-orange text-black text-xs font-bold px-2 py-1 rounded">Librarian's Choice</span>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-1">1984</h3>
                    <p class="text-sm text-gray-600 mb-3">George Orwell</p>
                    <div class="flex justify-between items-center">
                        <div class="flex">
                            <span class="text-primary-orange">★★★★★</span>
                        </div>
                        <button class="text-sm font-medium bg-black text-primary-orange px-3 py-1 rounded hover:bg-gray-800 transition">
                            Reserve
                        </button>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="relative pb-[150%] overflow-hidden">
                    <img src="https://m.media-amazon.com/images/I/61ZewDE3beL._AC_UF1000,1000_QL80_.jpg" 
                         alt="1984 book cover" 
                         class="absolute w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-4">
                        <span class="bg-primary-orange text-black text-xs font-bold px-2 py-1 rounded">Librarian's Choice</span>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-1">Book 2</h3>
                    <p class="text-sm text-gray-600 mb-3">Author 2</p>
                    <div class="flex justify-between items-center">
                        <div class="flex">
                            <span class="text-primary-orange">★★★★★</span>
                        </div>
                        <button class="text-sm font-medium bg-black text-primary-orange px-3 py-1 rounded hover:bg-gray-800 transition">
                            Reserve
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- More books... -->
        </div>
    </section>

    <!-- Testimonials -->
    <section class="bg-black text-primary-orange py-16 mb-16">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="text-3xl font-playfair mb-12 text-center font-bold">What Our Members Say</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-gray-900 p-6 rounded-xl">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full bg-primary-orange mr-4 flex items-center justify-center text-black font-bold">A</div>
                        <div>
                            <h4 class="font-semibold">Alex Johnson</h4>
                            <p class="text-sm text-gray-400">Member since 2018</p>
                        </div>
                    </div>
                    <p class="italic">
                        "The staff recommendations are always spot on. I've discovered so many amazing books I would have never found on my own."
                    </p>
                </div>
                div class="bg-gray-900 p-6 rounded-xl">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full bg-primary-orange mr-4 flex items-center justify-center text-black font-bold">A</div>
                        <div>
                            <h4 class="font-semibold">Alex Johnson</h4>
                            <p class="text-sm text-gray-400">Member since 2018</p>
                        </div>
                    </div>
                    <p class="italic">
                        "The staff recommendations are always spot on. I've discovered so many amazing books I would have never found on my own."
                    </p>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <!-- Any page-specific scripts would go here -->
    <script>

    </script>
@endpush
