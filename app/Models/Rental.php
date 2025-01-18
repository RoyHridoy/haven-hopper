<?php

namespace App\Models;

use App\Enums\RentalApprovalStatus;
use App\Enums\RentalType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function galleries()
    {
        return $this->morphMany(Image::class, 'imageable')->where('image_role', 'gallery');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable')->where('image_role', 'feature');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
