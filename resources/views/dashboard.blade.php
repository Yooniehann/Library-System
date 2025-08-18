@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid md:grid-cols-4 gap-6">
    <!-- Quick Stats -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500">Borrowed Books</p>
                <p class="text-2xl font-bold">5</p>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <i class="fas fa-book text-blue-500 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500">Reservations</p>
                <p class="text-2xl font-bold">2</p>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <i class="fas fa-calendar-check text-green-500 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500">Fines Due</p>
                <p class="text-2xl font-bold">$0.00</p>
            </div>
            <div class="bg-yellow-100 p-3 rounded-full">
                <i class="fas fa-money-bill-wave text-yellow-500 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500">Membership</p>
                <p class="text-2xl font-bold">
                    {{ auth()->user()->membershipType->name ?? 'None' }}
                </p>
            </div>
            <div class="bg-purple-100 p-3 rounded-full">
                <i class="fas fa-id-card text-purple-500 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="mt-8 bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b">
        <h2 class="text-lg font-semibold">Recent Activity</h2>
    </div>
    <div class="divide-y">
        <div class="p-6">
            <div class="flex items-start">
                <div class="bg-blue-100 p-2 rounded-full mr-4">
                    <i class="fas fa-book text-blue-500"></i>
                </div>
                <div>
                    <p class="font-medium">You borrowed "The Great Gatsby"</p>
                    <p class="text-sm text-gray-500">Due on June 15, 2023</p>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="flex items-start">
                <div class="bg-green-100 p-2 rounded-full mr-4">
                    <i class="fas fa-calendar-check text-green-500"></i>
                </div>
                <div>
                    <p class="font-medium">You reserved "To Kill a Mockingbird"</p>
                    <p class="text-sm text-gray-500">June 5, 2023</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recommended Books -->
<div class="mt-8">
    <h2 class="text-lg font-semibold mb-4">Recommended For You</h2>
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        @for($i = 0; $i < 4; $i++)
        <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition-shadow">
            <div class="h-48 bg-gray-200"></div>
            <div class="p-4">
                <h3 class="font-medium">Book Title {{ $i+1 }}</h3>
                <p class="text-sm text-gray-500">Author Name</p>
                <button class="mt-3 w-full bg-blue-500 text-white py-1 px-3 rounded text-sm hover:bg-blue-600">
                    Borrow
                </button>
            </div>
        </div>
        @endfor
    </div>
</div>
@endsection
