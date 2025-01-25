<?php

namespace App\Enums;

use App\Enums\Traits\EnumValues;

enum ReviewerType: string
{
    use EnumValues;

    case USER = 'user';
    case RENTAL_OWNER = 'rental_owner';
}
