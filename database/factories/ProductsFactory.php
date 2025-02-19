<?php

namespace Database\Factories;

use App\Models\Categories;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(2),
            'category_id' => Categories::factory(),
            'slug' => Str::slug(fake()->sentence()),
            'price' => fake()->numberBetween(1000, 10000),
            'stock' => rand(10, 100),
            'status' => true,
            'image' => null,
        ];
    }
}
