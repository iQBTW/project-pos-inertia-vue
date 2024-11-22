<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = ['Fried Rice', 'Ayam Bakar', 'Mie Ayam', 'Soto Ayam'];
        return [
            'name' => $name = fake()->unique()->randomElement($products),
            'slug' => Str::slug($name),
            'stock' => fake()->numberBetween(1, 50),
            'price' => fake()->numberBetween(2000, 20000),
        ];
    }
}
