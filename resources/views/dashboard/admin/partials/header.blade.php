<!-- Header -->
<header class="bg-slate-700 shadow z-40">
    <div class="flex items-center justify-between px-4 py-3 sm:px-6">

        <div class="flex items-center space-x-4">
            <!-- Hamburger menu button (mobile only) -->
            <div class="flex items-center md:hidden">
                <button @click="sidebarOpen = true" type="button"
                    class="text-yellow-400 hover:text-yellow-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Home button -->
            <div class="flex items-center mr-4">
                <a href="{{ route('home') }}" class="text-yellow-400 hover:text-yellow-300 flex items-center">
                    <i class="fas fa-home mr-2"></i>
                    <span>Home</span>
                </a>
            </div>
        </div>

        <!-- Search bar -->
        <div class="flex-1 max-w-md mx-4">
            <form action="{{ route('admin.search') }}" method="GET">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="query"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-yellow-300 focus:border-yellow-300 sm:text-sm"
                        placeholder="Search books, authors, or members..." value="{{ request('query') }}">
                </div>
            </form>
        </div>

        <!-- User profile and date -->
        <div class="flex items-center space-x-4">
            <div class="hidden md:block text-right">
                <p class="text-sm font-medium text-white">Welcome! Admin</p>
                <p class="text-xs text-white">{{ now()->format('M d, Y | l, h:i A') }}</p>
            </div>

            <!-- User avatar dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                    <div
                        class="h-8 w-8 rounded-full bg-yellow-400 flex items-center justify-center text-black font-semibold">
                        A
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false"
                    class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-black ring-1 ring-white ring-opacity-5 z-50">
                    <div class="py-1">
                        <a href="#"
                            class="block px-4 py-2 text-sm text-white hover:bg-yellow-400 hover:text-black">Your
                            Profile</a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-white hover:bg-yellow-400 hover:text-black">Settings</a>
                        <form action="{{ route('logout') }}" method="POST" class="bg-black">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-white hover:bg-yellow-400 hover:text-black">Sign
                                out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
