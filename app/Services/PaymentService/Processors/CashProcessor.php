<?php

namespace App\Services\PaymentService\Processors;

use App\Enums\BookingPaymentStatus;
use App\Models\Booking;
use App\Models\User;

class CashProcessor
{
    public function process(User $user, Booking $booking, object $processor): mixed
    {
        $booking->update(['payment_status' => BookingPaymentStatus::PENDING]);

        return redirect()->to(route('bookings.index'))->with([
            'message' => [
                'body' => 'You booking is created. Wait for admin approval',
                'type' => 'warning',
            ],
        ]);
    }
}
