<?php

namespace App\Services\PaymentService;

use App\Models\Booking;
use App\Models\User;
use App\Services\PaymentService\Processors\CashProcessor;

class PaymentProcessor
{
    protected static array $processors = [
        'cash' => [
            'name' => 'Cash',
            'processor' => CashProcessor::class,
        ],
    ];

    public function __construct(public User $user, public Booking $booking){
        //
    }

    public static function availableProviders(){
        $availableMethods = [];
        foreach (static::$processors as $key => $value) {
            $availableMethods[] = [
                'value' => $key,
                'name' => $value['name'],
            ];
        }
        return $availableMethods;
    }

    public static function process(User $user, Booking $booking, $provider){
        if (!in_array($provider, array_keys(static::$processors))) {
            throw new PaymentFailedException('Payment Processor not found');
        }
        $processorInstance = new static($user, $booking);

        $currentProcessor = static::$processors[$provider]['processor'];

        try {
            $processor = new $currentProcessor($processorInstance->user, $processorInstance->booking);
            $processor->process();
        } catch (\Exception $th) {
            throw new PaymentFailedException('Payment Failed');
        }
    }
}
