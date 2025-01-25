<?php

namespace App\Services\PaymentService;

use App\Models\Booking;
use App\Models\User;
use App\Services\PaymentService\Processors\CashProcessor;

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
        if (! in_array($provider, array_keys(static::$processors))) {
            throw new PaymentFailedException('Payment Processor not found');
        }

        $processorInstance = new self($user, $booking);

        $currentProcessor = static::$processors[$provider]['processor'];

        try {
            $processor = new $currentProcessor($processorInstance->user, $processorInstance->booking);
            $processor->process();
        } catch (\Exception $th) {
            throw new PaymentFailedException('Payment Failed');
        }
    }
}
