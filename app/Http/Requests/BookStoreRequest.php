<?php

namespace App\Http\Requests;

use App\DTO\UserAddressDTO;
use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        UserAddressDTO::validate($this->billing_address);

        return [
            'check_in_date' => [
                'required',
                'date',
                'after_or_equal:today',
                function ($attribute, $value, $fail) {
                    $checkInDate = request('check_in_date');
                    $checkOutDate = request('check_out_date');

                    // Ensure check-out date exists in the request
                    if (! $checkOutDate) {
                        $fail('The check-out date is required');

                        return;
                    }

                    // Check for overlapping bookings
                    $overlap = Booking::where([
                        'rental_id' => $this->route('rental'),
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
                },
            ],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
            'total_guests' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'total_price' => ['required', 'numeric'],
            'user_name' => ['required', 'string'],
            'user_email' => ['required', 'email'],
            'billing_address' => ['required', 'array'],
            'discount' => ['nullable', 'numeric'],
            'tax' => ['nullable', 'numeric'],
            'paymentMethod' => ['required', 'in:cash,stripe'],
            'convenience_fee' => ['nullable', 'numeric'],
            'status' => ['nullable', Rule::enum(BookingStatus::class)],
            'payment_status' => ['nullable', Rule::enum(PaymentStatus::class)],
            'user_phone' => ['nullable', 'string'],
        ];
    }
}
