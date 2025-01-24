<?php

namespace App\Models;

use App\Enums\ReportStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * Get the user who reported.
     *
     * @return BelongsTo<User, $this>
     */
    public function reportBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'report_by');
    }

    /**
     * Get the user who is reported.
     *
     * @return BelongsTo<User, $this>
     */
    public function reportTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'report_to');
    }
}
