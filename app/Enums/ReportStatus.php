<?php

namespace App\Enums;

enum ReportStatus: string
{
    case PENDING = 'pending';
    case RESOLVED = 'resolved';
}
