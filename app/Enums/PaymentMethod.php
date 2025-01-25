<?php

namespace App\Enums;

use App\Enums\Traits\EnumValues;

enum PaymentMethod: string
{
    use EnumValues;

    case CREDIT_CARD = 'credit_card';
    case PAYPAL = 'paypal';
    case STRIPE = 'stripe';
}
