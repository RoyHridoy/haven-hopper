<?php

namespace App\Services\PaymentService;

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
            'description' => 'Pay when you check in',
            'processor' => CashProcessor::class,
        ],
        'stripe' => [
            'name' => 'Stripe',
            'description' => 'Pay online using your credit card',
            'processor' => StripeProcessor::class,
        ],
    ];

    public function __construct(public User $user, public Booking $booking)
    {
        //
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

    public static function process(User $user, Booking $booking, string $provider): void
    {
        $processor = static::create($user, $booking)->getProcessor($user, $booking, $provider);

        try {
            $processor->process($user, $booking);
        } catch (\Exception $th) {
            throw new PaymentFailedException('Payment Failed');
        }
    }

    public function getProcessor(User $user, Booking $booking, string $provider)
    {
        if (! in_array($provider, array_keys(static::$processors))) {
            throw new PaymentFailedException('Payment Processor not found');
        }

        $processorInstance = static::create($user, $booking);
        $currentProcessor = static::$processors[$provider]['processor'];

        return new $currentProcessor($processorInstance->user, $processorInstance->booking);
    }

    public static function create(User $user, Booking $booking)
    {
        return new static($user, $booking);
    }
}
