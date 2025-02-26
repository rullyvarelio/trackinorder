<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(15)->create();

        User::create([
            'name' => '123',
            'email' => '123@gmail.com',
            'password' => Hash::make('123'),
            'is_admin' => true,
        ]);
    }
}
