<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property \Carbon\Carbon $check_in_date
 * @property \Carbon\Carbon $check_out_date
 * @property string $status
 * @property string $payment_status
 * @property float $price
 * @property float $tax
 * @property float $discount
 * @property float $total_price
 * @property int $total_guests
 * @property array<string, array{country: string, city: string, state: string, address_line_one: string, address_line_two: string}> $billing_address
 */
class BookingResource extends JsonResource
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
            'checkInDate' => $this->check_in_date->format('d M, Y'),
            'checkOutDate' => $this->check_out_date->format('d M, Y'),
            'bookingStatus' => $this->status,
            'paymentStatus' => $this->payment_status,
            'price' => $this->price,
            'tax' => $this->tax,
            'discount' => $this->discount,
            'totalPrice' => $this->total_price,
            'totalGuests' => $this->total_guests,
            'rental' => new RentalResource($this->whenLoaded('rental')),
            'billingAddress' => $this->billing_address,
        ];
    }
}
