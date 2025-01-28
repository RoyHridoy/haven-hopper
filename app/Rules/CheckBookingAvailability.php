<?php

namespace App\Rules;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Rental;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

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
        }

        // Ensure check-out date exists in the request
        if (! request('check_out_date')) {
            $fail('The check-out date is required');
        }

        $requestCheckInDate = Carbon::parse(request('check_in_date'));
        $requestCheckOutDate = Carbon::parse(request('check_out_date'));

        // Check for overlapping bookings
        $overlap = Booking::where([
            'rental_id' => $this->rentalId,
            'status' => BookingStatus::APPROVED,
        ])
            ->where(function ($query) use ($requestCheckInDate, $requestCheckOutDate) {
                $query->where('check_in_date', '<', $requestCheckOutDate)
                    ->where('check_out_date', '>', $requestCheckInDate);
            })->exists();

        if ($overlap) {
            $fail('The selected date range is already booked.');
            session()->flash('message', [
                'body' => 'The selected date range is already booked.',
                'type' => 'error',
            ]);
        }
    }
}
