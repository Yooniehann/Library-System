<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Payment | Library System</title>
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
                        <a href="{{ route('member.payments.create')}}" class="flex items-center px-4 py-3 text-sm font-medium text-white bg-dark-orange rounded-lg">
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
                        <h1 class="text-2xl font-bold text-white">Make a Payment</h1>
                        <p class="text-gray-400">Pay your outstanding fines</p>
                    </div>
                    <a href="{{ route('member.fines.index') }}" class="bg-slate-700 text-white px-4 py-2 rounded-lg hover:bg-slate-600 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Fines
                    </a>
                </div>

                <div class="max-w-2xl mx-auto">
                    @if($fine)
                    <!-- Payment for specific fine -->
                    <div class="bg-slate-800 rounded-lg shadow p-6 mb-6">
                        <h2 class="text-lg font-semibold text-white mb-4 border-b border-slate-700 pb-2">Paying Fine #{{ $fine->fine_id }}</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-gray-400 text-sm">Book</p>
                                <p class="text-white">{{ $fine->borrow->inventory->book->title }}</p>
                            </div>
                            
                            <div>
                                <p class="text-gray-400 text-sm">Fine Type</p>
                                <p class="text-white">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $fine->fine_type === 'overdue' ? 'bg-yellow-900 text-yellow-300' : 
                                           ($fine->fine_type === 'lost' ? 'bg-red-900 text-red-300' : 'bg-gray-600 text-gray-300') }}">
                                        {{ ucfirst($fine->fine_type) }}
                                    </span>
                                </p>
                            </div>
                            
                            <div>
                                <p class="text-gray-400 text-sm">Total Amount Due</p>
                                <p class="text-red-400 font-bold">${{ number_format($fine->total_amount, 2) }}</p>
                            </div>
                            
                            <div>
                                <p class="text-gray-400 text-sm">Amount Already Paid</p>
                                <p class="text-white">${{ number_format($fine->payment ? $fine->payment->amount : 0, 2) }}</p>
                            </div>
                            
                            <div class="md:col-span-2">
                                <p class="text-gray-400 text-sm">Remaining Balance</p>
                                <p class="text-green-400 font-bold text-xl">${{ number_format($fine->total_amount - ($fine->payment ? $fine->payment->amount : 0), 2) }}</p>
                            </div>
                        </div>
                    </div>
                    @else
                    <!-- Select fine to pay -->
                    <div class="bg-slate-800 rounded-lg shadow p-6 mb-6">
                        <h2 class="text-lg font-semibold text-white mb-4 border-b border-slate-700 pb-2">Select Fine to Pay</h2>
                        
                        <div class="form-group mb-4">
                            <label for="fineSelect" class="block text-gray-400 text-sm mb-2">Choose a fine to pay</label>
                            <select class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-primary-orange" 
                                    id="fineSelect" onchange="location = this.value;">
                                <option value="">-- Select a fine --</option>
                                @foreach($unpaidFines as $unpaidFine)
                                <option value="{{ route('member.payments.create', $unpaidFine->fine_id) }}" 
                                    {{ $fine && $fine->fine_id == $unpaidFine->fine_id ? 'selected' : '' }}>
                                    Fine #{{ $unpaidFine->fine_id }} - {{ $unpaidFine->borrow->inventory->book->title }} - 
                                    ${{ number_format($unpaidFine->total_amount, 2) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        @if($unpaidFines->isEmpty())
                        <div class="bg-slate-700 rounded-lg p-4 text-center">
                            <i class="fas fa-check-circle text-green-400 text-2xl mb-2"></i>
                            <p class="text-gray-300">You don't have any unpaid fines.</p>
                        </div>
                        @endif
                    </div>
                    @endif

                    @if($fine)
                    <div class="bg-slate-800 rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-white mb-4 border-b border-slate-700 pb-2">Payment Details</h2>
                        
                        <form action="{{ route('member.payments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="fine_id" value="{{ $fine->fine_id }}">

                            <div class="mb-4">
                                <label for="amount" class="block text-gray-400 text-sm mb-2">Amount to Pay *</label>
                                <input type="number" 
                                       class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-primary-orange" 
                                       id="amount" 
                                       name="amount" 
                                       value="{{ $fine->total_amount - ($fine->payment ? $fine->payment->amount : 0) }}" 
                                       min="0.01" 
                                       max="{{ $fine->total_amount - ($fine->payment ? $fine->payment->amount : 0) }}" 
                                       step="0.01" 
                                       required>
                                <p class="text-gray-500 text-xs mt-1">
                                    Maximum amount: ${{ number_format($fine->total_amount - ($fine->payment ? $fine->payment->amount : 0), 2) }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <label for="payment_method" class="block text-gray-400 text-sm mb-2">Payment Method *</label>
                                <select class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-primary-orange" 
                                        id="payment_method" 
                                        name="payment_method" 
                                        required>
                                    <option value="">-- Select payment method --</option>
                                    <option value="cash">Cash</option>
                                    <option value="card">Credit/Debit Card</option>
                                    <option value="online">Online Payment</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="notes" class="block text-gray-400 text-sm mb-2">Notes (Optional)</label>
                                <textarea class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-primary-orange" 
                                          id="notes" 
                                          name="notes" 
                                          rows="3" 
                                          placeholder="Any additional notes about this payment..."></textarea>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-3 mt-6">
                                <button type="submit" class="bg-primary-orange text-black px-6 py-3 rounded-lg hover:bg-dark-orange transition-colors font-semibold flex-1">
                                    <i class="fas fa-credit-card mr-2"></i> Process Payment
                                </button>
                                <a href="{{ route('member.fines.index') }}" class="bg-slate-700 text-white px-6 py-3 rounded-lg hover:bg-slate-600 transition-colors text-center">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                    @endif
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
                        <a href="{{ route('member.payments.create')}}" class="flex items-center px-2 py-2 text-base font-medium text-white bg-dark-orange rounded-lg">
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
        
        // Update amount field when payment method changes
        document.getElementById('payment_method').addEventListener('change', function() {
            if (this.value === 'online') {
                // For online payments, set amount to full remaining balance
                const maxAmount = {{ $fine->total_amount - ($fine->payment ? $fine->payment->amount : 0) }};
                document.getElementById('amount').value = maxAmount.toFixed(2);
                document.getElementById('amount').readOnly = true;
            } else {
                document.getElementById('amount').readOnly = false;
            }
        });
    </script>
</body>
</html>