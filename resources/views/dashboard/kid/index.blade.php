
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kid Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    body {
        margin: 0;
        font-family: 'Open Sans', sans-serif;
        background-color: #000000;
        color: #fff;
    }

    /* Sidebar */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        height: 100%;
        background-color: #000000;
        padding-top: 60px;
        transition: transform 0.3s ease;
        transform: translateX(-100%);
        z-index: 1000;
        overflow-y: auto;
        scrollbar-width: none;
    }
    .sidebar::-webkit-scrollbar { display: none; }
    .sidebar.open { transform: translateX(0); }

    .sidebar ul { list-style: none; padding: 0 0 20px 0; margin: 0; }
    .sidebar ul li {
        padding: 15px 25px;
        font-size: 1rem;
        cursor: pointer;
        color: #EEBA30;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: background 0.3s, color 0.3s;
    }
    .sidebar ul li:hover,
    .sidebar ul li.active { background-color: #D3A625; color: #000; }
    .sidebar ul li:hover i,
    .sidebar ul li.active i { color: #000; }

    .close-btn { position: absolute; top: 15px; right: 20px; font-size: 1.5rem; cursor: pointer; color: #EEBA30; background: none; border: none; }
    .open-btn { font-size: 1.5rem; cursor: pointer; color: #EEBA30; background: none; border: none; margin-right: 15px; transition: opacity 0.3s; }
    .open-btn.hidden { opacity: 0; pointer-events: none; }

    .content { margin-left: 0; padding: 20px; transition: margin-left 0.3s ease; }
    .content.shift { margin-left: 250px; }
    .header { display: flex; align-items: center; font-size: 1.5rem; margin-bottom: 20px; color: #EEBA30; }

    .scrollable { max-height: 400px; overflow-y: auto; }
    .scrollable::-webkit-scrollbar { display: none; }

    /* Hover animations without color change */
    .hover-card {
        transition: transform 0.3s;
        cursor: pointer;
    }
    .hover-card:hover {
        transform: translateY(-5px) scale(1.03);
    }
    .hover-card img {
        transition: transform 0.3s;
    }
    .hover-card:hover img {
        transform: scale(1.05);
    }

    button, .sidebar ul li, .hover-card, .hover-card img {
        cursor: pointer;
    }


    @media (max-width: 1024px) { .flex-cols { flex-direction: column; } }
    #notifications {
    space-y-3;
    max-height: none; /* remove height limit */
    overflow-y: visible; /* allow full height, no scroll */
}
/* Logo container */
.logo {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 5px 10px;
    text-decoration: none;    /* remove underline for link */
    transition: transform 0.2s ease, filter 0.2s ease;
    cursor: pointer;
}

/* Hover animation */
.logo:hover {
    transform: scale(1.1);
    filter: brightness(1.2);
}

/* Icon */
.logo-icon {
    width: 32px;
    height: 32px;
    color: #FBBF24;
    transition: transform 0.3s ease;
}

/* Icon hover effect */
.logo:hover .logo-icon {
    transform: rotate(15deg) scale(1.2);
}

/* Text */
.logo-text {
    font-size: 1.25rem;
    font-weight: bold;
    color: #FBBF24;
    font-family: 'Open Sans', sans-serif;
    transition: letter-spacing 0.3s ease;
}

/* Text hover effect */
.logo:hover .logo-text {
    letter-spacing: 1px;
}

</style>
</head>
<body>

<!-- Sidebar navigation -->
<div class="sidebar" id="sidebar">
    <button class="close-btn" onclick="closeNav()"><i class="fas fa-times"></i></button>
<a href="{{ url('/') }}" class="logo">
    <svg xmlns="http://www.w3.org/2000/svg" class="logo-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
    </svg>
    <span class="logo-text">Library</span>
</a>
    <ul>
        <li class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</li>
        <li><i class="fas fa-book"></i> Search Books</li>
        <li><i class="fas fa-calendar-check"></i> My Reservations</li>
        <li><i class="fas fa-credit-card"></i> Fines & Payments</li>
        <li><i class="fas fa-history"></i> Reading History</li>
        <li><i class="fas fa-trophy"></i> Achievements & Progress</li>
        <li><i class="fas fa-bell"></i> Notifications</li>
        <li><i class="fas fa-envelope"></i> Contact Librarian</li>
        <li><i class="fas fa-user-cog"></i> Profile Settings</li>
        <li><i class="fas fa-sign-out-alt"></i> Logout</li>
    </ul>
</div>

<!-- Main content -->
<div class="content" id="mainContent">
    <div class="header">
        <button class="open-btn" id="openBtn" onclick="openNav()"><i class="fas fa-bars"></i></button>
        <span>Welcome to Kid Dashboard</span>
    </div>

    <!-- Welcome -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold">Welcome back, <span class="text-yellow-400">Username</span></h1>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-gray-800 p-4 rounded-lg flex items-center gap-3 hover-card">
            <i class="fas fa-book text-yellow-400 text-2xl"></i>
            <div>
                <p class="text-gray-400 text-sm">Borrowed Books</p>
                <p class="text-white font-bold text-xl">12</p>
            </div>
        </div>
        <div class="bg-gray-800 p-4 rounded-lg flex items-center gap-3 hover-card">
            <i class="fas fa-exclamation-circle text-red-500 text-2xl"></i>
            <div>
                <p class="text-gray-400 text-sm">Overdue Books</p>
                <p class="text-white font-bold text-xl">3</p>
            </div>
        </div>
        <div class="bg-gray-800 p-4 rounded-lg flex items-center gap-3 hover-card">
            <i class="fas fa-calendar-check text-blue-400 text-2xl"></i>
            <div>
                <p class="text-gray-400 text-sm">Reservations</p>
                <p class="text-white font-bold text-xl">5</p>
            </div>
        </div>
        <div class="bg-gray-800 p-4 rounded-lg flex items-center gap-3 hover-card">
            <i class="fas fa-credit-card text-green-400 text-2xl"></i>
            <div>
                <p class="text-gray-400 text-sm">Fine Dues</p>
                <p class="text-white font-bold text-xl">$15.00</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-6">
        <h2 class="text-lg font-semibold mb-2">Quick Actions</h2>
        <div class="flex gap-4 flex-wrap">
            <button class="bg-yellow-400 text-black px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-yellow-500 transition">
                <i class="fas fa-book"></i> Borrow a Book
            </button>
            <button class="bg-yellow-400 text-black px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-yellow-500 transition">
                <i class="fas fa-sync-alt"></i> Renew Books
            </button>
            <button class="bg-yellow-400 text-black px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-yellow-500 transition">
                <i class="fas fa-credit-card"></i> Pay Fines
            </button>
        </div>
    </div>

    <!-- Two Column Section -->
    <div class="flex gap-6 flex-cols">
        <!-- Left Column: Borrowed Books + Notifications -->
        <div class="flex-1 space-y-6">
            <!-- Borrowed Books -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-semibold">Borrowed Books</h2>
                    <button class="text-sm text-yellow-400 hover:underline">View More</button>
                </div>
                <div class="scrollable space-y-4">
                    <!-- Borrowed books cards -->
                    <div class="bg-gray-800 p-3 rounded-lg flex items-center gap-3 hover-card">
                        <img src="https://via.placeholder.com/80x120" class="w-20 h-28 object-cover rounded" alt="Borrowed 1">
                        <div>
                            <p class="font-semibold">Book 1</p>
                            <p class="text-gray-400 text-sm">Due: 2025-08-30</p>
                        </div>
                    </div>
                    <div class="bg-gray-800 p-3 rounded-lg flex items-center gap-3 hover-card">
                        <img src="https://via.placeholder.com/80x120" class="w-20 h-28 object-cover rounded" alt="Borrowed 2">
                        <div>
                            <p class="font-semibold">Book 2</p>
                            <p class="text-gray-400 text-sm">Due: 2025-09-02</p>
                        </div>
                    </div>
                    <div class="bg-gray-800 p-3 rounded-lg flex items-center gap-3 hover-card">
                        <img src="https://via.placeholder.com/80x120" class="w-20 h-28 object-cover rounded" alt="Borrowed 3">
                        <div>
                            <p class="font-semibold">Book 3</p>
                            <p class="text-gray-400 text-sm">Due: 2025-09-05</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            <div id="notifications" class="space-y-3">
    <div class="bg-gray-700 p-4 rounded-lg flex items-center justify-between gap-4 hover-card">
        <div class="flex items-center gap-3">
            <i class="fas fa-book text-yellow-400 text-2xl"></i>
            <span class="font-medium">Book 3 is due tomorrow!</span>
        </div>
        <button class="text-red-400 hover:text-red-600" onclick="dismissNotification(this)">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>
    <div class="bg-gray-700 p-4 rounded-lg flex items-center justify-between gap-4 hover-card">
        <div class="flex items-center gap-3">
            <i class="fas fa-credit-card text-green-400 text-2xl"></i>
            <span class="font-medium">Your fine payment was successful.</span>
        </div>
        <button class="text-red-400 hover:text-red-600" onclick="dismissNotification(this)">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>
    <div class="bg-gray-700 p-4 rounded-lg flex items-center justify-between gap-4 hover-card">
        <div class="flex items-center gap-3">
            <i class="fas fa-star text-blue-400 text-2xl"></i>
            <span class="font-medium">New recommended books are available!</span>
        </div>
        <button class="text-red-400 hover:text-red-600" onclick="dismissNotification(this)">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>
</div>

        </div>

        <!-- Right Column: Top Picks + Recommended -->
        <div class="flex-1 space-y-6">
            <!-- Top Picks -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-semibold">Top Picks</h2>
                    <button class="text-sm text-yellow-400 hover:underline">View More</button>
                </div>
                <div class="scrollable grid grid-cols-1 gap-4">
                    <div class="bg-gray-800 p-3 rounded-lg flex items-center gap-3 hover-card">
                        <img src="https://via.placeholder.com/80x120" class="w-20 h-28 object-cover rounded" alt="Top 1">
                        <p>Book Title 1</p>
                    </div>
                    <div class="bg-gray-800 p-3 rounded-lg flex items-center gap-3 hover-card">
                        <img src="https://via.placeholder.com/80x120" class="w-20 h-28 object-cover rounded" alt="Top 2">
                        <p>Book Title 2</p>
                    </div>
                    <div class="bg-gray-800 p-3 rounded-lg flex items-center gap-3 hover-card">
                        <img src="https://via.placeholder.com/80x120" class="w-20 h-28 object-cover rounded" alt="Top 3">
                        <p>Book Title 3</p>
                    </div>
                </div>
            </div>

            <!-- Recommended Books -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-semibold">Recommended Books</h2>
                    <button class="text-sm text-yellow-400 hover:underline">View More</button>
                </div>
                <div class="scrollable grid grid-cols-1 gap-4">
                    <div class="bg-gray-800 p-3 rounded-lg flex items-center gap-3 hover-card">
                        <img src="https://via.placeholder.com/80x120" class="w-20 h-28 object-cover rounded" alt="Rec 1">
                        <p>Book Title A</p>
                    </div>
                    <div class="bg-gray-800 p-3 rounded-lg flex items-center gap-3 hover-card">
                        <img src="https://via.placeholder.com/80x120" class="w-20 h-28 object-cover rounded" alt="Rec 2">
                        <p>Book Title B</p>
                    </div>
                    <div class="bg-gray-800 p-3 rounded-lg flex items-center gap-3 hover-card">
                        <img src="https://via.placeholder.com/80x120" class="w-20 h-28 object-cover rounded" alt="Rec 3">
                        <p>Book Title C</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openNav() {
    document.getElementById("sidebar").classList.add("open");
    document.getElementById("mainContent").classList.add("shift");
    document.getElementById("openBtn").classList.add("hidden");
}
function closeNav() {
    document.getElementById("sidebar").classList.remove("open");
    document.getElementById("mainContent").classList.remove("shift");
    document.getElementById("openBtn").classList.remove("hidden");
}
function dismissNotification(button) {
    button.parentElement.remove();
}
</script>

</body>
</html>
