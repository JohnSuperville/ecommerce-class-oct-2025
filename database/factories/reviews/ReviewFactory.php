<?php

namespace Database\Factories\reviews;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\reviews\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1, // will be replaced by randomUsers
            'product_id' => 1, // will be replaced by randomProducts
            // 'user_id' => fake()->numberBetween(1, 5), //custom range
            // 'product_id' => fake()->numberBetween(1, 5), //custom range
            'rating' => fake()->numberBetween(1, 5),
            'title' => fake()->sentence(fake()->numberBetween(4, 6)),
            'description' => fake()->sentences(fake()->numberBetween(2, 8), true),
            'created_at' => fake()->dateTimeBetween(Carbon::now()->subDays(fake()->numberBetween(1, 20)), now()),
        ];
    }

    public function goodRatings(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => fake()->numberBetween(4, 5),
            ];
        });
    }

    public function randomUsers($array_of_ids): Factory
    {
        return $this->state(function (array $attributes) use ($array_of_ids) {
            return [
                'user_id' => fake()->randomElement($array_of_ids),
            ];
        });
    }

    public function randomProducts($array_of_ids): Factory
    {
        return $this->state(function (array $attributes) use ($array_of_ids) {
            return [
                'product_id' => fake()->randomElement($array_of_ids),
            ];
        });
    }
}
