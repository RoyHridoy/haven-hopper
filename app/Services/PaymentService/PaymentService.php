<?php

namespace App\Services\PaymentService;

use Illuminate\Support\Facades\Route;

class PaymentService
{
    public static function register(): void
    {
        Route::prefix('payment')->name('payment.')->group(function () {
            Route::get('process/{booking}', function () {
                return 'Processing Payment';
            })->name('process');

            Route::get('create', function () {
                return 'Processing Payment';
            })->name('process');

            Route::get('success', function () {
                // validate transaction than success
                return 'Processing Payment';
            })->name('stripe.success');
        });
    }

    public function boot(): void
    {
        //
    }
}
