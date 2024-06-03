<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice' => fake()->unique()->numerify('INV-####'),
            'user_id' => fake()->numberBetween(1, User::count()),
            'amount' => fake()->numberBetween(2000, 50000),
        ];
    }
}
