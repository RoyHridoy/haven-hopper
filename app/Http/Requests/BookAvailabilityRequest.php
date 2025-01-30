<?php

namespace App\Http\Requests;

use App\Rules\CheckBookingDateAvailability;
use Illuminate\Foundation\Http\FormRequest;

class BookAvailabilityRequest extends FormRequest
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
            'check_in_date' => ['required', 'date', 'after_or_equal:today', new CheckBookingDateAvailability($this->rental_id)],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
        ];
    }
}
