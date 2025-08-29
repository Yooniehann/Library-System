<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reservations | Library System</title>
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
                        <!-- ACTIVE LINK for this page -->
                        <a href="{{ route('reservations.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-white bg-dark-orange rounded-lg">
                            <i class="fas fa-bookmark mr-3"></i>
                            My Reservations
                        </a>
                        <a href="{{ route('member.fines.index')}}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-money-bill-wave mr-3"></i>
                            Fines & Payments
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
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
                    <h1 class="text-2xl font-bold text-white">My Reservations</h1>
                    <p class="text-gray-400">View and manage all your book reservations.</p>
                </div>

                <!-- Search Bar -->
                <div class="bg-slate-800 rounded-lg shadow p-4 mb-6">
                    <form action="{{ route('reservations.index') }}" method="GET" class="flex gap-3">
                        <div class="flex-1">
                            <input type="text" 
                                   name="search" 
                                   value="{{ $searchTerm ?? '' }}" 
                                   placeholder="Search by book title, author, reservation ID, or status..." 
                                   class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-primary-orange">
                        </div>
                        <button type="submit" class="bg-primary-orange text-black px-6 py-2 rounded-lg hover:bg-dark-orange transition-colors">
                            <i class="fas fa-search mr-2"></i> Search
                        </button>
                        @if(isset($searchTerm) && $searchTerm)
                            <a href="{{ route('reservations.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition-colors flex items-center">
                                <i class="fas fa-times mr-2"></i> Clear
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Dynamic Content Starts Here -->
                @if($reservations->isEmpty())
                    @if(isset($searchTerm) && $searchTerm)
                        <div class="bg-slate-800 rounded-lg shadow p-6 text-center">
                            <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                            <h3 class="text-lg font-medium text-white mb-2">No results found</h3>
                            <p class="text-gray-400">No reservations match your search for "{{ $searchTerm }}".</p>
                        </div>
                    @else
                        <div class="bg-slate-800 rounded-lg shadow p-6 text-center">
                            <i class="fas fa-bookmark text-4xl text-gray-400 mb-4"></i>
                            <h3 class="text-lg font-medium text-white mb-2">No reservations yet</h3>
                            <p class="text-gray-400 mb-4">You haven't made any book reservations.</p>
                            <a href="{{ route('books.index') }}" class="bg-primary-orange text-black px-4 py-2 rounded-lg hover:bg-dark-orange transition-colors">
                                Browse Books
                            </a>
                        </div>
                    @endif
                @else
                    <div class="bg-slate-800 rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-700 flex justify-between items-center">
                            <h2 class="text-lg font-semibold text-white">Your Reservations ({{ $reservations->count() }})</h2>
                            @if(isset($searchTerm) && $searchTerm)
                                <span class="text-sm text-gray-400">Search results for "{{ $searchTerm }}"</span>
                            @endif
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-700">
                                <thead class="bg-slate-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">Book Cover</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">Book Details</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">Reservation Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">Expiry Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">Priority</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-slate-800 divide-y divide-slate-700">
                                    @foreach($reservations as $reservation)
                                    @php
                                        $book = $reservation->book;
                                        $coverImage = $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://via.placeholder.com/128x192/1e293b/ffffff?text=No+Cover';
                                        $isExpired = $reservation->expiry_date->isPast() && $reservation->status === 'active';
                                    @endphp
                                    <tr class="hover:bg-slate-700">
                                        <!-- ID Column -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 font-mono">
                                            #{{ $reservation->reservation_id }}
                                        </td>
                                        
                                        <!-- Book Cover Column -->
                                        <td class="px-6 py-4">
                                            <div class="h-24 w-16 bg-slate-600 rounded-lg overflow-hidden shadow-md flex items-center justify-center">
                                                @if($book->cover_image)
                                                    <img src="{{ $coverImage }}" alt="{{ $book->title }} cover" class="h-full w-full object-cover">
                                                @else
                                                    <i class="fas fa-book text-gray-400 text-xl"></i>
                                                @endif
                                            </div>
                                        </td>
                                        
                                        <!-- Book Details Column -->
                                        <td class="px-6 py-4">
                                            <div class="max-w-xs">
                                                <div class="text-lg font-semibold text-white mb-1">{{ $book->title }}</div>
                                                <div class="text-sm text-gray-400 mb-2">by {{ $book->author->name ?? 'Unknown Author' }}</div>
                                                <div class="text-xs text-gray-500">ISBN: {{ $book->isbn }}</div>
                                                <a href="{{ route('books.show', $book->book_id) }}" class="text-xs text-primary-orange hover:text-dark-orange mt-2 inline-block">
                                                    <i class="fas fa-eye mr-1"></i> View Book
                                                </a>
                                            </div>
                                        </td>
                                        
                                        <!-- Dates Columns -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ $reservation->reservation_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ $reservation->expiry_date->format('M d, Y') }}
                                            @if($isExpired)
                                                <div class="text-xs text-red-400 mt-1">Expired</div>
                                            @endif
                                        </td>
                                        
                                        <!-- Priority Column -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 text-center">
                                            <span class="text-lg font-bold text-primary-orange">#{{ $reservation->priority_number }}</span>
                                        </td>
                                        
                                        <!-- Status Column -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($isExpired)
                                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-900 text-red-300">Expired</span>
                                            @else
                                                @switch($reservation->status)
                                                    @case('active')
                                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-900 text-green-300">Active</span>
                                                        <div class="text-xs text-gray-400 mt-1">
                                                            {{ round(now()->diffInDays($reservation->expiry_date)) }} days remaining
                                                        </div>
                                                        @break
                                                    @case('fulfilled')
                                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-900 text-blue-300">Fulfilled</span>
                                                        @break
                                                    @case('cancelled')
                                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-600 text-gray-300">Cancelled</span>
                                                        @break
                                                    @default
                                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-600 text-gray-300">{{ ucfirst($reservation->status) }}</span>
                                                @endswitch
                                            @endif
                                        </td>
                                        
                                        <!-- Actions Column -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if($reservation->status === 'active' && !$isExpired)
                                                <form action="{{ route('reservations.cancel', $reservation->reservation_id) }}" method="POST" class="w-full">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="w-full flex items-center justify-center px-4 py-2 bg-red-700 text-white text-sm rounded hover:bg-red-600 transition-colors"
                                                            onclick="return confirm('Are you sure you want to cancel this reservation?')">
                                                        <i class="fas fa-times mr-2"></i> Cancel
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-500 text-sm">No actions available</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                <!-- Dynamic Content Ends Here -->
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
                        <a href="#"
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
        function toggleMobileSidebar() {
            document.getElementById('mobile-sidebar').classList.toggle('hidden');
        }
    </script>
</body>
</html>