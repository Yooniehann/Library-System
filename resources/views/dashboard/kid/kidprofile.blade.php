<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Profile | Kid Library</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
body { background: #0f172a; color: #fff; font-family: 'Open Sans', sans-serif; }
.sidebar { position: fixed; top:0; left:0; width:250px; height:100%; background:#111827; padding-top:60px; z-index:1000; overflow-y:auto; scrollbar-width:none; box-shadow:3px 0 15px rgba(0,0,0,0.5); border-right:1px solid #2d2d2d; transition:transform 0.3s ease;}
.sidebar::-webkit-scrollbar { display:none; }
.sidebar ul { list-style:none; padding:0; margin:0; }
.sidebar ul li { padding:14px 20px; font-size:1rem; color:#FFD369; display:flex; align-items:center; gap:14px; border-radius:0.5rem; cursor:pointer; margin:4px 10px; transition: background .3s, color .3s; }
.sidebar ul li:hover { background:#FF9F1C; color:#111827; }
.sidebar ul li.selected { background:#FF9F1C; color:#111827; }
.main-content { margin-left:250px; padding:24px; transition: margin-left 0.3s ease; }
h1,h2 { color:#FFD369; }
.flex-header { display:flex; align-items:center; gap:16px; margin-bottom:1.5rem; }
.open-btn { font-size:1.5rem; color:#FFB347; background:none; border:none; cursor:pointer; }
.close-btn { position:absolute; top:16px; right:16px; background:transparent; border:none; color:#FFD369; font-size:1.25rem; cursor:pointer; }
@media(max-width:768px){ .main-content{margin-left:0;} }

/* Input group */
.input-group { position: relative; }
.input-group i { position: absolute; top:50%; left:12px; transform: translateY(-50%); color:#9ca3af; }
.input-group input { padding-left: 2.5rem; }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <button class="close-btn" onclick="closeNav()"><i class="fas fa-times"></i></button>
    <div class="flex items-center justify-center h-16 px-4 bg-black">
        <span class="text-xl font-bold text-yellow-400">Kid Dashboard</span>
    </div>
    <ul>
        <li onclick="location.href='{{ route('kid.dashboard') }}'"><i class="fas fa-tachometer-alt"></i> Dashboard</li>
        <li onclick="location.href='{{ url('/books') }}'"><i class="fas fa-home"></i> Home</li>
        <li onclick="window.location='{{ route('kid.kidfinepay.index') }}'"
    class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
    <i class="fas fa-credit-card mr-3"></i> Fines & Payments
</li>

        <li onclick="location.href='{{ route('kid.kidborrowed.index') }}'"><i class="fas fa-book-open"></i> My Books</li>
       <li onclick="window.location='{{ route('kid.kidreservation.index') }}'" class="flex items-center px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg">
    <i class="fas fa-calendar-check mr-3"></i> Reservations
</li>


        <li onclick="location.href='{{ route('kid.kidnoti.index') }}'"><i class="fas fa-bell"></i> Notifications</li>
        <li onclick="location.href='{{ route('kid.kidcontact.index') }}'"><i class="fas fa-envelope"></i> Contact Librarian</li>

        <li class="selected" onclick="location.href='{{ route('kid.kidprofile.index') }}'">
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
        <h1 class="text-2xl font-bold">Profile Settings</h1>
    </div>

    <section class="max-w-lg mx-auto py-10 px-6">
        <div class="bg-[#1e293b] rounded-2xl shadow-lg border border-gray-700 p-8 space-y-6">
            <h2 class="text-2xl font-bold text-yellow-400 mb-4 text-center">Edit Your Profile</h2>

            <form action="{{ route('kid.kidprofile.update') }}" method="POST" class="space-y-5">
                @csrf
                @method('PATCH')

                <!-- Full Name -->
            <div class="flex items-center bg-gray-800 rounded-lg border border-gray-600 px-3 py-2">
                <i class="fas fa-user text-gray-400 mr-3"></i>
                <input type="text" id="fullname" name="fullname" value="{{ old('fullname', $user->fullname) }}"
                    class="w-full bg-transparent text-white focus:outline-none focus:ring-0" placeholder="Full Name" required>
            </div>

            <!-- Email (readonly) -->
            <div class="flex items-center bg-gray-700 rounded-lg border border-gray-600 px-3 py-2">
                <i class="fas fa-envelope text-gray-400 mr-3"></i>
                <input type="email" id="email" name="email" value="{{ $user->email }}" readonly
                    class="w-full bg-transparent text-gray-400 cursor-not-allowed focus:outline-none focus:ring-0">
            </div>

                <!-- Password Section -->
                <div class="border-t border-gray-600 pt-4 space-y-4">
                    <h3 class="text-yellow-400 font-semibold">Change Password</h3>

                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="New password"
                            class="w-full px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                    </div>

                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password"
                            class="w-full px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-yellow-400 text-black font-semibold py-2 rounded-lg hover:bg-yellow-500 transition">
                    Update Profile
                </button>
            </form>
        </div>
    </section>
</div>

<script>
const sidebar = document.getElementById('sidebar');
const openBtn = document.getElementById('openBtn');
const mainContent = document.getElementById('mainContent');
function closeNav(){ sidebar.style.transform='translateX(-100%)'; openBtn.style.display='flex'; mainContent.style.marginLeft='0'; }
function openNav(){ sidebar.style.transform='translateX(0)'; openBtn.style.display='none'; mainContent.style.marginLeft='250px'; }
window.addEventListener('DOMContentLoaded',()=>{ if(window.innerWidth>=768){ sidebar.style.transform='translateX(0)'; openBtn.style.display='none'; mainContent.style.marginLeft='250px'; } else { sidebar.style.transform='translateX(-100%)'; openBtn.style.display='flex'; mainContent.style.marginLeft='0'; } });
window.addEventListener('resize',()=>{ if(window.innerWidth>=768){ sidebar.style.transform='translateX(0)'; openBtn.style.display='none'; mainContent.style.marginLeft='250px'; } else { sidebar.style.transform='translateX(-100%)'; openBtn.style.display='flex'; mainContent.style.marginLeft='0'; } });
</script>

</body>
</html>
