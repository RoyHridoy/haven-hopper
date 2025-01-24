<?php

namespace App\Http\Requests;

use App\DTO\UserAddressDTO;
use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
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
            'check_in_date' => ['required', 'date'],
            'check_out_date' => ['required', 'date'],
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
