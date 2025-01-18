<?php

namespace App\Enums;

enum ReviewerType: string
{
    case USER = 'user';
    case RENTAL_OWNER = 'rental_owner';
}
