<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $title
 * @property string $rental_type
 * @property int $price
 * @property int $total_guests
 * @property float $rating
 * @property string $check_in_time
 * @property string $check_out_time
 * @property LocationResource $location
 * @property AmenityResource $amenities
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
            'checkInTime' => Carbon::parse($this->check_in_time)->format('h:i:s A'),
            'checkOutTime' => Carbon::parse($this->check_out_time)->format('h:i:s A'),
            'location' => new LocationResource($this->location),
            'amenities' => AmenityResource::collection($this->amenities),
        ];
    }
}
