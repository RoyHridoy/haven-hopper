<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cities = config('cities');

        return [
            'country' => config('country')[0]['name'],
            'city' => $cities[rand(0, count($cities) - 1)]['name'],
        ];
    }

    public function withCoordinates(): static
    {
        return $this->state(fn (array $attributes) => [
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
        ]);
    }
}
