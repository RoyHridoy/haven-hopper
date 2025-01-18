<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case RENTAL_OWNER = 'rental_owner';
    case USER = 'user';
}
