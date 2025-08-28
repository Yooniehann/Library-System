@extends('dashboard.admin.index')

@section('title', 'Issued Books Management')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Issued Books Management</h1>
        </div>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if (session('info'))
            <div class="bg-blue-500 text-white p-4 rounded mb-4">
                {{ session('info') }}
            </div>
        @endif

        <!-- Manual Overdue Update Button -->
        <form action="{{ route('admin.issued-books.update-overdue') }}" method="POST"
            class="mb-6 bg-slate-800 p-4 rounded-lg">
            @csrf
            <div class="flex items-center space-x-4">
                <button type="submit"
                    class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i> Check for Overdue Books
                </button>
                <p class="text-gray-400 text-sm">
                    Manually update book status to overdue if due date has passed.
                    Current system date: {{ \App\Helpers\DateHelper::now()->format('M d, Y h:i A') }}
                </p>
            </div>
        </form>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Issued Card -->
            <div class="bg-slate-800 rounded-lg p-6 shadow">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-sm">Total Issued</p>
                        <h3 class="text-2xl font-bold text-white">{{ $stats['total_issued'] }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-book-open text-blue-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Active Card -->
            <div class="bg-slate-800 rounded-lg p-6 shadow">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-sm">Active</p>
                        <h3 class="text-2xl font-bold text-green-400">{{ $stats['active'] }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Overdue Card -->
            <div class="bg-slate-800 rounded-lg p-6 shadow">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-sm">Overdue</p>
                        <h3 class="text-2xl font-bold text-red-400">{{ $stats['overdue'] }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-red-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Fines Card -->
            <div class="bg-slate-800 rounded-lg p-6 shadow">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-sm">Total Fines</p>
                        <h3 class="text-2xl font-bold text-yellow-400">${{ number_format($stats['total_fines'], 2) }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-yellow-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-yellow-400 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="bg-slate-800 rounded-lg shadow p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <form method="GET" action="{{ route('admin.issued-books.index') }}">
                        <div class="relative flex">
                            <input type="text"
                                class="bg-slate-700 text-white border border-gray-600 rounded-l-lg w-full py-2 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                                placeholder="Search by ID, user, book, author..." name="search"
                                value="{{ $searchTerm }}">
                            <button type="submit"
                                class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded-r-lg">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Status Filter -->
                <div class="grid grid-cols-2 gap-4">
                    <form method="GET" action="{{ route('admin.issued-books.index') }}">
                        <select
                            class="bg-slate-700 text-white border border-gray-600 rounded-lg w-full py-2 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            name="status" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="active" {{ $statusFilter == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="overdue" {{ $statusFilter == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                    </form>

                    <a href="{{ route('admin.issued-books.index') }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg text-center">
                        <i class="fas fa-sync mr-2"></i> Reset
                    </a>
                </div>
            </div>
        </div>

        <!-- Books Table -->
        <div class="bg-slate-800 rounded-lg shadow overflow-hidden">
            @if ($borrows->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-slate-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Borrow ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Book</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Author</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Borrow Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Due Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Renewals</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-slate-800 divide-y divide-gray-700">
                            @foreach ($borrows as $borrow)
                                @php
                                    $currentDate = \App\Helpers\DateHelper::now();
                                    $isOverdueByDate = $borrow->due_date < $currentDate;
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">#{{ $borrow->borrow_id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-blue-500/20 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-blue-400 text-sm font-medium">
                                                    {{ substr($borrow->user->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-white">{{ $borrow->user->name }}</div>
                                                <div class="text-sm text-gray-400">{{ $borrow->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                        {{ Str::limit($borrow->inventory->book->title, 30) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                        {{ $borrow->inventory->book->author->fullname }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                        {{ $borrow->borrow_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="{{ $isOverdueByDate ? 'text-red-400' : 'text-green-400' }}">
                                            {{ $borrow->due_date->format('M d, Y') }}
                                            @if ($isOverdueByDate && $borrow->status != 'overdue')
                                                <span class="text-xs text-yellow-400 ml-1">(Overdue by date)</span>
                                            @endif
                                        </span>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($borrow->status == 'active')
                                            <span
                                                class="px-2 py-1 text-xs font-semibold bg-green-500/20 text-green-400 rounded-full">Active</span>
                                        @elseif($borrow->status == 'overdue')
                                            <span
                                                class="px-2 py-1 text-xs font-semibold bg-red-500/20 text-red-400 rounded-full">Overdue</span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-semibold bg-gray-500/20 text-gray-400 rounded-full">{{ ucfirst($borrow->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                        {{ $borrow->renewal_count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.issued-books.show', $borrow->borrow_id) }}"
                                                class="text-blue-400 hover:text-blue-500" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if ($borrow->status == 'active')
                                                <form action="{{ route('admin.issued-books.renew', $borrow->borrow_id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-green-400 hover:text-green-500"
                                                        title="Renew Book">
                                                        <i class="fas fa-redo"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if ($borrow->status != 'overdue' && $isOverdueByDate)
                                                <form
                                                    action="{{ route('admin.issued-books.overdue', $borrow->borrow_id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-yellow-400 hover:text-yellow-500"
                                                        title="Mark Overdue">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center">
                    <i class="fas fa-book-open fa-3x text-gray-600 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-400 mb-2">No issued books found</h3>
                    <p class="text-gray-500">
                        @if ($searchTerm || $statusFilter)
                            Try adjusting your search or filter criteria.
                        @else
                            There are currently no active issued books.
                        @endif
                    </p>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if ($borrows->hasPages())
            <div class="mt-6">
                {{ $borrows->appends(['search' => $searchTerm, 'status' => $statusFilter])->links() }}
            </div>
        @endif
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

@endsection

@section('scripts')
    <script>
        // Auto-refresh stats every 60 seconds
        setInterval(function() {
            fetch('{{ route('admin.issued-books.stats') }}')
                .then(response => response.json())
                .then(data => {
                    // Update stats cards
                    document.querySelector('[data-stat="total_issued"]').textContent = data.total_issued;
                    document.querySelector('[data-stat="active"]').textContent = data.active;
                    document.querySelector('[data-stat="overdue"]').textContent = data.overdue;
                    document.querySelector('[data-stat="total_fines"]').textContent = '$' + data.total_fines
                        .toFixed(2);
                });
        }, 60000);
    </script>
@endsection
