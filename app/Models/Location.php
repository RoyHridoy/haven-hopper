<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    /** @use HasFactory<\Database\Factories\LocationFactory> */
    use HasFactory;

    protected $fillable = [
        'country',
        'city',
        'state',
        'latitude',
        'longitude',
    ];
}
