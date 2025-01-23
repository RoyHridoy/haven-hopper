<?php

namespace App\Models;

use App\Enums\RentalApprovalStatus;
use App\Enums\RentalType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Rental extends Model
{
    /** @use HasFactory<\Database\Factories\RentalFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'rental_type',
        'price',
        'description',
        'approval_status',
        'rating',
        'owner_id',
        'location_id',
    ];

    protected $casts = [
        'rating' => 'float',
        'approval_status' => RentalApprovalStatus::class,
        'rental_type' => RentalType::class,
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
     * Get all the gallery images of the rental.
     *
     * @return MorphMany<Image, $this>
     */
    public function galleries(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable')->where('image_role', 'gallery');
    }

    /**
     * Get the featured image of the rental.
     *
     * @return MorphOne<Image, $this>
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->where('image_role', 'feature');
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
}
