<?php

use App\Http\Controllers\BecomeHostController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/become-a-host', [BecomeHostController::class, 'index'])->name('host.index');
Route::get('/search', SearchController::class)->name('search');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('register-host', [BecomeHostController::class, 'generateRegisterForm'])->name('host.form');
    Route::post('register-host', [BecomeHostController::class, 'register'])->name('host.register');
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

    Route::get('/process/{booking}', function (\Illuminate\Http\Request $request) {

        $booking = \App\Models\Booking::first();

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => ($booking->total_price * 100),
            'currency' => 'usd', // pull currency from env
            // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);

        return view('stripe.payments', [
            'booking' => $booking,
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    });

    Route::post('create', function () {
        $booking = \App\Models\Booking::first();

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => ($booking->total_price * 100),
            'currency' => 'usd',
            // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
            'automatic_payment_methods' => [
                'enabled' => false,
            ],
        ]);

        return response()->json(['clientSecret' => $paymentIntent->client_secret]);
    });




    Route::get('success', function(){
        // validate transaction than success
        return view('stripe.success');
    })->name('stripe.success');
});

require __DIR__.'/auth.php';



// create an intent id.
// create a charge
// render a form
// intent,
