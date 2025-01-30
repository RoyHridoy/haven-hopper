<?php

namespace App\Services\PaymentService;

use App\Enums\BookingPaymentStatus;
use App\Models\Booking;
use App\Models\User;
use App\Services\PaymentService\Processors\CashProcessor;
use App\Services\PaymentService\Processors\StripeProcessor;

class PaymentProcessor
{
    /**
     * @var array<string, array{name: string, description: string, processor: class-string}>
     */
    protected static array $processors = [
        'cash' => [
            'name' => 'Cash',
            'description' => 'Pay when you checked in',
            'processor' => CashProcessor::class,
        ],
        'stripe' => [
            'name' => 'Stripe',
            'description' => 'Pay online using your credit card',
            'processor' => StripeProcessor::class,
        ],
    ];

    public function __construct(public ?string $successUrl = null, public ?string $cancelUrl = null)
    {
        $this->successUrl = route('payment.stripe.success');
        $this->cancelUrl = route('payment.stripe.failed');
    }

    /**
     * @return array<array{ value: string, name: string, description: string}>
     */
    public static function availableProviders(): array
    {
        $availableMethods = [];

        foreach (static::$processors as $key => $value) {
            $availableMethods[] = [
                'value' => $key,
                'name' => $value['name'],
                'description' => $value['description'],
            ];
        }

        return $availableMethods;
    }

    public function process(User $user, Booking $booking, string $provider): mixed
    {

        if ($this->hasProcessor($provider) === false) {
            $booking->update(['payment_status' => BookingPaymentStatus::FAILED]);

            return redirect()->to($this->cancelUrl);

        }

        $processor = $this->getProcessor($provider);

        return $processor->process($user, $booking, $this);
    }

    public function getProcessor(string $provider): mixed
    {
        if (! in_array($provider, array_keys(static::$processors))) {
            throw new PaymentFailedException('Payment Processor not found');
        }

        $currentProcessor = static::$processors[$provider]['processor'];

        return new $currentProcessor;
    }

    public static function create(?string $successUrl = null, ?string $cancelUrl = null): self
    {
        return new self($successUrl, $cancelUrl);
    }

    public function hasProcessor(string $providerName): bool
    {
        return array_key_exists($providerName, static::$processors);
    }

    public function getSuccessUrl(): string
    {
        return $this->successUrl;
    }

    public function getCancelUrl(): string
    {
        return $this->cancelUrl;
    }
}
