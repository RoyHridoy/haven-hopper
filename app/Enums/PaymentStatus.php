<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case SUCCESS = 'success';
    case FAILED = 'failed';
}
