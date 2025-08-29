<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Notifications | Library System</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body { background: #0f172a; color: #fff; font-family: 'Open Sans', sans-serif; }
h1, h2 { color: #FFD369; }

/* Sidebar */
.sidebar {
    position: fixed;
    top: 0; left: 0;
    width: 250px; height: 100%;
    background: #111827;
    padding-top: 60px;
    z-index: 1000;
    overflow-y: auto;
    scrollbar-width: none;
    box-shadow: 3px 0 15px rgba(0,0,0,0.5);
    border-right: 1px solid #2d2d2d;
    transition: transform 0.3s ease;
}
.sidebar::-webkit-scrollbar { display: none; }
.sidebar ul { list-style: none; padding: 0; margin: 0; }
.sidebar ul li {
    padding: 14px 20px; font-size: 1rem;
    color: #FFD369; display: flex; align-items: center; gap: 14px;
    border-radius: 0.5rem; cursor: pointer; margin: 4px 10px;
    transition: background .3s, color .3s;
}
.sidebar ul li:hover { background: #FF9F1C; color: #111827; }
.sidebar ul li:hover i { color: #111827; }
.sidebar ul li.selected { background: #FF9F1C; color: #111827; }
.sidebar ul li.selected i { color: #111827; }

/* Close button inside sidebar */
.close-btn {
    position: fixed; /* Fix the button always visible */
    top: 16px;
    left: 210px; /* inside sidebar area */
    background: transparent;
    border: none;
    color: #FFD369;
    font-size: 1.25rem;
    cursor: pointer;
    z-index: 1100;
}

/* Main Content */
.main-content { margin-left: 250px; padding: 24px; transition: margin-left 0.3s ease; }

/* Flex header for hamburger + title */
.flex-header { display: flex; align-items: center; gap: 16px; margin-bottom: 1.5rem; }
.open-btn { font-size: 1.5rem; color: #FFB347; background: none; border: none; cursor: pointer; }

/* Notification cards */
.notification-card { background: #1e293b; border-radius: 12px; padding: 16px; margin-bottom: 12px; transition: background 0.2s; }
.notification-card:hover { background: #334155; }
.status-badge { padding: 2px 6px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
.bg-borrow { background: #2563eb; color: #fff; }
.bg-fine { background: #dc2626; color: #fff; }
.bg-reservation { background: #f59e0b; color: #111827; }

/* Responsive adjustments */
@media (max-width: 768px) {
    .main-content { margin-left: 0; }
    .close-btn { left: 180px; } /* Adjust close button inside smaller sidebar */
}
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <button class="close-btn" onclick="closeNav()"><i class="fas fa-times"></i></button>
    <div class="flex items-center justify-center h-16 px-4 bg-black">
        <span class="text-primary-orange text-xl font-bold">Kid Dashboard</span>
    </div>
    <ul>
        <li onclick="location.href='{{ route('kid.dashboard') }}'"><i class="fas fa-tachometer-alt"></i> Dashboard</li>
        <li onclick="location.href='{{ url('/books') }}'"><i class="fas fa-home"></i> Home</li>

        <li onclick="window.location='{{ route('kid.kidfinepay.index') }}'"
    class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
    <i class="fas fa-credit-card mr-3"></i> Fines & Payments
</li>


        <li onclick="window.location='{{ route('kid.kidborrowed.index') }}'" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
            <i class="fas fa-book-open mr-3"></i> My Books
        </li>
       <li onclick="window.location='{{ route('kid.kidreservation.index') }}'" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
    <i class="fas fa-calendar-check mr-3"></i> Reservations
</li>


        <li class="selected" onclick="location.href='{{ route('kid.kidnoti.index') }}'"><i class="fas fa-bell"></i> Notifications</li>
        <li onclick="window.location='{{ route('kid.kidcontact.index') }}'" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
            <i class="fas fa-book-open mr-3"></i> Contact </li>
       <li onclick="location.href='{{ route('kid.kidprofile.index') }}'">
    <i class="fas fa-user-cog"></i> Profile Setting
</li>

        <li>
            <form action="{{ route('logout') }}" method="POST">@csrf
                <button type="submit" class="flex items-center gap-2 w-full"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </li>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content" id="mainContent">
    <div class="flex-header">
        <button class="open-btn" id="openBtn" onclick="openNav()"><i class="fas fa-bars"></i></button>
        <h1 class="text-2xl font-bold">Notifications</h1>
    </div>

    @if($notifications->isEmpty())
        <div class="bg-slate-800 rounded-lg shadow p-6 text-center mt-6">
            <i class="fas fa-bell-slash text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-lg font-medium text-white mb-2">No notifications</h3>
            <p class="text-gray-400 mb-4">You currently have no notifications.</p>
            <a href="{{ url('/books') }}" class="bg-primary-orange text-black px-4 py-2 rounded-lg hover:bg-dark-orange transition-colors">
                Browse Books
            </a>
        </div>
    @else
        <div class="mt-6 space-y-4">
        @foreach($notifications as $notification)
            @php
                switch($notification->notif_type) {
                    case 'borrow_due':
                        $typeClass = 'bg-yellow-500 text-black';
                        $typeLabel = 'Due Soon';
                        break;
                    case 'fine':
                        $typeClass = 'bg-red-500 text-white';
                        $typeLabel = 'Unpaid Fine';
                        break;
                    case 'reservation':
                        $typeClass = 'bg-green-500 text-white';
                        $typeLabel = 'Ready for Pickup';
                        break;
                    default:
                        $typeClass = 'bg-gray-500 text-white';
                        $typeLabel = 'Notification';
                }
            @endphp

            <div class="notification-card flex justify-between items-center bg-slate-800 rounded-lg shadow p-4">
                <div>
                    <div class="font-semibold text-white">{{ $typeLabel }}</div>
                    <div class="text-gray-300 text-sm">{{ $notification->notif_message }}</div>
                    <div class="text-gray-500 text-xs mt-1">{{ $notification->notif_date->format('M d, Y') }}</div>
                </div>
                <span class="status-badge px-2 py-1 rounded {{ $typeClass }}">{{ $typeLabel }}</span>
            </div>
        @endforeach
        </div>
    @endif
</div>


<form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>

<div id="toast" class="toast"></div>

<!-- Logout Confirmation Modal -->
<div id="logoutModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
  <div class="bg-[#0f172a] text-white rounded-2xl shadow-2xl p-6 w-80 transform scale-95 transition-all duration-200" id="logoutCard" style="background-color:#0f172a; opacity:1;">
    <h2 class="text-xl font-bold text-yellow-400 mb-4 flex items-center justify-center gap-2">
      <i class="fas fa-sign-out-alt"></i> Confirm Logout
    </h2>
    <p class="text-gray-300 mb-6 text-sm">Are you sure you want to log out of your account?</p>
    <div class="flex justify-center gap-4">
      <button id="confirmLogout" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow">
        Yes
      </button>
      <button id="cancelLogout" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow">
        Cancel
      </button>
    </div>
  </div>
</div>

<script>
const logoutBtn = document.getElementById("logoutNav");
const logoutModal = document.getElementById("logoutModal");
const confirmLogout = document.getElementById("confirmLogout");
const cancelLogout = document.getElementById("cancelLogout");
const logoutForm = document.getElementById("logoutForm");
const logoutCard = document.getElementById("logoutCard");

logoutBtn.addEventListener("click", () => {
  logoutModal.classList.remove("hidden");
  setTimeout(() => {
    logoutCard.classList.remove("scale-95");
    logoutCard.classList.add("scale-100");
  }, 10);
});

confirmLogout.addEventListener("click", () => {
  logoutForm.submit();
});

cancelLogout.addEventListener("click", () => {
  logoutModal.classList.add("hidden");
});

logoutModal.addEventListener("click", (e) => {
  if (e.target === logoutModal) {
    logoutModal.classList.add("hidden");
  }
});
</script>
<script>
const sidebar = document.getElementById('sidebar');
const openBtn = document.getElementById('openBtn');
const mainContent = document.getElementById('mainContent');

function closeNav() {
    sidebar.style.transform = 'translateX(-100%)';
    openBtn.style.display = 'flex';
    mainContent.style.marginLeft = '0';
}

function openNav() {
    sidebar.style.transform = 'translateX(0)';
    openBtn.style.display = 'none';
    mainContent.style.marginLeft = '250px';
}

window.addEventListener('DOMContentLoaded', () => {
    if(window.innerWidth >= 768){
        sidebar.style.transform = 'translateX(0)';
        openBtn.style.display = 'none';
        mainContent.style.marginLeft = '250px';
    } else {
        sidebar.style.transform = 'translateX(-100%)';
        openBtn.style.display = 'flex';
        mainContent.style.marginLeft = '0';
    }
});

window.addEventListener('resize', () => {
    if(window.innerWidth >= 768){
        sidebar.style.transform = 'translateX(0)';
        openBtn.style.display = 'none';
        mainContent.style.marginLeft = '250px';
    } else {
        sidebar.style.transform = 'translateX(-100%)';
        openBtn.style.display = 'flex';
        mainContent.style.marginLeft = '0';
    }
});
</script>
</body>
</html>
