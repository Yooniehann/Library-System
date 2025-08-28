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
                        <a href="{{ route('member.payments.create') }}" class="flex items-center px-4 py-3 text-sm font-medium text-white bg-dark-orange rounded-lg">
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
                            <h1 class="text-2xl font-bold text-white">Make Payment</h1>
                            <p class="text-gray-400">Pay your fines or membership fees</p>
                        </div>
                        <a href="{{ route('member.payments.index') }}" class="bg-slate-700 text-white px-4 py-2 rounded-lg hover:bg-slate-600 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Payments
                        </a>
                    </div>
                </div>

                @if(session('error'))
                    <div class="bg-red-900 border border-red-700 text-red-300 px-4 py-3 rounded-lg mb-6">
                        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Payment Form -->
                    <div class="lg:col-span-2">
                        <div class="bg-slate-800 rounded-lg shadow p-6">
                            <h2 class="text-lg font-semibold text-white mb-4">Payment Details</h2>
                            
                            <form method="POST" action="{{ route('member.payments.store') }}">
                                @csrf

                                <div class="mb-4">
                                    <label for="payment_type" class="block text-sm font-medium text-gray-400 mb-2">Payment Type</label>
                                    <select class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-primary-orange" 
                                            id="payment_type" name="payment_type" required>
                                        <option value="">Select Payment Type</option>
                                        <option value="fine" {{ old('payment_type') === 'fine' ? 'selected' : '' }}>Fine Payment</option>
                                        <option value="membership_fee" {{ old('payment_type') === 'membership_fee' ? 'selected' : '' }}>Membership Fee</option>
                                    </select>
                                    @error('payment_type')
                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div id="fine-section" class="mb-4" style="display: none;">
                                    <label for="fine_id" class="block text-sm font-medium text-gray-400 mb-2">Select Fine</label>
                                    <select class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-primary-orange" 
                                            id="fine_id" name="fine_id">
                                        <option value="">Select Fine to Pay</option>
                                        @foreach($unpaidFines as $unpaidFine)
                                            <option value="{{ $unpaidFine->fine_id }}" 
                                                {{ (old('fine_id') == $unpaidFine->fine_id || ($fine && $fine->fine_id == $unpaidFine->fine_id)) ? 'selected' : '' }}
                                                data-amount="{{ $unpaidFine->amount_per_day }}">
                                                {{ $unpaidFine->borrow->book->title }} - RM {{ number_format($unpaidFine->amount_per_day, 2) }} ({{ ucfirst($unpaidFine->fine_type) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('fine_id')
                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div id="membership-section" class="mb-4" style="display: none;">
                                    <label for="membership_type_id" class="block text-sm font-medium text-gray-400 mb-2">Select Membership</label>
                                    <select class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-primary-orange" 
                                            id="membership_type_id" name="membership_type_id">
                                        <option value="">Select Membership Type</option>
                                        @foreach($membershipTypes as $membershipType)
                                            <option value="{{ $membershipType->membership_type_id }}" 
                                                {{ old('membership_type_id') == $membershipType->membership_type_id ? 'selected' : '' }}
                                                data-amount="{{ $membershipType->price }}">
                                                {{ $membershipType->name }} - RM {{ number_format($membershipType->price, 2) }} ({{ ucfirst($membershipType->duration) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('membership_type_id')
                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="amount" class="block text-sm font-medium text-gray-400 mb-2">Amount (RM)</label>
                                    <input type="number" class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-primary-orange" 
                                           id="amount" name="amount" value="{{ old('amount') }}" step="0.01" min="0.01" required readonly>
                                    @error('amount')
                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="payment_method" class="block text-sm font-medium text-gray-400 mb-2">Payment Method</label>
                                    <select class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-primary-orange" 
                                            id="payment_method" name="payment_method" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>Credit/Debit Card</option>
                                        <option value="online" {{ old('payment_method') === 'online' ? 'selected' : '' }}>Online Payment</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label for="notes" class="block text-sm font-medium text-gray-400 mb-2">Notes (Optional)</label>
                                    <textarea class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-primary-orange" 
                                              id="notes" name="notes" rows="3" placeholder="Any additional notes...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="bg-primary-orange text-black px-8 py-3 rounded-lg hover:bg-dark-orange transition-colors font-semibold">
                                        <i class="fas fa-credit-card mr-2"></i> Process Payment
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Unpaid Fines Summary -->
                    <div>
                        <div class="bg-slate-800 rounded-lg shadow p-6">
                            <h2 class="text-lg font-semibold text-white mb-4">Unpaid Fines Summary</h2>
                            
                            @if($unpaidFines->isEmpty())
                                <div class="text-center text-gray-400 py-8">
                                    <i class="fas fa-check-circle text-4xl mb-3"></i>
                                    <p>No unpaid fines</p>
                                </div>
                            @else
                                <div class="space-y-3">
                                    @foreach($unpaidFines as $unpaidFine)
                                    <div class="bg-slate-700 p-3 rounded-lg">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <div class="text-sm font-medium text-white">{{ $unpaidFine->borrow->book->title }}</div>
                                                <div class="text-xs text-gray-400">{{ ucfirst($unpaidFine->fine_type) }}</div>
                                            </div>
                                            <div class="text-sm font-semibold text-white">RM {{ number_format($unpaidFine->amount_per_day, 2) }}</div>
                                        </div>
                                        <div class="text-xs text-gray-400 mt-2">
                                            Due: {{ $unpaidFine->fine_date->format('M d, Y') }}
                                        </div>
                                        <a href="{{ route('member.payments.create.fine', $unpaidFine->fine_id) }}" 
                                           class="text-xs text-primary-orange hover:text-dark-orange mt-2 inline-block">
                                            <i class="fas fa-credit-card mr-1"></i> Pay this fine
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                                
                                <div class="mt-4 pt-4 border-t border-slate-700">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-400">Total Unpaid:</span>
                                        <span class="text-lg font-semibold text-white">
                                            RM {{ number_format($unpaidFines->sum('amount_per_day'), 2) }}
                                        </span>
                                    </div>
                                </div>
                            @endif
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
                        <a href="{{ route('member.payments.create') }}" class="flex items-center px-2 py-2 text-base font-medium text-white bg-dark-orange rounded-lg">
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

        document.addEventListener('DOMContentLoaded', function() {
            const paymentType = document.getElementById('payment_type');
            const fineSection = document.getElementById('fine-section');
            const membershipSection = document.getElementById('membership-section');
            const fineSelect = document.getElementById('fine_id');
            const membershipSelect = document.getElementById('membership_type_id');
            const amountInput = document.getElementById('amount');

            function updateSections() {
                const selectedType = paymentType.value;
                
                fineSection.style.display = selectedType === 'fine' ? 'block' : 'none';
                membershipSection.style.display = selectedType === 'membership_fee' ? 'block' : 'none';
                
                if (selectedType === 'fine') {
                    fineSelect.required = true;
                    membershipSelect.required = false;
                    updateAmountFromSelect(fineSelect);
                } else if (selectedType === 'membership_fee') {
                    fineSelect.required = false;
                    membershipSelect.required = true;
                    updateAmountFromSelect(membershipSelect);
                } else {
                    fineSelect.required = false;
                    membershipSelect.required = false;
                    amountInput.value = '';
                }
            }

            function updateAmountFromSelect(selectElement) {
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                if (selectedOption && selectedOption.dataset.amount) {
                    amountInput.value = selectedOption.dataset.amount;
                } else {
                    amountInput.value = '';
                }
            }

            paymentType.addEventListener('change', updateSections);
            fineSelect.addEventListener('change', () => updateAmountFromSelect(fineSelect));
            membershipSelect.addEventListener('change', () => updateAmountFromSelect(membershipSelect));

            // Initialize on page load
            updateSections();

            // If coming from a specific fine payment link, set the payment type
            @if($fine)
                paymentType.value = 'fine';
                updateSections();
            @endif
        });
    </script>
</body>
</html>