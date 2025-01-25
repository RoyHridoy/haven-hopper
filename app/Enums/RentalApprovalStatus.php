<?php

namespace App\Enums;

use App\Enums\Traits\EnumValues;

enum RentalApprovalStatus: string
{
    use EnumValues;

    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
