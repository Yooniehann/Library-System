<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Kid Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body { background: #0f172a; color: #fff; font-family: 'Open Sans', sans-serif; }

/* Colors */
.bg-primary-orange { background-color: #FFB347; } /* brighter, warmer */
.bg-dark-orange { background-color: #FF9F1C; }    /* vibrant accent */
.text-primary-orange { color: #FFB347; }
.text-dark-orange { color: #FF9F1C; }
.border-primary-orange { border-color: #FFB347; }
.bg-slate-900 { background-color: #0f172a; }
.bg-slate-800 { background-color: #1e293b; }
.bg-slate-700 { background-color: #334155; }

/* Sidebar */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    height: 100%;
    background: #111827;
    padding-top: 60px;
    transition: transform .3s ease;
    transform: translateX(-100%);
    z-index: 1000;
    overflow-y: auto;
    scrollbar-width: none;
    box-shadow: 3px 0 15px rgba(0,0,0,0.5);
    border-right: 1px solid #2d2d2d;
}
.sidebar::-webkit-scrollbar { display: none; }
.sidebar.open { transform: translateX(0); }

/* Sidebar Links */
.sidebar ul { list-style: none; padding: 0 0 20px 0; margin: 0; }
.sidebar ul li {
    padding: 14px 20px;
    font-size: 1rem;
    color: #FFD369; /* default text color */
    display: flex;
    align-items: center;
    gap: 14px;
    border-radius: 0.5rem;
    transition: background .3s, color .3s, transform .2s ease;
    cursor: pointer;
    margin: 4px 10px;
}

/* Hover effect for all links */
.sidebar ul li:hover {
    background: #FF9F1C; /* bright hover background */
    color: #111827;       /* text color on hover */
}
.sidebar ul li:hover i {
    color: #111827;       /* icon color on hover */
}

/* Remove permanent active effect completely */
.sidebar ul li.active {
    background: transparent; /* no highlight */
    color: #FFD369;          /* keep default text color */
}



/* Close/Open Buttons */
.close-btn {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 1.5rem;
    color: #FFB347;
    background: none;
    border: none;
}
.open-btn {
    font-size: 1.5rem;
    color: #FFB347;
    background: none;
    border: none;
    margin-right: 15px;
    transition: opacity .3s;
}
.open-btn.hidden { opacity: 0; pointer-events: none; }

/* Main Content */
.content { margin-left: 0; padding: 20px; transition: margin-left .3s ease; }
.content.shift { margin-left: 250px; }
.header { display: flex; align-items: center; font-size: 1.5rem; margin-bottom: 20px; color: #FFB347; }

/* Page Sections */
.page-section { display: none; animation: fade .25s ease; }
.page-section.active { display: block; }
@keyframes fade { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }

/* Cards & Tables */
.hover-card { transition: transform .3s, box-shadow .3s; cursor: pointer; border-radius: 12px; }
.hover-card:hover { transform: translateY(-5px) scale(1.02); box-shadow: 0 6px 18px rgba(0,0,0,.5); }
input.input, textarea.input { background: #1e293b; border: 1px solid #2d2d2d; border-radius: 8px; padding: 10px; color: #fff; width: 100%; }
table th, table td { white-space: nowrap; }

/* Toasts */
.toast { position: fixed; right: 16px; bottom: 16px; background: #1f2937; border: 1px solid #2a2a2a; padding: 12px 14px; border-radius: 10px; color: #fff; z-index: 1200; display: none; }
.toast.show { display: block; }


/* General card hover effect */
.hover-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.4);
    transition: all 0.3s ease;
}

/* Dashboard Two-Column Layout */
.dashboard-grid {
    display: grid;
    grid-template-columns: 1fr 1fr; /* left and right columns */
    gap: 2rem;
}
@media (max-width: 1024px) {
    .dashboard-grid {
        grid-template-columns: 1fr; /* stack on smaller screens */
    }
}

/* Left & Right Sections */
.dashboard-left, .dashboard-right {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Dashboard Cards */
.dashboard-card {
    background-color: #1e293b; /* slate-800 */
    padding: 0.5rem;
    border-radius: 0.5rem;
    transition: transform 0.3s, box-shadow 0.3s;
}
.dashboard-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.5);
}

/* Book Image */
.dashboard-card img {
    width: 100%;
    height: 10rem; /* smaller cover */
    object-fit: cover;
    border-radius: 0.5rem;
    margin-bottom: 0.5rem;
}

/* Book Info */
.book-title {
    font-weight: 600;
    font-size: 0.9rem;
    color: #fff;
}
.book-author {
    font-size: 0.75rem;
    color: #9ca3af;
}
.borrow-due {
    font-size: 0.7rem;
    color: #facc15; /* yellow accent for due date */
}

/* Notifications */
.notification-card {
    background-color: #1e293b;
    padding: 0.75rem;
    border-radius: 0.5rem;
    margin-bottom: 0.5rem;
    border-left: 3px solid #FFD369;
}
.notification-card p {
    margin: 0.125rem 0;
}
.notification-card .time {
    color: #9ca3af;
    font-size: 0.7rem;
}
.notification-card .message {
    color: #fff;
    font-size: 0.85rem;
}

</style>


</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <!-- Close Button -->
    <button class="close-btn" onclick="closeNav()"><i class="fas fa-times"></i></button>

    <!-- Logo -->
    <a href="{{ url('/') }}" class="flex items-center justify-center h-16 px-4 mb-6 bg-black">
        <i class="fas fa-book text-primary-orange text-2xl mr-2"></i>
        <span class="text-primary-orange font-bold text-xl">Library</span>
    </a>

    <!-- Navigation -->
    <ul id="navList" class="space-y-1">
       <li data-section="dashboard" class="flex items-center px-4 py-3 text-sm font-medium text-yellow-400 rounded-lg">
    <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
</li>

        <li onclick="window.location='{{ url('/books') }}'" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
            <i class="fas fa-home mr-3"></i> Home
        </li>
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


        <li onclick="window.location='{{ route('kid.kidnoti.index') }}'" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
            <i class="fas fa-book-open mr-3"></i> Notifications </li>
              <li onclick="location.href='{{ route('kid.kidcontact.index') }}'"><i class="fas fa-envelope"></i> Contact Librarian</li>

                      <li onclick="location.href='{{ route('kid.kidprofile.index') }}'">
    <i class="fas fa-user-cog"></i> Profile Setting
</li>

        <li id="logoutNav" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
            <i class="fas fa-sign-out-alt mr-3"></i> Logout
        </li>
    </ul>
</div>


<!-- Main Content -->
<div class="content" id="mainContent">
  <div class="header">
    <button class="open-btn" id="openBtn" onclick="openNav()"><i class="fas fa-bars"></i></button>
    <span>Welcome to Kid Dashboard</span>
  </div>

<!-- Dashboard -->
<section id="section-dashboard" class="page-section active">
  <h1 class="text-2xl font-semibold mb-4">
    Hello, <span class="text-yellow-400">{{ $user->fullname ?? '' }}</span>!
  </h1>
  <p class="text-gray-400 mb-6">Check your reading activities and fines today.</p>

  <!-- Summary Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-slate-800 p-4 rounded-lg flex items-center gap-3 hover-card">
      <i class="fas fa-book text-yellow-400 text-2xl"></i>
      <div>
        <p class="text-gray-400 text-sm">Borrowed Books</p>
        <p class="text-white font-bold text-xl">{{ $borrowedCount ?? 0 }}</p>
      </div>
    </div>
    <div class="bg-slate-800 p-4 rounded-lg flex items-center gap-3 hover-card">
      <i class="fas fa-exclamation-circle text-red-500 text-2xl"></i>
      <div>
        <p class="text-gray-400 text-sm">Overdue Books</p>
        <p class="text-white font-bold text-xl">{{ $overdueCount ?? 0 }}</p>
      </div>
    </div>
    <div class="bg-slate-800 p-4 rounded-lg flex items-center gap-3 hover-card">
      <i class="fas fa-credit-card text-green-400 text-2xl"></i>
      <div>
        <p class="text-gray-400 text-sm">Fines</p>
        <p class="text-white font-bold text-xl">${{ $finesTotal ?? '0.00' }}</p>
      </div>
    </div>
  </div>

  <!-- Two-Column Dashboard Layout -->
  <div class="dashboard-grid gap-6">

    <!-- Left Column: Recommended + Top Picks -->
    <div class="dashboard-left flex flex-col gap-6">

      <!-- Recommended Books -->
      <div>
        <h2 class="text-xl font-semibold text-white mb-2">Recommended Books</h2>
        <div class="flex gap-4 overflow-x-auto pb-2">
          @foreach($recommendedBooks as $book)
            <div class="dashboard-card flex-shrink-0 w-40">
              <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://via.placeholder.com/128x192/1e293b/ffffff?text=No+Cover' }}"
                   alt="{{ $book->title }}">
              <p class="book-title">{{ $book->title }}</p>
              <p class="book-author">by {{ $book->author->fullname ?? 'Unknown' }}</p>
            </div>
          @endforeach
        </div>
      </div>

      <!-- Top Picks -->
      <div>
        <h2 class="text-xl font-semibold text-white mb-2">Top Picks</h2>
        <div class="flex gap-4 overflow-x-auto pb-2">
          @foreach($topPicks as $book)
            <div class="dashboard-card flex-shrink-0 w-40">
              <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://via.placeholder.com/128x192/1e293b/ffffff?text=No+Cover' }}"
                   alt="{{ $book->title }}">
              <p class="book-title">{{ $book->title }}</p>
              <p class="book-author">by {{ $book->author->fullname ?? 'Unknown' }}</p>
              <p class="borrow-due text-yellow-400">Borrowed {{ $book->borrow_count ?? 0 }} times</p>
            </div>
          @endforeach
        </div>
      </div>

    </div>

    <!-- Right Column: My Borrowed Books + Notifications -->
    <div class="dashboard-right flex flex-col gap-6">

      <!-- My Borrowed Books -->
      <div>
        <h2 class="text-xl font-semibold text-white mb-2">My Borrowed Books</h2>
        <div class="flex gap-4 overflow-x-auto pb-2">
          @foreach($myBorrowedBooks as $borrow)
            <div class="dashboard-card flex-shrink-0 w-40">
              <img src="{{ $borrow->inventory->book->cover_image ? asset('storage/' . $borrow->inventory->book->cover_image) : 'https://via.placeholder.com/128x192/1e293b/ffffff?text=No+Cover' }}"
                   alt="{{ $borrow->inventory->book->title }}">
              <p class="book-title">{{ $borrow->inventory->book->title }}</p>
              <p class="book-author">by {{ $borrow->inventory->book->author->fullname ?? 'Unknown' }}</p>
              <p class="borrow-due">Due: {{ $borrow->due_date->format('M d, Y') }}</p>
            </div>
          @endforeach
        </div>
      </div>

      <!-- Notifications -->
      <div>
        <h2 class="text-xl font-semibold text-white mb-2">Latest Notifications</h2>
        <div class="flex flex-col gap-2">
          @forelse($notifications as $note)
            <div class="notification-card">
              <p class="time">{{ $note->created_at->format('M d, Y H:i') }}</p>
              <p class="message">{{ $note->message }}</p>
            </div>
          @empty
            <p class="text-gray-400 text-sm">No notifications yet.</p>
          @endforelse
        </div>
      </div>

    </div>

  </div>
</section>

<form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>

<div id="toast" class="toast"></div>

<script>
function openNav(){ document.getElementById('sidebar').classList.add('open'); document.getElementById('mainContent').classList.add('shift'); document.getElementById('openBtn').classList.add('hidden'); }
function closeNav(){ document.getElementById('sidebar').classList.remove('open'); document.getElementById('mainContent').classList.remove('shift'); document.getElementById('openBtn').classList.remove('hidden'); }
function goto(section){ location.hash=section; showSection(section); }
function showSection(section){ document.querySelectorAll('.page-section').forEach(s=>s.classList.remove('active')); const el=document.getElementById('section-'+section); if(el) el.classList.add('active'); if(innerWidth<1024) closeNav(); }
document.getElementById('navList').addEventListener('click', e=>{
  const li=e.target.closest('li');
  if(!li) return;
  if(li.id==='logoutNav'){ if(confirm('Logout?')) document.getElementById('logoutForm').submit(); return; }
  const sec=li.dataset.section;
  if(sec) goto(sec);
});
window.onload = function(){ if(location.hash){ showSection(location.hash.replace('#','')); } }

function renewBook(id){ alert('Renew book id: '+id); }
</script>
<script>
const navItems = document.querySelectorAll('.sidebar ul li');

navItems.forEach(item => {
    item.addEventListener('click', () => {
        // Remove 'selected' class from all items
        navItems.forEach(i => i.classList.remove('selected'));
        // Add 'selected' class to clicked item
        item.classList.add('selected');
    });
});
</script>
</body>
</html>

