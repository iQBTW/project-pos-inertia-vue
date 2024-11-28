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
            'amount' => fake()->numberBetween(2000, 50000),
            'total' => fake()->numberBetween(2000, 50000),
            'status' => fake()->numberBetween(0, 1),
        ];
    }
}
