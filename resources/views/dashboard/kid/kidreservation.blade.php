<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Reservations | Kid Library</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
body { background: #0f172a; color: #fff; font-family: 'Open Sans', sans-serif; }

/* Sidebar */
.sidebar { position: fixed; top: 0; left: 0; width: 250px; height: 100%; background: #111827; padding-top: 60px; z-index: 1000; overflow-y: auto; scrollbar-width: none; box-shadow: 3px 0 15px rgba(0,0,0,0.5); border-right: 1px solid #2d2d2d; transition: transform 0.3s ease; transform: translateX(0); }
.sidebar::-webkit-scrollbar { display: none; }
.sidebar ul { list-style: none; padding: 0; margin: 0; }
.sidebar ul li { padding: 14px 20px; font-size: 1rem; color: #FFD369; display: flex; align-items: center; gap: 14px; border-radius: 0.5rem; transition: background .3s, color .3s; cursor: pointer; margin: 4px 10px; }
.sidebar ul li:hover { background: #FF9F1C; color: #111827; }
.sidebar ul li:hover i { color: #111827; }
.sidebar ul li.selected { background: #FF9F1C; color: #111827; }
.sidebar ul li.selected i { color: #111827; }

/* Main Content */
.main-content { margin-left: 250px; padding: 24px; transition: margin-left 0.3s ease; }
h1, h2 { color: #FFD369; }

/* Table Cards */
.table-container { display: flex; flex-direction: column; gap: 1rem; }
.table-card { background: #1e293b; border-radius: 12px; overflow: hidden; shadow-lg; transition: transform .2s, box-shadow .2s; }
.table-card:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(0,0,0,0.5); }
.table-card-header { padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #334155; font-weight: 600; color: #FFD369; }
.table-card-body { display: grid; grid-template-columns: 64px 2fr 1fr 1fr 1fr 1fr; gap: 1rem; padding: 1rem 1.5rem; align-items: center; }
.table-card-body div { font-size: 0.875rem; color: #ccc; }
.table-card-body img { border-radius: 8px; }

/* Buttons */
.btn { padding: 6px 12px; border-radius: 6px; font-size: 0.875rem; display: flex; align-items: center; gap: 4px; transition: background .2s; cursor: pointer; }
.btn-cancel { background: #DC2626; color: #fff; }
.btn-cancel:hover { background: #B91C1C; }
.btn-view { background: #EEBA30; color: #111827; }
.btn-view:hover { background: #D3A625; }

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
    <!-- Navigation -->
    <ul id="navList" class="space-y-1">

       <ul>
        <li onclick="location.href='{{ route('kid.dashboard') }}'"><i class="fas fa-tachometer-alt"></i> Dashboard</li>
        <li onclick="location.href='{{ url('/books') }}'"><i class="fas fa-home"></i> Home</li>
        <li onclick="window.location='{{ route('kid.kidfinepay.index') }}'"
    class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
    <i class="fas fa-credit-card mr-3"></i> Fines & Payments
</li>

        <li onclick="location.href='{{ route('kid.kidborrowed.index') }}'"><i class="fas fa-book-open"></i> My Books</li>
        <li class="selected" onclick="window.location='{{ route('kid.kidreservation.index') }}'" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
    <i class="fas fa-calendar-check mr-3"></i> Reservations
</li>



        <li onclick="location.href='{{ route('kid.kidnoti.index') }}'"><i class="fas fa-bell"></i> Notifications</li>
        <li onclick="location.href='{{ route('kid.kidcontact.index') }}'"><i class="fas fa-envelope"></i> Contact Librarian</li>
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
    <!-- Flex container for hamburger + heading -->
    <div class="flex-header">
        <button class="open-btn" id="openBtn" onclick="openNav()"><i class="fas fa-bars"></i></button>
        <h1 class="text-2xl font-bold text-white">My Reservations</h1>
    </div>

    @if($reservations->isEmpty())
    <div class="bg-slate-800 rounded-lg shadow p-6 text-center">
        <i class="fas fa-bookmark text-4xl text-gray-400 mb-4"></i>
        <h3 class="text-lg font-medium text-white mb-2">No reservations yet</h3>
        <p class="text-gray-400 mb-4">You haven't made any book reservations.</p>
        <a href="{{ route('books.index') }}" class="btn btn-view">Browse Books</a>
    </div>
    @else
    <div class="table-container">
        @foreach($reservations as $reservation)
        @php
            $book = $reservation->book;
            $coverImage = $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://via.placeholder.com/128x192/1e293b/ffffff?text=No+Cover';
            $isExpired = $reservation->expiry_date->isPast() && $reservation->status === 'active';
        @endphp
        <div class="table-card">
            <div class="table-card-header">
                <span>#{{ $reservation->reservation_id }}</span>
                <span>{{ $reservation->expiry_date->format('M d, Y') }}</span>
            </div>
            <div class="table-card-body">
                <div class="h-24 w-16 bg-slate-600 rounded-lg overflow-hidden flex items-center justify-center">
                    <img src="{{ $coverImage }}" alt="{{ $book->title }} cover" class="h-full w-full object-cover">
                </div>
                <div>
                    <div class="text-lg font-semibold text-white">{{ $book->title }}</div>
                    <div class="text-sm text-gray-400">by {{ $book->author->name ?? 'Unknown Author' }}</div>
                    <a href="{{ route('books.show', $book->book_id) }}" class="btn btn-view mt-2"><i class="fas fa-eye mr-1"></i> View</a>
                </div>
                <div>{{ $reservation->reservation_date->format('M d, Y') }}</div>
                <div>
                    @if($isExpired)
                        <span class="status-badge bg-overdue">Expired</span>
                    @else
                        <span class="status-badge bg-active">{{ ucfirst($reservation->status) }}</span>
                    @endif
                </div>
                <div>
                    @if($reservation->status === 'active' && !$isExpired)
                        <form action="{{ route('kid.kidreservation.cancel', $reservation->reservation_id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-cancel" onclick="return confirm('Cancel this reservation?')"><i class="fas fa-times mr-1"></i> Cancel</button>
                        </form>
                    @else
                        <span class="text-gray-500">No actions</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>



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
