<?php

namespace App\Enums;

use App\Enums\Traits\EnumValues;

enum PaymentStatus: string
{
    use EnumValues;

    case SUCCESS = 'success';
    case FAILED = 'failed';
}
