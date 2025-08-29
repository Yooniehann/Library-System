@extends('dashboard.admin.index')

@section('title', 'Issued Book Details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Issued Book Details</h1>
        <a href="{{ route('admin.issued-books.index') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i> Back to List
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Add this near the top of the file, after the success/error messages -->
    @if($hasUnpaidFines)
    <div class="bg-red-500 text-white p-4 rounded mb-6">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle mr-3"></i>
            <div>
                <strong>Unpaid Fines!</strong> This book has unpaid fines. Please process payment before returning.
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Book and Borrowing Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Book Information Card -->
            <div class="bg-slate-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">Book Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="md:col-span-1">
                        <img src="{{ $borrow->inventory->book->cover_image ? asset('storage/' . $borrow->inventory->book->cover_image) : asset('images/default-book-cover.jpg') }}"
                             alt="Book Cover"
                             class="w-full h-48 object-cover rounded-lg shadow-md">
                    </div>
                    <div class="md:col-span-3">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-gray-400 text-sm">Title</label>
                                <p class="text-white font-medium">{{ $borrow->inventory->book->title }}</p>
                            </div>
                            <div>
                                <label class="text-gray-400 text-sm">Author</label>
                                <p class="text-white">{{ $borrow->inventory->book->author->fullname }}</p>
                            </div>
                            <div>
                                <label class="text-gray-400 text-sm">ISBN</label>
                                <p class="text-white">{{ $borrow->inventory->book->isbn }}</p>
                            </div>
                            <div>
                                <label class="text-gray-400 text-sm">Category</label>
                                <p class="text-white">{{ $borrow->inventory->book->category->category_name }}</p>
                            </div>
                            <div>
                                <label class="text-gray-400 text-sm">Publisher</label>
                                <p class="text-white">{{ $borrow->inventory->book->publisher->publisher_name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Borrowing Details Card -->
            <div class="bg-slate-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">Borrowing Details</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="text-gray-400 text-sm">Borrow ID</label>
                            <p class="text-white font-mono">#{{ $borrow->borrow_id }}</p>
                        </div>
                        <div>
                            <label class="text-gray-400 text-sm">Borrow Date</label>
                            <p class="text-white">{{ $borrow->borrow_date->format('M d, Y h:i A') }}</p>
                        </div>
                        <div>
                            <label class="text-gray-400 text-sm">Due Date</label>
                            <p class="{{ $borrow->due_date->isPast() ? 'text-red-400' : 'text-green-400' }} font-medium">
                                {{ $borrow->due_date->format('M d, Y h:i A') }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-gray-400 text-sm">Status</label>
                            <p>
                                @if($borrow->status == 'active')
                                    <span class="px-3 py-1 text-sm font-semibold bg-green-500/20 text-green-400 rounded-full">Active</span>
                                @elseif($borrow->status == 'overdue')
                                    <span class="px-3 py-1 text-sm font-semibold bg-red-500/20 text-red-400 rounded-full">Overdue</span>
                                @else
                                    <span class="px-3 py-1 text-sm font-semibold bg-gray-500/20 text-gray-400 rounded-full">{{ ucfirst($borrow->status) }}</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="text-gray-400 text-sm">Renewals</label>
                            <p class="text-white">{{ $borrow->renewal_count }} / 3</p>
                        </div>
                        <div>
                            <label class="text-gray-400 text-sm">Issued By</label>
                            <p class="text-white">{{ $borrow->staff->name ?? 'System' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Overdue Information -->
                @if($overdueDays > 0)
                <div class="mt-6 p-4 bg-red-500/10 border border-red-500/30 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-400 text-xl mr-3"></i>
                        <div>
                            <h4 class="text-red-400 font-semibold">Overdue Notice</h4>
                            <p class="text-red-300">
                                This book is {{ $overdueDays }} day{{ $overdueDays > 1 ? 's' : '' }} overdue.
                                Fine amount: <span class="font-bold">${{ number_format($fineAmount, 2) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Column - User Info and Actions -->
        <div class="space-y-6">
            <!-- User Information Card -->
            <div class="bg-slate-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">User Information</h2>

                <div class="text-center mb-4">
                    <div class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-blue-400 text-xl font-bold">
                            {{ substr($borrow->user->name, 0, 1) }}
                        </span>
                    </div>
                    <h3 class="text-white font-semibold">{{ $borrow->user->name }}</h3>
                    <p class="text-gray-400">{{ $borrow->user->email }}</p>

                    <div class="mt-2">
                        <span class="px-3 py-1 text-xs font-semibold
                            {{ $borrow->user->role == 'Member' ? 'bg-green-500/20 text-green-400' :
                               ($borrow->user->role == 'Kid' ? 'bg-blue-500/20 text-blue-400' : 'bg-purple-500/20 text-purple-400') }}
                            rounded-full">
                            {{ $borrow->user->role }}
                        </span>
                    </div>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="text-gray-400 text-sm">Phone</label>
                        <p class="text-white">{{ $borrow->user->phone ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Address</label>
                        <p class="text-white">{{ $borrow->user->address ?? 'Not provided' }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="bg-slate-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">Quick Actions</h2>

                @if($borrow->status != 'returned')
                <div class="space-y-3">
                    <!-- Return Book Button - Fixed -->
                    <button type="button"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors {{ $hasUnpaidFines ? 'opacity-50 cursor-not-allowed' : '' }}"
                            onclick="{{ $hasUnpaidFines ? '' : 'openReturnModal()' }}"
                            {{ $hasUnpaidFines ? 'disabled' : '' }}>
                        <i class="fas fa-undo mr-2"></i>
                        {{ $hasUnpaidFines ? 'Pay Fines First' : 'Mark as Returned' }}
                    </button>

                    @if($borrow->status == 'active' && $borrow->renewal_count < 3)
                    <form action="{{ route('admin.issued-books.renew', $borrow->borrow_id) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-redo mr-2"></i> Renew Book
                        </button>
                    </form>
                    @endif

                    @if($borrow->status != 'overdue' && $borrow->due_date->isPast())
                    <form action="{{ route('admin.issued-books.overdue', $borrow->borrow_id) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-exclamation-triangle mr-2"></i> Mark as Overdue
                        </button>
                    </form>
                    @endif
                </div>
                @else
                <div class="bg-blue-500/10 border border-blue-500/30 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-400 mr-3"></i>
                        <p class="text-blue-300">This book has already been returned.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Return Modal -->
<div id="returnModal" class="fixed inset-0 bg-black bg-opacity-50 items-center flex justify-center z-50 hidden">
    <div class="bg-slate-800 border border-gray-700 rounded-lg w-11/12 md:w-1/2 p-6">
        <div class="border-b border-gray-700 pb-4 mb-4">
            <h3 class="text-xl font-semibold text-white">Mark Book as Returned</h3>
        </div>
        <form action="{{ route('admin.issued-books.return', $borrow->borrow_id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="condition" class="block text-gray-400 text-sm mb-2">Book Condition</label>
                <select class="bg-slate-700 text-white border border-gray-600 rounded-lg w-full py-2 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        id="condition"
                        name="condition"
                        required>
                    <option value="excellent">Excellent - Like new</option>
                    <option value="good" selected>Good - Minor wear</option>
                    <option value="fair">Fair - Noticeable wear</option>
                    <option value="poor">Poor - Significant damage</option>
                    <option value="damaged">Damaged - Requires repair</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="notes" class="block text-gray-400 text-sm mb-2">Notes (Optional)</label>
                <textarea class="bg-slate-700 text-white border border-gray-600 rounded-lg w-full py-2 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                          id="notes"
                          name="notes"
                          rows="3"
                          placeholder="Any additional notes about the return..."></textarea>
            </div>
            @if($overdueDays > 0)
            <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-4 mb-4">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-400 mr-3"></i>
                    <div>
                        <p class="text-red-300">
                            This book is overdue by {{ $overdueDays }} days.
                            Fine amount: <span class="font-bold">${{ number_format($fineAmount, 2) }}</span>
                        </p>
                    </div>
                </div>
            </div>
            @endif
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-700">
                <button type="button"
                        class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition-colors"
                        onclick="closeReturnModal()">
                    Cancel
                </button>
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                    Confirm Return
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openReturnModal() {
        document.getElementById('returnModal').classList.remove('hidden');
    }

    function closeReturnModal() {
        document.getElementById('returnModal').classList.add('hidden');
    }

    // Close modal when clicking outside of it
    document.getElementById('returnModal').addEventListener('click', function(e) {
        if (e.target.id === 'returnModal') {
            closeReturnModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeReturnModal();
        }
    });
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@endsection
