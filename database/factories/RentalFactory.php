<?php

namespace Database\Factories;

use App\Enums\RentalApprovalStatus;
use App\Enums\RentalType;
use App\Models\Amenity;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rental>
 */
class RentalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'rental_type' => fake()->randomElement(RentalType::cases()),
            'price' => fake()->numberBetween(100, 1000),
            'description' => fake()->paragraph(),
            'total_guests' => fake()->numberBetween(1, 5),
            'location_id' => Location::factory(),
            'owner_id' => User::query()
                ->where('role', 'rental_owner')
                ->where('status', 'active')
                ->inRandomOrder()
                ->first()?->id ?? User::factory()->rentalOwner(),
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'approval_status' => RentalApprovalStatus::APPROVED,
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'approval_status' => RentalApprovalStatus::REJECTED,
        ]);
    }

    public function rating(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => fake()->randomFloat(2, 1, 5),
        ]);
    }

    public function withAmenities(int $count = 5): static
    {
        return $this->afterCreating(function ($rental) use ($count) {
            $rental->amenities()->attach(Amenity::query()->inRandomOrder()->limit($count)->get());
        });
    }
}
