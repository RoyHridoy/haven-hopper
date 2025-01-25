<?php

namespace Database\Factories;

use App\Enums\ReviewerType;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $reviewType = $this->faker->randomElement(ReviewerType::cases());

        if ($reviewType === ReviewerType::RENTAL_OWNER) {
            $reviewBy = User::query()->WhereHas('rentals')->inRandomOrder()->first()?->id;
            $userId = User::query()->whereDoesntHave('rentals')->inRandomOrder()->first()?->id;
            $rentalId = null;
        } else {
            $userId = null;
            $reviewBy = User::query()->whereDoesntHave('rentals')->inRandomOrder()->first()?->id;
            $rentalId = Rental::query()->inRandomOrder()->first()?->id;
        }

        return [
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->paragraph(),
            'reviewer_type' => $reviewType,
            'review_by' => $reviewBy,
            'user_id' => $userId,
            'rental_id' => $rentalId,
        ];
    }
}
