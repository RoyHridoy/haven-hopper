<?php

namespace App\Services\PaymentService\Processors;

use App\Services\PaymentService\Concern\PaymentProcessorConcern;
use Stripe\StripeClient;

class StripeProcessor extends PaymentProcessorConcern
{
    protected StripeClient $client;

    public function __construct()
    {
        $this->client = new StripeClient(env('STRIPE_SECRET'));
    }

    public function process($user, $booking): mixed
    {
        return redirect()->route('payment.process', ['booking' => $booking->id]);
    }

    public function client(): StripeClient
    {
        return $this->client;
    }
}
