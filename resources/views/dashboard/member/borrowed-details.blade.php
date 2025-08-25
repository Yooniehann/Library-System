<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow Details | Library System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .bg-primary-orange { background-color: #EEBA30; }
        .bg-dark-orange { background-color: #D3A625; }
        .text-primary-orange { color: #EEBA30; }
        .text-dark-orange { color: #D3A625; }
        .border-primary-orange { border-color: #EEBA30; }
        .hover\:bg-dark-orange:hover { background-color: #D3A625; }
        .bg-slate-900 { background-color: #0f172a; }
        .bg-slate-800 { background-color: #1e293b; }
        .bg-slate-700 { background-color: #334155; }
    </style>
</head>
<body class="bg-slate-900 text-gray-200 font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-black border-r border-slate-700">
                <div class="flex items-center justify-center h-16 px-4 bg-black">
                    <span class="text-primary-orange text-xl font-bold">Member Dashboard</span>
                </div>
                <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto">
                    <nav class="flex-1 space-y-2">
                        <a href="{{ route('member.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('borrowed.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-white bg-dark-orange rounded-lg">
                            <i class="fas fa-book-open mr-3"></i>
                            My Borrowed Books
                        </a>
                        <!-- Other menu items... -->
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Navigation -->
            <div class="flex items-center justify-between px-4 py-3 bg-black border-b border-slate-700">
                <a href="{{ route('borrowed.index') }}" class="text-primary-orange hover:text-dark-orange">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Borrowed Books
                </a>
                <span class="text-primary-orange text-lg font-bold">Borrow Details</span>
                <div class="w-6"></div>
            </div>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                @php
                    $book = $borrow->inventory->book;
                    $coverImage = $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://via.placeholder.com/300x450/1e293b/ffffff?text=No+Cover';
                @endphp

                <div class="max-w-4xl mx-auto">
                    <!-- Header -->
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-white">Borrow Details</h1>
                        <p class="text-gray-400">Detailed information about your borrowed book</p>
                    </div>

                    <div class="bg-slate-800 rounded-lg shadow overflow-hidden">
                        <!-- Book Information -->
                        <div class="p-6 border-b border-slate-700">
                            <div class="flex flex-col md:flex-row gap-6">
                                <!-- Book Cover -->
                                <div class="flex-shrink-0">
                                    <div class="h-64 w-48 bg-slate-700 rounded-lg overflow-hidden shadow-lg flex items-center justify-center">
                                        @if($book->cover_image)
                                            <img src="{{ $coverImage }}" alt="{{ $book->title }} cover" class="h-full w-full object-cover">
                                        @else
                                            <i class="fas fa-book text-gray-400 text-5xl"></i>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Book Details -->
                                <div class="flex-1">
                                    <h2 class="text-2xl font-bold text-white mb-2">{{ $book->title }}</h2>
                                    <p class="text-lg text-gray-400 mb-4">by {{ $book->author->fullname ?? 'Unknown Author' }}</p>
                                    
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-500">ISBN:</span>
                                            <span class="text-white ml-2">{{ $book->isbn }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Category:</span>
                                            <span class="text-white ml-2">{{ $book->category->category_name ?? 'N/A' }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Publisher:</span>
                                            <span class="text-white ml-2">{{ $book->publisher->publisher_name ?? 'N/A' }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Publication Year:</span>
                                            <span class="text-white ml-2">{{ $book->publication_year }}</span>
                                        </div>
                                    </div>
                                    
                                    <p class="text-gray-400 mt-4 text-sm">{{ Str::limit($book->description, 200) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Borrow Information -->
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-white mb-4">Borrow Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-gray-500">Borrow ID:</span>
                                        <span class="text-white ml-2 font-mono">#{{ $borrow->borrow_id }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Borrow Date:</span>
                                        <span class="text-white ml-2">{{ $borrow->borrow_date->format('F d, Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Due Date:</span>
                                        <span class="text-white ml-2">{{ $borrow->due_date->format('F d, Y') }}</span>
                                    </div>
                                </div>
                                
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-gray-500">Status:</span>
                                        @if($borrow->status == 'active')
                                            @if($borrow->due_date->isPast())
                                                <span class="ml-2 px-3 py-1 text-xs font-semibold rounded-full bg-red-900 text-red-300">Overdue</span>
                                            @else
                                                <span class="ml-2 px-3 py-1 text-xs font-semibold rounded-full bg-green-900 text-green-300">Active</span>
                                            @endif
                                        @else
                                            <span class="ml-2 px-3 py-1 text-xs font-semibold rounded-full bg-gray-600 text-gray-300">{{ ucfirst($borrow->status) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Renewals Used:</span>
                                        <span class="text-white ml-2">{{ $borrow->renewal_count }} / 2</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Processed by:</span>
                                        <span class="text-white ml-2">{{ $borrow->staff->name ?? 'System' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            @if($borrow->status == 'active')
                            <div class="mt-6 pt-4 border-t border-slate-700">
                                <h4 class="text-md font-semibold text-white mb-3">Quick Actions</h4>
                                <div class="flex flex-wrap gap-3">
                                    <form action="{{ route('borrow.renew', $borrow->borrow_id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="flex items-center px-4 py-2 bg-blue-700 text-white rounded hover:bg-blue-600 transition-colors">
                                            <i class="fas fa-sync-alt mr-2"></i> Renew Book
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('book.return', $borrow->borrow_id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="flex items-center px-4 py-2 bg-green-700 text-white rounded hover:bg-green-600 transition-colors">
                                            <i class="fas fa-undo mr-2"></i> Return Book
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>