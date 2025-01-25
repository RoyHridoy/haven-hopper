<?php

namespace App\Http\Requests;

use App\Enums\ReviewerType;
use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
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
            'rating' => 'required|numeric|min:0|max:5',
            'comment' => 'nullable|string',
            'reviewer_type' => 'required|string|in:'.implode(',', ReviewerType::values()),
            'review_by' => 'required|exists:users,id',
            'user_id' => 'required|exists:users,id',
            'rental_id' => 'required|exists:rentals,id',
        ];
    }
}
