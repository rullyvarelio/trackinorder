<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoriesFactory extends Factory
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
