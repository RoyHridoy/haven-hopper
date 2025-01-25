<?php

namespace App\Http\Requests;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:0',
            'transaction_id' => 'required|string|max:255',
            'transaction_details' => 'nullable|array',
            'payment_status' => 'required|string|in:'.implode(',', PaymentStatus::values()),
            'payment_method' => 'required|string|in:'.implode(',', PaymentMethod::values()),
            'booking_id' => 'required|exists:booking,id',
        ];
    }
}
