<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Payments | Library System</title>
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
                        <a href="{{ route('member.fines.index')}}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-money-bill-wave mr-3"></i>
                            Fines 
                        </a>
                        <a href="{{ route('member.payments.index')}}" class="flex items-center px-4 py-3 text-sm font-medium text-white bg-dark-orange rounded-lg">
                            <i class="fas fa-money-bill-wave mr-3"></i>
                            Payments
                        </a>
                        <a href="member.notifications.index" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
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
                    <h1 class="text-2xl font-bold text-white">My Payments</h1>
                    <p class="text-gray-400">View your payment history and receipts.</p>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-slate-800 rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="rounded-full bg-blue-900 p-3 mr-4">
                                <i class="fas fa-receipt text-blue-300 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm">Total Payments</p>
                                <p class="text-white text-xl font-bold">{{ $stats['total'] }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-slate-800 rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="rounded-full bg-green-900 p-3 mr-4">
                                <i class="fas fa-money-bill-wave text-green-300 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm">Total Amount Paid</p>
                                <p class="text-white text-xl font-bold">${{ number_format($stats['total_amount'], 2) }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-slate-800 rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="rounded-full bg-purple-900 p-3 mr-4">
                                <i class="fas fa-file-invoice-dollar text-purple-300 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm">Fines Amount</p>
                                <p class="text-white text-xl font-bold">${{ number_format($stats['fines_amount'], 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Content Starts Here -->
                @if($payments->isEmpty())
                    <div class="bg-slate-800 rounded-lg shadow p-6 text-center">
                        <i class="fas fa-receipt text-4xl text-gray-400 mb-4"></i>
                        <h3 class="text-lg font-medium text-white mb-2">No payments found</h3>
                        <p class="text-gray-400">You haven't made any payments yet.</p>
                    </div>
                @else
                    <div class="bg-slate-800 rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-700">
                            <h2 class="text-lg font-semibold text-white">Your Payments ({{ $payments->total() }})</h2>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-700">
                                <thead class="bg-slate-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-yellow-300 uppercase tracking-wider">Type</th>
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
                                                {{ $payment->payment_type === 'fine' ? 'bg-blue-900 text-blue-300' : 'bg-gray-600 text-gray-300' }}">
                                                {{ str_replace('_', ' ', ucfirst($payment->payment_type)) }}
                                            </span>
                                            @if($payment->fine)
                                            <div class="text-xs text-gray-400 mt-1">
                                                Fine #{{ $payment->fine->fine_id }}
                                            </div>
                                            @endif
                                        </td>
                                        
                                        <!-- Amount Column -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <span class="text-green-400">${{ number_format($payment->amount, 2) }}</span>
                                        </td>
                                        
                                        <!-- Method Column -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ ucfirst($payment->payment_method) }}
                                        </td>
                                        
                                        <!-- Date Column -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'N/A' }}
                                        </td>
                                        
                                        <!-- Status Column -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @switch($payment->status)
                                                @case('completed')
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-900 text-green-300">Completed</span>
                                                    @break
                                                @case('pending')
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-900 text-yellow-300">Pending</span>
                                                    @break
                                                @case('failed')
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-900 text-red-300">Failed</span>
                                                    @break
                                                @case('refunded')
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-600 text-gray-300">Refunded</span>
                                                    @break
                                                @default
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-600 text-gray-300">{{ ucfirst($payment->status) }}</span>
                                            @endswitch
                                        </td>
                                        
                                        <!-- Actions Column -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('member.payments.show', $payment->payment_id) }}" class="text-primary-orange hover:text-dark-orange">
                                                <i class="fas fa-eye mr-1"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="px-6 py-4 bg-slate-700 border-t border-slate-600">
                            {{ $payments->links() }}
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
                        <a href="{{ route('member.fines.index')}}" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-money-bill-wave mr-4"></i>
                            Fines
                        </a>
                        <a href="{{ route('member.payments.index')}}" class="flex items-center px-2 py-2 text-base font-medium text-white bg-dark-orange rounded-lg">
                            <i class="fas fa-money-bill-wave mr-4"></i>
                            Payments
                        </a>
                        <a href="{{ route('member.notifications.index')}}" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
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