<?php

namespace Database\Factories;

use App\Models\Category;
use Carbon\Carbon;
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
            'name' => fake()->word(),
            'category_id' => Category::factory(),
            'slug' => fake()->slug(),
            'price' => fake()->randomFloat(2, 10, 500),
            'stock' => random_int(20, 200), // default
            'status' => 'available',
            'image' => null,
            'created_at' => Carbon::create(2020, 1, 1)->timestamp,
            'updated_at' => Carbon::create(2020, 1, 1)->timestamp,
        ];
    }
}
