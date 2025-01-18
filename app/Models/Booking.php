<?php

namespace App\Models;

use App\Enums\BookingPaymentStatus;
use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /** @use HasFactory<\Database\Factories\BookingFactory> */
    use HasFactory;

    protected $fillable = [
        'check_in_date',
        'check_out_date',
        'total_guests',
        'price',
        'total_price',
        'discount',
        'tax',
        'convenience_fee',
        'status',
        'payment_status',
        'user_id',
        'rental_id',
    ];

    protected $casts = [
        'check_in_date' => 'datetime',
        'check_out_date' => 'datetime',
        'status' => BookingStatus::class,
        'payment_status' => BookingPaymentStatus::class,
    ];
}
