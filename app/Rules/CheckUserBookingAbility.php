<?php

namespace App\Rules;

use App\Models\Rental;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckUserBookingAbility implements ValidationRule
{
    public function __construct(protected int $rentalId) {}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Rental::query()->where('id', $this->rentalId)->where('owner_id', auth()->id())->exists()) {
            $fail('You can not book your own rental.');
        }
    }
}
