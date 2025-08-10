<?php

namespace Database\Factories;

use App\Enums\RentalApprovalStatus;
use App\Enums\RentalType;
use App\Models\Amenity;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

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
            'location_id' => Location::query()->inRandomOrder()->first()?->id,
            'owner_id' => User::query()
                ->where('role', 'rental_owner')
                ->where('status', 'active')
                ->inRandomOrder()
                ->first()?->id ?? User::factory()->rentalOwner(),
            'images' => $this->getRandomRentalImages(),
        ];
    }

    /**
     * Get random image paths from public/images/rental
     *
     * @return array
     */
    private function getRandomRentalImages(): array
    {
        $imageDir = public_path('storage/rental');
        $allImages = File::exists($imageDir) ? File::files($imageDir) : [];
        return collect($allImages)
            ->map(fn($file) => 'rental/' . $file->getFilename())
            ->shuffle()
            ->take(fake()->numberBetween(1, 6))
            ->values()
            ->all();
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
