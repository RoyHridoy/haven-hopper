<?php

namespace App\Services\PaymentService\Processors;

use App\Models\Booking;
use App\Models\User;

class CashProcessor
{
    public function __construct(public User $user, public Booking $booking){

    }

    public function process(){
        $this->booking->update([
            'payment_status' => 'paid'
        ]);
    }
}
