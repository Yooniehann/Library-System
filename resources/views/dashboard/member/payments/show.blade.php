<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details | Library System</title>
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
                        <a href="{{ route('member.payments.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-white bg-dark-orange rounded-lg">
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
                            <h1 class="text-2xl font-bold text-white">Payment Details</h1>
                            <p class="text-gray-400">Payment ID: #{{ $payment->payment_id }}</p>
                        </div>
                        <a href="{{ route('member.payments.index') }}" class="bg-slate-700 text-white px-4 py-2 rounded-lg hover:bg-slate-600 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Payments
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-900 border border-green-700 text-green-300 px-4 py-3 rounded-lg mb-6">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Payment Information -->
                    <div class="bg-slate-800 rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-white mb-4">Payment Information</h2>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Payment ID:</span>
                                <span class="text-white font-mono">#{{ $payment->payment_id }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Payment Type:</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($payment->payment_type === 'fine') bg-yellow-900 text-yellow-300
                                    @else bg-blue-900 text-blue-300 @endif">
                                    {{ str_replace('_', ' ', ucfirst($payment->payment_type)) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Amount:</span>
                                <span class="text-lg font-semibold text-white">RM {{ number_format($payment->amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Payment Method:</span>
                                <span class="text-white capitalize">{{ $payment->payment_method }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Payment Date:</span>
                                <span class="text-white">{{ $payment->payment_date->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Status:</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($payment->status === 'completed') bg-green-900 text-green-300
                                    @elseif($payment->status === 'pending') bg-yellow-900 text-yellow-300
                                    @elseif($payment->status === 'failed') bg-red-900 text-red-300
                                    @else bg-gray-600 text-gray-300 @endif">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </div>
                            @if($payment->transaction_id)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Transaction ID:</span>
                                <span class="text-white">{{ $payment->transaction_id }}</span>
                            </div>
                            @endif
                            @if($payment->notes)
                            <div>
                                <span class="text-gray-400 block mb-2">Notes:</span>
                                <p class="text-white bg-slate-700 p-3 rounded-lg">{{ $payment->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Details -->
                    <div class="bg-slate-800 rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-white mb-4">Payment Details</h2>
                        
                        @if($payment->payment_type === 'fine' && $payment->fine)
                        <div class="space-y-4">
                            <h3 class="text-md font-medium text-white">Fine Payment</h3>
                            @if($payment->fine->borrow && $payment->fine->borrow->book)
                            <div class="flex items-start space-x-3">
                                <div class="h-16 w-12 bg-slate-600 rounded overflow-hidden shadow-md flex items-center justify-center">
                                    @if($payment->fine->borrow->book->cover_image)
                                        <img src="{{ asset('storage/' . $payment->fine->borrow->book->cover_image) }}" 
                                             alt="{{ $payment->fine->borrow->book->title }} cover" 
                                             class="h-full w-full object-cover">
                                    @else
                                        <i class="fas fa-book text-gray-400"></i>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-white">{{ $payment->fine->borrow->book->title }}</div>
                                    <div class="text-xs text-gray-400">{{ $payment->fine->borrow->book->author->name ?? 'Unknown Author' }}</div>
                                </div>
                            </div>
                            @endif
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-400">Fine Type:</span>
                                    <p class="text-white">{{ ucfirst($payment->fine->fine_type) }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-400">Fine Amount:</span>
                                    <p class="text-white">RM {{ number_format($payment->fine->amount_per_day, 2) }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-400">Fine Date:</span>
                                    <p class="text-white">{{ $payment->fine->fine_date->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-400">Fine Status:</span>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($payment->fine->status === 'paid') bg-green-900 text-green-300
                                        @else bg-red-900 text-red-300 @endif">
                                        {{ ucfirst($payment->fine->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        @elseif($payment->payment_type === 'membership_fee' && $payment->membershipType)
                        <div class="space-y-4">
                            <h3 class="text-md font-medium text-white">Membership Payment</h3>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-400">Membership Type:</span>
                                    <p class="text-white">{{ $payment->membershipType->name }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-400">Duration:</span>
                                    <p class="text-white capitalize">{{ $payment->membershipType->duration }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-400">Price:</span>
                                    <p class="text-white">RM {{ number_format($payment->membershipType->price, 2) }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-400">Max Books:</span>
                                    <p class="text-white">{{ $payment->membershipType->max_books_allowed }}</p>
                                </div>
                            </div>
                        </div>
                        
                        @else
                        <div class="text-center text-gray-400 py-8">
                            <i class="fas fa-info-circle text-4xl mb-3"></i>
                            <p>No additional details available</p>
                        </div>
                        @endif
                    </div>

                    <!-- Receipt Actions -->
                    <div class="lg:col-span-2">
                        <div class="bg-slate-800 rounded-lg shadow p-6">
                            <h2 class="text-lg font-semibold text-white mb-4">Receipt</h2>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <button onclick="window.print()" class="bg-primary-orange text-black px-6 py-3 rounded-lg hover:bg-dark-orange transition-colors flex-1 text-center">
                                    <i class="fas fa-print mr-2"></i> Print Receipt
                                </button>
                                <a href="{{ route('member.payments.index') }}" class="bg-slate-700 text-white px-6 py-3 rounded-lg hover:bg-slate-600 transition-colors flex-1 text-center">
                                    <i class="fas fa-list mr-2"></i> View All Payments
                                </a>
                                @if($payment->payment_type === 'fine' && $payment->fine)
                                <a href="{{ route('member.fines.show', $payment->fine->fine_id) }}" class="bg-slate-700 text-white px-6 py-3 rounded-lg hover:bg-slate-600 transition-colors flex-1 text-center">
                                    <i class="fas fa-money-bill-wave mr-2"></i> View Fine Details
                                </a>
                                @endif
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
                        <a href="{{ route('member.payments.index') }}" class="flex items-center px-2 py-2 text-base font-medium text-white bg-dark-orange rounded-lg">
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