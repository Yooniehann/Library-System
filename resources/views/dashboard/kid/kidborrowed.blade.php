<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>My Books | Library System</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    /* Search Bar */
.search-bar input {
    background-color: #0f172a;  /* same as body */
    color: #ededed;             /* black text inside search */
    border: 1px solid #4b5563; /* subtle border */
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
    outline: none;
    font-size: 0.95rem;
}
.search-bar input::placeholder {
    color: #9ca3af; /* placeholder color */
}
.search-bar input:focus {
    border-color: #FF9F1C; /* orange border on focus */
    box-shadow: 0 0 0 2px rgba(255, 159, 28, 0.3); /* subtle focus glow */
}

/* Search Button */
.search-bar button {
    background-color: #FF9F1C;  /* orange button */
    color: #000000;             /* black text on button */
    border-radius: 0.5rem;
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.25rem;
    transition: background-color 0.2s;
}
.search-bar button:hover {
    background-color: #FF8C00;  /* slightly darker orange on hover */
}

/* Clear Button */
.search-bar a {
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.25rem;
    transition: background-color 0.2s;
    background-color: #6b7280; /* gray background */
    color: #f7f7f7;
}
.search-bar a:hover {
    background-color: #4b5563; /* darker gray on hover */
}

body { background: #0f172a; color: #fff; font-family: 'Open Sans', sans-serif; }

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

/* Main Content */
.main-content { margin-left: 250px; padding: 24px; transition: margin-left 0.3s ease; }
h1, h2 { color: #FFD369; }

/* Flex header for hamburger + title */
.flex-header { display: flex; align-items: center; gap: 16px; margin-bottom: 1.5rem; }
.open-btn { font-size: 1.5rem; color: #FFB347; background: none; border: none; cursor: pointer; }

/* Table Styling */
.table-container { background: #1e293b; border-radius: 12px; overflow-x-auto; }
table { width: 100%; border-collapse: collapse; }
th, td { padding: 12px 16px; text-align: left; }
thead { background: #334155; color: #FFD369; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; }
tbody tr { border-bottom: 1px solid #2d2d2d; transition: background .2s; }
tbody tr:hover { background: #374151; }
.status-badge { padding: 4px 8px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
.bg-active { background: #065f46; color: #a7f3d0; }
.bg-overdue { background: #7f1d1d; color: #fecaca; }
.bg-other { background: #4b5563; color: #d1d5db; }

/* Buttons */
.btn { padding: 6px 12px; border-radius: 6px; font-size: 0.875rem; display: flex; align-items: center; gap: 4px; transition: background .2s; cursor: pointer; }
.btn-renew { background: #2563eb; color: #fff; }
.btn-renew:hover { background: #1d4ed8; }
.btn-return { background: #16a34a; color: #fff; }
.btn-return:hover { background: #15803d; }

/* Form and search input */
input, button { font-family: 'Open Sans', sans-serif; }

/* Responsive adjustments */
@media (max-width: 768px) {
    .main-content { margin-left: 0; }
}
/* Hamburger as flex item */
.flex-header { display: flex; align-items: center; gap: 16px; margin-bottom: 1.5rem; }
.open-btn { background: transparent; border: none; font-size: 1.5rem; color: #FFD369; cursor: pointer; }

/* Close button inside sidebar */
.close-btn { position: absolute; top: 16px; right: 16px; background: transparent; border: none; color: #FFD369; font-size: 1.25rem; cursor: pointer; }

/* Responsive adjustments */
@media (max-width: 768px) {
  .main-content { margin-left: 0; }
  .table-card-body { grid-template-columns: 48px 2fr 1fr; grid-template-rows: auto auto; }
  .table-card-body div:nth-child(4),
  .table-card-body div:nth-child(5),
  .table-card-body div:nth-child(6) { grid-column: span 3; font-size: 0.75rem; color: #bbb; }
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

        <li class="selected" onclick="location.href='{{ route('kid.kidborrowed.index') }}'"><i class="fas fa-book-open"></i> My Books</li>
        <li onclick="window.location='{{ route('kid.kidreservation.index') }}'" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
    <i class="fas fa-calendar-check mr-3"></i> Reservations
</li>

        <li onclick="location.href='{{ route('kid.kidnoti.index') }}'"><i class="fas fa-bell"></i> Notifications</li>
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
<div class="main-content" id="mainContent">

    <!-- Hamburger + Heading -->
    <div class="flex-header">
        <button class="open-btn" id="openBtn" onclick="openNav()"><i class="fas fa-bars"></i></button>
        <h1 class="text-2xl font-bold">My Books</h1>
    </div>

    <!-- Search Bar -->
<div class="bg-slate-800 rounded-lg shadow p-4 mb-6 search-bar">
    <form action="{{ route('kid.kidborrowed.index') }}" method="GET" class="flex gap-3">
        <div class="flex-1">
            <input type="text"
                   name="search"
                   value="{{ request()->get('search') ?? '' }}"
                   placeholder="Search by book title, author, borrow ID, or status..."
                   class="w-full px-4 py-2 rounded-lg text-black bg-slate-800 border border-slate-600 placeholder-gray-400 focus:outline-none focus:border-yellow-500">
        </div>
        <button type="submit" class="px-6 py-2 rounded-lg bg-yellow-400 text-black hover:bg-orange-500 transition-colors flex items-center gap-2">
            <i class="fas fa-search"></i> Search
        </button>
        @if(request()->get('search'))
            <a href="{{ route('kid.kidborrowed.index') }}" class="px-4 py-2 rounded-lg bg-gray-600 text-white hover:bg-gray-500 transition-colors flex items-center gap-2">
                <i class="fas fa-times"></i> Clear
            </a>
        @endif
    </form>
</div>


    @if($borrows->isEmpty())
        <div class="bg-slate-800 rounded-lg shadow p-6 text-center">
            <i class="fas fa-book-open text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-lg font-medium text-white mb-2">No books borrowed yet</h3>
            <p class="text-gray-400 mb-4">You haven't borrowed any books from our library.</p>
            <a href="{{ url('/books') }}" class="bg-primary-orange text-black px-4 py-2 rounded-lg hover:bg-dark-orange transition-colors">
                Browse Books
            </a>
        </div>
    @else
        <div class="table-container shadow">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Book</th>
                        <th>Borrow Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrows as $borrow)
                    <tr>
                        <td>#{{ $borrow->borrow_id }}</td>
                        <td>
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('storage/' . $borrow->inventory->book->cover_image) }}"
                                     alt="{{ $borrow->inventory->book->title }}"
                                     class="w-12 h-16 object-cover rounded-md">
                                <div>
                                    <div class="text-white font-semibold">{{ $borrow->inventory->book->title }}</div>
                                    <div class="text-gray-400 text-sm">
                                        by {{ $borrow->inventory->book->author->fullname ?? 'Unknown Author' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-gray-300 text-sm">{{ $borrow->borrow_date->format('M d, Y') }}</td>
                        <td class="text-gray-300 text-sm">{{ $borrow->due_date->format('M d, Y') }}</td>
                        <td>
                            @if($borrow->status == 'active')
                                @if($borrow->due_date->isPast())
                                    <span class="status-badge bg-overdue">Overdue</span>
                                @else
                                    <span class="status-badge bg-active">Active</span>
                                @endif
                            @else
                                <span class="status-badge bg-other">{{ ucfirst($borrow->status) }}</span>
                            @endif
                        </td>
                        <td class="flex flex-col gap-2">
                            @if($borrow->status == 'active')
                                <form action="{{ route('kid.kidborrow.renew', $borrow->borrow_id) }}" method="POST">@csrf
                                    <button type="submit" class="btn btn-renew"><i class="fas fa-sync-alt"></i> Renew</button>
                                </form>
                                <form action="{{ route('kid.kidborrow.create', $borrow->borrow_id) }}" method="POST">@csrf
                                    <button type="submit" class="btn btn-return"><i class="fas fa-undo"></i> Return</button>
                                </form>
                            @else
                                <span class="text-gray-400 text-sm">No actions</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
