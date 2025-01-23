<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $title
 * @property string $rental_type
 * @property int $price
 * @property int $total_guests
 * @property float $rating
 */
class RentalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->rental_type,
            'price' => $this->price,
            'totalGuests' => $this->total_guests,
            'rating' => $this->rating,
        ];
    }
}
