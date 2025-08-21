@extends('dashboard.admin.index')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-white mb-6">Edit Stock In #{{ $stockin->stockin_id }}</h1>

    <div class="bg-slate-800 rounded-lg shadow p-6">
        <form action="{{ route('admin.stockins.update', $stockin) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="supplier_id" class="block text-gray-300 text-sm font-bold mb-2">Supplier *</label>
                    <select name="supplier_id" id="supplier_id" 
                           class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           required>
                        <option value="">Select Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->supplier_id }}" {{ old('supplier_id', $stockin->supplier_id) == $supplier->supplier_id ? 'selected' : '' }}>
                                {{ $supplier->supplier_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="staff_id" class="block text-gray-300 text-sm font-bold mb-2">Staff *</label>
                    <select name="staff_id" id="staff_id" 
                        class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        required>
                        <option value="">Select Staff</option>
                        @foreach($staff as $staffMember)
                            <option value="{{ $staffMember->staff_id }}" {{ old('staff_id', $stockin->staff_id) == $staffMember->staff_id ? 'selected' : '' }}>
                                {{ $staffMember->fullname }}
                            </option>
                        @endforeach
                    </select>
                    @error('staff_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="stockin_date" class="block text-gray-300 text-sm font-bold mb-2">Date *</label>
                    <input type="date" name="stockin_date" id="stockin_date" 
                           class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           value="{{ old('stockin_date', $stockin->stockin_date->format('Y-m-d')) }}" required>
                    @error('stockin_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-300 text-sm font-bold mb-2">Status *</label>
                    <select name="status" id="status" 
                           class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           required>
                        <option value="Pending" {{ old('status', $stockin->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Received" {{ old('status', $stockin->status) == 'Received' ? 'selected' : '' }}>Received</option>
                        <option value="Canceled" {{ old('status', $stockin->status) == 'Canceled' ? 'selected' : '' }}>Canceled</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('admin.stockins.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-[#EEBA30] hover:bg-[#D3A625] text-black font-bold py-2 px-4 rounded">
                    Update Stock In
                </button>
            </div>
        </form>
    </div>
</div>
@endsection