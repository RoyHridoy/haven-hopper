<?php

namespace App\Rules;

use App\Models\Rental;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TotalGuests implements ValidationRule
{
    public function __construct(protected int $rentalId)
    {
        //
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $rental = Rental::find($this->rentalId);

        if (! $rental) {
            $fail('The rental does not exists');
        }

        if ($value > $rental->total_guests) {
            $fail('The total guests must not exceed the allowed guests for this rental.');
        }
    }
}
