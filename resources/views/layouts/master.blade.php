<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | Library Management System</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- Page-specific styles -->
    @stack('styles')

    <style>
        :root {
            --primary: #f59e0b;
            --primary-hover: #d97706;
            --dark: #0f172a;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0f172a;
        }

        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(15, 23, 42, 0.95);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background-color: rgba(15, 23, 42, 0.98);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background-color: var(--primary);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
        }

        .logo-text {
            font-family: 'Playfair Display', serif;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .footer-link:hover {
            color: var(--primary) !important;
            transform: translateX(5px);
        }

        .search-box {
            transition: all 0.3s ease;
        }

        .search-box:focus-within {
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.3);
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(245, 158, 11, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(245, 158, 11, 0);
            }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .logo-container {
            transition: all 0.3s ease;
        }

        .logo-container:hover {
            transform: scale(1.05) rotate(-5deg);
        }
    </style>
</head>

<body class="bg-slate-900">
    <!-- Navbar -->
    <nav class="navbar fixed top-0 left-0 right-0 z-50 text-white py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <!-- Logo with animation -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center logo-container">
                        <div
                            class="w-10 h-10 bg-yellow-300 rounded-full flex items-center justify-center mr-3 pulse-animation">
                            <i class="fas fa-book-open text-black text-xl"></i>
                        </div>
                        <span class="logo-text text-2xl font-bold">
                            <span class="text-yellow-300">LIB</span>RARY
                        </span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-6">
                    <!-- Search Bar -->
                    {{-- <div class="search-box relative mr-4">
                        <input type="text" placeholder="Search books..."
                            class="bg-black bg-opacity-30 text-white pl-10 pr-4 py-2 rounded-full w-64 focus:outline-none focus:ring-2 focus:ring-yellow-300 transition-all">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div> --}}

                    <a href="{{ route('home') }}"
                        class="text-white hover:text-yellow-300 transition duration-300 font-medium">Home</a>
                    <a href="{{ route('books.index') }}"
                        class="text-white hover:text-yellow-300 transition duration-300 font-medium">Books</a>
                    @auth
                        @if (Auth::user()->role !== 'Guest' && Auth::user()->role !== 'Admin')
                            @if (Auth::user()->role === 'Member')
                                <a href="{{ route('member.borrowed.index') }}"
                                    class="text-white hover:text-yellow-300 transition duration-300 font-medium">My
                                    Books</a>
                            @elseif (Auth::user()->role === 'Kid')
                                <a href="{{ route('kid.kidborrowed.index') }}"
                                    class="text-white hover:text-yellow-300 transition duration-300 font-medium">My
                                    Books</a>
                            @else
                                <a href="{{ route('borrowed.index') }}"
                                    class="text-white hover:text-yellow-300 transition duration-300 font-medium">My
                                    Books</a>
                            @endif
                        @else
                            <a href="#"
                                onclick="event.preventDefault(); alert('You need to upgrade your membership to access My Books.');"
                                class="text-white hover:text-yellow-300 transition duration-300 font-medium opacity-50 cursor-not-allowed">My
                                Books</a>
                        @endif
                    @else
                        <a href="{{ route('borrowed.index') }}"
                            class="text-white hover:text-yellow-300 transition duration-300 font-medium">My Books</a>
                    @endauth
                    <a href="{{ route('about') }}"
                        class="text-white hover:text-yellow-300 transition duration-300 font-medium">About</a>
                    <a href="{{ route('contact') }}"
                        class="text-white hover:text-yellow-300 transition duration-300 font-medium">Contact</a>

                    @auth
                        <div class="relative group" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <rect x="3" y="3" width="8" height="8" rx="2" stroke-width="2" />
                                    <rect x="13" y="3" width="8" height="5" rx="2" stroke-width="2" />
                                    <rect x="13" y="10" width="8" height="11" rx="2" stroke-width="2" />
                                    <rect x="3" y="13" width="8" height="8" rx="2" stroke-width="2" />
                                </svg>
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute right-0 mt-2 w-48 bg-black bg-opacity-90 rounded-lg shadow-lg py-1 z-50 border border-gray-700">
                                @if (Auth::user()->role === 'Guest')
                                    <a href="#"
                                        onclick="event.preventDefault(); alert('You need to purchase a membership plan to access the dashboard.');"
                                        class="block px-4 py-2 text-sm text-white hover:bg-gray-800 hover:text-yellow-300 transition opacity-50 cursor-not-allowed">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2 text-sm text-white hover:bg-gray-800 hover:text-yellow-300 transition">Dashboard</a>
                                @endif
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-white hover:bg-gray-800 hover:text-yellow-300 transition">Profile</a>
                                @can('admin')
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="block px-4 py-2 text-sm text-white hover:bg-gray-800 hover:text-yellow-300 transition">Admin
                                        Panel</a>
                                @endcan
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="block px-4 py-2 text-sm text-white hover:bg-gray-800 hover:text-yellow-300 transition">Logout</a>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex space-x-3">
                            <a href="{{ route('login') }}"
                                class="block px-4 py-2 border border-yellow-300 text-yellow-300 rounded-sm hover:bg-yellow-300 hover:text-black transition duration-300">Sign
                                In</a>
                            <a href="{{ route('register') }}"
                                class="block px-4 py-2 border border-yellow-300 text-yellow-300 rounded-sm hover:bg-yellow-300 hover:text-black transition duration-300">Sign
                                Up</a>
                        </div>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="menu-btn" class="text-white focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="menu"
            class="hidden md:hidden bg-black bg-opacity-95 absolute top-16 left-0 right-0 shadow-lg animate__animated animate__fadeIn">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <div class="px-3 py-2">
                    <input type="text" placeholder="Search books..."
                        class="bg-gray-800 text-white px-4 py-2 rounded-full w-full focus:outline-none focus:ring-2 focus:ring-yellow-300">
                </div>
                <a href="{{ route('home') }}" class="block px-3 py-2 text-white hover:text-yellow-300">Home</a>
                <a href="{{ route('books.index') }}"
                    class="block px-3 py-2 text-white hover:text-yellow-300">Books</a>
                @auth
                    @if (Auth::user()->role !== 'Guest' && Auth::user()->role !== 'Admin')
                        @if (Auth::user()->role === 'Member')
                            <a href="{{ route('member.borrowed.index') }}"
                                class="block px-3 py-2 text-white hover:text-yellow-300">My Books</a>
                        @elseif (Auth::user()->role === 'Kid')
                            <a href="{{ route('kid.kidborrowed.index') }}"
                                class="block px-3 py-2 text-white hover:text-yellow-300">My Books</a>
                        @else
                            <a href="{{ route('borrowed.index') }}"
                                class="block px-3 py-2 text-white hover:text-yellow-300">My Books</a>
                        @endif
                    @else
                        <a href="#"
                            onclick="event.preventDefault(); alert('You need to upgrade your membership to access My Books.');"
                            class="block px-3 py-2 text-white hover:text-yellow-300 opacity-50 cursor-not-allowed">My
                            Books</a>
                    @endif
                @else
                    <a href="{{ route('borrowed.index') }}"
                        class="block px-3 py-2 text-white hover:text-yellow-300">My Books</a>
                @endauth
                <a href="{{ route('about') }}" class="block px-3 py-2 text-white hover:text-yellow-300">About</a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 text-white hover:text-yellow-300">Contact</a>

                @auth
                    <div class="pt-4 pb-3 border-t border-gray-700">
                        <div class="flex items-center px-5">
                            <div
                                class="w-8 h-8 bg-yellow-300 rounded-full flex items-center justify-center text-black font-semibold mr-3">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
                        </div>
                        <div class="mt-3 px-2 space-y-1">
                            @if (Auth::user()->role === 'Guest')
                                <a href="#"
                                    onclick="event.preventDefault(); alert('You need to purchase a membership plan to access the dashboard.');"
                                    class="block px-3 py-2 text-white hover:text-yellow-300 opacity-50 cursor-not-allowed">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}"
                                    class="block px-3 py-2 text-white hover:text-yellow-300">Dashboard</a>
                            @endif
                            <a href="{{ route('profile.edit') }}"
                                class="block px-3 py-2 text-white hover:text-yellow-300">Profile</a>
                            @can('admin')
                                <a href="{{ route('admin.dashboard') }}"
                                    class="block px-3 py-2 text-white hover:text-yellow-300">Admin Panel</a>
                            @endcan
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="block px-3 py-2 text-white hover:text-yellow-300">Logout</a>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="pt-2 space-y-2">
                        <a href="{{ route('login') }}"
                            class="block w-full px-3 py-2 text-center bg-transparent border border-yellow-300 text-white hover:bg-yellow-300 hover:text-black rounded-full font-medium">Sign
                            In</a>
                        <a href="{{ route('register') }}"
                            class="block w-full px-3 py-2 text-center bg-transparent border border-yellow-300 text-white hover:bg-yellow-300 hover:text-black rounded-full font-medium">Sign
                            Up</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20 min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-black text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About Section -->
                <div class="glass-card p-6 animate__animated animate__fadeInUp">
                    <h2 class="text-2xl font-bold mb-4 logo-text">
                        <span class="text-yellow-300">LIB</span>RARY
                    </h2>
                    <p class="text-gray-400 mb-4">
                        Your premier destination for knowledge and learning. Explore our vast collection of books and
                        resources.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 hover:bg-yellow-300 rounded-full flex items-center justify-center text-white hover:text-black transition duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 hover:bg-yellow-300 rounded-full flex items-center justify-center text-white hover:text-black transition duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 hover:bg-yellow-300 rounded-full flex items-center justify-center text-white hover:text-black transition duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 hover:bg-yellow-300 rounded-full flex items-center justify-center text-white hover:text-black transition duration-300">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="glass-card p-6 animate__animated animate__fadeInUp animate__delay-1s">
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}"
                                class="text-gray-400 hover:text-yellow-300 transition duration-300 flex items-center footer-link">
                                <i class="fas fa-chevron-right text-xs mr-2 text-yellow-300"></i> Home</a></li>
                        <li><a href="{{ route('books.index') }}"
                                class="text-gray-400 hover:text-yellow-300 transition duration-300 flex items-center footer-link">
                                <i class="fas fa-chevron-right text-xs mr-2 text-yellow-300"></i> Book Catalog</a></li>
                        <li>
                            @auth
                                @if (Auth::user()->role !== 'Guest' && Auth::user()->role !== 'Admin')
                                    @if (Auth::user()->role === 'Member')
                                        <a href="{{ route('member.borrowed.index') }}"
                                            class="text-gray-400 hover:text-yellow-300 transition duration-300 flex items-center footer-link">
                                            <i class="fas fa-chevron-right text-xs mr-2 text-yellow-300"></i> My Books
                                        </a>
                                    @elseif (Auth::user()->role === 'Kid')
                                        <a href="{{ route('kid.kidborrowed.index') }}"
                                            class="text-gray-400 hover:text-yellow-300 transition duration-300 flex items-center footer-link">
                                            <i class="fas fa-chevron-right text-xs mr-2 text-yellow-300"></i> My Books
                                        </a>
                                    @else
                                        <a href="{{ route('borrowed.index') }}"
                                            class="text-gray-400 hover:text-yellow-300 transition duration-300 flex items-center footer-link">
                                            <i class="fas fa-chevron-right text-xs mr-2 text-yellow-300"></i> My Books
                                        </a>
                                    @endif
                                @else
                                    <a href="#"
                                        onclick="event.preventDefault(); alert('You need to upgrade your membership to access My Books.');"
                                        class="text-gray-400 hover:text-yellow-300 transition duration-300 flex items-center footer-link opacity-50 cursor-not-allowed">
                                        <i class="fas fa-chevron-right text-xs mr-2 text-yellow-300"></i> My Books
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('borrowed.index') }}"
                                    class="text-gray-400 hover:text-yellow-300 transition duration-300 flex items-center footer-link">
                                    <i class="fas fa-chevron-right text-xs mr-2 text-yellow-300"></i> My Books
                                </a>
                            @endauth
                        </li>
                        <li><a href="{{ route('about') }}"
                                class="text-gray-400 hover:text-yellow-300 transition duration-300 flex items-center footer-link">
                                <i class="fas fa-chevron-right text-xs mr-2 text-yellow-300"></i> About Us</a></li>
                        <li><a href="{{ route('contact') }}"
                                class="text-gray-400 hover:text-yellow-300 transition duration-300 flex items-center footer-link">
                                <i class="fas fa-chevron-right text-xs mr-2 text-yellow-300"></i> Contact</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="glass-card p-6 animate__animated animate__fadeInUp animate__delay-2s">
                    <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div
                                class="w-10 h-10 bg-yellow-300 rounded-full flex items-center justify-center text-black mr-3 mt-1">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <a href="tel:+1234567890"
                                    class="text-gray-400 hover:text-yellow-300 transition duration-300">+1 (234)
                                    567-890</a>
                                <p class="text-sm text-gray-500">Library Help Desk</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div
                                class="w-10 h-10 bg-yellow-300 rounded-full flex items-center justify-center text-black mr-3 mt-1">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <a href="mailto:info@library.com"
                                    class="text-gray-400 hover:text-yellow-300 transition duration-300">info@library.com</a>
                                <p class="text-sm text-gray-500">General Inquiries</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div
                                class="w-10 h-10 bg-yellow-300 rounded-full flex items-center justify-center text-black mr-3 mt-1">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <p class="text-gray-400">123 Library Street, Knowledge City</p>
                                <p class="text-sm text-gray-500">Open Mon-Fri: 9AM - 8PM</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="glass-card p-6 animate__animated animate__fadeInUp animate__delay-3s">
                    <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
                    <p class="text-gray-400 mb-4">Subscribe to our newsletter for the latest updates and book releases.
                    </p>
                    <form class="mt-4">
                        <input type="email" placeholder="Your email"
                            class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-300 text-white mb-2">
                        <button type="submit"
                            class="w-full bg-yellow-300 hover:bg-yellow-400 text-black font-medium py-2 px-4 rounded-full transition duration-300">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>

            <!-- Copyright & Additional Links -->
            <div class="border-t border-gray-800 mt-12 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-500 text-sm mb-4 md:mb-0">
                        &copy; {{ date('Y') }} Library Management System. All rights reserved.
                    </p>
                    <div class="flex space-x-6">
                        <a href="{{ route('privacy') }}"
                            class="text-gray-500 hover:text-yellow-300 text-sm transition duration-300">Privacy
                            Policy</a>
                        <a href="{{ route('terms') }}"
                            class="text-gray-500 hover:text-yellow-300 text-sm transition duration-300">Terms of
                            Service</a>
                        <a href="{{ route('faq') }}"
                            class="text-gray-500 hover:text-yellow-300 text-sm transition duration-300">FAQs</a>
                        <a href="/sitemap.xml"
                            class="text-gray-500 hover:text-yellow-300 text-sm transition duration-300">Sitemap</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="back-to-top"
        class="fixed bottom-8 right-8 w-12 h-12 bg-yellow-300 hover:bg-yellow-400 text-black rounded-full shadow-lg flex items-center justify-center transition-all duration-300 opacity-0 invisible">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

    <script>
        // Navbar scroll effect
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar');
            const hamburgerBtn = document.getElementById('menu-btn');
            const mobileMenu = document.getElementById('menu');
            const backToTopBtn = document.getElementById('back-to-top');

            // Mobile menu toggle
            hamburgerBtn.addEventListener('click', function() {
                hamburgerBtn.classList.toggle('open');
                mobileMenu.classList.toggle('hidden');
                mobileMenu.classList.toggle('flex');
            });

            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }

                // Back to top button
                if (window.scrollY > 300) {
                    backToTopBtn.classList.remove('opacity-0', 'invisible');
                    backToTopBtn.classList.add('opacity-100', 'visible');
                } else {
                    backToTopBtn.classList.add('opacity-0', 'invisible');
                    backToTopBtn.classList.remove('opacity-100', 'visible');
                }
            });

            // Back to top functionality
            backToTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Initialize with scrolled class if not at top
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            }
        });
    </script>

    @yield('scripts')
    @stack('scripts')

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>
