@extends('dashboard.admin.index')

@section('title', 'Overdue Books')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Overdue Books</h1>
            <div class="bg-red-500/20 border border-red-500/30 rounded-lg px-4 py-2">
                <p class="text-red-400 font-semibold">Total Fines: ${{ number_format($totalFines, 2) }}</p>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search and Filter Section -->
        <div class="bg-slate-800 rounded-lg shadow p-6 mb-6">
            <form action="{{ route('admin.overdue-books.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search Input -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-300 mb-1">Search</label>
                        <input type="text" name="search" id="search" value="{{ $searchTerm ?? '' }}"
                            placeholder="Search by ID, book, user..."
                            class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Due Date Range Picker -->
                    <div>
                        <label for="due_date_range" class="block text-sm font-medium text-gray-300 mb-1">Due Date
                            Range</label>
                        <input type="text" name="due_date_range" id="due_date_range" value="{{ $dateRange ?? '' }}"
                            placeholder="Select due date range..."
                            class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-end space-x-2">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-search mr-2"></i> Search
                        </button>
                        <a href="{{ route('admin.overdue-books.index') }}"
                            class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-sync mr-2"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Count -->
        @if (isset($searchTerm) || isset($dateRange))
            <div class="mb-4 text-sm text-gray-300">
                Showing {{ $overdueBooks->total() }} result(s)
                @if (isset($searchTerm))
                    for "{{ $searchTerm }}"
                @endif
                @if (isset($dateRange))
                    with due date between {{ $dateRange }}
                @endif
            </div>
        @endif

        <div class="bg-slate-800 rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-slate-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Borrow ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Book
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">User
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Borrow Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Due
                                Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Days
                                Overdue</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Fine
                                Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-slate-800 divide-y divide-gray-700">
                        @forelse($overdueBooks as $borrow)
                            @php
                                $currentDate = \App\Helpers\DateHelper::now();
                                // Calculate whole days overdue
                                $daysOverdue = max(0, $currentDate->diffInDays($borrow->due_date, false) * -1);
                                // For display, use ceil() to round up to nearest whole day
                                $displayDaysOverdue = ceil($daysOverdue);
                                $fineAmount = max(0, $displayDaysOverdue) * 0.5;
                            @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">#{{ $borrow->borrow_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                    {{ $borrow->inventory->book->title }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                    {{ $borrow->user->fullname }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                    {{ $borrow->borrow_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-red-400 font-medium">
                                    {{ $borrow->due_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                    {{ $displayDaysOverdue }} day{{ $displayDaysOverdue != 1 ? 's' : '' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white font-medium">
                                    ${{ number_format($fineAmount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.overdue-books.show', $borrow->borrow_id) }}"
                                        class="text-blue-400 hover:text-blue-300 mr-3">
                                        View Details
                                    </a>
                                    <a href="{{ route('admin.issued-books.show', $borrow->borrow_id) }}"
                                        class="text-green-400 hover:text-green-300">
                                        Manage Borrow
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-400">
                                    No overdue books found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($overdueBooks->hasPages())
                <div class="bg-slate-700 px-6 py-4">
                    {{ $overdueBooks->appends(request()->except('page'))->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Include jQuery and Date Range Picker -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.css" />

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <script>
        $(document).ready(function() {
            // Initialize date range picker
            $('#due_date_range').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'MM/DD/YYYY'
                }
            });

            // Update the input when dates are selected
            $('#due_date_range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                    'MM/DD/YYYY'));
            });

            // Clear the input when cleared
            $('#due_date_range').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
@endsection
