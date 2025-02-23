<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Food',
            'color' => 'red',
            'slug' => 'food',
        ]);
        Category::create([
            'name' => 'Drink',
            'color' => 'blue',
            'slug' => 'drink',
        ]);
        Category::create([
            'name' => 'Snack',
            'color' => 'yellow',
            'slug' => 'snack',
        ]);
    }
}
