<?php

namespace App\Models;

use App\Enums\ReviewerType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * Get the user who created the review.
     *
     * @return BelongsTo<User, $this>
     */
    public function reviewBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'review_by');
    }

    /**
     * Get the user being reviewed.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the rental associated with the review.
     *
     * @return BelongsTo<Rental, $this>
     */
    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }
}
