<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Admin Dashboard</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine JS for dropdowns -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .sidebar-item:hover {
            background-color: rgb(253 224 71);
            color: #000;
            transform: translateX(5px);
            transition: all 0.3s ease;
        }

        .sidebar-item {
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: rgb(253 224 71 / 0.5);
            transition: all 0.3s ease;
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans" x-data="{
    sidebarOpen: window.innerWidth > 768,
    sidebarExpanded: window.innerWidth > 768,
    init() {
        if (localStorage.getItem('sidebarExpanded') !== null) {
            this.sidebarExpanded = localStorage.getItem('sidebarExpanded') === 'true';
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                this.sidebarOpen = true;
            } else {
                this.sidebarExpanded = false;
            }
        });
    },
    toggleSidebar() {
        if (window.innerWidth <= 768) {
            this.sidebarOpen = !this.sidebarOpen;
        } else {
            this.sidebarExpanded = !this.sidebarExpanded;
            localStorage.setItem('sidebarExpanded', this.sidebarExpanded);
        }
    }
}" x-cloak>
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('dashboard.admin.partials.sidebar')

        <!-- Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            @include('dashboard.admin.partials.header')

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto no-scrollbar p-4 md:p-6 bg-slate-900">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Listen for the close-sidebar event
            document.addEventListener('close-sidebar', function() {
                Alpine.store('sidebarOpen', false);
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const sidebar = document.getElementById('sidebar');
                const toggleBtn = document.getElementById('toggle-sidebar');
                const closeBtn = document.getElementById('close-sidebar');

                if (window.innerWidth <= 768 &&
                    !sidebar.contains(event.target) &&
                    !toggleBtn.contains(event.target) &&
                    !closeBtn.contains(event.target) &&
                    Alpine.store('sidebarOpen')) {
                    Alpine.store('sidebarOpen', false);
                }
            });
        });
    </script>
</body>

</html>
