<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Kid Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
  body{margin:0;font-family:'Open Sans',sans-serif;background:#000;color:#fff}
  /* Sidebar */
  .sidebar{position:fixed;top:0;left:0;width:250px;height:100%;background:#000;padding-top:60px;transition:transform .3s ease;transform:translateX(-100%);z-index:1000;overflow-y:auto;scrollbar-width:none}
  .sidebar::-webkit-scrollbar{display:none}
  .sidebar.open{transform:translateX(0)}
  .sidebar ul{list-style:none;padding:0 0 20px 0;margin:0}
  .sidebar ul li{padding:15px 25px;font-size:1rem;color:#EEBA30;display:flex;align-items:center;gap:12px;transition:background .3s,color .3s}
  .sidebar ul li:hover,.sidebar ul li.active{background:#D3A625;color:#000}
  .sidebar ul li:hover i,.sidebar ul li.active i{color:#000}
  .close-btn{position:absolute;top:15px;right:20px;font-size:1.5rem;color:#EEBA30;background:none;border:none}
  .open-btn{font-size:1.5rem;color:#EEBA30;background:none;border:none;margin-right:15px;transition:opacity .3s}
  .open-btn.hidden{opacity:0;pointer-events:none}
  .content{margin-left:0;padding:20px;transition:margin-left .3s ease}
  .content.shift{margin-left:250px}
  .header{display:flex;align-items:center;font-size:1.5rem;margin-bottom:20px;color:#EEBA30}
  .scrollable{max-height:400px;overflow-y:auto}
  .scrollable::-webkit-scrollbar{display:none}
  .hover-card{transition:transform .3s;cursor:pointer}
  .hover-card:hover{transform:translateY(-5px) scale(1.03)}
  .hover-card img{transition:transform .3s}
  .hover-card:hover img{transform:scale(1.05)}
  button,.sidebar ul li,.hover-card,.hover-card img{cursor:pointer}
  @media (max-width:1024px){.flex-cols{flex-direction:column}}
  /* Logo */
  .logo{display:flex;align-items:center;gap:8px;padding:5px 10px;text-decoration:none;transition:transform .2s ease,filter .2s ease;cursor:pointer}
  .logo:hover{transform:scale(1.1);filter:brightness(1.2)}
  .logo-icon{width:32px;height:32px;color:#FBBF24;transition:transform .3s ease}
  .logo:hover .logo-icon{transform:rotate(15deg) scale(1.2)}
  .logo-text{font-size:1.25rem;font-weight:bold;color:#FBBF24;transition:letter-spacing .3s ease}
  .logo:hover .logo-text{letter-spacing:1px}
  /* Sections */
  .page-section{display:none;animation:fade .25s ease}
  .page-section.active{display:block}
  @keyframes fade{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}
  /* Badges */
  .badge{border:2px dashed #D3A625;border-radius:12px;padding:12px;display:flex;gap:12px;align-items:center}
  .badge.locked{opacity:.5;filter:grayscale(100%)}
  /* Modal */
  .modal{position:fixed;inset:0;background:rgba(0,0,0,.7);display:none;align-items:center;justify-content:center;z-index:1100}
  .modal.open{display:flex}
  .modal-card{background:#111;color:#fff;border:1px solid #333;border-radius:12px;padding:18px;width:95%;max-width:520px;box-shadow:0 10px 30px rgba(0,0,0,.4)}
  .input{background:#0b0b0b;border:1px solid #2d2d2d;border-radius:8px;padding:10px;color:#fff;width:100%}
  .pill{background:#0e0e0e;border:1px solid #2a2a2a;border-radius:999px;padding:.35rem .75rem;display:inline-flex;gap:8px;align-items:center}
  .table{width:100%;border-collapse:collapse}
  .table th,.table td{border-bottom:1px solid #1f1f1f;padding:10px}
  .table th{color:#EEBA30;font-weight:600;text-align:left}
  .toast{position:fixed;right:16px;bottom:16px;background:#0f0f0f;border:1px solid #2a2a2a;padding:12px 14px;border-radius:10px;color:#fff;z-index:1200;display:none}
  .toast.show{display:block}
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <button class="close-btn" onclick="closeNav()"><i class="fas fa-times"></i></button>
  <a href="{{ url('/') }}" class="logo">
    <svg xmlns="http://www.w3.org/2000/svg" class="logo-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
    </svg>
    <span class="logo-text">Library</span>
  </a>
  <ul id="navList">
    <li data-section="dashboard" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</li>
    <li data-section="search"><i class="fas fa-book"></i> Search Books</li>
    <li data-section="reservations"><i class="fas fa-calendar-check"></i> My Reservations</li>
    <li data-section="fines"><i class="fas fa-credit-card"></i> Fines & Payments</li>
    <li data-section="history"><i class="fas fa-history"></i> Reading History</li>
    <li data-section="achievements"><i class="fas fa-trophy"></i> Achievements & Progress</li>
    <li data-section="notifications"><i class="fas fa-bell"></i> Notifications</li>
    <li data-section="contact"><i class="fas fa-envelope"></i> Contact Librarian</li>
    <li data-section="profile"><i class="fas fa-user-cog"></i> Profile Settings</li>
    <li id="logoutNav"><i class="fas fa-sign-out-alt"></i> Logout</li>
  </ul>
</div>

<!-- Main -->
<div class="content" id="mainContent">
  <div class="header">
    <button class="open-btn" id="openBtn" onclick="openNav()"><i class="fas fa-bars"></i></button>
    <span>Welcome to Kid Dashboard</span>
  </div>

  <!-- Dashboard -->
  <section id="section-dashboard" class="page-section active">
    <div class="mb-6">
      <h1 class="text-2xl font-semibold">Welcome back, <span id="welcomeName" class="text-yellow-400">Username</span></h1>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      <div class="bg-gray-800 p-4 rounded-lg flex items-center gap-3 hover-card">
        <i class="fas fa-book text-yellow-400 text-2xl"></i>
        <div>
          <p class="text-gray-400 text-sm">Borrowed Books</p>
          <p id="statBorrowed" class="text-white font-bold text-xl">0</p>
        </div>
      </div>
      <div class="bg-gray-800 p-4 rounded-lg flex items-center gap-3 hover-card">
        <i class="fas fa-exclamation-circle text-red-500 text-2xl"></i>
        <div>
          <p class="text-gray-400 text-sm">Overdue Books</p>
          <p id="statOverdue" class="text-white font-bold text-xl">0</p>
        </div>
      </div>
      <div class="bg-gray-800 p-4 rounded-lg flex items-center gap-3 hover-card">
        <i class="fas fa-calendar-check text-blue-400 text-2xl"></i>
        <div>
          <p class="text-gray-400 text-sm">Reservations</p>
          <p id="statReservations" class="text-white font-bold text-xl">0</p>
        </div>
      </div>
      <div class="bg-gray-800 p-4 rounded-lg flex items-center gap-3 hover-card">
        <i class="fas fa-credit-card text-green-400 text-2xl"></i>
        <div>
          <p class="text-gray-400 text-sm">Fine Dues</p>
          <p id="statFines" class="text-white font-bold text-xl">$0.00</p>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-6">
      <h2 class="text-lg font-semibold mb-2">Quick Actions</h2>
      <div class="flex gap-4 flex-wrap">
        <button onclick="goto('search')" class="bg-yellow-400 text-black px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-yellow-500 transition"><i class="fas fa-book"></i> Borrow a Book</button>
        <button onclick="renewAll()" class="bg-yellow-400 text-black px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-yellow-500 transition"><i class="fas fa-sync-alt"></i> Renew Books</button>
        <button onclick="goto('fines')" class="bg-yellow-400 text-black px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-yellow-500 transition"><i class="fas fa-credit-card"></i> Pay Fines</button>
      </div>
    </div>

    <!-- Two Columns -->
    <div class="flex gap-6 flex-cols">
      <!-- Left: Borrowed + Notifications -->
      <div class="flex-1 space-y-6">
        <div>
          <div class="flex justify-between items-center mb-2">
            <h2 class="text-lg font-semibold">Borrowed Books</h2>
            <button onclick="goto('history')" class="text-sm text-yellow-400 hover:underline">View More</button>
          </div>
          <div id="borrowedList" class="scrollable space-y-4"></div>
        </div>

        <div>
          <div class="flex justify-between items-center mb-2">
            <h2 class="text-lg font-semibold">Notifications</h2>
            <button onclick="goto('notifications')" class="text-sm text-yellow-400 hover:underline">Open Center</button>
          </div>
          <div id="homeNotifications" class="space-y-3"></div>
        </div>
      </div>

      <!-- Right: Top Picks + Recommended -->
      <div class="flex-1 space-y-6">
        <div>
          <div class="flex justify-between items-center mb-2">
            <h2 class="text-lg font-semibold">Top Picks</h2>
            <button onclick="goto('search')" class="text-sm text-yellow-400 hover:underline">View More</button>
          </div>
          <div id="topPicks" class="scrollable grid grid-cols-1 gap-4"></div>
        </div>

        <div>
          <div class="flex justify-between items-center mb-2">
            <h2 class="text-lg font-semibold">Recommended Books</h2>
            <button onclick="goto('search')" class="text-sm text-yellow-400 hover:underline">View More</button>
          </div>
          <div id="recommended" class="scrollable grid grid-cols-1 gap-4"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- Search Books -->
  <section id="section-search" class="page-section">
    <h2 class="text-xl font-semibold mb-4"><i class="fas fa-search mr-2 text-yellow-400"></i>Search Books</h2>
    <div class="grid md:grid-cols-3 gap-3 mb-4">
      <input id="searchQuery" class="input" placeholder="Search by title or author…" />
      <select id="filterCategory" class="input">
        <option value="">All Categories</option>
        <option>Fiction</option><option>Adventure</option><option>Fantasy</option><option>Science</option>
      </select>
      <select id="filterStatus" class="input">
        <option value="">All Status</option>
        <option value="available">Available</option>
        <option value="borrowed">Borrowed</option>
      </select>
    </div>
    <div id="searchResults" class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4"></div>
    <p id="noResults" class="text-gray-400 mt-4 hidden">No books found. Try a different search.</p>
  </section>

  <!-- Reservations -->
  <section id="section-reservations" class="page-section">
    <div class="flex items-center justify-between mb-3">
      <h2 class="text-xl font-semibold"><i class="fas fa-calendar-check mr-2 text-yellow-400"></i>My Reservations</h2>
      <button onclick="clearExpiredReservations()" class="pill text-sm"><i class="fa-solid fa-broom"></i> Clear expired</button>
    </div>
    <table class="table">
      <thead><tr><th>Book</th><th>Reserved On</th><th>Expires</th><th>Status</th><th>Action</th></tr></thead>
      <tbody id="reservationRows"></tbody>
    </table>
  </section>

  <!-- Fines & Payments -->
  <section id="section-fines" class="page-section">
    <div class="flex items-center justify-between mb-3">
      <h2 class="text-xl font-semibold"><i class="fas fa-credit-card mr-2 text-yellow-400"></i>Fines & Payments</h2>
      <div class="pill"><i class="fa-solid fa-sack-dollar text-green-400"></i> <span>Total Due:&nbsp;<b id="totalDue">$0.00</b></span></div>
    </div>
    <table class="table">
      <thead><tr><th>Reason</th><th>Issued</th><th>Amount</th><th>Status</th><th>Action</th></tr></thead>
      <tbody id="fineRows"></tbody>
    </table>
    <div class="mt-4">
      <button id="paySelectedBtn" class="bg-yellow-400 text-black px-4 py-2 rounded-lg hover:bg-yellow-500 transition disabled:opacity-40" disabled>
        <i class="fa-solid fa-wallet mr-1"></i> Pay Selected
      </button>
    </div>
  </section>

  <!-- Reading History -->
  <section id="section-history" class="page-section">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
      <h2 class="text-xl font-semibold"><i class="fas fa-history mr-2 text-yellow-400"></i>Reading History</h2>
      <div class="flex gap-2">
        <select id="historyRange" class="input">
          <option value="all">All Time</option>
          <option value="30">Last 30 days</option>
          <option value="90">Last 90 days</option>
          <option value="365">Last Year</option>
        </select>
        <button onclick="exportHistoryCSV()" class="pill text-sm"><i class="fa-solid fa-file-export"></i> Export CSV</button>
      </div>
    </div>
    <table class="table">
      <thead><tr><th>Book</th><th>Borrowed</th><th>Returned</th><th>Pages</th></tr></thead>
      <tbody id="historyRows"></tbody>
    </table>
  </section>

  <!-- Achievements -->
  <section id="section-achievements" class="page-section">
    <h2 class="text-xl font-semibold mb-4"><i class="fas fa-trophy mr-2 text-yellow-400"></i>Achievements & Progress</h2>
    <div class="grid md:grid-cols-2 gap-4">
      <div class="bg-gray-800 p-4 rounded-lg">
        <h3 class="font-semibold mb-2 text-yellow-400">Reading Streak</h3>
        <div class="w-full bg-gray-900 rounded-full h-3">
          <div id="streakBar" class="bg-yellow-400 h-3 rounded-full" style="width:0%"></div>
        </div>
        <p id="streakText" class="mt-2 text-sm text-gray-300">0-day streak</p>
      </div>
      <div class="bg-gray-800 p-4 rounded-lg">
        <h3 class="font-semibold mb-2 text-yellow-400">Pages Read</h3>
        <div class="w-full bg-gray-900 rounded-full h-3">
          <div id="pagesBar" class="bg-yellow-400 h-3 rounded-full" style="width:0%"></div>
        </div>
        <p id="pagesText" class="mt-2 text-sm text-gray-300">0 / 1000 pages</p>
      </div>
    </div>
    <h3 class="mt-6 mb-2 font-semibold text-yellow-400">Badges</h3>
    <div id="badgeGrid" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3"></div>
  </section>

  <!-- Notifications Center -->
  <section id="section-notifications" class="page-section">
    <div class="flex items-center justify-between mb-3">
      <h2 class="text-xl font-semibold"><i class="fas fa-bell mr-2 text-yellow-400"></i>Notifications</h2>
      <div class="flex gap-2">
        <button onclick="markAllRead()" class="pill text-sm"><i class="fa-solid fa-check-double"></i> Mark all read</button>
        <button onclick="clearAllNotifications()" class="pill text-sm"><i class="fa-solid fa-trash"></i> Clear all</button>
      </div>
    </div>
    <div id="notifList" class="space-y-3"></div>
  </section>

  <!-- Contact Librarian -->
  <section id="section-contact" class="page-section">
    <h2 class="text-xl font-semibold mb-4"><i class="fas fa-envelope mr-2 text-yellow-400"></i>Contact Librarian</h2>
    <form id="contactForm" class="grid md:grid-cols-2 gap-4 max-w-3xl">
      <div>
        <label class="text-sm text-gray-300">Your Name</label>
        <input id="contactName" class="input" placeholder="Your name"/>
      </div>
      <div>
        <label class="text-sm text-gray-300">Email</label>
        <input id="contactEmail" type="email" class="input" placeholder="you@example.com"/>
      </div>
      <div class="md:col-span-2">
        <label class="text-sm text-gray-300">Topic</label>
        <select id="contactTopic" class="input">
          <option>General</option><option>Borrowing</option><option>Fines</option><option>Technical</option>
        </select>
      </div>
      <div class="md:col-span-2">
        <label class="text-sm text-gray-300">Message</label>
        <textarea id="contactMsg" class="input" rows="5" placeholder="Type your message…"></textarea>
      </div>
      <div class="md:col-span-2 flex gap-3">
        <button type="submit" class="bg-yellow-400 text-black px-4 py-2 rounded-lg hover:bg-yellow-500 transition"><i class="fa-solid fa-paper-plane mr-1"></i> Send</button>
        <span id="contactStatus" class="text-sm text-green-400 hidden">Sent! We'll reply soon.</span>
      </div>
    </form>
  </section>

  <!-- Profile Settings -->
  <section id="section-profile" class="page-section">
    <h2 class="text-xl font-semibold mb-4"><i class="fas fa-user-cog mr-2 text-yellow-400"></i>Profile Settings</h2>
    <div class="grid lg:grid-cols-3 gap-6">
      <div class="bg-gray-800 p-4 rounded-lg">
        <h3 class="font-semibold mb-3">Avatar</h3>
        <img id="avatarPreview" src="https://i.pravatar.cc/160?img=14" class="w-32 h-32 object-cover rounded-full border border-gray-700 mb-3" alt="Avatar"/>
        <input id="avatarInput" type="file" accept="image/*" class="input"/>
      </div>
      <div class="bg-gray-800 p-4 rounded-lg lg:col-span-2">
        <h3 class="font-semibold mb-3">Account</h3>
        <div class="grid md:grid-cols-2 gap-3">
          <div>
            <label class="text-sm text-gray-300">Username</label>
            <input id="profName" class="input" placeholder="Your name"/>
          </div>
          <div>
            <label class="text-sm text-gray-300">Email</label>
            <input id="profEmail" type="email" class="input" placeholder="you@example.com"/>
          </div>
          <div>
            <label class="text-sm text-gray-300">Favorite Genre</label>
            <input id="profGenre" class="input" placeholder="e.g., Fantasy"/>
          </div>
          <div class="flex items-center gap-3 mt-2">
            <label class="pill"><input id="prefEmails" type="checkbox" class="mr-2"> Email notifications</label>
            <label class="pill"><input id="prefTips" type="checkbox" class="mr-2"> Reading tips</label>
          </div>
        </div>
        <div class="mt-4 flex gap-3">
          <button onclick="saveProfile()" class="bg-yellow-400 text-black px-4 py-2 rounded-lg hover:bg-yellow-500 transition"><i class="fa-solid fa-floppy-disk mr-1"></i> Save Profile</button>
          <span id="profileSaved" class="text-sm text-green-400 hidden">Profile saved!</span>
        </div>
      </div>
    </div>

    <div class="bg-gray-800 p-4 rounded-lg mt-6 max-w-3xl">
      <h3 class="font-semibold mb-3">Change Password</h3>
      <div class="grid md:grid-cols-3 gap-3">
        <input id="pwCurrent" type="password" class="input" placeholder="Current Password"/>
        <input id="pwNew" type="password" class="input" placeholder="New Password"/>
        <input id="pwConfirm" type="password" class="input" placeholder="Confirm New"/>
      </div>
      <div class="mt-3 flex gap-3">
        <button onclick="changePassword()" class="bg-yellow-400 text-black px-4 py-2 rounded-lg hover:bg-yellow-500 transition"><i class="fa-solid fa-key mr-1"></i> Update Password</button>
        <span id="pwStatus" class="text-sm hidden"></span>
      </div>
    </div>
  </section>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="modal" aria-hidden="true">
  <div class="modal-card">
    <div class="flex items-center justify-between mb-2">
      <h3 class="font-semibold text-yellow-400"><i class="fa-solid fa-credit-card mr-2"></i>Pay Fines</h3>
      <button onclick="closePayment()" class="pill"><i class="fa-solid fa-xmark"></i> Close</button>
    </div>
    <p class="text-sm text-gray-300 mb-3">Amount to pay: <b id="payAmount">$0.00</b></p>
    <div class="grid gap-3">
      <input id="payName" class="input" placeholder="Name on card"/>
      <input id="payNumber" class="input" placeholder="Card number"/>
      <div class="grid grid-cols-2 gap-3">
        <input id="payExp" class="input" placeholder="MM/YY"/>
        <input id="payCvc" class="input" placeholder="CVC"/>
      </div>
    </div>
    <button onclick="confirmPayment()" class="bg-yellow-400 text-black px-4 py-2 rounded-lg hover:bg-yellow-500 transition mt-4 w-full">
      <i class="fa-solid fa-lock mr-1"></i> Pay Securely
    </button>
  </div>
</div>

<!-- Toast -->
<div id="toast" class="toast"></div>

<!-- Hidden Logout Form (works with Laravel if route exists) -->
<form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>

<script>
/* ---------- STATE (dummy data you can replace with Blade later) ---------- */
const STATE = {
  user: { id:1, name:'Alex Kim', email:'alex.kid@example.com', favoriteGenre:'Fantasy', avatar:'https://i.pravatar.cc/160?img=14', prefs:{emails:true,tips:true} },
  books: [
    {id:1,title:'The Secret Garden',author:'F. H. Burnett',category:'Fiction',pages:240,cover:'https://picsum.photos/seed/sg/160/240',available:false},
    {id:2,title:'Journey to the Center of the Earth',author:'Jules Verne',category:'Adventure',pages:320,cover:'https://picsum.photos/seed/jv/160/240',available:true},
    {id:3,title:'The Hobbit',author:'J.R.R. Tolkien',category:'Fantasy',pages:295,cover:'https://picsum.photos/seed/hob/160/240',available:false},
    {id:4,title:'A Wrinkle in Time',author:'M. L’Engle',category:'Science',pages:256,cover:'https://picsum.photos/seed/wit/160/240',available:true},
    {id:5,title:'Percy Jackson: Lightning Thief',author:'Rick Riordan',category:'Fantasy',pages:377,cover:'https://picsum.photos/seed/pj/160/240',available:true},
    {id:6,title:'Charlotte’s Web',author:'E. B. White',category:'Fiction',pages:192,cover:'https://picsum.photos/seed/cw/160/240',available:true},
    {id:7,title:'Harry Potter and the Sorcerer’s Stone',author:'J.K. Rowling',category:'Fantasy',pages:309,cover:'https://picsum.photos/seed/hp/160/240',available:true}
  ],
  borrowed: [
    {bookId:1, due:'2025-08-30'},
    {bookId:3, due:'2025-09-05'}
  ],
  reservations: [
    {id:1, bookId:2, reservedAt:'2025-08-22', expires:'2025-08-29', status:'Active'}
  ],
  fines: [
    {id:1, reason:'Overdue: The Secret Garden (3 days)', amount:5.00, issued:'2025-08-20', status:'unpaid', selected:false},
    {id:2, reason:'Book damage: The Hobbit', amount:10.00, issued:'2025-08-18', status:'unpaid', selected:false}
  ],
  history: [
    {bookId:7, borrowed:'2025-07-01', returned:'2025-07-10', pages:309},
    {bookId:6, borrowed:'2025-07-15', returned:'2025-07-22', pages:192}
  ],
  notifications: JSON.parse(localStorage.getItem('kid_notifs')||'[]').length
    ? JSON.parse(localStorage.getItem('kid_notifs'))
    : [
        {id:101, text:'Book 3 is due tomorrow!', type:'due', read:false},
        {id:102, text:'Your fine payment was successful.', type:'payment', read:true},
        {id:103, text:'New recommended books are available!', type:'recommend', read:false}
      ],
  achievements:{
    streakDays:5, targetStreak:14, pagesRead:501, pagesTarget:1000,
    badges:[
      {icon:'fa-book-open', title:'First Borrow', desc:'Borrowed first book', unlocked:true},
      {icon:'fa-fire', title:'3-Day Streak', desc:'Read 3 days in a row', unlocked:true},
      {icon:'fa-crown', title:'Fantasy Fan', desc:'Read 3 fantasy books', unlocked:false},
      {icon:'fa-star', title:'Page Turner', desc:'Read 1000 pages', unlocked:false},
      {icon:'fa-rocket', title:'Speed Reader', desc:'Finished a book in 1 day', unlocked:false},
      {icon:'fa-heart', title:'Library Helper', desc:'Wrote a book review', unlocked:false}
    ]
  }
};

/* ---------- Helpers ---------- */
const $ = (sel)=>document.querySelector(sel);
const $$ = (sel)=>document.querySelectorAll(sel);
const fmtMoney = (n)=>'$'+n.toFixed(2);
const todayISO = ()=>new Date().toISOString().slice(0,10);
const byId = (id)=>STATE.books.find(b=>b.id===id);
function daysBetween(a,b){ return Math.round((new Date(b)-new Date(a))/(1000*60*60*24)); }
function toast(msg, ok=true){
  const t = $('#toast'); t.textContent = msg;
  t.style.borderColor = ok ? '#34d399' : '#ef4444';
  t.classList.add('show'); setTimeout(()=>t.classList.remove('show'),1800);
}
function setHash(section){ location.hash = section; }

/* ---------- Sidebar controls ---------- */
function openNav(){ $('#sidebar').classList.add('open'); $('#mainContent').classList.add('shift'); $('#openBtn').classList.add('hidden'); }
function closeNav(){ $('#sidebar').classList.remove('open'); $('#mainContent').classList.remove('shift'); $('#openBtn').classList.remove('hidden'); }
function goto(section){ setHash(section); showSection(section); }
function showSection(section){
  $$('.page-section').forEach(s=>s.classList.remove('active'));
  const el = document.getElementById('section-'+section);
  if(el){ el.classList.add('active'); }
  // nav highlight
  $$('#navList li').forEach(li=>li.classList.toggle('active', li.dataset.section===section));
  if (innerWidth < 1024) closeNav();
  // render per section
  switch(section){
    case 'dashboard': renderDashboard(); break;
    case 'search': renderSearch(); break;
    case 'reservations': renderReservations(); break;
    case 'fines': renderFines(); break;
    case 'history': renderHistory(); break;
    case 'achievements': renderAchievements(); break;
    case 'notifications': renderNotifications(); break;
    case 'contact': /* nothing dynamic */ break;
    case 'profile': renderProfile(); break;
  }
}

/* ---------- NAV events ---------- */
$('#navList').addEventListener('click', (e)=>{
  const li = e.target.closest('li'); if(!li) return;
  if(li.id==='logoutNav'){ doLogout(); return; }
  const sec = li.dataset.section; if(sec) goto(sec);
});

/* ---------- Logout (frontend trigger for Laravel form) ---------- */
function doLogout(){
  if(confirm('Are you sure you want to logout?')){
    const form = document.getElementById('logoutForm');
    if (form && form.action.includes('logout')) form.submit();
    else toast('Demo: logout form not wired. Add Laravel route.', false);
  }
}

/* ---------- DASHBOARD ---------- */
function renderDashboard(){
  $('#welcomeName').textContent = STATE.user.name;

  const overdue = STATE.borrowed.filter(b=>new Date(b.due) < new Date(todayISO())).length;
  const finesDue = STATE.fines.filter(f=>f.status==='unpaid').reduce((s,f)=>s+f.amount,0);

  $('#statBorrowed').textContent = STATE.borrowed.length;
  $('#statOverdue').textContent = overdue;
  $('#statReservations').textContent = STATE.reservations.length;
  $('#statFines').textContent = fmtMoney(finesDue);

  // Borrowed list
  const list = $('#borrowedList'); list.innerHTML='';
  STATE.borrowed.slice(0,5).forEach(item=>{
    const b = byId(item.bookId);
    const dueTxt = new Date(item.due).toISOString().slice(0,10);
    const div = document.createElement('div');
    div.className='bg-gray-800 p-3 rounded-lg flex items-center gap-3 hover-card';
    div.innerHTML = `
      <img src="${b.cover}" class="w-20 h-28 object-cover rounded" alt="${b.title}">
      <div class="flex-1">
        <p class="font-semibold">${b.title}</p>
        <p class="text-gray-400 text-sm">Due: ${dueTxt}</p>
      </div>
      <button class="pill text-sm" onclick="renewOne(${b.id})"><i class="fa-solid fa-sync"></i> Renew</button>`;
    list.appendChild(div);
  });

  // Home notifications (show 3)
  const hn = $('#homeNotifications'); hn.innerHTML='';
  STATE.notifications.slice(0,3).forEach(n=>{
    const iconMap = {due:'fa-book',payment:'fa-credit-card',recommend:'fa-star'};
    const div = document.createElement('div');
    div.className='bg-gray-700 p-4 rounded-lg flex items-center justify-between gap-4 hover-card';
    div.innerHTML = `
      <div class="flex items-center gap-3">
        <i class="fas ${iconMap[n.type]||'fa-bell'} text-yellow-400 text-2xl"></i>
        <span class="font-medium ${n.read?'text-gray-400':''}">${n.text}</span>
      </div>
      <button class="text-red-400 hover:text-red-600" onclick="dismissNotif(${n.id})"><i class="fas fa-times text-xl"></i></button>`;
    hn.appendChild(div);
  });

  // Top picks & Recommended
  const picks = $('#topPicks'); picks.innerHTML='';
  const recs = $('#recommended'); recs.innerHTML='';
  STATE.books.slice(0,3).forEach(b=>{
    picks.appendChild(bookRowCard(b));
  });
  STATE.books.slice(3,6).forEach(b=>{
    recs.appendChild(bookRowCard(b));
  });
}
function bookRowCard(b){
  const c = document.createElement('div');
  c.className='bg-gray-800 p-3 rounded-lg flex items-center gap-3 hover-card';
  c.innerHTML = `
    <img src="${b.cover}" class="w-20 h-28 object-cover rounded" alt="${b.title}">
    <div class="flex-1">
      <p class="font-semibold">${b.title}</p>
      <p class="text-gray-400 text-sm">${b.author}</p>
    </div>
    ${b.available
      ? `<button class="pill text-sm" onclick="borrowBook(${b.id})"><i class='fa-solid fa-book'></i> Borrow</button>`
      : `<span class="text-sm text-red-400">Borrowed</span>`}`;
  return c;
}

/* Quick actions */
function renewAll(){
  if(!STATE.borrowed.length) return toast('No borrowed books to renew.', false);
  STATE.borrowed.forEach(b=>b.due = new Date(new Date(b.due).getTime()+7*86400000).toISOString().slice(0,10));
  toast('All borrowed books renewed +7 days.');
  renderDashboard(); renderHistory();
}
function renewOne(bookId){
  const entry = STATE.borrowed.find(x=>x.bookId===bookId);
  if(!entry) return;
  entry.due = new Date(new Date(entry.due).getTime()+7*86400000).toISOString().slice(0,10);
  toast('Book renewed +7 days.');
  renderDashboard();
}

/* ---------- SEARCH ---------- */
function renderSearch(){
  const q = ($('#searchQuery').value||'').toLowerCase();
  const cat = $('#filterCategory').value;
  const st = $('#filterStatus').value;
  const results = STATE.books.filter(b=>{
    const matchQ = !q || b.title.toLowerCase().includes(q) || b.author.toLowerCase().includes(q);
    const matchC = !cat || b.category===cat;
    const matchS = !st || (st==='available' ? b.available : !b.available);
    return matchQ && matchC && matchS;
  });
  const grid = $('#searchResults'); grid.innerHTML='';
  results.forEach(b=>{
    const card = document.createElement('div');
    card.className='bg-gray-800 p-4 rounded-lg hover-card';
    card.innerHTML = `
      <img src="${b.cover}" class="w-full h-48 object-cover rounded mb-3" alt="${b.title}">
      <div class="flex items-start justify-between gap-2">
        <div>
          <p class="font-semibold">${b.title}</p>
          <p class="text-gray-400 text-sm">${b.author} • ${b.category}</p>
        </div>
        <span class="pill text-xs ${b.available?'':'opacity-60'}">
          <i class="fa-solid ${b.available?'fa-circle-check text-green-400':'fa-clock text-yellow-400'}"></i>
          ${b.available?'Available':'Borrowed'}
        </span>
      </div>
      <div class="mt-3 flex gap-2">
        ${b.available
          ? `<button class="bg-yellow-400 text-black px-3 py-1 rounded hover:bg-yellow-500" onclick="borrowBook(${b.id})"><i class='fa-solid fa-book mr-1'></i>Borrow</button>`
          : `<button class="bg-yellow-400 text-black px-3 py-1 rounded hover:bg-yellow-500" onclick="reserveBook(${b.id})"><i class='fa-solid fa-calendar-plus mr-1'></i>Reserve</button>`}
        <button class="pill text-xs" onclick="infoBook(${b.id})"><i class="fa-solid fa-circle-info"></i> Info</button>
      </div>`;
    grid.appendChild(card);
  });
  $('#noResults').classList.toggle('hidden', results.length>0);
}
$('#searchQuery').addEventListener('input', renderSearch);
$('#filterCategory').addEventListener('change', renderSearch);
$('#filterStatus').addEventListener('change', renderSearch);

function borrowBook(id){
  const b = byId(id); if(!b || !b.available) return toast('Not available.', false);
  b.available = false;
  STATE.borrowed.push({bookId:id, due:new Date(Date.now()+14*86400000).toISOString().slice(0,10)});
  STATE.history.push({bookId:id, borrowed:todayISO(), returned:'', pages:b.pages});
  toast('Borrowed: '+b.title);
  renderDashboard(); renderSearch();
}
function reserveBook(id){
  const exists = STATE.reservations.find(r=>r.bookId===id);
  if(exists) return toast('Already reserved.', false);
  const ex = new Date(Date.now()+7*86400000).toISOString().slice(0,10);
  STATE.reservations.push({id:Date.now(), bookId:id, reservedAt:todayISO(), expires:ex, status:'Active'});
  toast('Reserved: '+byId(id).title);
  renderDashboard(); renderReservations(); renderSearch();
}
function infoBook(id){
  const b = byId(id);
  alert(`${b.title}\nby ${b.author}\nCategory: ${b.category}\nPages: ${b.pages}`);
}

/* ---------- RESERVATIONS ---------- */
function renderReservations(){
  const tbody = $('#reservationRows'); tbody.innerHTML='';
  if(!STATE.reservations.length){
    tbody.innerHTML = `<tr><td colspan="5" class="text-center text-gray-400 p-4">No reservations.</td></tr>`;
    return;
  }
  STATE.reservations.forEach(r=>{
    const b = byId(r.bookId);
    const tr = document.createElement('tr');
    const expired = new Date(r.expires) < new Date(todayISO());
    tr.innerHTML = `
      <td class="font-semibold">${b.title}</td>
      <td>${r.reservedAt}</td>
      <td class="${expired?'text-red-400':''}">${r.expires}</td>
      <td>${expired?'Expired':r.status}</td>
      <td>
        <button class="pill text-sm" onclick="cancelReservation(${r.id})"><i class="fa-solid fa-xmark"></i> Cancel</button>
      </td>`;
    tbody.appendChild(tr);
  });
}
function cancelReservation(id){
  if(!confirm('Cancel this reservation?')) return;
  STATE.reservations = STATE.reservations.filter(r=>r.id!==id);
  toast('Reservation cancelled.');
  renderReservations(); renderDashboard();
}
function clearExpiredReservations(){
  const before = STATE.reservations.length;
  STATE.reservations = STATE.reservations.filter(r=>new Date(r.expires)>=new Date(todayISO()));
  const removed = before - STATE.reservations.length;
  toast(removed?`Removed ${removed} expired.`:'No expired reservations.');
  renderReservations(); renderDashboard();
}

/* ---------- FINES ---------- */
let paymentSelection = [];
function renderFines(){
  const tbody = $('#fineRows'); tbody.innerHTML='';
  paymentSelection = [];
  const fines = STATE.fines;
  if(!fines.length){
    tbody.innerHTML = `<tr><td colspan="5" class="text-center text-gray-400 p-4">No fines 🎉</td></tr>`;
    $('#totalDue').textContent = '$0.00';
    $('#paySelectedBtn').disabled = true;
    return;
  }
  let total = 0;
  fines.forEach(f=>{
    if(f.status==='unpaid') total += f.amount;
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${f.reason}</td>
      <td>${f.issued}</td>
      <td>${fmtMoney(f.amount)}</td>
      <td class="${f.status==='unpaid'?'text-red-400':'text-green-400'}">${f.status}</td>
      <td>
        ${f.status==='unpaid'
          ? `<label class="pill text-sm"><input type="checkbox" class="mr-2" onchange="toggleFine(${f.id}, this.checked)"> Select</label>`
          : `<span class="text-gray-400 text-sm">Paid</span>`}
      </td>`;
    tbody.appendChild(tr);
  });
  $('#totalDue').textContent = fmtMoney(total);
  $('#paySelectedBtn').disabled = true;
}
function toggleFine(id, checked){
  if(checked) paymentSelection.push(id);
  else paymentSelection = paymentSelection.filter(x=>x!==id);
  $('#paySelectedBtn').disabled = paymentSelection.length===0;
}
$('#paySelectedBtn').addEventListener('click', ()=>{
  const amt = paymentSelection.map(id=>STATE.fines.find(f=>f.id===id).amount).reduce((a,b)=>a+b,0);
  $('#payAmount').textContent = fmtMoney(amt||0);
  $('#paymentModal').classList.add('open');
});
function closePayment(){ $('#paymentModal').classList.remove('open'); }
function confirmPayment(){
  const n = $('#payName').value.trim(), card = $('#payNumber').value.trim(), exp=$('#payExp').value.trim(), cvc=$('#payCvc').value.trim();
  if(!n || card.length<12 || !exp || cvc.length<3) return toast('Please enter valid payment details.', false);
  // Mark selected fines as paid
  STATE.fines.forEach(f=>{ if(paymentSelection.includes(f.id)) f.status='paid'; });
  addNotification('Payment received. Thank you!', 'payment');
  toast('Payment successful!');
  $('#paymentModal').classList.remove('open');
  renderFines(); renderDashboard();
}

/* ---------- HISTORY ---------- */
function renderHistory(){
  const range = $('#historyRange').value || 'all';
  const tbody = $('#historyRows'); tbody.innerHTML='';
  const cutoff = range==='all' ? null : new Date(Date.now()-parseInt(range)*86400000);
  const rows = STATE.history
    .map(h=>({ ...h, book: byId(h.bookId) }))
    .filter(h=> !cutoff || new Date(h.borrowed)>=cutoff)
    .sort((a,b)=>new Date(b.borrowed)-new Date(a.borrowed));
  if(!rows.length){
    tbody.innerHTML = `<tr><td colspan="4" class="text-center text-gray-400 p-4">No history yet.</td></tr>`; return;
  }
  rows.forEach(h=>{
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td class="font-semibold">${h.book.title}</td>
      <td>${h.borrowed}</td>
      <td>${h.returned || '-'}</td>
      <td>${h.pages}</td>`;
    tbody.appendChild(tr);
  });
}
$('#historyRange').addEventListener('change', renderHistory);
function exportHistoryCSV(){
  const rows = [['Book','Borrowed','Returned','Pages']];
  STATE.history.forEach(h=>{
    const b = byId(h.bookId);
    rows.push([b.title, h.borrowed, h.returned, h.pages]);
  });
  const csv = rows.map(r=>r.map(v=>`"${String(v).replace(/"/g,'""')}"`).join(',')).join('\n');
  const blob = new Blob([csv], {type:'text/csv'});
  const a = document.createElement('a');
  a.href = URL.createObjectURL(blob); a.download = 'reading_history.csv'; a.click();
}

/* ---------- ACHIEVEMENTS ---------- */
function renderAchievements(){
  const a = STATE.achievements;
  $('#streakBar').style.width = Math.min(100, (a.streakDays/a.targetStreak)*100)+'%';
  $('#streakText').textContent = `${a.streakDays}-day streak`;
  $('#pagesBar').style.width = Math.min(100, (a.pagesRead/a.pagesTarget)*100)+'%';
  $('#pagesText').textContent = `${a.pagesRead} / ${a.pagesTarget} pages`;
  const grid = $('#badgeGrid'); grid.innerHTML='';
  a.badges.forEach(b=>{
    const div = document.createElement('div');
    div.className='badge '+(b.unlocked?'':'locked');
    div.innerHTML = `<i class="fa-solid ${b.icon} text-2xl text-yellow-400"></i>
      <div><p class="font-semibold">${b.title}</p><p class="text-gray-400 text-sm">${b.desc}</p></div>`;
    grid.appendChild(div);
  });
}

/* ---------- NOTIFICATIONS ---------- */
function renderNotifications(){
  const list = $('#notifList'); list.innerHTML='';
  if(!STATE.notifications.length){
    list.innerHTML = `<div class="text-gray-400">No notifications 🎉</div>`;
    return;
  }
  STATE.notifications.forEach(n=>{
    const row = document.createElement('div');
    row.className='bg-gray-700 p-4 rounded-lg flex items-center justify-between gap-4 hover-card';
    row.innerHTML = `
      <div class="flex items-center gap-3">
        <i class="fas ${n.type==='due'?'fa-book':n.type==='payment'?'fa-credit-card':'fa-star'} text-yellow-400 text-2xl"></i>
        <span class="font-medium ${n.read?'text-gray-400':''}">${n.text}</span>
      </div>
      <div class="flex gap-2">
        <button class="pill text-xs" onclick="toggleRead(${n.id})"><i class="fa-solid fa-eye"></i> ${n.read?'Unread':'Read'}</button>
        <button class="pill text-xs" onclick="dismissNotif(${n.id})"><i class="fa-solid fa-xmark"></i> Dismiss</button>
      </div>`;
    list.appendChild(row);
  });
}
function toggleRead(id){
  const n = STATE.notifications.find(x=>x.id===id); if(!n) return;
  n.read = !n.read; saveNotifs(); renderNotifications(); renderDashboard();
}
function dismissNotif(id){
  STATE.notifications = STATE.notifications.filter(n=>n.id!==id);
  saveNotifs(); renderNotifications(); renderDashboard();
}
function markAllRead(){ STATE.notifications.forEach(n=>n.read=true); saveNotifs(); renderNotifications(); renderDashboard(); }
function clearAllNotifications(){ STATE.notifications=[]; saveNotifs(); renderNotifications(); renderDashboard(); }
function addNotification(text,type='general'){ STATE.notifications.unshift({id:Date.now(), text, type, read:false}); saveNotifs(); }
function saveNotifs(){ localStorage.setItem('kid_notifs', JSON.stringify(STATE.notifications)); }

/* ---------- CONTACT ---------- */
$('#contactForm').addEventListener('submit', (e)=>{
  e.preventDefault();
  const name = $('#contactName').value.trim();
  const email = $('#contactEmail').value.trim();
  const msg = $('#contactMsg').value.trim();
  if(!name || !email || !msg){ toast('Please fill all fields.', false); return; }
  $('#contactStatus').classList.remove('hidden');
  addNotification('Message sent to librarian.','general');
  toast('Message sent!');
  e.target.reset();
  setTimeout(()=>$('#contactStatus').classList.add('hidden'), 1500);
});

/* ---------- PROFILE ---------- */
function renderProfile(){
  $('#avatarPreview').src = STATE.user.avatar;
  $('#profName').value = STATE.user.name;
  $('#profEmail').value = STATE.user.email;
  $('#profGenre').value = STATE.user.favoriteGenre;
  $('#prefEmails').checked = !!STATE.user.prefs.emails;
  $('#prefTips').checked = !!STATE.user.prefs.tips;
}
$('#avatarInput').addEventListener('change', (e)=>{
  const file = e.target.files[0]; if(!file) return;
  const reader = new FileReader();
  reader.onload = ()=>{ $('#avatarPreview').src = reader.result; STATE.user.avatar = reader.result; toast('Avatar updated.'); };
  reader.readAsDataURL(file);
});
function saveProfile(){
  STATE.user.name = $('#profName').value.trim() || STATE.user.name;
  STATE.user.email = $('#profEmail').value.trim() || STATE.user.email;
  STATE.user.favoriteGenre = $('#profGenre').value.trim();
  STATE.user.prefs.emails = $('#prefEmails').checked;
  STATE.user.prefs.tips = $('#prefTips').checked;
  $('#welcomeName').textContent = STATE.user.name;
  $('#profileSaved').classList.remove('hidden');
  setTimeout(()=>$('#profileSaved').classList.add('hidden'),1500);
  toast('Profile saved!');
}
function changePassword(){
  const c=$('#pwCurrent').value, n=$('#pwNew').value, x=$('#pwConfirm').value;
  const st=$('#pwStatus'); st.classList.remove('hidden');
  if(!c||!n||!x){ st.textContent='Fill all fields.'; st.className='text-sm text-red-400'; return; }
  if(n.length<6){ st.textContent='New password too short.'; st.className='text-sm text-red-400'; return; }
  if(n!==x){ st.textContent='Passwords do not match.'; st.className='text-sm text-red-400'; return; }
  st.textContent='Password updated (demo).'; st.className='text-sm text-green-400';
  toast('Password updated.');
  $('#pwCurrent').value=''; $('#pwNew').value=''; $('#pwConfirm').value='';
}

/* ---------- INIT & ROUTING ---------- */
function initialFill(){
  // Prefill contact with profile info
  $('#contactName').value = STATE.user.name;
  $('#contactEmail').value = STATE.user.email;
  renderDashboard(); renderSearch(); renderReservations(); renderFines(); renderHistory(); renderAchievements(); renderNotifications(); renderProfile();
}
window.addEventListener('hashchange', ()=>{
  const s = (location.hash||'#dashboard').replace('#','');
  showSection(s);
});
function boot(){
  initialFill();
  const start = (location.hash||'#dashboard').replace('#','');
  showSection(start);
}
boot();
</script>

</body>
</html>

