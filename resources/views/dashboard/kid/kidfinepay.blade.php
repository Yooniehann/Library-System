<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Fines & Payments | Library System</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

/* Flex header for hamburger + title */
.flex-header { display: flex; align-items: center; gap: 16px; margin-bottom: 1.5rem; }
.open-btn { font-size: 1.5rem; color: #FFB347; background: none; border: none; cursor: pointer; }


/* Fine Cards */
.fine-card { background: #1e293b; padding: 16px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; transition: background 0.3s; }
.fine-card:hover { background: #334155; }
.fine-info { flex: 1; }
.status-badge { padding: 4px 8px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
.bg-unpaid { background: #b91c1c; color: #fee2e2; }
.bg-paid { background: #16a34a; color: #d1fae5; }

/* Buttons */
.btn-pay { background: #facc15; color: #111827; padding: 6px 12px; border-radius: 6px; font-weight: 600; transition: background 0.2s; }
.btn-pay:hover { background: #eab308; }

/* Close button inside sidebar */
.close-btn { position: absolute; top: 16px; right: 16px; background: transparent; border: none; color: #FFD369; font-size: 1.25rem; cursor: pointer; }

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


        <li class="selected "onclick="window.location='{{ route('kid.kidfinepay.index') }}'"
    class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
    <i class="fas fa-credit-card mr-3"></i> Fines & Payments
</li>

        <li onclick="location.href='{{ route('kid.kidborrowed.index') }}'"><i class="fas fa-book-open"></i> My Books</li>
        <li onclick="window.location='{{ route('kid.kidreservation.index') }}'" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
    <i class="fas fa-calendar-check mr-3"></i> Reservations
</li>

        <li onclick="location.href='{{ route('kid.kidnoti.index') }}'"><i class="fas fa-bell"></i> Notifications</li>
        <li onclick="location.href='{{ route('kid.kidcontact.index') }}'"><i class="fas fa-envelope"></i> Contact Librarian</li>
        <li onclick="location.href='{{ route('profile.edit') }}'">
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

     <!-- Hamburger + Heading -->
    <div class="flex-header">
        <button class="open-btn" id="openBtn" onclick="openNav()"><i class="fas fa-bars"></i></button>
        <h1 class="text-2xl font-bold">Fine and Payment</h1>
    </div>

  <!-- Fines & Payments List -->
<div class="space-y-4">
    @forelse($fines ?? [] as $fine)
    <div class="fine-card bg-slate-800 rounded-lg p-4 flex justify-between items-start shadow">
        <div class="fine-info">
            <p class="text-white font-semibold">
                {{ $fine->borrow->book->title ?? 'Unknown Book' }}
                <span class="text-gray-400 text-sm">(#Borrow ID: {{ $fine->borrow_id }})</span>
            </p>
            <p class="text-gray-400 text-sm">Fine Type: {{ ucfirst($fine->fine_type) }}</p>
            <p class="text-gray-400 text-sm">Description: {{ $fine->description }}</p>
            <p class="text-gray-400 text-sm">Fine Date: {{ $fine->fine_date->format('d M Y') }}</p>
            <p class="text-gray-400 text-sm">Amount per Day: ${{ number_format($fine->amount_per_day, 2) }}</p>
        </div>

        <div class="flex flex-col items-end gap-2">
            <span class="status-badge {{ $fine->status == 'paid' ? 'bg-green-600' : 'bg-red-600' }}">
    {{ ucfirst($fine->status) }}
</span>


            @if($fine->status != 'paid')
                <!-- Link to process payment page -->
                <a href="{{ route('kid.kidprocesspay.index', $fine->fine_id) }}"
                   class="btn-pay flex items-center justify-center mt-2">
                   <i class="fas fa-credit-card mr-1"></i> Pay
                </a>
            @else
                <p class="text-green-300 text-sm mt-2">
    Paid on: {{ $fine->payment ? \Carbon\Carbon::parse($fine->payment->payment_date)->format('d M Y') : '-' }}
</p>

            @endif
        </div>
    </div>
    @empty
    <div class="bg-slate-800 rounded-lg shadow p-6 text-center">
        <i class="fas fa-check-circle text-4xl text-gray-400 mb-4"></i>
        <h3 class="text-lg font-medium text-white mb-2">No fines found</h3>
        <p class="text-gray-400 mb-4">You currently have no fines or pending payments.</p>
    </div>
    @endforelse
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
function closeNav() {
    document.getElementById('sidebar').style.transform = 'translateX(-100%)';
    document.getElementById('mainContent').style.marginLeft = '0';
    document.querySelector('.flex-header').style.marginLeft = '0';
}
function openNav() {
    document.getElementById('sidebar').style.transform = 'translateX(0)';
    document.getElementById('mainContent').style.marginLeft = '250px';
    document.querySelector('.flex-header').style.marginLeft = '250px';
}
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
