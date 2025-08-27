@extends('dashboard.admin.index')

@section('title', 'Overdue Book Details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Overdue Book Details</h1>
        <a href="{{ route('admin.overdue-books.index') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i> Back to List
        </a>
    </div>

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
                            <p class="text-red-400 font-medium">
                                {{ $borrow->due_date->format('M d, Y h:i A') }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-gray-400 text-sm">Status</label>
                            <p>
                                <span class="px-3 py-1 text-sm font-semibold bg-red-500/20 text-red-400 rounded-full">Overdue</span>
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
                <div class="mt-6 p-4 bg-red-500/10 border border-red-500/30 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-400 text-xl mr-3"></i>
                        <div>
                            <h4 class="text-red-400 font-semibold">Overdue Notice</h4>
                            <p class="text-red-300">
                                This book is {{ $displayDaysOverdue }} day{{ $displayDaysOverdue != 1 ? 's' : '' }} overdue.
                                Fine amount: <span class="font-bold">${{ number_format($fineAmount, 2) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
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

                <div class="space-y-3">
                    <a href="{{ route('admin.issued-books.show', $borrow->borrow_id) }}"
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors inline-block text-center">
                        <i class="fas fa-cog mr-2"></i> Manage Borrow
                    </a>

                    @if($borrow->renewal_count < 3 && $borrow->status !== 'returned')
                    <form action="{{ route('admin.issued-books.renew', $borrow->borrow_id) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-redo mr-2"></i> Renew Book
                        </button>
                    </form>
                    @endif

                    <button type="button" onclick="openReturnModal()"
                            class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-undo mr-2"></i> Mark as Returned
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Return Book Modal -->
<div id="returnModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-slate-800 rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-semibold text-white mb-4">Return Book</h3>

        <form action="{{ route('admin.issued-books.return', $borrow->borrow_id) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-400 text-sm mb-2">Condition on Return</label>
                <select name="condition" class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="excellent">Excellent</option>
                    <option value="good">Good</option>
                    <option value="fair">Fair</option>
                    <option value="poor">Poor</option>
                    <option value="damaged">Damaged</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-400 text-sm mb-2">Notes (Optional)</label>
                <textarea name="notes" rows="3" class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Any additional notes..."></textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeReturnModal()" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                    Cancel
                </button>
                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg">
                    Confirm Return
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<script>
function openReturnModal() {
    document.getElementById('returnModal').classList.remove('hidden');
}

function closeReturnModal() {
    document.getElementById('returnModal').classList.add('hidden');
}
</script>
@endsection
