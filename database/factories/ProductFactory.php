<?php

namespace Database\Factories;

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
        return [
            'name' => fake()->unique()->sentence(2),
            'description' => fake()->text(),
            // 'price' => fake()->randomFloat(2, 1, 200),
            'price' => fake()->numberBetween(1000, 200000),
            'image_url' => fake()->imageUrl(width: 200, height: 200),
        ];
    }
}
