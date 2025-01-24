<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', HomeController::class)->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('bookings', [BookingController::class, 'index'])->middleware(['auth', 'verified'])->name('bookings.index');
Route::get('bookings/{rental}/availability', [BookingController::class, 'checkAvailability'])->middleware(['auth', 'verified'])->name('bookings.availability');
Route::post('bookings/{rental}/availability', [BookingController::class, 'availabilityValidate'])->middleware(['auth', 'verified'])->name('bookings.availabilityValidate');
Route::post('bookings/{rental}/checkout', [BookingController::class, 'checkout'])->middleware(['auth', 'verified'])->name('bookings.checkout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
