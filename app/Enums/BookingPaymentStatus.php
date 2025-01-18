<?php

namespace App\Enums;

enum BookingPaymentStatus: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case FAILED = 'failed';
}
