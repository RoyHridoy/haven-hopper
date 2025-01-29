<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = config('cities');

        foreach ($cities as $city) {
            Location::create([
                'country' => config('country')[0]['name'],
                'city' => $city['name'],
            ]);
        }
    }
}
