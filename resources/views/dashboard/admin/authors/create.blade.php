@extends('dashboard.admin.index')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-white mb-6">Add New Author</h1>

        <div class="bg-slate-800 rounded-lg shadow p-6">
            <form action="{{ route('admin.authors.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="fullname" class="block text-gray-300 text-sm font-bold mb-2">Full Name *</label>
                        <input type="text" name="fullname" id="fullname"
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            required value="{{ old('fullname') }}">
                        @error('fullname')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="nationality" class="block text-gray-300 text-sm font-bold mb-2">Nationality</label>
                        <input type="text" name="nationality" id="nationality"
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            value="{{ old('nationality') }}">
                        @error('nationality')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="birth_year" class="block text-gray-300 text-sm font-bold mb-2">Birth Year</label>
                        <input type="number" name="birth_year" id="birth_year" min="1000" max="{{ date('Y') }}"
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            value="{{ old('birth_year') }}">
                        @error('birth_year')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4 md:col-span-2">
                        <label for="biography" class="block text-gray-300 text-sm font-bold mb-2">Biography</label>
                        <textarea name="biography" id="biography" rows="5"
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ old('biography') }}</textarea>
                        @error('biography')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <a href="{{ route('admin.authors.index') }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                        Cancel
                    </a>
                    <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded">
                        Save Author
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
