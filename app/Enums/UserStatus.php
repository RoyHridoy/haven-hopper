<?php

namespace App\Enums;

enum UserStatus: string
{
    case ACTIVE = 'active';
    case BLACKLISTED = 'blacklisted';
}
