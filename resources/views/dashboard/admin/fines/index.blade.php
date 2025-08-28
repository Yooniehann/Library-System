@extends('dashboard.admin.index')

@section('title', 'Fines Management')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Fines Management</h1>
            <div class="text-sm text-gray-400">Fines are automatically generated for overdue, lost, or damaged books</div>
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
                        <p class="text-gray-400 text-sm">Total Fines</p>
                        <h3 class="text-2xl font-bold text-white">{{ $stats['total'] }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-blue-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800 rounded-lg p-6 shadow">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-sm">Unpaid</p>
                        <h3 class="text-2xl font-bold text-red-400">{{ $stats['unpaid'] }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-red-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-times-circle text-red-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800 rounded-lg p-6 shadow">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-sm">Paid</p>
                        <h3 class="text-2xl font-bold text-green-400">{{ $stats['paid'] }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-400 text-xl"></i>
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
                        <p class="text-gray-400 text-sm">Unpaid Amount</p>
                        <h3 class="text-2xl font-bold text-orange-400">${{ number_format($stats['unpaid_amount'], 2) }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-orange-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-orange-400 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="bg-slate-800 rounded-lg shadow p-6 mb-6">
            <form action="{{ route('admin.fines.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by ID, user, book..."
                            class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4">
                    </div>

                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Status</label>
                        <select name="status"
                            class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4">
                            <option value="">All Status</option>
                            <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="waived" {{ request('status') == 'waived' ? 'selected' : '' }}>Waived</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Type</label>
                        <select name="type"
                            class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4">
                            <option value="">All Types</option>
                            <option value="overdue" {{ request('type') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                            <option value="lost" {{ request('type') == 'lost' ? 'selected' : '' }}>Lost</option>
                            <option value="damage" {{ request('type') == 'damage' ? 'selected' : '' }}>Damage</option>
                        </select>
                    </div>

                    <div class="flex items-end space-x-2">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
                            <i class="fas fa-filter mr-2"></i> Filter
                        </button>
                        <a href="{{ route('admin.fines.index') }}"
                            class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg">
                            <i class="fas fa-sync mr-2"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Fines Table -->
        <div class="bg-slate-800 rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-slate-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Fine
                                ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">User
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Book
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Type
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Daily Rate</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Total Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-slate-800 divide-y divide-gray-700">
                        @forelse($fines as $fine)
                            @php
                                $totalAmount = 0;
                                if ($fine->fine_type === 'overdue') {
                                    $currentDate = \App\Helpers\DateHelper::now();
                                    $dueDate = $fine->borrow->due_date;
                                    // Calculate whole days overdue
                                    $daysOverdue = max(0, ceil(($currentDate->diffInHours($dueDate, false) / 24) * -1));
                                    $totalAmount = $daysOverdue * $fine->amount_per_day;
                                } else {
                                    $totalAmount = $fine->amount_per_day;
                                }
                            @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">#{{ $fine->fine_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-8 h-8 bg-blue-500/20 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-blue-400 text-sm font-medium">
                                                {{ substr($fine->borrow->user->name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-white">{{ $fine->borrow->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-400">{{ $fine->borrow->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                    {{ $fine->borrow->inventory->book->title }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    <span class="capitalize">{{ $fine->fine_type }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white font-medium">
                                    ${{ number_format($fine->amount_per_day, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white font-medium">
                                    ${{ number_format($totalAmount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ $fine->fine_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($fine->status == 'unpaid')
                                        <span
                                            class="px-2 py-1 text-xs font-semibold bg-red-500/20 text-red-400 rounded-full">Unpaid</span>
                                    @elseif($fine->status == 'paid')
                                        <span
                                            class="px-2 py-1 text-xs font-semibold bg-green-500/20 text-green-400 rounded-full">Paid</span>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs font-semibold bg-gray-500/20 text-gray-400 rounded-full">Waived</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.fines.show', $fine->fine_id) }}"
                                            class="text-blue-400 hover:text-blue-500" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if ($fine->status == 'unpaid')
                                            <a href="{{ route('admin.payments.show-process-fine', $fine->fine_id) }}"
                                                class="text-green-400 hover:text-green-500" title="Process Payment">
                                                <i class="fas fa-credit-card"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-400">
                                    No fines found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if ($fines->hasPages())
            <div class="mt-6">
                {{ $fines->appends(request()->except('page'))->links() }}
            </div>
        @endif
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
