<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'token_order' => Order::factory(),
            'total_price' => Order::factory(),
            'paid' => fake()->randomFloat(2, 100, 1000),
            'changes' => fake()->randomFloat(2, 0, 50),
        ];
    }
}
