@extends('dashboard.admin.index')

@section('title', 'Payments Management')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Payments Management</h1>
            <a href="{{ route('admin.payments.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                <i class="fas fa-plus mr-2"></i> New Payment
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
            <div class="bg-slate-800 rounded-lg p-6 shadow">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-sm">Total Payments</p>
                        <h3 class="text-2xl font-bold text-white">{{ $stats['total'] }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-receipt text-blue-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800 rounded-lg p-6 shadow">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-sm">Completed</p>
                        <h3 class="text-2xl font-bold text-green-400">{{ $stats['completed'] }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800 rounded-lg p-6 shadow">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-sm">Pending</p>
                        <h3 class="text-2xl font-bold text-yellow-400">{{ $stats['pending'] }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-yellow-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800 rounded-lg p-6 shadow">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-sm">Total Amount</p>
                        <h3 class="text-2xl font-bold text-yellow-400">${{ number_format($stats['total_amount'], 2) }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-yellow-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-yellow-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800 rounded-lg p-6 shadow">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-sm">Fines Amount</p>
                        <h3 class="text-2xl font-bold text-orange-400">${{ number_format($stats['fines_amount'], 2) }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-orange-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-orange-400 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="bg-slate-800 rounded-lg shadow p-6 mb-6">
            <form action="{{ route('admin.payments.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by ID, transaction, user..."
                            class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4">
                    </div>

                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Status</label>
                        <select name="status"
                            class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4">
                            <option value="">All Status</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Type</label>
                        <select name="type"
                            class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4">
                            <option value="">All Types</option>
                            <option value="fine" {{ request('type') == 'fine' ? 'selected' : '' }}>Fine</option>
                            <option value="membership_fee" {{ request('type') == 'membership_fee' ? 'selected' : '' }}>Membership Fee</option>
                        </select>
                    </div>

                    <div class="flex items-end space-x-2">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
                            <i class="fas fa-filter mr-2"></i> Filter
                        </button>
                        <a href="{{ route('admin.payments.index') }}"
                            class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg">
                            <i class="fas fa-sync mr-2"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Payments Table -->
        <div class="bg-slate-800 rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-slate-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Payment ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Method</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-slate-800 divide-y divide-gray-700">
                        @forelse($payments as $payment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">#{{ $payment->payment_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-500/20 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-blue-400 text-sm font-medium">
                                                {{ substr($payment->user->name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-white">{{ $payment->user->name }}</div>
                                            <div class="text-sm text-gray-400">{{ $payment->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    <span class="capitalize">{{ str_replace('_', ' ', $payment->payment_type) }}</span>
                                    @if($payment->fine)
                                        <div class="text-xs text-gray-400">Fine #{{ $payment->fine->fine_id }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white font-medium">
                                    ${{ number_format($payment->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 capitalize">
                                    {{ $payment->payment_method }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ $payment->payment_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($payment->status == 'completed')
                                        <span class="px-2 py-1 text-xs font-semibold bg-green-500/20 text-green-400 rounded-full">Completed</span>
                                    @elseif($payment->status == 'pending')
                                        <span class="px-2 py-1 text-xs font-semibold bg-yellow-500/20 text-yellow-400 rounded-full">Pending</span>
                                    @elseif($payment->status == 'failed')
                                        <span class="px-2 py-1 text-xs font-semibold bg-red-500/20 text-red-400 rounded-full">Failed</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold bg-gray-500/20 text-gray-400 rounded-full">Refunded</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.payments.show', $payment->payment_id) }}"
                                            class="text-blue-400 hover:text-blue-500" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($payment->status == 'pending')
                                            <form action="{{ route('admin.payments.update-status', $payment->payment_id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="text-green-400 hover:text-green-500" title="Mark as Completed">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-400">
                                    No payments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if ($payments->hasPages())
            <div class="mt-6">
                {{ $payments->appends(request()->except('page'))->links() }}
            </div>
        @endif
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
