<?php

namespace Database\Factories;

use App\Enums\BookingPaymentStatus;
use App\Enums\BookingStatus;
use App\Enums\UserRole;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(BookingStatus::cases());

        $paymentStatus = BookingPaymentStatus::PENDING;

        if (in_array($status, [BookingStatus::APPROVED, BookingStatus::COMPLETED])) {
            $paymentStatus = BookingPaymentStatus::PAID;
        }

        if (in_array($status, [BookingStatus::CANCELLED, BookingStatus::REJECTED])) {
            $paymentStatus = BookingPaymentStatus::FAILED;
        }
        $user = User::query()->where('role', UserRole::USER)->inRandomOrder()->first();

        return [
            'check_in_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'check_out_date' => $this->faker->dateTimeBetween('+1 week', '+2 week'),
            'total_guests' => $this->faker->numberBetween(1, 3),
            'price' => $this->faker->numberBetween(100, 1000),
            'total_price' => $this->faker->numberBetween(100, 1000),
            'discount' => $this->faker->numberBetween(0, 100),
            'tax' => $this->faker->numberBetween(0, 100),
            'convenience_fee' => $this->faker->numberBetween(0, 100),
            'user_name' => $user->name,
            'user_email' => $user->email,
            'billing_address' => [
                'country' => fake()->country(),
                'city' => fake()->city(),
                'state' => fake()->state(),
                'address_line_one' => fake()->address(),
            ],
            'user_phone' => fake()->phoneNumber(),
            'status' => $status,
            'payment_status' => $paymentStatus,
            'user_id' => $user->id,
            'rental_id' => Rental::query()->inRandomOrder()->first()->id,
        ];
    }
}
