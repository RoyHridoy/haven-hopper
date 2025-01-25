<?php

namespace App\Http\Requests;

use App\Enums\RentalType;
use App\Enums\RentalApprovalStatus;
use Illuminate\Foundation\Http\FormRequest;

class StoreRentalRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'rental_type' => 'required|string|in:' . implode(',', RentalType::values()),
            'price' => 'required|integer|min:0',
            'total_guests' => 'required|integer|min:1',
            'guest_on_requests' => 'nullable|integer|min:0',
            'extra_guests_charge' => 'nullable|integer|min:0',
            'rating' => 'nullable|numeric|min:0|max:5',
            'description' => 'nullable|string',
            'approval_status' => 'required|string|in:' . implode(',', RentalApprovalStatus::values()),
            'owner_id' => 'required|exists:users,id',
            'location_id' => 'required|exists:locations,id'
        ];
    }
}
