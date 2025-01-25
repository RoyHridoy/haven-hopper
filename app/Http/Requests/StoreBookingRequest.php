<?php

namespace App\Http\Requests;

use App\Enums\BookingPaymentStatus;
use App\Enums\BookingStatus;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'total_guests' => 'required|integer|min:1',
            'price' => 'required|integer|min:0',
            'total_price' => 'required|integer|min:0',
            'discount' => 'nullable|integer|min:0',
            'tax' => 'nullable|numeric|min:0',
            'convenience_fee' => 'nullable|integer|min:0',
            'status' => 'required|string|in:'.implode(',', BookingStatus::values()),
            'payment_status' => 'required|string|in:'.implode(',', BookingPaymentStatus::values()),
            'user_id' => 'required|exists:users,id',
            'rental_id' => 'required|exists:rentals,id',
        ];
    }
}
