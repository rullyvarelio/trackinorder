<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categories::create([
            'name' => 'Food',
            'color' => 'red',
            'slug' => 'food',
        ]);
        Categories::create([
            'name' => 'Drink',
            'color' => 'blue',
            'slug' => 'drink',
        ]);
        Categories::create([
            'name' => 'Snack',
            'color' => 'yellow',
            'slug' => 'snack',
        ]);
    }
}
