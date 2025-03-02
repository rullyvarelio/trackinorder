<?php

namespace Database\Seeders;

use App\Models\Role;
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
        User::factory(15)->recycle(
            Role::all()
        )->create();

        User::create([
            'name' => '123',
            'email' => '123@gmail.com',
            'password' => Hash::make('123'),
            'role_id' => 1,
        ]);

        User::create([
            'name' => '321',
            'email' => '321@gmail.com',
            'password' => Hash::make('321'),
            'role_id' => 2,
        ]);
    }
}
