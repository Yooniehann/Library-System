@extends('dashboard.admin.index')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Manage Suppliers</h1>
            <a href="{{ route('admin.suppliers.create') }}"
                class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded">
                Add New Supplier
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search Bar -->
        <div class="mb-6">
            <form action="{{ route('admin.suppliers.index') }}" method="GET" class="flex items-center">
                <input type="text" name="search" placeholder="Search by name, contact, phone, or email..." 
                    value="{{ $searchTerm ?? '' }}" 
                    class="bg-slate-700 text-white rounded-l-lg py-2 px-4 w-full md:w-1/2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded-r-lg">
                    <i class="fa-solid fa-magnifying-glass"></i> Search
                </button>
                @if(isset($searchTerm) && $searchTerm != '')
                    <a href="{{ route('admin.suppliers.index') }}" class="ml-2 text-gray-300 hover:text-white">
                        <i class="fa-solid fa-times-circle"></i> Clear
                    </a>
                @endif
            </form>
        </div>

        <div class="bg-slate-800 rounded-lg shadow overflow-hidden">
            @if($suppliers->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-slate-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Phone
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Discount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-slate-800 divide-y divide-gray-700">
                        @foreach ($suppliers as $supplier)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $supplier->supplier_id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                    {{ $supplier->supplier_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-300">{{ $supplier->contact_person ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ $supplier->phone ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ $supplier->email ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ $supplier->discount_rate }}%</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.suppliers.edit', $supplier) }}"
                                            class="text-yellow-400 hover:text-yellow-500"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700"><i
                                                    class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div class="p-6 text-center text-gray-300">
                    @if(isset($searchTerm) && $searchTerm != '')
                        No suppliers found matching your search criteria.
                    @else
                        No suppliers found. <a href="{{ route('admin.suppliers.create') }}" class="text-yellow-400 hover:underline">Add your first supplier</a>.
                    @endif
                </div>
            @endif
        </div>

        <div class="mt-4">
            {{ $suppliers->appends(request()->input())->links() }}
        </div>
    </div>
@endsection