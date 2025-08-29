<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\MembershipType;
use App\Http\Controllers\{
    AuthorController,
    BookController,
    BookReturnController,
    BorrowController,
    CategoryController,
    ProfileController,
    MembershipTypeController,
    UserController,
    SupplierController,
    StockInController,
    StockInDetailController,
    CatalogController,
    ReservationController,
};
use App\Http\Controllers\Admin\SearchController;

use App\Http\Controllers\Kid\BorrowedController;
use App\Http\Controllers\Kid\KidDashboardController;
use App\Http\Controllers\Kid\KidReservationController;
use App\Http\Controllers\Kid\KidFineController;
use App\Http\Controllers\Kid\AchievementController;
use App\Http\Controllers\Kid\KidNotificationController;
use App\Http\Controllers\Kid\KidContactController;
use App\Http\Controllers\Kid\KidProfileController;

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

// Book page in home
Route::get('/books', [CatalogController::class, 'books'])->name('books.index');

// Book details route
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

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
            // Get the first membership type ID
            $firstMembershipType = MembershipType::first();

            if ($firstMembershipType) {
                return redirect()->route('membership.select', $firstMembershipType->id)
                    ->with('info', 'Please select a membership plan to continue');
            } else {
                // Fallback if no membership types exist
                return redirect()->route('home')
                    ->with('error', 'No membership plans available. Please contact administrator.');
            }
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
        // let controller decide whether user can select
        Route::get('/select/{type}', [MembershipTypeController::class, 'select'])
            ->name('membership.select')
            ->middleware('auth');

        // only Guests can proceed to purchase/payment
        Route::middleware('role:Guest')->group(function () {
            Route::post('/choose', [MembershipTypeController::class, 'choose'])
                ->name('membership.choose');
            Route::get('/payment', [MembershipTypeController::class, 'payment'])
                ->name('membership.payment');
            Route::post('/process-payment', [MembershipTypeController::class, 'processPayment'])
                ->name('membership.process-payment');
        });

        // success page (available once upgraded)
        Route::get('/success', [MembershipTypeController::class, 'success'])
            ->name('membership.success')
            ->middleware('auth');
    });

    Route::get('/test-flash', function () {
        return redirect('/')->with('info', 'This is a test message');
    });

    // Borrow routes - Only for members (not guests)
    Route::post('/borrow/{book}', [BorrowController::class, 'create'])
        ->name('borrow.create')
        ->middleware('role:Member,Kid');

    // Borrow renewal route - Only for members (not guests)
    Route::post('/borrow/{borrow}/renew', [BorrowController::class, 'renew'])
        ->name('borrow.renew')
        ->middleware('role:Member,Kid');

    // Reservation routes - Only for members (not guests)
    Route::post('/reserve/{book}', [ReservationController::class, 'create'])
        ->name('reservations.create')
        ->middleware('role:Member,Kid');

    // Return routes
    Route::post('/return/{borrow}', [BookReturnController::class, 'returnBook'])
        ->name('book.return')
        ->middleware('role:Member,Kid');

    // Borrowing history - Only for members
    Route::get('/borrowed', [BorrowController::class, 'index'])
        ->middleware('role:Member,Kid')
        ->name('borrowed.index');

    // Borrow details route
    Route::get('/borrowed/{id}', [BorrowController::class, 'show'])
        ->middleware('role:Member,Kid')
        ->name('borrowed.show');


    // Reservations
    // Route::get('/reservations', [ReservationController::class, 'index'])
    //     ->middleware('role:Member,Kid')
    //     ->name('reservations.index');

    // // Reservation cancel route
    // Route::post('/reservations/{id}/cancel', [ReservationController::class, 'cancel'])
    //     ->middleware('role:Member,Kid')
    //     ->name('reservations.cancel')
    //     ->name('borrowed.index')
    //     ->middleware('role:Member,Kid');

    // Reservations
    Route::get('/reservations', [ReservationController::class, 'index'])
        ->middleware('role:Member,Kid')
        ->name('reservations.index');

    // Reservation cancel route
    Route::post('/reservations/{id}/cancel', [ReservationController::class, 'cancel'])
        ->middleware('role:Member,Kid')
        ->name('reservations.cancel');
});

/*
|--------------------------------------------------------------------------
| Role-Based Dashboards
|--------------------------------------------------------------------------
*/

// Admin routes - Consolidated all admin routes into one group
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'role:Admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard.admin.index');
    })->name('dashboard');

    // Search route
    Route::get('/search', [SearchController::class, 'search'])->name('search');

    // Categories Routes
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    // Suppliers Routes
    Route::prefix('suppliers')->name('suppliers.')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('index');
        Route::get('/create', [SupplierController::class, 'create'])->name('create');
        Route::post('/', [SupplierController::class, 'store'])->name('store');
        Route::get('/{supplier}/edit', [SupplierController::class, 'edit'])->name('edit');
        Route::put('/{supplier}', [SupplierController::class, 'update'])->name('update');
        Route::delete('/{supplier}', [SupplierController::class, 'destroy'])->name('destroy');
    });

    // Authors Routes
    Route::prefix('authors')->name('authors.')->group(function () {
        Route::get('/', [AuthorController::class, 'index'])->name('index');
        Route::get('/create', [AuthorController::class, 'create'])->name('create');
        Route::post('/', [AuthorController::class, 'store'])->name('store');
        Route::get('/{author}/edit', [AuthorController::class, 'edit'])->name('edit');
        Route::put('/{author}', [AuthorController::class, 'update'])->name('update');
        Route::delete('/{author}', [AuthorController::class, 'destroy'])->name('destroy');
    });

    // Users Routes - Make sure the name prefix is 'users.' (plural)
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });


    // Books Routes
    Route::prefix('books')->name('books.')->group(function () {
        Route::get('/', [BookController::class, 'index'])->name('index');
        Route::get('/create', [BookController::class, 'create'])->name('create');
        Route::post('/', [BookController::class, 'store'])->name('store');
        Route::get('/{book}/edit', [BookController::class, 'edit'])->name('edit');
        Route::put('/{book}', [BookController::class, 'update'])->name('update');
        Route::delete('/{book}', [BookController::class, 'destroy'])->name('destroy');
    });

    // StockIn Routes
    Route::prefix('stockins')->name('stockins.')->group(function () {
        Route::get('/', [StockInController::class, 'index'])->name('index');
        Route::get('/create', [StockInController::class, 'create'])->name('create');
        Route::post('/', [StockInController::class, 'store'])->name('store');
        Route::get('/{stockin}', [StockInController::class, 'show'])->name('show');
        Route::get('/{stockin}/edit', [StockInController::class, 'edit'])->name('edit');
        Route::put('/{stockin}', [StockInController::class, 'update'])->name('update');
        Route::delete('/{stockin}', [StockInController::class, 'destroy'])->name('destroy');

        // StockInDetail Routes
        Route::prefix('/{stockin}/details')->name('details.')->group(function () {
            Route::get('/create', [StockInDetailController::class, 'create'])->name('create');
            Route::post('/', [StockInDetailController::class, 'store'])->name('store');
            Route::get('/{detail}/edit', [StockInDetailController::class, 'edit'])->name('edit');
            Route::put('/{detail}', [StockInDetailController::class, 'update'])->name('update');
            Route::delete('/{detail}', [StockInDetailController::class, 'destroy'])->name('destroy');
        });
    });

    // ... other admin routes can be added here ...
});

// Member routes
Route::middleware(['auth', 'verified', 'role:Member'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.member.index');
    })->name('dashboard');
});

// Kid routes
Route::middleware(['auth', 'verified', 'role:Kid'])->prefix('kid')->name('kid.')->group(function () {

    // Dashboard main page
    Route::get('/dashboard', [KidDashboardController::class, 'index'])->name('dashboard');

    // Borrowed books
    Route::get('/borrowed', [BorrowedController::class, 'index'])->name('kidborrowed.index');
    Route::post('/borrow/{book}', [BorrowedController::class, 'create'])->name('kidborrow.create');
    Route::post('/borrow/{borrow}/renew', [BorrowedController::class, 'renew'])->name('kidborrow.renew');

    // Kid Reservations
Route::get('/reservations', [KidReservationController::class, 'index'])->name('kidreservation.index');
Route::post('/reserve/{book}', [KidReservationController::class, 'create'])->name('kidreservation.create');
Route::post('/reservations/{id}/cancel', [KidReservationController::class, 'cancel'])->name('kidreservation.cancel');


  // Fines & Payments
  Route::get('/fines', [KidFineController::class, 'index'])->name('kidfinepay.index');
Route::post('/fines/{fine}/pay', [KidFineController::class, 'pay'])->name('kidfines.pay');


    // Notifications
Route::get('/notifications', [KidNotificationController::class, 'index'])->name('kidnoti.index');

  // Contact Librarian (fixed, not nested)
    Route::get('/contact', [KidContactController::class, 'index'])->name('kidcontact.index');
    Route::post('/contact/send', [KidContactController::class, 'send'])->name('kidcontact.send');


    // Profile Settings
Route::get('/profile', [KidProfileController::class, 'edit'])->name('kidprofile.index');
Route::patch('/profile', [KidProfileController::class, 'update'])->name('kidprofile.update');
});
