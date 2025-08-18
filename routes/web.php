<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\MembershipType;
use App\Http\Controllers\{
    BookController,
    BorrowController,
    ProfileController,
    MembershipTypeController
};

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Static Pages
Route::view('/about', 'static.about')->name('about');
Route::view('/contact', 'static.contact')->name('contact');
Route::view('/faq', 'static.faq')->name('faq');
Route::view('/privacy', 'static.privacy')->name('privacy');
Route::view('/terms', 'static.terms')->name('terms');
Route::view('/memberplan', 'static.memberplan')->name('memberplan');

// Book Catalog
Route::controller(BookController::class)->name('books.')->group(function () {
    Route::get('/books', 'index')->name('index');
    Route::get('/books/search', 'search')->name('search');
    Route::get('/books/{book}', 'show')->name('show');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard redirect
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->role === 'Guest') {
            return redirect()->route('membership.select', MembershipType::first()->id)
                ->with('info', 'Please select a membership plan to continue');
        }

        return match ($user->role) {
            'Admin' => redirect()->route('admin.dashboard'),
            'Member' => redirect()->route('member.dashboard'),
            'Kid' => redirect()->route('kid.dashboard'),
            default => redirect()->route('home')
        };
    })->name('dashboard');

    // Profile routes
    Route::controller(ProfileController::class)->name('profile.')->group(function () {
        Route::get('/profile', 'edit')->name('edit');
        Route::patch('/profile', 'update')->name('update');
        Route::delete('/profile', 'destroy')->name('destroy');
    });

    // Membership routes
    Route::prefix('membership')->group(function () {
        Route::middleware('role:Guest')->group(function () {
            Route::get('/select/{type}', [MembershipTypeController::class, 'select'])
                ->name('membership.select');
            Route::post('/choose', [MembershipTypeController::class, 'choose'])
                ->name('membership.choose');
            Route::get('/payment', [MembershipTypeController::class, 'payment'])
                ->name('membership.payment');
            Route::post('/process-payment', [MembershipTypeController::class, 'processPayment'])
                ->name('membership.process-payment');
        });

        // ✅ Success should be accessible for upgraded Members/Kids
        Route::get('/success', [MembershipTypeController::class, 'success'])
            ->name('membership.success')
            ->middleware('auth');
    });


    // Borrowing
    Route::get('/borrowed', [BorrowController::class, 'index'])
        ->middleware('role:Member,Kid')
        ->name('borrowed.index');
});

/*
|--------------------------------------------------------------------------
| Role-Based Dashboards
|--------------------------------------------------------------------------
*/
// Admin routes
Route::middleware(['auth', 'verified', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.admin.index');
    })->name('dashboard');
    Route::get('/books', function () {
        return view('dashboard.admin.books');
    })->name('books');
    Route::get('/users', function () {
        return view('dashboard.admin.users');
    })->name('users');
});

// Member routes
Route::middleware(['auth', 'verified', 'is.member', 'check.membership'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.member.index');
    })->name('dashboard');
    Route::get('/books', function () {
        return view('dashboard.member.books');
    })->name('books');
    Route::get('/profile', function () {
        return view('dashboard.member.profile');
    })->name('profile');
});

// Kid routes
Route::middleware(['auth', 'verified', 'role:Kid'])->prefix('kid')->name('kid.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.kid.index');
    })->name('dashboard');
    Route::get('/books', function () {
        return view('dashboard.kid.books');
    })->name('books');
    Route::get('/activities', function () {
        return view('dashboard.kid.activities');
    })->name('activities');
});
