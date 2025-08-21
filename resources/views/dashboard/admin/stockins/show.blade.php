@extends('dashboard.admin.index')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Stock In Details</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.stockins.details.create', $stockin) }}" 
               class="bg-[#EEBA30] hover:bg-[#d3b35a] text-black font-bold py-2 px-4 rounded">
                Add Book
            </a>
            <a href="{{ route('admin.stockins.edit', $stockin) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Edit Header
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Header Information -->
    <div class="bg-slate-800 rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-bold text-white mb-4">Stock In Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-gray-300 text-sm">Supplier</p>
                <p class="text-white font-medium">{{ $stockin->supplier->supplier_name }}</p>
            </div>
            <div>
                <p class="text-gray-300 text-sm">Staff</p>
                <p class="text-white font-medium">{{ $stockin->staff->fullname }}</p>
            </div>
            <div>
                <p class="text-gray-300 text-sm">Date</p>
                <p class="text-white font-medium">{{ $stockin->stockin_date->format('M d, Y') }}</p>
            </div>
            <div>
                <p class="text-gray-300 text-sm">Total Books</p>
                <p class="text-white font-medium">{{ $stockin->total_books }}</p>
            </div>
            <div>
                <p class="text-gray-300 text-sm">Status</p>
                <span class="px-2 py-1 text-xs rounded-full 
                    @if($stockin->status == 'Received') bg-green-500 text-white
                    @elseif($stockin->status == 'Canceled') bg-red-500 text-white
                    @else bg-yellow-500 text-black @endif">
                    {{ $stockin->status }}
                </span>
            </div>
        </div>
    </div>

    <!-- Books List -->
    <div class="bg-slate-800 rounded-lg shadow overflow-hidden">
        <h2 class="text-xl font-bold text-white p-6 border-b border-gray-700">Books in this Stock In</h2>
        
        @if($stockin->details->count() > 0)
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-slate-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Book</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Price/Unit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Condition</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Remarks</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-slate-800 divide-y divide-gray-700">
                    @foreach($stockin->details as $detail)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                            @if($detail->inventories->isNotEmpty())
                                {{ $detail->inventories->first()->book->title }}
                            @else
                                Unknown Book
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $detail->received_quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">${{ number_format($detail->price_per_unit, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $detail->condition }}</td>
                        <td class="px-6 py-4 text-sm text-gray-300">{{ $detail->remarks ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.stockins.details.edit', ['stockin' => $stockin, 'detail' => $detail]) }}" 
                                   class="text-blue-400 hover:text-blue-500">Edit</a>
                                <form action="{{ route('admin.stockins.details.destroy', ['stockin' => $stockin, 'detail' => $detail]) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this book from stockin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-6 text-center">
                <p class="text-gray-300">No books added to this stock in yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection