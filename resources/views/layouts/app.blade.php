<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Library System</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')
</head>
<body class="bg-slate-900">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-slate-700 shadow-sm">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold text-yellow-300">
                    <i class="fas fa-book mr-2"></i> Library System
                </a>

                <nav class="flex items-center space-x-6 text-yellow-300">
                    @auth
                    <div class="relative group">
                        <button class="flex items-center space-x-2 focus:outline-none">
                            <span class="font-medium">{{ Auth::user()->fullname }}</span>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>

                        <div class="absolute right-0 mt-2 w-48 bg-slate-700 rounded-md shadow-lg py-1 z-10 hidden group-hover:block">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-yellow-300 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-yellow-300 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    @endauth
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 py-8">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-6">
            <div class="container mx-auto px-4 text-center">
                <p>&copy; {{ date('Y') }} Library System. All rights reserved.</p>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
