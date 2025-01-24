<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    /** @use HasFactory<\Database\Factories\ImageFactory> */
    use HasFactory;

    protected $fillable = [
        'path',
        'imageable_id',
        'imageable_type',
        'image_role',
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
