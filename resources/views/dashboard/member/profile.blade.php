<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Library System</title>
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
        
        /* Custom styles for profile page */
        .profile-section {
            transition: all 0.3s ease;
        }
        .profile-section:hover {
            transform: translateY(-2px);
        }
        .tab-button {
            transition: all 0.2s ease;
        }
        .tab-button.active {
            border-bottom: 2px solid #EEBA30;
        }
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
                        <a href="{{ route('books.index') }}"
                            class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fa-solid fa-house mr-3"></i>
                            Home
                        </a>
                        <a href="{{ route('borrowed.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-book-open mr-3"></i>
                            My Borrowed Books
                        </a>
                        <a href="{{ route('reservations.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-bookmark mr-3"></i>
                            My Reservations
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-money-bill-wave mr-3"></i>
                            Fines & Payments
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fa-solid fa-bell mr-3"></i>
                            Notification
                        </a>
                        <!-- ACTIVE LINK for this page -->
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-sm font-medium text-white bg-dark-orange rounded-lg">
                            <i class="fas fa-user-cog mr-3"></i>
                            Profile Settings
                        </a>
                    </nav>
                </div>
                <div class="p-4 border-t border-slate-700">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-sign-out-alt mr-3"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Navigation (Mobile) -->
            <div class="md:hidden flex items-center justify-between px-4 py-3 bg-black border-b border-slate-700">
                <button class="text-primary-orange focus:outline-none" onclick="toggleMobileSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="text-primary-orange text-lg font-bold">My Profile</span>
                <div class="w-6"></div>
            </div>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-white">My Profile</h1>
                    <p class="text-gray-400">Manage your personal information and account settings.</p>
                </div>

                <!-- Profile Tabs -->
                <div class="mb-6 border-b border-slate-700">
                    <div class="flex space-x-6">
                        <button id="personal-tab" class="tab-button py-3 text-sm font-medium text-white active">Personal Information</button>
                        <button id="membership-tab" class="tab-button py-3 text-sm font-medium text-gray-400">Membership</button>
                        <button id="preferences-tab" class="tab-button py-3 text-sm font-medium text-gray-400">Preferences</button>
                        <button id="security-tab" class="tab-button py-3 text-sm font-medium text-gray-400">Security</button>
                    </div>
                </div>

                <!-- Personal Information Tab -->
                <div id="personal-content" class="profile-content">
                    <div class="bg-slate-800 rounded-lg shadow p-6 mb-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold text-white">Personal Information</h2>
                            <button class="text-primary-orange hover:text-dark-orange">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Full Name</label>
                                <p class="text-white">{{ $user->fullname }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Email Address</label>
                                <p class="text-white">john.smith@example.com</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Phone Number</label>
                                <p class="text-white">(555) 123-4567</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Date of Birth</label>
                                <p class="text-white">January 15, 1985</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Gender</label>
                                <p class="text-white">Male</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Address</label>
                                <p class="text-white">123 Library Lane, Bookville, BS 12345</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-800 rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-white mb-6">Reading Preferences</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Favorite Genres</label>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    <span class="px-3 py-1 bg-slate-700 text-xs rounded-full">Mystery</span>
                                    <span class="px-3 py-1 bg-slate-700 text-xs rounded-full">Science Fiction</span>
                                    <span class="px-3 py-1 bg-slate-700 text-xs rounded-full">History</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Preferred Formats</label>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    <span class="px-3 py-1 bg-slate-700 text-xs rounded-full">Physical Books</span>
                                    <span class="px-3 py-1 bg-slate-700 text-xs rounded-full">eBooks</span>
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-400 mb-1">Favorite Authors</label>
                                <p class="text-white">J.K. Rowling, Isaac Asimov, Dan Brown</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Membership Tab -->
                <div id="membership-content" class="profile-content hidden">
                    <div class="bg-slate-800 rounded-lg shadow p-6 mb-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold text-white">Membership Details</h2>
                            <button class="bg-primary-orange text-black px-4 py-2 rounded-lg hover:bg-dark-orange transition-colors text-sm">
                                Upgrade Membership
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Membership Type</label>
                                <p class="text-white">Premium Annual</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Membership Status</label>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-900 text-green-300">Active</span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Start Date</label>
                                <p class="text-white">January 15, 2023</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Expiry Date</label>
                                <p class="text-white">January 14, 2024</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Max Books Allowed</label>
                                <p class="text-white">10 books</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Renewal Option</label>
                                <p class="text-white">Auto-renewal enabled</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-800 rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-white mb-6">Borrowing History & Statistics</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                            <div class="bg-slate-700 p-4 rounded-lg">
                                <p class="text-3xl font-bold text-primary-orange">42</p>
                                <p class="text-gray-400 mt-1">Books Borrowed</p>
                            </div>
                            <div class="bg-slate-700 p-4 rounded-lg">
                                <p class="text-3xl font-bold text-primary-orange">3</p>
                                <p class="text-gray-400 mt-1">Current Loans</p>
                            </div>
                            <div class="bg-slate-700 p-4 rounded-lg">
                                <p class="text-3xl font-bold text-primary-orange">2</p>
                                <p class="text-gray-400 mt-1">Active Reservations</p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-md font-medium text-white mb-3">Most Borrowed Categories</h3>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400">Science Fiction</span>
                                    <span class="text-white">12 books</span>
                                </div>
                                <div class="w-full bg-slate-700 rounded-full h-2">
                                    <div class="bg-primary-orange h-2 rounded-full" style="width: 60%"></div>
                                </div>
                                
                                <div class="flex items-center justify-between mt-4">
                                    <span class="text-gray-400">Mystery</span>
                                    <span class="text-white">8 books</span>
                                </div>
                                <div class="w-full bg-slate-700 rounded-full h-2">
                                    <div class="bg-primary-orange h-2 rounded-full" style="width: 40%"></div>
                                </div>
                                
                                <div class="flex items-center justify-between mt-4">
                                    <span class="text-gray-400">History</span>
                                    <span class="text-white">6 books</span>
                                </div>
                                <div class="w-full bg-slate-700 rounded-full h-2">
                                    <div class="bg-primary-orange h-2 rounded-full" style="width: 30%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preferences Tab -->
                <div id="preferences-content" class="profile-content hidden">
                    <div class="bg-slate-800 rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-white mb-6">Notification Preferences</h2>
                        
                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-md font-medium text-white">Due Date Reminders</h3>
                                    <p class="text-gray-400 text-sm">Get notified before your borrowed items are due</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-orange"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-md font-medium text-white">Reservation Alerts</h3>
                                    <p class="text-gray-400 text-sm">Get notified when your reserved items become available</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-orange"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-md font-medium text-white">Overdue Notices</h3>
                                    <p class="text-gray-400 text-sm">Get notified when you have overdue items</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-orange"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-md font-medium text-white">New Arrivals</h3>
                                    <p class="text-gray-400 text-sm">Get notified about new books in your favorite genres</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-orange"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-md font-medium text-white">Event Notifications</h3>
                                    <p class="text-gray-400 text-sm">Get notified about library events and workshops</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-orange"></div>
                                </label>
                            </div>
                        </div>
                        
                        <div class="mt-8">
                            <h3 class="text-md font-medium text-white mb-4">Notification Methods</h3>
                            <div class="flex items-center space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" class="rounded bg-slate-700 border-slate-600 text-primary-orange focus:ring-primary-orange" checked>
                                    <span class="ml-2 text-gray-300">Email</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" class="rounded bg-slate-700 border-slate-600 text-primary-orange focus:ring-primary-orange">
                                    <span class="ml-2 text-gray-300">SMS</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" class="rounded bg-slate-700 border-slate-600 text-primary-orange focus:ring-primary-orange" checked>
                                    <span class="ml-2 text-gray-300">In-app notifications</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="mt-8 flex justify-end">
                            <button class="bg-primary-orange text-black px-6 py-2 rounded-lg hover:bg-dark-orange transition-colors">
                                Save Preferences
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Security Tab -->
                <div id="security-content" class="profile-content hidden">
                    <div class="bg-slate-800 rounded-lg shadow p-6 mb-6">
                        <h2 class="text-lg font-semibold text-white mb-6">Change Password</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Current Password</label>
                                <input type="password" class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-primary-orange">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">New Password</label>
                                <input type="password" class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-primary-orange">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Confirm New Password</label>
                                <input type="password" class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-primary-orange">
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button class="bg-primary-orange text-black px-6 py-2 rounded-lg hover:bg-dark-orange transition-colors">
                                Update Password
                            </button>
                        </div>
                    </div>

                    <div class="bg-slate-800 rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-white mb-6">Login Activity</h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-slate-700 rounded-lg">
                                <div>
                                    <p class="text-white">Chrome on Windows</p>
                                    <p class="text-gray-400 text-sm">New York, USA • October 15, 2023 at 2:30 PM</p>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-900 text-green-300">Current</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 bg-slate-700 rounded-lg">
                                <div>
                                    <p class="text-white">Safari on iPhone</p>
                                    <p class="text-gray-400 text-sm">New York, USA • October 14, 2023 at 7:15 PM</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 bg-slate-700 rounded-lg">
                                <div>
                                    <p class="text-white">Firefox on MacOS</p>
                                    <p class="text-gray-400 text-sm">New York, USA • October 12, 2023 at 10:45 AM</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button class="text-primary-orange hover:text-dark-orange text-sm">
                                <i class="fas fa-sign-out-alt mr-1"></i> Sign out from all other devices
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile sidebar overlay -->
    <div class="fixed inset-0 z-40 md:hidden hidden" id="mobile-sidebar">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75"></div>
        <div class="fixed inset-y-0 left-0 flex max-w-xs w-full">
            <div class="relative flex-1 flex flex-col w-64 bg-black">
                <div class="absolute top-0 right-0 -mr-14 p-1">
                    <button class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none focus:bg-gray-600" onclick="toggleMobileSidebar()">
                        <i class="fas fa-times text-white"></i>
                    </button>
                </div>
                <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                    <div class="flex-shrink-0 flex items-center px-4">
                        <span class="text-primary-orange text-xl font-bold">Member Dashboard</span>
                    </div>
                    <nav class="mt-5 px-2 space-y-1">
                        <a href="{{ route('member.dashboard') }}" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-tachometer-alt mr-4"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('books.index') }}" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fa-solid fa-house mr-4"></i>
                            Home
                        </a>
                        <a href="{{ route('borrowed.index') }}" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-book-open mr-4"></i>
                            My Borrowed Books
                        </a>
                        <a href="{{ route('reservations.index') }}" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-bookmark mr-4"></i>
                            My Reservations
                        </a>
                        <a href="#" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fas fa-money-bill-wave mr-4"></i>
                            Fines & Payments
                        </a>
                        <a href="#" class="flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
                            <i class="fa-solid fa-bell mr-4"></i>
                            Notification
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-2 py-2 text-base font-medium text-white bg-dark-orange rounded-lg">
                            <i class="fas fa-user-cog mr-4"></i>
                            Profile Settings
                        </a>
                    </nav>
                </div>
                <div class="flex-shrink-0 flex border-t border-slate-700 p-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex-shrink-0 w-full group block">
                            <div class="flex items-center">
                                <div>
                                    <i class="fas fa-sign-out-alt text-gray-300 group-hover:text-white mr-3"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-300 group-hover:text-white">Logout</p>
                                </div>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleMobileSidebar() {
            document.getElementById('mobile-sidebar').classList.toggle('hidden');
        }

        // Tab switching functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-button');
            const contents = document.querySelectorAll('.profile-content');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    tabs.forEach(t => t.classList.remove('active', 'text-white'));
                    tabs.forEach(t => t.classList.add('text-gray-400'));
                    
                    // Add active class to clicked tab
                    this.classList.add('active', 'text-white');
                    this.classList.remove('text-gray-400');
                    
                    // Hide all content
                    contents.forEach(content => content.classList.add('hidden'));
                    
                    // Show the corresponding content
                    const contentId = this.id.replace('-tab', '-content');
                    document.getElementById(contentId).classList.remove('hidden');
                });
            });
        });
    </script>
</body>
</html>