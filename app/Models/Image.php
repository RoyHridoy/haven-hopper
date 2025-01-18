<?php

namespace App\Models;

class Image extends Model
{
    public function imagable()
    {
        return $this->morphTo();
    }
}
