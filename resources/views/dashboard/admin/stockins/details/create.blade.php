@extends('dashboard.admin.index')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-white mb-6">Add Book to Stock In #{{ $stockin->stockin_id }}</h1>

    <div class="bg-slate-800 rounded-lg shadow p-6">
        <form action="{{ route('admin.stockins.details.store', $stockin) }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="book_id" class="block text-gray-300 text-sm font-bold mb-2">Book *</label>
                    <select name="book_id" id="book_id" 
                           class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           required>
                        <option value="">Select Book</option>
                        @foreach($books as $book)
                            <option value="{{ $book->book_id }}" {{ old('book_id') == $book->book_id ? 'selected' : '' }}>
                                {{ $book->title }} ({{ $book->isbn }})
                            </option>
                        @endforeach
                    </select>
                    @error('book_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="received_quantity" class="block text-gray-300 text-sm font-bold mb-2">Quantity *</label>
                    <input type="number" name="received_quantity" id="received_quantity" min="1"
                           class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           value="{{ old('received_quantity') }}" required>
                    @error('received_quantity')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="price_per_unit" class="block text-gray-300 text-sm font-bold mb-2">Price per Unit *</label>
                    <input type="number" name="price_per_unit" id="price_per_unit" step="0.01" min="0"
                           class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           value="{{ old('price_per_unit') }}" required>
                    @error('price_per_unit')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="condition" class="block text-gray-300 text-sm font-bold mb-2">Condition *</label>
                    <select name="condition" id="condition" 
                           class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           required>
                        <option value="New" {{ old('condition') == 'New' ? 'selected' : '' }}>New</option>
                        <option value="Good" {{ old('condition') == 'Good' ? 'selected' : '' }}>Good</option>
                        <option value="Fair" {{ old('condition') == 'Fair' ? 'selected' : '' }}>Fair</option>
                        <option value="Damaged" {{ old('condition') == 'Damaged' ? 'selected' : '' }}>Damaged</option>
                    </select>
                    @error('condition')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4 md:col-span-2">
                    <label for="remarks" class="block text-gray-300 text-sm font-bold mb-2">Remarks</label>
                    <textarea name="remarks" id="remarks" rows="3"
                              class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ old('remarks') }}</textarea>
                    @error('remarks')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('admin.stockins.show', $stockin) }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-[#EEBA30] hover:bg-[#D3A625] text-black font-bold py-2 px-4 rounded">
                    Add Book
                </button>
            </div>
        </form>
    </div>
</div>
@endsection