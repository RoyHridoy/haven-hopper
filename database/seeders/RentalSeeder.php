<?php

namespace Database\Seeders;

use App\Models\Rental;
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
            ->withAmenities(3)
            ->create();

        Rental::factory()
            ->approved()
            ->count(5)
            ->withAmenities()
            ->create();

        Rental::factory()
            ->rejected()
            ->count(3)
            ->create();

        Rental::factory()
            ->approved()
            ->rating()
            ->count(7)
            ->withAmenities(4)
            ->create();
    }
}
