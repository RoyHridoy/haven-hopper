<?php

namespace App\Models;

use App\Enums\ReviewerType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;

    protected $fillable = [
        'rating',
        'comment',
        'reviewer_type',
        'review_by',
        'user_id',
        'rental_id',
    ];

    protected $casts = [
        'reviewer_type' => ReviewerType::class,
    ];

    public function reviewBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'review_by');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

}
