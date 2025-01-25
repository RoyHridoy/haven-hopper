<?php

namespace App\Enums;

use App\Enums\Traits\EnumValues;

enum ReportStatus: string
{
    use EnumValues;

    case PENDING = 'pending';
    case RESOLVED = 'resolved';
}
