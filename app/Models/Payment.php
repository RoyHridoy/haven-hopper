<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
