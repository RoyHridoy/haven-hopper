<?php

namespace App\Enums;

use App\Enums\Traits\EnumValues;

enum RentalType: string
{
    use EnumValues;

    case HOTEL = 'hotel';
    case GUEST_HOUSE = 'guest_house';
    case APARTMENT = 'apartment';
}
