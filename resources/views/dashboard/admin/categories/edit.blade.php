@extends('dashboard.admin.index')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-white mb-6">Edit Category</h1>

    <div class="bg-slate-800 rounded-lg shadow p-6">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="category_name" class="block text-gray-300 text-sm font-bold mb-2">Category Name</label>
                <input type="text" name="category_name" id="category_name"
                       class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                       value="{{ old('category_name', $category->category_name) }}" required>
                @error('category_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-300 text-sm font-bold mb-2">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('admin.categories.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded">
                    Update Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
