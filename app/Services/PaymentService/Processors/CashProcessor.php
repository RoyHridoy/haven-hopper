<?php

namespace App\Services\PaymentService\Processors;

use App\Enums\BookingPaymentStatus;
use App\Models\Booking;
use App\Models\User;

class CashProcessor
{
    public function __construct(public User $user, public Booking $booking) {}

    public function process(): void
    {
        $this->booking->update([
            'payment_status' => BookingPaymentStatus::PENDING,
        ]);
    }
}
