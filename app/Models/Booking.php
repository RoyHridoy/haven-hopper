<?php

namespace App\Models;

use App\Enums\BookingPaymentStatus;
use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'user_name',
        'user_email',
        'discount',
        'tax',
        'convenience_fee',
        'status',
        'payment_status',
        'billing_address',
        'user_id',
        'rental_id',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'status' => BookingStatus::class,
        'payment_status' => BookingPaymentStatus::class,
        'billing_address' => 'array',
    ];

    /**
     * Get the user who is booked.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the rental of the booking.
     *
     * @return BelongsTo<Rental, $this>
     */
    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

    /**
     * Get the payment of the booking.
     *
     * @return HasMany<Payment, $this>
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Summary of scopeOverlap
     *
     * @param  mixed  $query
     * @param  mixed  $checkInDate
     * @param  mixed  $checkOutDate
     */
    public function scopeOverlap($query, $checkInDate, $checkOutDate): mixed
    {
        return $query->where(function ($query) use ($checkInDate, $checkOutDate) {
            $query->where('check_in_date', '<', $checkOutDate)
                ->where('check_out_date', '>', $checkInDate);
        });
    }

    /**
     * @param  mixed  $query
     */
    public function scopeApproved($query): mixed
    {
        return $query->where('status', BookingStatus::APPROVED);
    }
}
