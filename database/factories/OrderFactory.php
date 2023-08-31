<?php

namespace Database\Factories;

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
            'number' => time() . uniqid(true),
            // 'total_price' => fake()->randomFloat(2, 1, 1000),
            'total_price' => fake()->numberBetween(100000, 1000000),
            'payment_status' => 1,
            'user_id' => 1,
        ];
    }
}
