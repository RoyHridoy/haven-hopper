<?php

namespace App\Enums\Traits;

trait EnumValues
{
    /**
     * Get all values of the enum.
     *
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
