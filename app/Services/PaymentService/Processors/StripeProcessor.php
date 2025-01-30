<?php

namespace App\Services\PaymentService\Processors;

use App\Models\Booking;
use App\Models\User;
use App\Services\PaymentService\Concern\PaymentProcessorConcern;
use Inertia\Inertia;
use Stripe\StripeClient;

class StripeProcessor extends PaymentProcessorConcern
{
    protected StripeClient $client;

    public function __construct()
    {
        $this->client = new StripeClient(config('services.stripe.secret'));
    }

    public function process(User $user, Booking $booking): mixed
    {
        return Inertia::location(route('payment.process', ['booking' => $booking->id]));
    }

    public function client(): StripeClient
    {
        return $this->client;
    }
}
