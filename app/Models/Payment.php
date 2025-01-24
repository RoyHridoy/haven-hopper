<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

    protected $fillable = [
        'amount',
        'transaction_id',
        'transaction_details',
        'payment_status',
        'payment_method',
        'booking_id',
    ];

    protected $casts = [
        'transaction_details' => 'array',
        'payment_method' => PaymentMethod::class,
        'payment_status' => PaymentStatus::class,
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
