<?php

namespace App\Models;

use App\Enums\ReportStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    /** @use HasFactory<\Database\Factories\ReportFactory> */
    use HasFactory;

    protected $fillable = [
        'reason',
        'status',
        'report_by',
        'report_to',
    ];

    protected $casts = [
        'status' => ReportStatus::class,
    ];
}
