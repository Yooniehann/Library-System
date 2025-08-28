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
