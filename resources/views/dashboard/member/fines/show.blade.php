<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fine Details | Library System</title>
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
                        <!-- ACTIVE LINK for this page -->
                        <a href="{{ route('member.fines.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-white bg-dark-orange rounded-lg">
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
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-white">Fine Details</h1>
                            <p class="text-gray-400">Fine ID: #{{ $fine->fine_id }}</p>
                        </div>
                        <a href="{{ route('member.fines.index') }}" class="bg-slate-700 text-white px-4 py-2 rounded-lg hover:bg-slate-600 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Fines
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Fine Information -->
                    <div class="bg-slate-800 rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-white mb-4">Fine Information</h2>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Fine Type:</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($fine->fine_type === 'overdue') bg-yellow-900 text-yellow-300
                                    @elseif($fine->fine_type === 'lost') bg-red-900 text-red-300
                                    @else bg-gray-600 text-gray-300 @endif">
                                    {{ ucfirst($fine->fine_type) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Amount:</span>
                                <span class="text-lg font-semibold text-white">RM {{ number_format($fine->amount_per_day, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Fine Date:</span>
                                <span class="text-white">{{ $fine->fine_date->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Status:</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($fine->status === 'unpaid') bg-red-900 text-red-300
                                    @elseif($fine->status === 'paid') bg-green-900 text-green-300
                                    @else bg-blue-900 text-blue-300 @endif">
                                    {{ ucfirst($fine->status) }}
                                </span>
                            </div>
                            @if($fine->description)
                            <div>
                                <span class="text-gray-400 block mb-2">Description:</span>
                                <p class="text-white bg-slate-700 p-3 rounded-lg">{{ $fine->description }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Book Information -->
                    <div class="bg-slate-800 rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-white mb-4">Book Information</h2>
                        @if($fine->borrow && $fine->borrow->book)
                        @php
                            $book = $fine->borrow->book;
                            $coverImage = $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://via.placeholder.com/128x192/1e293b/ffffff?text=No+Cover';
                        @endphp
                        <div class="flex items-start space-x-4">
                            <div class="h-24 w-16 bg-slate-600 rounded-lg overflow-hidden shadow-md flex items-center justify-center">
                                @if($book->cover_image)
                                    <img src="{{ $coverImage }}" alt="{{ $book->title }} cover" class="h-full w-full object-cover">
                                @else
                                    <i class="fas fa-book text-gray-400 text-xl"></i>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-white">{{ $book->title }}</h3>
                                <p class="text-gray-400">by {{ $book->author->name ?? 'Unknown Author' }}</p>
                                <p class="text-sm text-gray-500">ISBN: {{ $book->isbn }}</p>
                                <a href="{{ route('books.show', $book->book_id) }}" class="text-primary-orange hover:text-dark-orange text-sm inline-block mt-2">
                                    <i class="fas fa-eye mr-1"></i> View Book Details
                                </a>
                            </div>
                        </div>
                        @else
                        <div class="text-center text-gray-400 py-8">
                            <i class="fas fa-book text-4xl mb-3"></i>
                            <p>Book information not available</p>
                        </div>
                        @endif
                    </div>

                    <!-- Borrow Information -->
                    <div class="bg-slate-800 rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-white mb-4">Borrow Information</h2>
                        @if($fine->borrow)
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Borrow Date:</span>
                                <span class="text-white">{{ $fine->borrow->borrow_date->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Due Date:</span>
                                <span class="text-white">{{ $fine->borrow->due_date->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Status:</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($fine->borrow->status === 'active') bg-green-900 text-green-300
                                    @elseif($fine->borrow->status === 'overdue') bg-red-900 text-red-300
                                    @else bg-gray-600 text-gray-300 @endif">
                                    {{ ucfirst($fine->borrow->status) }}
                                </span>
                            </div>
                        </div>
                        @else
                        <div class="text-center text-gray-400 py-8">
                            <i class="fas fa-history text-4xl mb-3"></i>
                            <p>Borrow information not available</p>
                        </div>
                        @endif
                    </div>

                    <!-- Payment Information -->
                    <div class="bg-slate-800 rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-white mb-4">Payment Information</h2>
                        @if($fine->payment)
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Payment Date:</span>
                                <span class="text-white">{{ $fine->payment->payment_date->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Payment Method:</span>
                                <span class="text-white capitalize">{{ $fine->payment->payment_method }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Transaction ID:</span>
                                <span class="text-white">{{ $fine->payment->transaction_id ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Status:</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($fine->payment->status === 'completed') bg-green-900 text-green-300
                                    @elseif($fine->payment->status === 'pending') bg-yellow-900 text-yellow-300
                                    @else bg-red-900 text-red-300 @endif">
                                    {{ ucfirst($fine->payment->status) }}
                                </span>
                            </div>
                        </div>
                        @else
                        <div class="text-center text-gray-400 py-8">
                            <i class="fas fa-credit-card text-4xl mb-3"></i>
                            <p>No payment information available</p>
                            @if($fine->status === 'unpaid')
                            <a href="{{ route('member.payments.create.fine', $fine->fine_id) }}" class="bg-primary-orange text-black px-4 py-2 rounded-lg hover:bg-dark-orange transition-colors inline-block mt-3">
                                <i class="fas fa-credit-card mr-2"></i> Pay Now
                            </a>
                            @endif
                        </div>
                        @endif
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
                        <a href="{{ route('member.fines.index') }}" class="flex items-center px-2 py-2 text-base font-medium text-white bg-dark-orange rounded-lg">
                            <i class="fas fa-money-bill-wave mr-4"></i>
                            Fines & Payments
                        </a>
                        <a href="#" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
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
    </script>
</body>
</html>