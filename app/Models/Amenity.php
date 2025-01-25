<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Amenity extends Model
{
    /** @use HasFactory<\Database\Factories\AmenityFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
    ];

    /**
     * Get the rentals associated with the amenity.
     *
     * @return BelongsToMany<Rental, $this>
     */
    public function rentals(): BelongsToMany
    {
        return $this->belongsToMany(Rental::class);
    }
}
