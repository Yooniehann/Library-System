@extends('dashboard.admin.index')

@section('title', 'Returned Books')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Returned Books</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="bg-slate-800 rounded-lg shadow p-6 mb-6">
        <form action="{{ route('admin.returned-books.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-300 mb-1">Search</label>
                    <input type="text"
                           name="search"
                           id="search"
                           value="{{ $searchTerm ?? '' }}"
                           placeholder="Search by ID, book, user..."
                           class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Date Range Picker -->
                <div>
                    <label for="date_range" class="block text-sm font-medium text-gray-300 mb-1">Return Date Range</label>
                    <input type="text"
                           name="date_range"
                           id="date_range"
                           value="{{ $dateRange ?? '' }}"
                           placeholder="Select date range..."
                           class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Condition Filter -->
                <div>
                    <label for="condition" class="block text-sm font-medium text-gray-300 mb-1">Condition</label>
                    <select name="condition"
                            id="condition"
                            class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Conditions</option>
                        <option value="excellent" {{ (isset($conditionFilter) && $conditionFilter == 'excellent') ? 'selected' : '' }}>Excellent</option>
                        <option value="good" {{ (isset($conditionFilter) && $conditionFilter == 'good') ? 'selected' : '' }}>Good</option>
                        <option value="fair" {{ (isset($conditionFilter) && $conditionFilter == 'fair') ? 'selected' : '' }}>Fair</option>
                        <option value="poor" {{ (isset($conditionFilter) && $conditionFilter == 'poor') ? 'selected' : '' }}>Poor</option>
                        <option value="damaged" {{ (isset($conditionFilter) && $conditionFilter == 'damaged') ? 'selected' : '' }}>Damaged</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-end space-x-2">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-search mr-2"></i> Search
                    </button>
                    <a href="{{ route('admin.returned-books.index') }}"
                       class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-sync mr-2"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Results Count -->
    @if(isset($searchTerm) || isset($dateRange) || isset($conditionFilter))
    <div class="mb-4 text-sm text-gray-300">
        Showing {{ $returnedBooks->total() }} result(s)
        @if(isset($searchTerm))
            for "{{ $searchTerm }}"
        @endif
        @if(isset($dateRange))
            between {{ $dateRange }}
        @endif
        @if(isset($conditionFilter))
            with condition: {{ $conditionFilter }}
        @endif
    </div>
    @endif

    <div class="bg-slate-800 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-slate-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Borrow ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Book</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Borrow Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Return Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Condition</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Fine</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-slate-800 divide-y divide-gray-700">
                    @forelse($returnedBooks as $borrow)
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
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                            {{ $borrow->bookReturn->return_date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
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
                            <span class="{{ $color }} capitalize">{{ $condition }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                            ${{ number_format($borrow->bookReturn->fine_amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.returned-books.show', $borrow->borrow_id) }}"
                               class="text-blue-400 hover:text-blue-300 mr-3">
                                View Details
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-400">
                            No returned books found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($returnedBooks->hasPages())
        <div class="bg-slate-700 px-6 py-4">
            {{ $returnedBooks->appends(request()->except('page'))->links() }}
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
        $('#date_range').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
                format: 'MM/DD/YYYY'
            }
        });

        // Update the input when dates are selected
        $('#date_range').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        // Clear the input when cleared
        $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
</script>
@endsection
