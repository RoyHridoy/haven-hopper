<?php

namespace App\Enums;

use App\Enums\Traits\EnumValues;

enum BookingStatus: string
{
    use EnumValues;

    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';
}
