<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Notifications | Library System</title>
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
        
        /* Enhanced notification styles */
        .notification-new {
            background: linear-gradient(90deg, rgba(238, 186, 48, 0.15) 0%, rgba(238, 186, 48, 0.05) 100%);
            border-left: 4px solid #EEBA30;
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .notification-new::before {
            content: '';
            position: absolute;
            top: 8px;
            right: 8px;
            width: 10px;
            height: 10px;
            background-color: #EEBA30;
            border-radius: 50%;
            box-shadow: 0 0 10px 3px rgba(238, 186, 48, 0.6);
            animation: pulse 2s infinite;
        }
        
        .notification-old {
            background-color: rgba(30, 41, 59, 0.7);
            border-left: 4px solid transparent;
            transition: all 0.3s ease;
        }
        
        .notification-old:hover {
            background-color: rgba(51, 65, 85, 0.7);
            transform: translateX(4px);
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(238, 186, 48, 0.7);
            }
            70% {
                box-shadow: 0 0 0 8px rgba(238, 186, 48, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(238, 186, 48, 0);
            }
        }
        
        /* Filter buttons */
        .filter-btn {
            transition: all 0.2s ease;
        }
        
        .filter-btn.active {
            background-color: #EEBA30;
            color: #000;
        }
        
        /* Notification type badges */
        .badge-borrowed {
            background-color: rgba(66, 153, 225, 0.2);
            color: #4299e1;
        }
        
        .badge-reservation {
            background-color: rgba(101, 163, 13, 0.2);
            color: #65a30d;
        }
        
        .badge-fine {
            background-color: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }
        
        .badge-system {
            background-color: rgba(156, 163, 175, 0.2);
            color: #9ca3af;
        }
        
        /* Date styling */
        .notification-date {
            position: relative;
            padding-left: 20px;
        }
        
        .notification-date::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 12px;
            height: 12px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%239ca3af' viewBox='0 0 24 24'%3E%3Cpath d='M19 4h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2z'/%3E%3C/svg%3E");
            background-size: contain;
            opacity: 0.7;
        }
        
        /* Improved empty state */
        .empty-state {
            transition: all 0.3s ease;
        }
        
        .empty-state:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
        }
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
                        <a href="{{ route('member.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('books.index') }}"
                            class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
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
                        <!-- ACTIVE LINK for this page -->
                        <a href="{{ route('member.notifications.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-white bg-dark-orange rounded-lg">
                            <i class="fa-solid fa-bell mr-3"></i>
                            Notification
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
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
                <button class="text-primary-orange focus:outline-none" onclick="toggleMobileSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="text-primary-orange text-lg font-bold">Member Dashboard</span>
                <div class="w-6"></div>
            </div>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-white">My Notifications</h1>
                    <p class="text-gray-400">Stay updated with your library activities</p>
                </div>

                @if(session('success'))
                    <div class="bg-green-900 bg-opacity-30 border border-green-700 text-green-300 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if($notifications->isEmpty())
                    <div class="bg-slate-800 rounded-lg shadow p-6 text-center empty-state">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-700 mb-4">
                            <i class="fas fa-bell-slash text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-white mb-2">No notifications yet</h3>
                        <p class="text-gray-400">We'll notify you when there's something new.</p>
                    </div>
                @else
                    <!-- Search and Filter Bar -->
                    <div class="bg-slate-800 rounded-lg shadow p-4 mb-6">
                        <form action="{{ route('member.notifications.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                            <div class="flex-1">
                                <input type="text" 
                                       name="search" 
                                       value="{{ $searchTerm ?? '' }}" 
                                       placeholder="Search notifications by title, message, or type..." 
                                       class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-primary-orange">
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="bg-primary-orange text-black px-4 py-2 rounded-lg hover:bg-dark-orange transition-colors">
                                    <i class="fas fa-search mr-2"></i> Search
                                </button>
                                @if(isset($searchTerm) && $searchTerm)
                                    <a href="{{ route('member.notifications.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition-colors flex items-center">
                                        <i class="fas fa-times mr-2"></i> Clear
                                    </a>
                                @endif
                            </div>
                        </form>
                        
                        <!-- Filter buttons -->
                        <div class="mt-4 flex flex-wrap gap-2">
                            <button class="filter-btn active px-3 py-1 rounded-lg text-sm bg-primary-orange text-black" data-filter="all">
                                All Notifications
                            </button>
                            <button class="filter-btn px-3 py-1 rounded-lg text-sm bg-slate-700 text-gray-300 hover:bg-slate-600" data-filter="new">
                                New Only
                            </button>
                            <button class="filter-btn px-3 py-1 rounded-lg text-sm bg-slate-700 text-gray-300 hover:bg-slate-600" data-filter="old">
                                Viewed Only
                            </button>
                        </div>
                    </div>

                    <div class="bg-slate-800 rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-700 flex justify-between items-center">
                            <h2 class="text-lg font-semibold text-white">Your Notifications ({{ $notifications->count() }})</h2>
                            @if(isset($searchTerm) && $searchTerm)
                                <span class="text-sm text-gray-400">Search results for "{{ $searchTerm }}"</span>
                            @endif
                        </div>
                        
                        <div class="divide-y divide-slate-700" id="notifications-container">
                            @foreach($notifications as $notification)
                            <div class="p-6 transition-colors notification-item 
                                {{ $notification->is_new ? 'notification-new' : 'notification-old' }}"
                                data-is-new="{{ $notification->is_new ? 'true' : 'false' }}">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <h3 class="text-lg font-semibold text-white">{{ $notification->title }}</h3>
                                            <div class="flex items-center space-x-2">
                                                @if($notification->is_new)
                                                <span class="text-xs px-2 py-1 bg-primary-orange bg-opacity-20 text-primary-orange rounded-full flex items-center">
                                                    <span class="h-2 w-2 rounded-full bg-primary-orange mr-1"></span>
                                                    NEW
                                                </span>
                                                @endif
                                                <span class="text-xs px-2 py-1 rounded-full badge-{{ $notification->notification_type }}">
                                                    {{ ucfirst($notification->notification_type) }}
                                                </span>
                                            </div>
                                        </div>
                                        <p class="text-gray-300 mb-3">{{ $notification->message }}</p>
                                        <div class="flex items-center text-sm text-gray-400">
                                            <span class="mr-4">
                                                <i class="far fa-calendar-alt mr-1"></i>
                                                {{ $notification->sent_date->format('M d, Y') }}
                                            </span>
                                            <span>
                                                <i class="far fa-clock mr-1"></i>
                                                {{ $notification->sent_date->format('h:i A') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        @if($notifications->hasPages())
                        <div class="px-6 py-4 border-t border-slate-700 bg-slate-900">
                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-400">
                                    Showing {{ $notifications->firstItem() }} to {{ $notifications->lastItem() }} of {{ $notifications->total() }} results
                                </div>
                                <div class="flex space-x-2">
                                    @if($notifications->onFirstPage())
                                        <span class="px-3 py-1 rounded bg-slate-700 text-gray-500 text-sm">Previous</span>
                                    @else
                                        <a href="{{ $notifications->previousPageUrl() }}" class="px-3 py-1 rounded bg-slate-600 hover:bg-slate-500 text-white text-sm">Previous</a>
                                    @endif
                                    
                                    @if($notifications->hasMorePages())
                                        <a href="{{ $notifications->nextPageUrl() }}" class="px-3 py-1 rounded bg-slate-600 hover:bg-slate-500 text-white text-sm">Next</a>
                                    @else
                                        <span class="px-3 py-1 rounded bg-slate-700 text-gray-500 text-sm">Next</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                @endif
            </main>
        </div>
    </div>

    <!-- Mobile sidebar overlay -->
    <div class="fixed inset-0 z-40 md:hidden hidden" id="mobile-sidebar">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75"></div>
        <div class="fixed inset-y-0 left-0 flex max-w-xs w-full">
            <div class="relative flex-1 flex flex-col w-64 bg-black">
                <div class="absolute top-0 right-0 -mr-14 p-1">
                    <button class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none focus:bg-gray-600" onclick="toggleMobileSidebar()">
                        <i class="fas fa-times text-white"></i>
                    </button>
                </div>
                <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                    <div class="flex-shrink-0 flex items-center px-4">
                        <span class="text-primary-orange text-xl font-bold">Member Dashboard</span>
                    </div>
                    <nav class="mt-5 px-2 space-y-1">
                        <a href="{{ route('member.dashboard') }}" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-tachometer-alt mr-4"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('books.index') }}" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fa-solid fa-house mr-4"></i>
                            Home
                        </a>
                        <a href="{{ route('borrowed.index') }}" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-book-open mr-4"></i>
                            My Borrowed Books
                        </a>
                        <a href="{{ route('reservations.index') }}" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-bookmark mr-4"></i>
                            My Reservations
                        </a>
                        <a href="{{ route('member.fines.index')}}" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-money-bill-wave mr-4"></i>
                            Fines & Payments
                        </a>
                        <a href="{{ route('member.notifications.index') }}" class="flex items-center px-2 py-2 text-base font-medium text-white bg-dark-orange rounded-lg">
                            <i class="fa-solid fa-bell mr-4"></i>
                            Notification
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
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
        function toggleMobileSidebar() {
            document.getElementById('mobile-sidebar').classList.toggle('hidden');
        }
        
        // Notification filtering functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const notificationItems = document.querySelectorAll('.notification-item');
            
            // Filter functionality
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filter = this.getAttribute('data-filter');
                    
                    // Update active button
                    filterButtons.forEach(btn => btn.classList.remove('active', 'bg-primary-orange', 'text-black'));
                    filterButtons.forEach(btn => btn.classList.add('bg-slate-700', 'text-gray-300'));
                    this.classList.add('active', 'bg-primary-orange', 'text-black');
                    this.classList.remove('bg-slate-700', 'text-gray-300');
                    
                    // Filter notifications
                    notificationItems.forEach(item => {
                        const isNew = item.getAttribute('data-is-new') === 'true';
                        
                        if (filter === 'all') {
                            item.style.display = 'block';
                        } else if (filter === 'new' && isNew) {
                            item.style.display = 'block';
                        } else if (filter === 'old' && !isNew) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>