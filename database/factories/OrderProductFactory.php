<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderProduct>
 */
class OrderProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => fake()->numberBetween(1, Order::count()),
            'product_id' => fake()->numberBetween(1, Product::count()),
            'qty' => fake()->numberBetween(1, 10),
            'total_per_product' => fake()->numberBetween(2000, 20000),
        ];
    }
}
