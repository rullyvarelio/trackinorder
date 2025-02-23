<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => range('Food', 'Drink', 'Snack'),
            'color' => range('red', 'blue', 'yellow'),
            'slug' => Str::slug(fake()->sentence(2)),
        ];
    }
}
