<?php

namespace Database\Factories;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    protected $model = Restaurant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->realText(),
            'lowest_price' => fake()->randomNumber(),
            'highest_price' => fake()->randomNumber(),
            'postal_code' => fake()->postcode(),
            'address' => fake()->address(),
            'opening_time'=> fake()->time(),
            'closing_time' => fake()->time(),
            'seating_capacity' => fake()->randomNumber(),
        ];
    }
}
