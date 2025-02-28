<?php

namespace Database\Factories;

use App\Models\OrderProduct;
use App\Models\User;
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
            'user_id' => User::factory(),
            'total_price' => OrderProduct::factory(),
            'status' => fake()->randomElement(['pending', 'paid', 'completed']),
            'token_order' => uniqid('ORD'.Str::random(7), false),
        ];
    }
}
