<?php

namespace App\Models;

use App\Enums\ReviewerType;
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
}
