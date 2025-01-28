<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\PaymentService\PaymentProcessor;
use Illuminate\Http\Request;

class StripePaymentController
{
    public function process(Booking $booking): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('stripe.payments', ['booking' => $booking]);
    }

    public function create(Booking $booking, Request $request)
    {

        $user = \App\Models\User::query()->where('id', $booking->user_id)->first();

        $stripeInstance = (new PaymentProcessor($user, $booking))->getProcessor($user, $booking, 'stripe');
        $paymentIntent = $stripeInstance->client()->paymentIntents->create([
            'amount' => ($booking->total_price * 100),
            'currency' => env('STRIPE_CURRENCY', 'usd'),
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);

        return response()->json(['clientSecret' => $paymentIntent->client_secret]);
    }

    public function success(Request $request)
    {
        return view('stripe.success');
    }
}
