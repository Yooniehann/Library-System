<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Library Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .bg-primary-orange { background-color: #EEBA30; }
        .bg-dark-orange { background-color: #D3A625; }
        .text-primary-orange { color: #EEBA30; }
        .text-dark-orange { color: #D3A625; }
        .border-primary-orange { border-color: #EEBA30; }
        .hover\:bg-dark-orange:hover { background-color: #D3A625; }
        .bg-slate-900 { background-color: #0f172a; }
        .bg-slate-800 { background-color: #1e293b; }
        .bg-slate-700 { background-color: #334155; }
    </style>
</head>
<body class="bg-slate-900 text-gray-200 font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-black border-r border-slate-700">
                <div class="flex items-center justify-center h-16 px-4 bg-black">
                    <span class="text-primary-orange text-xl font-bold">Member Dashboard</span>
                </div>
                <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto">
                    <nav class="flex-1 space-y-2">
                        <a href="#" class="flex items-center px-4 py-3 text-sm font-medium text-white bg-dark-orange rounded-lg">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('books.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fa-solid fa-house mr-3"></i>
                            Home
                        </a>
                        <a href="{{ route('borrowed.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-book-open mr-3"></i>
                            My Borrowed Books
                        </a>
                        <a href="{{ route('reservations.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-bookmark mr-3"></i>
                            My Reservations
                        </a>
                        <a href="{{ route('member.fines.index')}}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-money-bill-wave mr-3"></i>
                            Fines & Payments
                        </a>
                        <a href="{{ route('member.notifications.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fa-solid fa-bell mr-3"></i>
                            Notification
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-user-cog mr-3"></i>
                            Profile Settings
                        </a>
                    </nav>
                </div>
                <div class="p-4 border-t border-slate-700">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-sign-out-alt mr-3"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Navigation (Mobile) -->
            <div class="md:hidden flex items-center justify-between px-4 py-3 bg-black border-b border-slate-700">
                <button class="text-primary-orange focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="text-primary-orange text-lg font-bold">Member Dashboard</span>
                <div class="w-6"></div>
            </div>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-white">Welcome back, Si Si!</h1>
                    <p class="text-gray-400">Here's what's happening with your account today.</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-slate-800 rounded-lg shadow p-4 ">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-900 bg-opacity-30 text-green-400">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-400">Borrowed Books</p>
                                <p class="text-2xl font-semibold text-white">3</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-800 rounded-lg shadow p-4 ">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-900 bg-opacity-30 text-red-400">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-400">Overdue Books</p>
                                <p class="text-2xl font-semibold text-white">1</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-800 rounded-lg shadow p-4  ">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-900 bg-opacity-30 text-blue-400">
                                <i class="fas fa-bookmark"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-400">Reservations</p>
                                <p class="text-2xl font-semibold text-white">2</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-800 rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-900 bg-opacity-30 text-yellow-400">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-400">Fines Due</p>
                                <p class="text-2xl font-semibold text-white">$5.50</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-white mb-3">Quick Actions</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <a href="#" class="bg-slate-800 rounded-lg shadow p-4 flex items-center justify-center border border-slate-700 hover:border-primary-orange transition-colors hover:bg-slate-700">
                            <i class="fas fa-book text-primary-orange mr-2"></i>
                            <span>Borrow a Book</span>
                        </a>
                        <a href="#" class="bg-slate-800 rounded-lg shadow p-4 flex items-center justify-center border border-slate-700 hover:border-primary-orange transition-colors hover:bg-slate-700">
                            <i class="fas fa-sync-alt text-primary-orange mr-2"></i>
                            <span>Renew Books</span>
                        </a>
                        <a href="#" class="bg-slate-800 rounded-lg shadow p-4 flex items-center justify-center border border-slate-700 hover:border-primary-orange transition-colors hover:bg-slate-700">
                            <i class="fas fa-credit-card text-primary-orange mr-2"></i>
                            <span>Pay Fines</span>
                        </a>
                    </div>
                </div>



                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Current Borrowings -->
                    <div class="lg:col-span-2">
                        <div class="bg-slate-800 rounded-lg shadow overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-700">
                                <h2 class="text-lg font-semibold text-white">Currently Borrowed Books</h2>
                            </div>
                            <div class="divide-y divide-slate-700">
                                <div class="p-4 hover:bg-slate-700">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-16 w-12 bg-slate-600 flex items-center justify-center">
                                            <i class="fas fa-book text-gray-400"></i>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <h3 class="text-sm font-medium text-white">The Silent Patient</h3>
                                            <p class="text-sm text-gray-400">Alex Michaelides</p>
                                            <p class="text-xs text-gray-500">Due: May 15, 2023</p>
                                        </div>
                                        <div class="ml-4">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-900 text-red-300">Overdue</span>
                                            <button class="ml-2 text-sm text-primary-orange hover:text-dark-orange">Renew</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 hover:bg-slate-700">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-16 w-12 bg-slate-600 flex items-center justify-center">
                                            <i class="fas fa-book text-gray-400"></i>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <h3 class="text-sm font-medium text-white">Educated</h3>
                                            <p class="text-sm text-gray-400">Tara Westover</p>
                                            <p class="text-xs text-gray-500">Due: May 20, 2023</p>
                                        </div>
                                        <div class="ml-4">
                                            <button class="text-sm text-primary-orange hover:text-dark-orange">Renew</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 hover:bg-slate-700">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-16 w-12 bg-slate-600 flex items-center justify-center">
                                            <i class="fas fa-book text-gray-400"></i>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <h3 class="text-sm font-medium text-white">Atomic Habits</h3>
                                            <p class="text-sm text-gray-400">James Clear</p>
                                            <p class="text-xs text-gray-500">Due: May 25, 2023</p>
                                        </div>
                                        <div class="ml-4">
                                            <button class="text-sm text-primary-orange hover:text-dark-orange">Renew</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-4 border-t border-slate-700 bg-slate-900">
                                <a href="#" class="text-sm font-medium text-primary-orange hover:text-dark-orange">View all borrowed books →</a>
                            </div>
                        </div>
                    </div> 

                    <!-- Notifications -->
                    <div>
                        <div class="bg-slate-800 rounded-lg shadow overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-700">
                                <h2 class="text-lg font-semibold text-white">Notifications</h2>
                            </div>
                            <div class="divide-y divide-slate-700">
                                <div class="p-4 hover:bg-slate-700">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="h-5 w-5 text-red-400 fas fa-exclamation-circle"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-white">Overdue book</p>
                                            <p class="text-sm text-gray-400">"The Silent Patient" was due on May 15</p>
                                            <p class="text-xs text-gray-500">2 days ago</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 hover:bg-slate-700">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="h-5 w-5 text-green-400 fas fa-check-circle"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-white">Reservation ready</p>
                                            <p class="text-sm text-gray-400">"Where the Crawdads Sing" is available for pickup</p>
                                            <p class="text-xs text-gray-500">1 day ago</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 hover:bg-slate-700">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="h-5 w-5 text-blue-400 fas fa-info-circle"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-white">Library announcement</p>
                                            <p class="text-sm text-gray-400">Extended hours this weekend</p>
                                            <p class="text-xs text-gray-500">3 days ago</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-4 border-t border-slate-700 bg-slate-900">
                                <a href="#" class="text-sm font-medium text-primary-orange hover:text-dark-orange">View all notifications →</a>
                            </div>
                        </div>
                    </div> 
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile sidebar overlay -->
    <div class="fixed inset-0 z-40 md:hidden hidden" id="mobile-sidebar">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75"></div>
        <div class="fixed inset-y-0 left-0 flex max-w-xs w-full">
            <div class="relative flex-1 flex flex-col w-64 bg-black">
                <div class="absolute top-0 right-0 -mr-14 p-1">
                    <button class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none focus:bg-gray-600">
                        <i class="fas fa-times text-white"></i>
                    </button>
                </div>
                <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                    <div class="flex-shrink-0 flex items-center px-4">
                        <span class="text-primary-orange text-xl font-bold">Member Dashboard</span>
                    </div>
                    <nav class="mt-5 px-2 space-y-1">
                        <a href="#" class="flex items-center px-2 py-2 text-base font-medium text-white bg-dark-orange rounded-lg">
                            <i class="fas fa-tachometer-alt mr-4"></i>
                            Dashboard
                        </a>
                        <a href="#" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fa-solid fa-house mr-4"></i>
                            Home
                        </a>
                        <a href="{{ route('borrowed.index') }}" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-book-open mr-4"></i>
                            My Borrowed Books
                        </a>
                        <a href="#" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-bookmark mr-4"></i>
                            My Reservations
                        </a>
                        <a href="{{ route('member.fines.index')}}" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-money-bill-wave mr-4"></i>
                            Fines & Payments
                        </a>
                        <a href="{{ route('member.notifications.index') }}"
                            class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fa-solid fa-bell mr-4"></i>
                            Notification
                        </a>
                        <a href="#" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-user-cog mr-4"></i>
                            Profile Settings
                        </a>
                    </nav>
                </div>
                <div class="flex-shrink-0 flex border-t border-slate-700 p-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex-shrink-0 w-full group block">
                            <div class="flex items-center">
                                <div>
                                    <i class="fas fa-sign-out-alt text-gray-300 group-hover:text-white mr-3"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-300 group-hover:text-white">Logout</p>
                                </div>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div> 

    <script>
        // Simple mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const sidebarToggle = document.querySelector('.md\\:hidden button');
            
            sidebarToggle.addEventListener('click', function() {
                mobileSidebar.classList.toggle('hidden');
            });
            
            // Close button inside mobile sidebar
            const closeButton = document.querySelector('#mobile-sidebar button');
            closeButton.addEventListener('click', function() {
                mobileSidebar.classList.add('hidden');
            });
        });
    </script>
</body>
</html>