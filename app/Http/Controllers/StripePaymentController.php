<?php

namespace App\Http\Controllers;

use App\Enums\BookingPaymentStatus;
use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Services\PaymentService\PaymentFailedException;
use App\Services\PaymentService\PaymentProcessor;
use Illuminate\Http\Request;

class StripePaymentController
{
    public function process(Booking $booking): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('stripe.payments', ['booking' => $booking]);
    }

    /**
     * @throws PaymentFailedException
     */
    public function create(Booking $booking, Request $request)
    {


        $stripeInstance = PaymentProcessor::create()->getProcessor('stripe');

        $paymentIntent = $stripeInstance->client()->paymentIntents->create([
            'amount' => ($booking->total_price * 100),
            'currency' => env('STRIPE_CURRENCY', 'usd'),
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
            'metadata' => ['booking_id' => $booking->id],
        ]);

        return response()->json(['clientSecret' => $paymentIntent->client_secret]);
    }

    public function success(Request $request)
    {
        $stripeInstance = PaymentProcessor::create()->getProcessor('stripe');
        $paymentIntent = $stripeInstance->client()->paymentIntents->retrieve($request->payment_intent);

        $booking = Booking::query()->where('id', $paymentIntent->metadata->booking_id)->first();

        if ($paymentIntent->status !== 'succeeded') {

            $booking->update([
                'payment_status' => BookingPaymentStatus::FAILED,
                'status' => BookingStatus::PENDING,
            ]);

            return redirect()->route('bookings.index')->with([
                'message' => [
                    'body' => 'You have successfully failed to make payment.',
                    'type' => 'error',
                ],
            ]);
        }

        $booking->update([
            'payment_status' => BookingPaymentStatus::PAID,
            'status' => BookingStatus::APPROVED,
        ]);

        return redirect()->route('bookings.index')->with([
            'message' => [
                'body' => 'Successfully Created Booking',
                'type' => 'success',
            ],
        ]);
    }

    public function failed()
    {
        return 'Payment failed';
    }
}
