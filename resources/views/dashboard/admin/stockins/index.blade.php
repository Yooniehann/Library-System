@extends('dashboard.admin.index')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Manage Stock Ins</h1>
        <a href="{{ route('admin.stockins.create') }}" 
            class="bg-[#EEBA30] hover:bg-[#D3A625] text-black font-bold py-2 px-4 rounded">
                Create New Stock In
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="bg-slate-800 rounded-lg shadow p-4 mb-6">
        <h2 class="text-lg font-semibold text-white mb-4">Search & Filter</h2>
        <form method="GET" action="{{ route('admin.stockins.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Supplier Name</label>
                    <input type="text" name="supplier" placeholder="Search by supplier" 
                        class="w-full px-4 py-2 bg-slate-700 border border-gray-600 rounded-md text-white search-input"
                        value="{{ request('supplier') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Staff Name</label>
                    <input type="text" name="staff" placeholder="Search by staff" 
                        class="w-full px-4 py-2 bg-slate-700 border border-gray-600 rounded-md text-white search-input"
                        value="{{ request('staff') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">From Date</label>
                    <input type="date" name="from_date"
                        class="w-full px-4 py-2 bg-slate-700 border border-gray-600 rounded-md text-white search-input"
                        value="{{ request('from_date') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">To Date</label>
                    <input type="date" name="to_date"
                        class="w-full px-4 py-2 bg-slate-700 border border-gray-600 rounded-md text-white search-input"
                        value="{{ request('to_date') }}">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-1">Status</label>
                    <select name="status" class="w-full px-4 py-2 bg-slate-700 border border-gray-600 rounded-md text-white status-select">
                        <option value="">All Statuses</option>
                        <option value="Received" {{ request('status') == 'Received' ? 'selected' : '' }}>Received</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Canceled" {{ request('status') == 'Canceled' ? 'selected' : '' }}>Canceled</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <a href="{{ route('admin.stockins.index') }}" class="bg-gray-600 hover:bg-gray-500 text-white font-medium py-2 px-4 rounded mr-2 transition duration-300">
                    <i class="fas fa-times mr-2"></i>Reset
                </a>
                <button type="submit" class="bg-[#EEBA30] hover:bg-[#D3A625] text-black font-medium py-2 px-4 rounded transition duration-300">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
            </div>
        </form>
    </div>

    <div class="bg-slate-800 rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-slate-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Supplier</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Staff</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total Books</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-slate-800 divide-y divide-gray-700">
                @foreach($stockins as $stockin)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $stockin->stockin_id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">{{ $stockin->supplier->supplier_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $stockin->staff->fullname }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $stockin->stockin_date->format('M d, Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $stockin->total_books }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="px-2 py-1 text-xs rounded-full text-white"
                            @class([
                                'bg-green-500' => $stockin->status === 'Received',
                                'bg-red-500' => $stockin->status === 'Canceled',
                                'bg-yellow-500 text-black' => $stockin->status !== 'Received' && $stockin->status !== 'Canceled',
                            ])>
                            {{ $stockin->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.stockins.show', $stockin) }}" class="text-blue-400 hover:text-blue-500 transition duration-300" title="View">
                                <i class="fas fa-eye fa-lg"></i>
                            </a>
                            <a href="{{ route('admin.stockins.edit', $stockin) }}" class="text-yellow-400 hover:text-yellow-500 transition duration-300" title="Edit">
                                <i class="fas fa-edit fa-lg"></i>
                            </a>
                            <form action="{{ route('admin.stockins.destroy', $stockin) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this stockin?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition duration-300" title="Delete">
                                    <i class="fas fa-trash-alt fa-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $stockins->appends(request()->except('page'))->links() }}
    </div>
</div>

<style>
    .search-input:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(238, 186, 48, 0.3);
    }
    .status-select:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(238, 186, 48, 0.3);
    }
</style>
@endsection