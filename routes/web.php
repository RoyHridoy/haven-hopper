<?php

use App\Http\Controllers\BecomeHostController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RentalShowController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Middleware\UsersOnlyMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/become-a-host', [BecomeHostController::class, 'index'])->name('host.index');
Route::get('/search', SearchController::class)->name('search');
Route::get('/rentals/{rental}', RentalShowController::class)->name('rental.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('register-host', [BecomeHostController::class, 'generateRegisterForm'])->name('host.form')->middleware(UsersOnlyMiddleware::class);
    Route::post('register-host', [BecomeHostController::class, 'register'])->name('host.register')->middleware(UsersOnlyMiddleware::class);
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{rental}/availability', [BookingController::class, 'checkAvailability'])->name('bookings.availability');
    Route::post('bookings/{rental}/availability', [BookingController::class, 'availabilityValidate'])->name('bookings.availabilityValidate');
    Route::get('bookings/{rental}/checkout', [BookingController::class, 'checkout'])->name('bookings.checkout');
    Route::post('bookings/{rental}/checkout', [BookingController::class, 'storeBooking'])->name('bookings.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/process/{booking}', [StripePaymentController::class, 'process'])->name('process');
    Route::post('create/{booking}', [StripePaymentController::class, 'create'])->name('stripe.create');
    Route::get('success', [StripePaymentController::class, 'success'])->name('stripe.success');
    Route::get('failed', [StripePaymentController::class, 'failed'])->name('stripe.failed');
    Route::get('success-page', [StripePaymentController::class, 'successPage'])->name('stripe.success.page');
});

require __DIR__.'/auth.php';
