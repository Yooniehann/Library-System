@extends('dashboard.admin.index')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-slate-800 rounded-xl p-6 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white">Welcome back, {{ Auth::user()->fullname }}!</h1>
                <p class="text-yellow-400 mt-2">Here's what's happening with your library today.</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-400">Today is</p>
                <p class="text-lg font-semibold text-white">{{ now()->format('l, F j, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl p-6 shadow-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Total Users</p>
                    <p class="text-3xl font-bold">{{ $totalUsers }}</p>
                </div>
                <div class="bg-blue-500 p-3 rounded-full">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.users.index') }}" class="text-sm opacity-80 hover:opacity-100 flex items-center">
                    View all users <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>

        <!-- Total Books -->
        <div class="bg-gradient-to-r from-green-600 to-green-800 rounded-xl p-6 shadow-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Total Books</p>
                    <p class="text-3xl font-bold">{{ $totalBooks }}</p>
                </div>
                <div class="bg-green-500 p-3 rounded-full">
                    <i class="fas fa-book text-2xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.books.index') }}" class="text-sm opacity-80 hover:opacity-100 flex items-center">
                    Manage books <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>

        <!-- Active Borrows -->
        <div class="bg-gradient-to-r from-yellow-600 to-yellow-800 rounded-xl p-6 shadow-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Active Borrows</p>
                    <p class="text-3xl font-bold">{{ $activeBorrows }}</p>
                    <p class="text-sm opacity-80 mt-1">{{ $overdueBorrows }} overdue</p>
                </div>
                <div class="bg-yellow-500 p-3 rounded-full">
                    <i class="fas fa-exchange-alt text-2xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.issued-books.index') }}" class="text-sm opacity-80 hover:opacity-100 flex items-center">
                    View borrows <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-gradient-to-r from-purple-600 to-purple-800 rounded-xl p-6 shadow-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Total Revenue</p>
                    <p class="text-3xl font-bold">${{ number_format($totalRevenue, 2) }}</p>
                </div>
                <div class="bg-purple-500 p-3 rounded-full">
                    <i class="fas fa-dollar-sign text-2xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-sm opacity-80">From fines</p>
            </div>
        </div>
    </div>

    <!-- Charts and Graphs Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Monthly Borrows Chart -->
        <div class="bg-slate-800 rounded-xl p-6 shadow-lg">
            <h2 class="text-xl font-semibold text-white mb-4">Borrows Overview (Last 6 Months)</h2>
            <div class="h-64">
                <canvas id="monthlyBorrowsChart"></canvas>
            </div>
        </div>

        <!-- User Distribution Chart -->
        <div class="bg-slate-800 rounded-xl p-6 shadow-lg">
            <h2 class="text-xl font-semibold text-white mb-4">User Distribution</h2>
            <div class="h-64">
                <canvas id="userRolesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activities Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Borrows -->
        <div class="bg-slate-800 rounded-xl p-6 shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-white">Recent Borrows</h2>
                <a href="{{ route('admin.issued-books.index') }}" class="text-yellow-400 text-sm hover:text-yellow-300">
                    View all
                </a>
            </div>
            <div class="space-y-3">
                @foreach($recentBorrows as $borrow)
                <div class="bg-slate-700 rounded-lg p-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white font-medium">{{ $borrow->inventory->book->title }}</p>
                            <p class="text-gray-400 text-sm">Borrowed by {{ $borrow->user->fullname }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-white text-sm">{{ $borrow->borrow_date->format('M d') }}</p>
                            <span class="inline-block px-2 py-1 text-xs rounded-full
                                {{ $borrow->status === 'active' ? 'bg-green-500 text-white' :
                                   ($borrow->status === 'overdue' ? 'bg-red-500 text-white' : 'bg-gray-500 text-white') }}">
                                {{ ucfirst($borrow->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-slate-800 rounded-xl p-6 shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-white">Recent Users</h2>
                <a href="{{ route('admin.users.index') }}" class="text-yellow-400 text-sm hover:text-yellow-300">
                    View all
                </a>
            </div>
            <div class="space-y-3">
                @foreach($recentUsers as $user)
                <div class="bg-slate-700 rounded-lg p-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-yellow-400 flex items-center justify-center text-black font-semibold mr-3">
                                {{ strtoupper(substr($user->fullname, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-white font-medium">{{ $user->fullname }}</p>
                                <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-2 py-1 text-xs rounded-full
                                {{ $user->role === 'Admin' ? 'bg-purple-500 text-white' :
                                   ($user->role === 'Member' ? 'bg-green-500 text-white' :
                                   ($user->role === 'Kid' ? 'bg-blue-500 text-white' : 'bg-gray-500 text-white')) }}">
                                {{ $user->role }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Additional Information Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Categories -->
        <div class="bg-slate-800 rounded-xl p-6 shadow-lg">
            <h2 class="text-xl font-semibold text-white mb-4">Top Categories</h2>
            <div class="space-y-3">
                @foreach($categories as $category)
                <div class="flex items-center justify-between">
                    <span class="text-white">{{ $category->category_name }}</span>
                    <span class="bg-yellow-500 text-black px-2 py-1 rounded-full text-xs">
                        {{ $category->books_count }} books
                    </span>
                </div>
                <div class="w-full bg-slate-700 rounded-full h-2 mb-4">
                    <div class="bg-yellow-500 h-2 rounded-full"
                         style="width: {{ ($category->books_count / max(1, $totalBooks)) * 100 }}%">
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Top Authors -->
        <div class="bg-slate-800 rounded-xl p-6 shadow-lg">
            <h2 class="text-xl font-semibold text-white mb-4">Top Authors</h2>
            <div class="space-y-3">
                @foreach($topAuthors as $author)
                <div class="flex items-center justify-between bg-slate-700 rounded-lg p-3">
                    <span class="text-white">{{ $author->fullname }}</span>
                    <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">
                        {{ $author->books_count }} books
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-slate-800 rounded-xl p-6 shadow-lg">
        <h2 class="text-xl font-semibold text-white mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.books.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-lg text-center transition-colors">
                <i class="fas fa-plus-circle text-2xl mb-2"></i>
                <p>Add New Book</p>
            </a>
            <a href="{{ route('admin.users.create') }}" class="bg-green-600 hover:bg-green-700 text-white p-4 rounded-lg text-center transition-colors">
                <i class="fas fa-user-plus text-2xl mb-2"></i>
                <p>Add New User</p>
            </a>
            <a href="{{ route('admin.stockins.create') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white p-4 rounded-lg text-center transition-colors">
                <i class="fas fa-box-open text-2xl mb-2"></i>
                <p>Stock In Books</p>
            </a>
            <a href="{{ route('admin.fines.index') }}" class="bg-red-600 hover:bg-red-700 text-white p-4 rounded-lg text-center transition-colors">
                <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                <p>Manage Fines</p>
            </a>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Monthly Borrows Chart
        const monthlyCtx = document.getElementById('monthlyBorrowsChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: @json(array_column($monthlyData, 'month')),
                datasets: [{
                    label: 'Borrows',
                    data: @json(array_column($monthlyData, 'count')),
                    backgroundColor: 'rgba(234, 179, 8, 0.8)',
                    borderColor: 'rgba(234, 179, 8, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#fff' },
                        grid: { color: 'rgba(255,255,255,0.1)' }
                    },
                    x: {
                        ticks: { color: '#fff' },
                        grid: { color: 'rgba(255,255,255,0.1)' }
                    }
                },
                plugins: {
                    legend: {
                        labels: { color: '#fff' }
                    }
                }
            }
        });

        // User Roles Chart
        const rolesCtx = document.getElementById('userRolesChart').getContext('2d');
        new Chart(rolesCtx, {
            type: 'doughnut',
            data: {
                labels: @json($userRoles->pluck('role')),
                datasets: [{
                    data: @json($userRoles->pluck('count')),
                    backgroundColor: [
                        'rgba(139, 92, 246, 0.8)', // Admin - Purple
                        'rgba(34, 197, 94, 0.8)',  // Member - Green
                        'rgba(59, 130, 246, 0.8)', // Kid - Blue
                        'rgba(107, 114, 128, 0.8)' // Guest - Gray
                    ],
                    borderColor: [
                        'rgba(139, 92, 246, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(59, 130, 246, 1)',
                        'rgba(107, 114, 128, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#fff' }
                    }
                }
            }
        });
    });
</script>
@endsection
