<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory(20)->recycle(
            User::all(),
            Transaction::all(),
        )->create();
    }
}
