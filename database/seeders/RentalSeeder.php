<?php

namespace Database\Seeders;

use App\Models\Rental;
use App\Models\User;
use Illuminate\Database\Seeder;

class RentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rental::factory()
            ->count(10)
            ->afterCreating(function ($rental) {
                $rental->favorites()->create([
                    'user_id' => User::query()->inRandomOrder()->first()->id,
                ]);
            })
            ->withAmenities(3)
            ->create();

        Rental::factory()
            ->approved()
            ->afterCreating(function ($rental) {
                $rental->favorites()->create([
                    'user_id' => User::query()->inRandomOrder()->first()->id,
                ]);
            })
            ->count(5)
            ->withAmenities()
            ->create();

        Rental::factory()
            ->rejected()
            ->count(3)
            ->create();

        Rental::factory()
            ->approved()
            ->afterCreating(function ($rental) {
                $rental->favorites()->create([
                    'user_id' => User::query()->inRandomOrder()->first()->id,
                ]);
            })
            ->rating()
            ->count(7)
            ->withAmenities(4)
            ->create();
    }
}
