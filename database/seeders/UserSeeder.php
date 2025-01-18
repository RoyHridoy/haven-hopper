<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->admin()
            ->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
            ]);

        User::factory()
            ->rentalOwner()
            ->blacklisted()
            ->create();

        User::factory()
            ->rentalOwner()
            ->count(4)
            ->create();

        User::factory()
            ->count(10)
            ->create();

        User::factory()
            ->blacklisted()
            ->count(2)
            ->create();
    }
}
