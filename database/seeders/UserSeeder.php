<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'is_admin' => true,
            'slug' => 'test-user'
        ]);
        User::factory()->create([
            'name' => 'Test User 2',
            'email' => 'test2@gmail.com',
            'is_admin' => false,
            'slug' => 'test-user-2'
        ]);
    }
}
