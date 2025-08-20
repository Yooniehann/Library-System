@extends('dashboard.admin.index')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Manage Users</h1>
            <a href="{{ route('admin.users.create') }}"
                class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded">
                Add New User
            </a>
        </div>

        <!-- Search Bar -->
        <div class="mb-6">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-2">
                <input type="text" name="search" placeholder="Search by name, email, membership type or role..."
                    value="{{ request('search') }}"
                    class="flex-1 bg-slate-700 text-white border border-gray-600 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <button type="submit"
                    class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-6 rounded-lg">
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.users.index') }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Users Table -->
        <div class="bg-slate-800 rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-slate-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Member</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Contact Info</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Membership</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Role</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-slate-800 divide-y divide-gray-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-750 transition-colors duration-150">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-300 font-mono">{{ $user->user_id }}</div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-white">{{ $user->fullname }}</div>
                                        <div class="text-xs text-gray-400">
                                            {{ ucfirst($user->gender) }} • {{ $user->date_of_birth->age }} years
                                            @if ($user->is_kid)
                                                <span class="bg-blue-500 text-white px-1 rounded ml-1">Child</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-white">{{ $user->email }}</div>
                                <div class="text-xs text-gray-400">{{ $user->phone ?? 'No phone' }}</div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                @if ($user->membershipType)
                                    <div class="text-sm font-medium text-white">{{ $user->membershipType->type_name }}</div>
                                    <div class="text-xs text-gray-400">
                                        @if ($user->membership_start_date && $user->membership_end_date)
                                            {{ $user->membership_start_date->format('M d, Y') }} -
                                            {{ $user->membership_end_date->format('M d, Y') }}
                                        @else
                                            No dates set
                                        @endif
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400">No membership</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $user->status === 'active' ? 'bg-green-600 text-white' : 
                                       ($user->status === 'suspended' ? 'bg-red-600 text-white' : 'bg-yellow-600 text-white') }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $user->role === 'Librarian' ? 'bg-purple-600 text-white' : 
                                       ($user->role === 'Member' ? 'bg-blue-600 text-white' : 'bg-gray-600 text-white') }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-3">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="text-yellow-400 hover:text-yellow-300 transition-colors duration-200">
                                        Edit
                                    </a>
                                    @if ($user->role !== 'Librarian')
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:text-red-400 transition-colors duration-200"
                                                onclick="return confirm('Are you sure you want to delete {{ $user->fullname }}?')">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-400">
                                @if(request('search'))
                                    No users found matching your search criteria.
                                @else
                                    No users found.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->appends(['search' => request('search')])->links() }}
        </div>
    </div>
@endsection