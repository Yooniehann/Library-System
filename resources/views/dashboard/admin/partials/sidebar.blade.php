<!-- Sidebar -->
<div id="sidebar" x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform"
    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full" :class="{ 'w-20': !sidebarExpanded, 'w-64': sidebarExpanded }"
    class="fixed md:relative h-screen bg-black text-white z-50 overflow-y-auto no-scrollbar" x-data="{ sidebarExpanded: window.innerWidth > 768 }">

    <div class="p-4 flex items-center justify-between border-b border-black">
        <div class="flex items-center space-x-2" x-show="sidebarExpanded">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-300" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <span class="text-xl font-bold">Library</span>
        </div>
        <button @click="sidebarExpanded = !sidebarExpanded" class="text-gray-400 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path x-show="sidebarExpanded" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 19l-7-7 7-7" />
                <path x-show="!sidebarExpanded" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <button id="close-sidebar" class="md:hidden text-gray-400 hover:text-white" x-show="sidebarExpanded"
            @click="sidebarOpen = false">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="p-4 h-[calc(100%-120px)] overflow-y-auto no-scrollbar">
        

        <h3 class="text-xs uppercase text-gray-400 font-semibold mb-2" x-show="sidebarExpanded">DASHBOARD</h3>

        <ul class="space-y-2">
            <!-- Manage Books with dropdown -->
            <li x-data="{ open: false }">
                <div @click="open = !open"
                    class="sidebar-item flex items-center justify-between p-2 rounded cursor-pointer">
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span x-show="sidebarExpanded">Manage Books</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200"
                        :class="{ 'transform rotate-90': open }" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" x-show="sidebarExpanded">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <ul x-show="open && sidebarExpanded" x-collapse class="pl-8 mt-1 space-y-1">
                    <li><a href="{{ route('admin.books.create') }}" class="dropdown-item block p-2 text-sm rounded">Add
                            New Book</a></li>
                    <li><a href="{{ route('admin.books.index') }}" class="dropdown-item block p-2 text-sm rounded">View
                            All Books</a></li>
                    <li><a href="{{ route('admin.books.index') }}" class="dropdown-item block p-2 text-sm rounded">Edit
                            Books</a></li>
                </ul>
            </li>

            <!-- Manage Inventories (Book Copies) with dropdown -->
            {{-- <li x-data="{ open: false }">
                <div @click="open = !open"
                    class="sidebar-item flex items-center justify-between p-2 rounded cursor-pointer">
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span x-show="sidebarExpanded">Manage Inventories</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200"
                        :class="{ 'transform rotate-90': open }" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" x-show="sidebarExpanded">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <ul x-show="open && sidebarExpanded" x-collapse class="pl-8 mt-1 space-y-1">
                    <li><a href="#" class="dropdown-item block p-2 text-sm rounded">Add Book Copies</a></li>
                    <li><a href="#" class="dropdown-item block p-2 text-sm rounded">View Inventory</a></li>
                    <li><a href="#" class="dropdown-item block p-2 text-sm rounded">Update Copies</a></li>
                    <li><a href="#" class="dropdown-item block p-2 text-sm rounded">Track Availability</a></li>
                </ul>
            </li> --}}

            <!-- Manage Suppliers with dropdown -->
            <li x-data="{ open: false }">
                <div @click="open = !open"
                    class="sidebar-item flex items-center justify-between p-2 rounded cursor-pointer">
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24"
                            fill="currentColor">
                            <!-- Hat -->
                            <path d="M2 10h20l-2-4H4l-2 4z" />
                            <!-- Face -->
                            <circle cx="12" cy="15" r="3" />
                            <!-- Shoulders -->
                            <path d="M6 22c0-3 4-5 6-5s6 2 6 5H6z" />
                        </svg>
                        <span x-show="sidebarExpanded">Manage Suppliers</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200"
                        :class="{ 'transform rotate-90': open }" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" x-show="sidebarExpanded">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <ul x-show="open && sidebarExpanded" x-collapse class="pl-8 mt-1 space-y-1">
                    <li><a href="{{ route('admin.suppliers.create') }}"
                            class="dropdown-item block p-2 text-sm rounded">Add New Supplier</a></li>
                    <li><a href="{{ route('admin.suppliers.index') }}"
                            class="dropdown-item block p-2 text-sm rounded">View All Suppliers</a></li>
                </ul>
            </li>


            <!-- Manage Members with dropdown -->
            <li x-data="{ open: false }">
                <div @click="open = !open"
                    class="sidebar-item flex items-center justify-between p-2 rounded cursor-pointer">
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span x-show="sidebarExpanded">Manage Members</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200"
                        :class="{ 'transform rotate-90': open }" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" x-show="sidebarExpanded">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <ul x-show="open && sidebarExpanded" x-collapse class="pl-8 mt-1 space-y-1">
                    <li><a href="{{ route('admin.users.create') }}"
                            class="dropdown-item block p-2 text-sm rounded">Add New User</a></li>
                    <li><a href="{{ route('admin.users.index') }}"
                            class="dropdown-item block p-2 text-sm rounded">View All Users</a></li>
                </ul>
            </li>

            <!-- Manage Authors with dropdown -->
            <li x-data="{ open: false }">
                <div @click="open = !open"
                    class="sidebar-item flex items-center justify-between p-2 rounded cursor-pointer">
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span x-show="sidebarExpanded">Manage Authors</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200"
                        :class="{ 'transform rotate-90': open }" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" x-show="sidebarExpanded">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <ul x-show="open && sidebarExpanded" x-collapse class="pl-8 mt-1 space-y-1">
                    <li><a href="{{ route('admin.authors.create') }}"
                            class="dropdown-item block p-2 text-sm rounded">Add New Author</a></li>
                    <li><a href="{{ route('admin.authors.index') }}"
                            class="dropdown-item block p-2 text-sm rounded">View All Authors</a></li>
                    {{-- <li><a href="{{ route('admin.authors.index') }}" class="dropdown-item block p-2 text-sm rounded">Edit Authors</a></li> --}}
                </ul>
            </li>

            <!-- Manage Category with dropdown -->
            <li x-data="{ open: false }">
                <div @click="open = !open"
                    class="sidebar-item flex items-center justify-between p-2 rounded cursor-pointer">
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span x-show="sidebarExpanded">Manage Category</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200"
                        :class="{ 'transform rotate-90': open }" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" x-show="sidebarExpanded">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <ul x-show="open && sidebarExpanded" x-collapse class="pl-8 mt-1 space-y-1">
                    <li><a href="{{ route('admin.categories.create') }}"
                            class="dropdown-item block p-2 text-sm rounded">Add New Category</a></li>
                    <li><a href="{{ route('admin.categories.index') }}"
                            class="dropdown-item block p-2 text-sm rounded">View All Categories</a></li>
                </ul>
            </li>

            <!-- Stock Management -->
            <li x-data="{ open: false }">
                <div @click="open = !open"
                    class="sidebar-item flex items-center justify-between p-2 rounded cursor-pointer">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        <span x-show="sidebarExpanded">Stock Management</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200"
                        :class="{ 'transform rotate-90': open }" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" x-show="sidebarExpanded">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <ul x-show="open && sidebarExpanded" x-collapse class="pl-8 mt-1 space-y-1">
                    <li><a href="{{ route('admin.stockins.create') }}"
                            class="dropdown-item block p-2 text-sm rounded">Create Stock In</a></li>
                    <li><a href="{{ route('admin.stockins.index') }}"
                            class="dropdown-item block p-2 text-sm rounded">View Stock Ins</a></li>

                </ul>
            </li>

            <!-- Other menu items -->
            <li>
                <a href="#" class="sidebar-item flex items-center space-x-2 p-2 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                    </svg>
                    <span x-show="sidebarExpanded">Issued Books</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-item flex items-center space-x-2 p-2 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span x-show="sidebarExpanded">Returned Books</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-item flex items-center space-x-2 p-2 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span x-show="sidebarExpanded">Overdue Books</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-item flex items-center space-x-2 p-2 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span x-show="sidebarExpanded">Fines & Payments</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-item flex items-center space-x-2 p-2 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span x-show="sidebarExpanded">Email</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-item flex items-center space-x-2 p-2 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span x-show="sidebarExpanded">Reports / Analytics</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-item flex items-center space-x-2 p-2 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span x-show="sidebarExpanded">Settings</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Logout -->
    <div class="p-4 border-t border-slate-700">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="sidebar-item w-full flex items-center space-x-2 p-2 rounded text-red-400 hover:text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span x-show="sidebarExpanded">Logout</span>
            </button>
        </form>
    </div>
</div>
