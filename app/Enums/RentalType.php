<?php

namespace App\Enums;

enum RentalType: string
{
    case HOTEL = 'hotel';
    case GUEST_HOUSE = 'guest_house';
    case APARTMENT = 'apartment';
}
