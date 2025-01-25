<?php

namespace App\Rules;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Rental;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckBookingAvailability implements ValidationRule
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

            return;
        }

        $checkInDate = request('check_in_date');
        $checkOutDate = request('check_out_date');

        // Ensure check-out date exists in the request
        if (! $checkOutDate) {
            $fail('The check-out date is required');

            return;
        }

        // Check for overlapping bookings
        $overlap = Booking::where([
            'rental_id' => $this->rentalId,
            'status' => BookingStatus::APPROVED,
        ])
            ->where(function ($query) use ($checkInDate, $checkOutDate) {
                $query->whereBetween('check_in_date', [$checkInDate, $checkOutDate])
                    ->orWhereBetween('check_out_date', [$checkInDate, $checkOutDate])
                    ->orWhere(function ($query) use ($checkInDate, $checkOutDate) {
                        $query->whereDate('check_in_date', '<', $checkInDate)
                            ->whereDate('check_out_date', '>', $checkOutDate);
                    });
            })->exists();

        if ($overlap) {
            $fail('The selected date range is already booked.');
        }
    }
}
