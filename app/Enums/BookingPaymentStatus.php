<?php

namespace App\Enums;

use App\Enums\Traits\EnumValues;

enum BookingPaymentStatus: string
{
    use EnumValues;

    case PENDING = 'pending';
    case PAID = 'paid';
    case FAILED = 'failed';
}
