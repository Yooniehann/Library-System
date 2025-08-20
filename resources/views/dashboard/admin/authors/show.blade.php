@extends('dashboard.admin.index')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Author Details</h1>
        <a href="{{ route('admin.authors.index') }}" class="text-gray-300 hover:text-white">
            <i class="fas fa-arrow-left mr-1"></i> Back to Authors
        </a>
    </div>

    <div class="bg-slate-800 rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-700 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-white">{{ $author->fullname }}</h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.authors.edit', $author->author_id) }}" 
                   class="text-primary-orange hover:text-dark-orange">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-white mb-2">Biography</h3>
                    <div class="bg-slate-700 rounded-lg p-4 text-gray-300">
                        {{ $author->biography ?? 'No biography available.' }}
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-white mb-2">Details</h3>
                    <div class="bg-slate-700 rounded-lg p-4">
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-400">Nationality</h4>
                            <p class="text-white">{{ $author->nationality ?? 'N/A' }}</p>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-sm font-medium text-gray-400">Birth Year</h4>
                            <p class="text-white">{{ $author->birth_year ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection