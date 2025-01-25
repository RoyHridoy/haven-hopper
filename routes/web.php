<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', HomeController::class)->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');
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

require __DIR__.'/auth.php';
