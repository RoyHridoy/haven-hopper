<?php

namespace App\Services\PaymentService\Processors;

use App\Enums\BookingPaymentStatus;
use App\Models\Booking;
use App\Models\User;

class CashProcessor
{
    public function process(User $user, Booking $booking, $processor): mixed
    {
        $booking->update(['payment_status' => BookingPaymentStatus::PENDING]);

        return redirect()->to($processor->getSuccessUrl());
    }
}
