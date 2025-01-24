<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favorite extends Model
{
    /** @use HasFactory<\Database\Factories\FavoriteFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rental_id',
    ];
}
