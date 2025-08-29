@extends('dashboard.admin.index')

@section('title', 'Fine Details')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Fine Details #{{ $fine->fine_id }}</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.fines.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Fines
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Fine Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Fine Details Card -->
                <div class="bg-slate-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">Fine Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-gray-400 text-sm">Fine ID</label>
                            <p class="text-white font-mono">#{{ $fine->fine_id }}</p>
                        </div>
                        <div>
                            <label class="text-gray-400 text-sm">Type</label>
                            <p class="text-white capitalize">{{ $fine->fine_type }}</p>
                        </div>
                        <div>
                            <label class="text-gray-400 text-sm">Daily Rate</label>
                            <p class="text-white font-medium">${{ number_format($fine->amount_per_day, 2) }}</p>
                        </div>
                        <div>
                            <label class="text-gray-400 text-sm">Total Amount</label>
                            <p class="text-white font-medium">${{ number_format($totalAmount, 2) }}</p>
                        </div>
                        <div>
                            <label class="text-gray-400 text-sm">Status</label>
                            <p>
                                @if ($fine->status == 'unpaid')
                                    <span
                                        class="px-3 py-1 text-sm font-semibold bg-red-500/20 text-red-400 rounded-full">Unpaid</span>
                                @elseif($fine->status == 'paid')
                                    <span
                                        class="px-3 py-1 text-sm font-semibold bg-green-500/20 text-green-400 rounded-full">Paid</span>
                                @else
                                    <span
                                        class="px-3 py-1 text-sm font-semibold bg-gray-500/20 text-gray-400 rounded-full">Waived</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="text-gray-400 text-sm">Date Issued</label>
                            <p class="text-white">{{ $fine->fine_date->format('M d, Y') }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-gray-400 text-sm">Description</label>
                            <p class="text-white">{{ $fine->description ?? 'No description provided' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Borrow Information Card -->
                <div class="bg-slate-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">Borrow Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-gray-400 text-sm">Borrow ID</label>
                            <p class="text-white font-mono">#{{ $fine->borrow->borrow_id }}</p>
                        </div>
                        <div>
                            <label class="text-gray-400 text-sm">Book Title</label>
                            <p class="text-white">{{ $fine->borrow->inventory->book->title }}</p>
                        </div>
                        <div>
                            <label class="text-gray-400 text-sm">Borrow Date</label>
                            <p class="text-white">{{ $fine->borrow->borrow_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <label class="text-gray-400 text-sm">Due Date</label>
                            <p class="text-white">{{ $fine->borrow->due_date->format('M d, Y') }}</p>
                        </div>
                        @if ($fine->fine_type === 'overdue')
                            <div>
                                <label class="text-gray-400 text-sm">Days Overdue</label>
                                <p class="text-white">
                                    @php
                                        $currentDate = \App\Helpers\DateHelper::now();
                                        $dueDate = $fine->borrow->due_date;
                                        // Calculate whole days overdue
                                        $daysOverdue = max(
                                            0,
                                            ceil(($currentDate->diffInHours($dueDate, false) / 24) * -1),
                                        );
                                        echo $daysOverdue == 1 ? '1 day' : "{$daysOverdue} days";
                                    @endphp
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- User Information and Actions -->
            <div class="space-y-6">
                <!-- User Information Card -->
                <div class="bg-slate-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">User Information</h2>

                    <div class="text-center mb-4">
                        <div class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-blue-400 text-xl font-bold">
                                {{ substr($fine->borrow->user->name, 0, 1) }}
                            </span>
                        </div>
                        <h3 class="text-white font-semibold">{{ $fine->borrow->user->name }}</h3>
                        <p class="text-gray-400">{{ $fine->borrow->user->email }}</p>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="text-gray-400 text-sm">Phone</label>
                            <p class="text-white">{{ $fine->borrow->user->phone ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="text-gray-400 text-sm">Address</label>
                            <p class="text-white">{{ $fine->borrow->user->address ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="bg-slate-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">Quick Actions</h2>

                    <div class="space-y-3">
                        @if ($fine->status == 'unpaid')
                            <a href="{{ route('admin.payments.show-process-fine', $fine->fine_id) }}"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors inline-block text-center">
                                <i class="fas fa-credit-card mr-2"></i> Process Payment
                            </a>
                        @endif

                        <a href="{{ route('admin.issued-books.show', $fine->borrow->borrow_id) }}"
                            class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition-colors inline-block text-center">
                            <i class="fas fa-eye mr-2"></i> View Borrow Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
