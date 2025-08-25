@extends('dashboard.admin.index')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-white mb-6">Add New Supplier</h1>

    <div class="bg-slate-800 rounded-lg shadow p-6">
        <form action="{{ route('admin.suppliers.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="supplier_name" class="block text-gray-300 text-sm font-bold mb-2">Supplier Name *</label>
                    <input type="text" name="supplier_name" id="supplier_name"
                           class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           required value="{{ old('supplier_name') }}">
                    @error('supplier_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="contact_person" class="block text-gray-300 text-sm font-bold mb-2">Contact Person *</label>
                    <input type="text" name="contact_person" id="contact_person"
                           class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           required value="{{ old('contact_person') }}">
                    @error('contact_person')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-gray-300 text-sm font-bold mb-2">Phone *</label>
                    <input type="text" name="phone" id="phone" pattern="[0-9]+"
                           class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           required value="{{ old('phone') }}">
                    <p class="text-xs text-gray-400 mt-1">Numbers only, no spaces or special characters</p>
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-300 text-sm font-bold mb-2">Email *</label>
                    <input type="email" name="email" id="email"
                           class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           required value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4 md:col-span-2">
                    <label for="address" class="block text-gray-300 text-sm font-bold mb-2">Address</label>
                    <textarea name="address" id="address" rows="3"
                              class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="discount_rate" class="block text-gray-300 text-sm font-bold mb-2">Discount Rate (%)</label>
                    <input type="number" step="0.01" min="0" max="100" name="discount_rate" id="discount_rate"
                           class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           value="{{ old('discount_rate', '0.00') }}">
                    @error('discount_rate')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('admin.suppliers.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded">
                    Save Supplier
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
