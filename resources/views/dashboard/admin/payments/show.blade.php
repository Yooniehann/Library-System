@extends('dashboard.admin.index')

@section('title', 'Payment Details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Payment Details #{{ $payment->payment_id }}</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.payments.index') }}"
               class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i> Back to Payments
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Payment Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Payment Details Card -->
            <div class="bg-slate-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">Payment Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-gray-400 text-sm">Payment ID</label>
                        <p class="text-white font-mono">#{{ $payment->payment_id }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Type</label>
                        <p class="text-white capitalize">{{ str_replace('_', ' ', $payment->payment_type) }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Amount</label>
                        <p class="text-white font-medium">${{ number_format($payment->amount, 2) }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Method</label>
                        <p class="text-white capitalize">{{ $payment->payment_method }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Status</label>
                        <p>
                            @if($payment->status == 'completed')
                                <span class="px-3 py-1 text-sm font-semibold bg-green-500/20 text-green-400 rounded-full">Completed</span>
                            @elseif($payment->status == 'pending')
                                <span class="px-3 py-1 text-sm font-semibold bg-yellow-500/20 text-yellow-400 rounded-full">Pending</span>
                            @elseif($payment->status == 'failed')
                                <span class="px-3 py-1 text-sm font-semibold bg-red-500/20 text-red-400 rounded-full">Failed</span>
                            @else
                                <span class="px-3 py-1 text-sm font-semibold bg-gray-500/20 text-gray-400 rounded-full">Refunded</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Date</label>
                        <p class="text-white">{{ $payment->payment_date->format('M d, Y') }}</p>
                    </div>
                    @if($payment->transaction_id)
                    <div>
                        <label class="text-gray-400 text-sm">Transaction ID</label>
                        <p class="text-white">{{ $payment->transaction_id }}</p>
                    </div>
                    @endif
                    @if($payment->fine)
                    <div>
                        <label class="text-gray-400 text-sm">Fine ID</label>
                        <p class="text-white">#{{ $payment->fine->fine_id }}</p>
                    </div>
                    @endif
                    @if($payment->membershipType)
                    <div>
                        <label class="text-gray-400 text-sm">Membership Type</label>
                        <p class="text-white">{{ $payment->membershipType->name }}</p>
                    </div>
                    @endif
                    @if($payment->notes)
                    <div class="md:col-span-2">
                        <label class="text-gray-400 text-sm">Notes</label>
                        <p class="text-white">{{ $payment->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Fine Information Card (if applicable) -->
            @if($payment->fine)
            <div class="bg-slate-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">Fine Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-gray-400 text-sm">Fine ID</label>
                        <p class="text-white font-mono">#{{ $payment->fine->fine_id }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Type</label>
                        <p class="text-white capitalize">{{ $payment->fine->fine_type }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Amount</label>
                        <p class="text-white font-medium">${{ number_format($payment->fine->amount_per_day, 2) }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Status</label>
                        <p>
                            @if($payment->fine->status == 'unpaid')
                                <span class="px-3 py-1 text-sm font-semibold bg-red-500/20 text-red-400 rounded-full">Unpaid</span>
                            @elseif($payment->fine->status == 'paid')
                                <span class="px-3 py-1 text-sm font-semibold bg-green-500/20 text-green-400 rounded-full">Paid</span>
                            @else
                                <span class="px-3 py-1 text-sm font-semibold bg-gray-500/20 text-gray-400 rounded-full">Waived</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Book</label>
                        <p class="text-white">{{ $payment->fine->borrow->inventory->book->title }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Description</label>
                        <p class="text-white">{{ $payment->fine->description }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- User Information and Actions -->
        <div class="space-y-6">
            <!-- User Information Card -->
            <div class="bg-slate-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">User Information</h2>

                <div class="text-center mb-4">
                    <div class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-blue-400 text-xl font-bold">
                            {{ substr($payment->user->name, 0, 1) }}
                        </span>
                    </div>
                    <h3 class="text-white font-semibold">{{ $payment->user->name }}</h3>
                    <p class="text-gray-400">{{ $payment->user->email }}</p>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="text-gray-400 text-sm">Phone</label>
                        <p class="text-white">{{ $payment->user->phone ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Address</label>
                        <p class="text-white">{{ $payment->user->address ?? 'Not provided' }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="bg-slate-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">Actions</h2>

                <div class="space-y-3">
                    @if($payment->status == 'pending')
                    <form action="{{ route('admin.payments.update-status', $payment->payment_id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-check mr-2"></i> Mark as Completed
                        </button>
                    </form>
                    @endif

                    @if($payment->status == 'completed')
                    <form action="{{ route('admin.payments.update-status', $payment->payment_id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="refunded">
                        <button type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-colors"
                                onclick="return confirm('Are you sure you want to mark this payment as refunded?')">
                            <i class="fas fa-undo mr-2"></i> Mark as Refunded
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
