<?php

namespace App\Models;

use App\Enums\RentalApprovalStatus;
use App\Enums\RentalType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
