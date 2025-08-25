@extends('dashboard.admin.index')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-white mb-6">Add New Book</h1>

    <div class="bg-slate-800 rounded-lg shadow p-6">
        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="title" class="block text-gray-300 text-sm font-bold mb-2">Title *</label>
                    <input type="text" name="title" id="title" 
                           class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           required value="{{ old('title') }}">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="isbn" class="block text-gray-300 text-sm font-bold mb-2">ISBN *</label>
                    <input type="text" name="isbn" id="isbn" 
                           class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           required value="{{ old('isbn') }}">
                    @error('isbn')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="author_id" class="block text-gray-300 text-sm font-bold mb-2">Author *</label>
                    <select name="author_id" id="author_id" 
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
                        <option value="">Select Author</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->author_id }}" {{ old('author_id') == $author->author_id ? 'selected' : '' }}>
                                {{ $author->fullname }}
                            </option>
                        @endforeach
                    </select>
                    @error('author_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="publisher_id" class="block text-gray-300 text-sm font-bold mb-2">Publisher *</label>
                    <select name="publisher_id" id="publisher_id" 
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
                        <option value="">Select Publisher</option>
                        @foreach($publishers as $publisher)
                            <option value="{{ $publisher->publisher_id }}" {{ old('publisher_id') == $publisher->publisher_id ? 'selected' : '' }}>
                                {{ $publisher->publisher_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('publisher_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="category_id" class="block text-gray-300 text-sm font-bold mb-2">Category *</label>
                    <select name="category_id" id="category_id" 
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="publication_year" class="block text-gray-300 text-sm font-bold mb-2">Publication Year *</label>
                    <input type="number" name="publication_year" id="publication_year" 
                           class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           min="1000" max="{{ date('Y') + 1 }}" required value="{{ old('publication_year') }}">
                    @error('publication_year')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="language" class="block text-gray-300 text-sm font-bold mb-2">Language *</label>
                    <input type="text" name="language" id="language" 
                           class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           required value="{{ old('language', 'English') }}">
                    @error('language')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="pages" class="block text-gray-300 text-sm font-bold mb-2">Pages</label>
                    <input type="number" name="pages" id="pages" min="1"
                           class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           value="{{ old('pages') }}">
                    @error('pages')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="pricing" class="block text-gray-300 text-sm font-bold mb-2">Price *</label>
                    <input type="number" step="0.01" name="pricing" id="pricing" min="0"
                           class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           required value="{{ old('pricing') }}">
                    @error('pricing')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4 md:col-span-2">
                    <label for="cover_image" class="block text-gray-300 text-sm font-bold mb-2">Cover Image</label>
                    <input type="file" name="cover_image" id="cover_image" 
                           class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    @error('cover_image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4 md:col-span-2">
                    <label for="description" class="block text-gray-300 text-sm font-bold mb-2">Description</label>
                    <textarea name="description" id="description" rows="5"
                              class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('admin.books.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded">
                    Save Book
                </button>
            </div>
        </form>
    </div>
</div>
@endsection