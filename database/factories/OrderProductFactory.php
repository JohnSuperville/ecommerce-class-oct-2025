<?php

namespace Database\Factories;

use App\Models\User;
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
            // 'order_id' => 1, // will be replaced by randomProducts
            // 'order_id' => fake()->numberBetween(1, 12),, //custom range
            // 'product_id' => fake()->numberBetween(1, 12),
            'user_id' => User::factory(),
            'price' => fake()->numberBetween(50, 100),
            'quantity' => fake()->numberBetween(1, 3),
        ];
    }

    public function randomProducts($array_of_values): Factory
    {
        return $this->state(function (array $attributes) use ($array_of_values) {
            return [
                'product_id' => fake()->randomElement($array_of_values),
            ];
        });
    }
}
