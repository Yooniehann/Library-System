<?php

use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Http\Controllers\{
    AuthorController,
    BookController,
    BookCopyController,
    BorrowRecordController,
    CategoryController,
    FeedbackController,
    FineController,
    NotificationController,
    ProfileController,
    PublisherController,
    ReservationController,
    UserController
};

/*
|--------------------------------------------------------------------------
| Public Routes (accessible to all users)
|--------------------------------------------------------------------------
*/

// Home Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Static Pages
Route::view('/about', 'static.about')->name('about');
Route::view('/contact', 'static.contact')->name('contact');
Route::view('/faq', 'static.faq')->name('faq');
Route::view('/privacy', 'static.privacy')->name('privacy');
Route::view('/terms', 'static.terms')->name('terms');

// Book Catalog
Route::controller(BookController::class)->name('books.')->group(function () {
    Route::get('/books', 'index')->name('index');
    Route::get('/books/search', 'search')->name('search');
    Route::get('/books/{book}', 'show')->name('show');
});

// sitemap
Route::get('/sitemap.xml', function() {
    return Sitemap::create()
        ->add(Url::create('/'))
        ->add(Url::create('/books'))
        ->add(Url::create('/categories'))
        // Add all your important routes
        ->writeToFile(public_path('sitemap.xml'));
});

/*
|--------------------------------------------------------------------------
| Authentication Routes (Laravel Breeze/UI)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::controller(ProfileController::class)->name('profile.')->group(function () {
        Route::get('/profile', 'edit')->name('edit');
        Route::patch('/profile', 'update')->name('update');
        Route::delete('/profile', 'destroy')->name('destroy');
    });

    // Borrowing System
    Route::controller(BorrowRecordController::class)->name('borrowed.')->prefix('borrowed')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/{bookCopy}', 'store')->name('store');
        Route::post('/return/{borrowRecord}', 'return')->name('return');
    });

    // Reservations
    Route::controller(ReservationController::class)->name('reservations.')->prefix('reservations')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/{book}', 'store')->name('store');
        Route::delete('/{reservation}', 'destroy')->name('destroy');
    });

    // Feedback
    Route::resource('feedback', FeedbackController::class)->only(['index', 'store']);

    // Notifications
    Route::controller(NotificationController::class)->name('notifications.')->prefix('notifications')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/mark-as-read', 'markAsRead')->name('markAsRead');
    });

    // Fines
    Route::get('/fines', [FineController::class, 'index'])->name('fines.index');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Books Management
    Route::controller(BookController::class)->name('books.')->prefix('books')->group(function () {
        Route::get('/', 'adminIndex')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{book}/edit', 'edit')->name('edit');
        Route::put('/{book}', 'update')->name('update');
        Route::delete('/{book}', 'destroy')->name('destroy');
    });

    // Book Copies Management
    Route::resource('book-copies', BookCopyController::class)->except(['show']);

    // Authors Management
    Route::resource('authors', AuthorController::class)->except(['show']);

    // Publishers Management
    Route::resource('publishers', PublisherController::class)->except(['show']);

    // Categories Management
    Route::resource('categories', CategoryController::class)->except(['index', 'show']);

    // Borrow Records Management
    Route::controller(BorrowRecordController::class)->name('borrow-records.')->prefix('borrow-records')->group(function () {
        Route::get('/', 'adminIndex')->name('index');
        Route::post('/approve/{borrowRecord}', 'approve')->name('approve');
        Route::post('/reject/{borrowRecord}', 'reject')->name('reject');
    });

    // User Management
    Route::controller(UserController::class)->name('users.')->prefix('users')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/{user}/promote', 'promote')->name('promote');
        Route::post('/{user}/demote', 'demote')->name('demote');
        Route::post('/{user}/suspend', 'suspend')->name('suspend');
        Route::post('/{user}/activate', 'activate')->name('activate');
    });

    // Fines Management
    Route::controller(FineController::class)->name('fines.')->prefix('fines')->group(function () {
        Route::get('/', 'adminIndex')->name('index');
        Route::post('/{fine}/waive', 'waive')->name('waive');
        Route::post('/{fine}/pay', 'markAsPaid')->name('markAsPaid');
    });

    // Reservations Management
    Route::get('/reservations', [ReservationController::class, 'adminIndex'])->name('reservations.index');

    // Feedback Management
    Route::get('/feedback', [FeedbackController::class, 'adminIndex'])->name('feedback.index');
});
