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
                        <!-- ACTIVE LINK for this page -->
                        <a href="{{ route('member.fines.index')}}" class="flex items-center px-4 py-3 text-sm font-medium text-white bg-dark-orange rounded-lg">
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
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-white">Fine Details</h1>
                        <p class="text-gray-400">Fine #{{ $fine->fine_id }}</p>
                    </div>
                    <a href="{{ route('member.fines.index') }}" class="bg-slate-700 text-white px-4 py-2 rounded-lg hover:bg-slate-600 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Fines
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Fine Information Card -->
                    <div class="bg-slate-800 rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-white mb-4 border-b border-slate-700 pb-2">Fine Information</h2>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Fine ID:</span>
                                <span class="text-white font-mono">#{{ $fine->fine_id }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-400">Status:</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $fine->status === 'paid' ? 'bg-green-900 text-green-300' : 
                                       ($fine->status === 'waived' ? 'bg-blue-900 text-blue-300' : 'bg-red-900 text-red-300') }}">
                                    {{ ucfirst($fine->status) }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-400">Type:</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $fine->fine_type === 'overdue' ? 'bg-yellow-900 text-yellow-300' : 
                                       ($fine->fine_type === 'lost' ? 'bg-red-900 text-red-300' : 'bg-gray-600 text-gray-300') }}">
                                    {{ ucfirst($fine->fine_type) }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-400">Amount per Day:</span>
                                <span class="text-white">${{ number_format($fine->amount_per_day, 2) }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-400">Total Amount:</span>
                                <span class="text-red-400 font-bold">${{ number_format($fine->total_amount, 2) }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-400">Fine Date:</span>
                                <span class="text-white">{{ $fine->fine_date->format('M d, Y') }}</span>
                            </div>
                            
                            @if($fine->fine_type === 'overdue')
                            <div class="flex justify-between">
                                <span class="text-gray-400">Days Overdue:</span>
                                <span class="text-white">{{ $fine->days_overdue }} days</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Book Information Card -->
                    <div class="bg-slate-800 rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-white mb-4 border-b border-slate-700 pb-2">Book Information</h2>
                        
                        <div class="flex items-start mb-4">
                            <div class="h-20 w-14 bg-slate-700 rounded overflow-hidden shadow-md flex items-center justify-center mr-4">
                                @if($fine->borrow->inventory->book->cover_image)
                                    <img src="{{ asset('storage/' . $fine->borrow->inventory->book->cover_image) }}" alt="Book cover" class="h-full w-full object-cover">
                                @else
                                    <i class="fas fa-book text-gray-400 text-xl"></i>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">{{ $fine->borrow->inventory->book->title }}</h3>
                                <p class="text-gray-400">by {{ $fine->borrow->inventory->book->author->fullname ?? 'Unknown Author' }}</p>
                                <p class="text-sm text-gray-500">ISBN: {{ $fine->borrow->inventory->book->isbn }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Borrow Date:</span>
                                <span class="text-white">{{ $fine->borrow->borrow_date->format('M d, Y') }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-400">Due Date:</span>
                                <span class="text-white">{{ $fine->borrow->due_date->format('M d, Y') }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-400">Return Date:</span>
                                <span class="text-white">
                                    {{ $fine->borrow->return_date ? $fine->borrow->return_date->format('M d, Y') : 'Not returned' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Card -->
                <div class="bg-slate-800 rounded-lg shadow p-6 mb-6">
                    <h2 class="text-lg font-semibold text-white mb-4 border-b border-slate-700 pb-2">Description</h2>
                    <p class="text-gray-300">{{ $fine->description }}</p>
                </div>

                <!-- Payment Information Card (if paid) -->
                @if($fine->payment)
                <div class="bg-slate-800 rounded-lg shadow p-6 mb-6">
                    <h2 class="text-lg font-semibold text-white mb-4 border-b border-slate-700 pb-2">Payment Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Payment ID:</span>
                            <span class="text-white">#{{ $fine->payment->payment_id }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-400">Amount Paid:</span>
                            <span class="text-green-400 font-bold">${{ number_format($fine->payment->amount, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-400">Payment Method:</span>
                            <span class="text-white">{{ ucfirst($fine->payment->payment_method) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-400">Payment Date:</span>
                            <span class="text-white">{{ $fine->payment->payment_date->format('M d, Y') }}</span>
                        </div>
                        
                        @if($fine->payment->transaction_id)
                        <div class="flex justify-between md:col-span-2">
                            <span class="text-gray-400">Transaction ID:</span>
                            <span class="text-white font-mono">{{ $fine->payment->transaction_id }}</span>
                        </div>
                        @endif
                        
                        @if($fine->payment->notes)
                        <div class="md:col-span-2 mt-4 pt-4 border-t border-slate-700">
                            <h3 class="text-md font-semibold text-white mb-2">Payment Notes</h3>
                            <p class="text-gray-300">{{ $fine->payment->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="bg-slate-800 rounded-lg shadow p-6">
                    <div class="flex flex-col sm:flex-row gap-4">
                        @if($fine->status === 'unpaid')
                        <a href="{{ route('member.payments.create', $fine->fine_id) }}" class="bg-primary-orange text-black px-6 py-3 rounded-lg hover:bg-dark-orange transition-colors text-center font-semibold">
                            <i class="fas fa-credit-card mr-2"></i> Pay Now
                        </a>
                        @endif
                        
                        <a href="{{ route('member.fines.index') }}" class="bg-slate-700 text-white px-6 py-3 rounded-lg hover:bg-slate-600 transition-colors text-center">
                            <i class="fas fa-list mr-2"></i> Back to Fines List
                        </a>
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
                        <a href="{{ route('books.index') }}"
                            class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
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
                        <!-- ACTIVE LINK for this page -->
                        <a href="{{ route('member.fines.index')}}" class="flex items-center px-2 py-2 text-base font-medium text-white bg-dark-orange rounded-lg">
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