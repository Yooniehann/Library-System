@extends('dashboard.admin.index')

@section('title', 'Returned Book Details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Returned Book Details</h1>
        <a href="{{ route('admin.returned-books.index') }}"
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
                            <p class="text-white">{{ $borrow->due_date->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-gray-400 text-sm">Status</label>
                            <p>
                                <span class="px-3 py-1 text-sm font-semibold bg-blue-500/20 text-blue-400 rounded-full">Returned</span>
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
            </div>

            <!-- Return Details Card -->
            <div class="bg-slate-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">Return Details</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="text-gray-400 text-sm">Return Date</label>
                            <p class="text-white">{{ $borrow->bookReturn->return_date->format('M d, Y h:i A') }}</p>
                        </div>
                        <div>
                            <label class="text-gray-400 text-sm">Condition on Return</label>
                            @php
                                $condition = $borrow->bookReturn->condition_on_return;
                                $color = match($condition) {
                                    'excellent' => 'text-green-400',
                                    'good' => 'text-blue-400',
                                    'fair' => 'text-yellow-400',
                                    'poor' => 'text-orange-400',
                                    'damaged' => 'text-red-400',
                                    default => 'text-gray-400'
                                };
                            @endphp
                            <p class="{{ $color }} capitalize">{{ $condition }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-gray-400 text-sm">Late Days</label>
                            <p class="text-white">{{ $borrow->bookReturn->late_days }} days</p>
                        </div>
                        <div>
                            <label class="text-gray-400 text-sm">Fine Amount</label>
                            <p class="text-white">${{ number_format($borrow->bookReturn->fine_amount, 2) }}</p>
                        </div>
                        <div>
                            <label class="text-gray-400 text-sm">Processed By</label>
                            <p class="text-white">{{ $borrow->bookReturn->staff->name ?? 'System' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - User Info -->
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
        </div>
    </div>
</div>

<!-- Make sure you have Font Awesome included for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@endsection
