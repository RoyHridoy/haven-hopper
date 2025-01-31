<?php

namespace App\Models;

use App\Enums\RentalApprovalStatus;
use App\Enums\RentalType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rental extends Model
{
    /** @use HasFactory<\Database\Factories\RentalFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'rental_type',
        'total_guests',
        'guest_on_requests',
        'extra_guests_charge',
        'price',
        'description',
        'approval_status',
        'rating',
        'images',
        'owner_id',
        'location_id',
    ];

    protected $casts = [
        'rating' => 'float',
        'total_guests' => 'integer',
        'approval_status' => RentalApprovalStatus::class,
        'rental_type' => RentalType::class,
        'images' => 'array',
    ];

    /**
     * Get the amenities associated with the rental.
     *
     * @return BelongsToMany<Amenity, $this>
     */
    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class);
    }

    /**
     * Get the location of the Rental.
     *
     * @return BelongsTo<Location, $this>
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the owner of the rental.
     *
     * @return BelongsTo<User, $this>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get all the bookings of the rental.
     *
     * @return HasMany<Booking, $this>
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get all the reviews of the rental.
     *
     * @return HasMany<Review, $this>
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the user who keep favorite this rental.
     *
     * @return HasMany<Favorite, $this>
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * @param  mixed  $query
     */
    public function scopeApproved($query): mixed
    {
        return $query->where('approval_status', RentalApprovalStatus::APPROVED);
    }

    /**
     * @param  mixed  $query
     * @param  string  $checkInDate
     * @param  string  $checkOutDate
     */
    public function scopeAvailableIn($query, $checkInDate, $checkOutDate): mixed
    {
        return $query
            ->whereDoesntHave('bookings', fn ($query) => $query
                ->overlap(Carbon::parse($checkInDate), Carbon::parse($checkOutDate))
                ->approved()
            );
    }

    /**
     * @param  mixed  $query
     * @param  string  $cityName
     */
    public function scopeByCity($query, $cityName): mixed
    {
        return $query
            ->whereHas('location', fn ($query) => $query
                ->where('city', $cityName));
    }

    /**
     * @param  mixed  $query
     * @param  mixed  $categoryName
     */
    public function scopeByCategory($query, $categoryName): mixed
    {
        return $query->where('rental_type', $categoryName);
    }
}
