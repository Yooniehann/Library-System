@extends('dashboard.layouts.profile')

@section('content')
<div class="bg-slate-800 rounded-xl shadow-lg overflow-hidden card-hover">
    <!-- Tab Navigation -->
    <div class="border-b border-slate-700">
        <nav class="flex space-x-8 px-6">
            <button
                @click="activeTab = 'profile'"
                :class="activeTab === 'profile' ? 'border-yellow-500 text-yellow-500' : 'border-transparent text-gray-400 hover:text-gray-300'"
                class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200"
            >
                <i class="fas fa-user-circle mr-2"></i>Profile Information
            </button>
            <button
                @click="activeTab = 'password'"
                :class="activeTab === 'password' ? 'border-yellow-500 text-yellow-500' : 'border-transparent text-gray-400 hover:text-gray-300'"
                class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200"
            >
                <i class="fas fa-lock mr-2"></i>Change Password
            </button>
            <button
                @click="activeTab = 'danger'"
                :class="activeTab === 'danger' ? 'border-red-500 text-red-500' : 'border-transparent text-gray-400 hover:text-gray-300'"
                class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200"
            >
                <i class="fas fa-exclamation-triangle mr-2"></i>Danger Zone
            </button>
        </nav>
    </div>

    <!-- Tab Content -->
    <div class="p-6">
        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="bg-green-800/50 border border-green-600 text-green-300 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fas fa-check-circle mr-3"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-800/50 border border-red-600 text-red-300 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    <span class="font-medium">Please fix the following errors:</span>
                </div>
                <ul class="list-disc list-inside ml-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Profile Information Tab -->
        <div x-show="activeTab === 'profile'" x-transition>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Full Name -->
                    <div>
                        <label for="fullname" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-user mr-2 text-yellow-500"></i>Full Name
                        </label>
                        <input type="text" name="fullname" id="fullname" value="{{ old('fullname', $user->fullname) }}"
                            class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors duration-200">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-envelope mr-2 text-yellow-500"></i>Email Address
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors duration-200">
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-phone mr-2 text-yellow-500"></i>Phone Number
                        </label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                            class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors duration-200">
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-calendar mr-2 text-yellow-500"></i>Date of Birth
                        </label>
                        <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}"
                            class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors duration-200">
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-venus-mars mr-2 text-yellow-500"></i>Gender
                        </label>
                        <select name="gender" id="gender"
                            class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors duration-200">
                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>

                <!-- Address -->
                <div class="mb-6">
                    <label for="address" class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-map-marker-alt mr-2 text-yellow-500"></i>Address
                    </label>
                    <textarea name="address" id="address" rows="3"
                        class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors duration-200">{{ old('address', $user->address) }}</textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="btn-primary text-white font-medium py-2 px-6 rounded-lg flex items-center">
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Password Update Tab -->
        <div x-show="activeTab === 'password'" x-transition>
            <form method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PATCH')

                <div class="space-y-6 mb-6">
                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-key mr-2 text-yellow-500"></i>Current Password
                        </label>
                        <input type="password" name="current_password" id="current_password"
                            class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors duration-200">
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-lock mr-2 text-yellow-500"></i>New Password
                        </label>
                        <input type="password" name="password" id="password"
                            class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors duration-200">
                        <p class="text-xs text-gray-400 mt-2">Must be at least 8 characters with uppercase, lowercase, and numbers.</p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-lock mr-2 text-yellow-500"></i>Confirm New Password
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors duration-200">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="btn-primary text-white font-medium py-2 px-6 rounded-lg flex items-center">
                        <i class="fas fa-sync-alt mr-2"></i>Update Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Danger Zone Tab -->
        <div x-show="activeTab === 'danger'" x-transition>
            <div class="bg-red-900/20 border border-red-700 rounded-lg p-6 mb-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-500 text-2xl mr-4"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-red-300 mb-2">Delete Account</h3>
                        <p class="text-red-200 text-sm mb-4">
                            Once your account is deleted, all of its resources and data will be permanently deleted.
                            Before deleting your account, please download any data or information that you wish to retain.
                        </p>
                    </div>
                </div>

                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div class="mb-4">
                        <label for="delete_password" class="block text-sm font-medium text-red-300 mb-2">
                            <i class="fas fa-key mr-2"></i>Confirm Password
                        </label>
                        <input type="password" name="password" id="delete_password"
                            class="w-full bg-slate-700 border border-red-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors duration-200"
                            placeholder="Enter your password to confirm account deletion">
                    </div>

                    <button type="submit"
                        class="btn-danger text-white font-medium py-2 px-6 rounded-lg flex items-center"
                        onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
                        <i class="fas fa-trash-alt mr-2"></i>Delete Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- User Stats Card -->
<div class="bg-slate-800 rounded-xl shadow-lg p-6 mt-6 card-hover">
    <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
        <i class="fas fa-chart-bar mr-3 text-yellow-500"></i>Account Statistics
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-slate-700 rounded-lg p-4 text-center">
            <div class="text-yellow-500 text-3xl mb-2">
                <i class="fas fa-book-open"></i>
            </div>
            <h3 class="text-white font-semibold">Books Borrowed</h3>
            <p class="text-2xl font-bold text-yellow-500 mt-2">{{ $user->borrows()->count() }}</p>
        </div>

        <div class="bg-slate-700 rounded-lg p-4 text-center">
            <div class="text-yellow-500 text-3xl mb-2">
                <i class="fas fa-clock"></i>
            </div>
            <h3 class="text-white font-semibold">Active Borrows</h3>
            <p class="text-2xl font-bold text-yellow-500 mt-2">{{ $user->activeBorrows()->count() }}</p>
        </div>

        <div class="bg-slate-700 rounded-lg p-4 text-center">
            <div class="text-yellow-500 text-3xl mb-2">
                <i class="fas fa-calendar-check"></i>
            </div>
            <h3 class="text-white font-semibold">Reservations</h3>
            <p class="text-2xl font-bold text-yellow-500 mt-2">{{ $user->reservations()->count() }}</p>
        </div>
    </div>
</div>
@endsection
