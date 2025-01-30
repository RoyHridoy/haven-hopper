<?php

namespace App\Rules;

use App\Models\Booking;
use App\Models\Rental;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class CheckBookingDateAvailability implements ValidationRule
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
        if (! Rental::where('id', $this->rentalId)->exists()) {
            $fail('The rental does not exists');
        }

        $requestCheckInDate = Carbon::parse(request('check_in_date'));
        $requestCheckOutDate = Carbon::parse(request('check_out_date'));

        // Check for overlapping bookings
        if (Booking::where('rental_id', $this->rentalId)->approved()->overlap($requestCheckInDate, $requestCheckOutDate)->exists()) {
            $fail('The selected date range is already booked.');
        }
    }
}
