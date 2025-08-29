<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History | Library System</title>
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
                            <h1 class="text-2xl font-bold text-white">Payment History</h1>
                            <p class="text-gray-400">View all your payment transactions</p>
                        </div>
                        <a href="{{ route('member.payments.create') }}" class="bg-primary-orange text-black px-4 py-2 rounded-lg hover:bg-dark-orange transition-colors">
                            <i class="fas fa-plus mr-2"></i> New Payment
                        </a>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="bg-slate-800 rounded-lg shadow p-4 mb-6">
                    <form action="{{ route('member.payments.index') }}" method="GET" class="flex gap-3">
                        <div class="flex-1">
                            <input type="text" 
                                   name="search" 
                                   value="{{ $searchTerm ?? '' }}" 
                                   placeholder="Search by payment type, method, status, or book title..." 
                                   class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-primary-orange">
                        </div>
                        <button type="submit" class="bg-primary-orange text-black px-6 py-2 rounded-lg hover:bg-dark-orange transition-colors">
                            <i class="fas fa-search mr-2"></i> Search
                        </button>
                        @if(isset($searchTerm) && $searchTerm)
                            <a href="{{ route('member.payments.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition-colors flex items-center">
                                <i class="fas fa-times mr-2"></i> Clear
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Payments Table -->
                @if($payments->isEmpty())
                    @if(isset($searchTerm) && $searchTerm)
                        <div class="bg-slate-800 rounded-lg shadow p-6 text-center">
                            <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                            <h3 class="text-lg font-medium text-white mb-2">No results found</h3>
                            <p class="text-gray-400">No payments match your search for "{{ $searchTerm }}".</p>
                        </div>
                    @else
                        <div class="bg-slate-800 rounded-lg shadow p-6 text-center">
                            <i class="fas fa-receipt text-4xl text-gray-400 mb-4"></i>
                            <h3 class="text-lg font-medium text-white mb-2">No payments yet</h3>
                            <p class="text-gray-400 mb-4">You haven't made any payments yet.</p>
                            <a href="{{ route('member.payments.create') }}" class="bg-primary-orange text-black px-4 py-2 rounded-lg hover:bg-dark-orange transition-colors">
                                Make Your First Payment
                            </a>
                        </div>
                    @endif
                @else
                    <div class="bg-slate-800 rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-700 flex justify-between items-center">
                            <h2 class="text-lg font-semibold text-white">Your Payments ({{ $payments->total() }})</h2>
                            @if(isset($searchTerm) && $searchTerm)
                                <span class="text-sm text-gray-400">Search results for "{{ $searchTerm }}"</span>
                            @endif
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-700">
                                <thead class="bg-slate-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">Details</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">Method</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-slate-800 divide-y divide-slate-700">
                                    @foreach($payments as $payment)
                                    <tr class="hover:bg-slate-700">
                                        <!-- ID Column -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 font-mono">
                                            #{{ $payment->payment_id }}
                                        </td>
                                        
                                        <!-- Type Column -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                @if($payment->payment_type === 'fine') bg-yellow-900 text-yellow-300
                                                @else bg-blue-900 text-blue-300 @endif">
                                                {{ str_replace('_', ' ', ucfirst($payment->payment_type)) }}
                                            </span>
                                        </td>
                                        
                                        <!-- Details Column -->
                                        <td class="px-6 py-4">
                                            @if($payment->payment_type === 'fine' && $payment->fine && $payment->fine->borrow && $payment->fine->borrow->book)
                                                <div class="text-sm font-medium text-white">{{ $payment->fine->borrow->book->title }}</div>
                                                <div class="text-xs text-gray-400">Fine: {{ ucfirst($payment->fine->fine_type) }}</div>
                                            @elseif($payment->payment_type === 'membership_fee' && $payment->membershipType)
                                                <div class="text-sm font-medium text-white">{{ $payment->membershipType->name }}</div>
                                                <div class="text-xs text-gray-400">{{ ucfirst($payment->membershipType->duration) }} membership</div>
                                            @else
                                                <div class="text-sm text-gray-400">Details not available</div>
                                            @endif
                                        </td>
                                        
                                        <!-- Amount Column -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-white">
                                            RM {{ number_format($payment->amount, 2) }}
                                        </td>
                                        
                                        <!-- Method Column -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 capitalize">
                                            {{ $payment->payment_method }}
                                        </td>
                                        
                                        <!-- Date Column -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ $payment->payment_date->format('M d, Y H:i') }}
                                        </td>
                                        
                                        <!-- Status Column -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                @if($payment->status === 'completed') bg-green-900 text-green-300
                                                @elseif($payment->status === 'pending') bg-yellow-900 text-yellow-300
                                                @elseif($payment->status === 'failed') bg-red-900 text-red-300
                                                @else bg-gray-600 text-gray-300 @endif">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        
                                        <!-- Actions Column -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('member.payments.show', $payment->payment_id) }}" 
                                               class="px-3 py-1 bg-slate-600 text-white rounded hover:bg-slate-500 transition-colors text-xs">
                                                <i class="fas fa-eye mr-1"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if($payments->hasPages())
                        <div class="px-6 py-4 border-t border-slate-700 bg-slate-900">
                            {{ $payments->links() }}
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