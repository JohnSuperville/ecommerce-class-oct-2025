<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            // 'user_id' => 1,
            'order_no' => 'ORD-' . Carbon::now()->year . '-' . Str::random(6),
            'subtotal' => fake()->numberBetween(200, 400),
            'total' => fake()->numberBetween(200, 300),
            'payment_provider' => 'none',
            'payment_id' => 'none',
            'shipping_id' => 1,
            'shipping_address_id' => 1,
            'billing_address_id' => 1,
            'payment_status' => 'paid',
            'created_at' => fake()->dateTimeBetween(now()->subMonth(3), now()->subMonth(1)),
        ];
    }

    public function randomUsers($user_ids): Factory
    {
        return $this->state(function (array $attributes) use ($user_ids) {
            return [
                'user_id' => fake()->randomElement($user_ids),
            ];
        });
    }
}
