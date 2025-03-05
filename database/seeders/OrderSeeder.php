<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\StockOut;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $products = Product::where('status', 'available')->where('stock', '>=', 3)->get();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->info('No users or products found. Skipping OrderSeeder.');
            return;
        }

        // Generate 100 orders
        for ($i = 0; $i < 100; $i++) {
            $user = $users->random();
            $createdAt = Carbon::createFromTimestamp(mt_rand(
                Carbon::create(2024, 2, 25)->timestamp,
                Carbon::now()->timestamp
            ));

            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => 0,
                'status' => 'pending',
                'token_order' => uniqid('ORD' . Str::random(7), false),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            $totalPrice = 0;
            $selectedProducts = $products->random(rand(1, min(3, $products->count()))); // Ensure we don't exceed available products

            foreach ($selectedProducts as $product) {
                $quantity = rand(1, min(5, $product->stock)); // Ensure we don't order more than stock

                if ($quantity < 1) {
                    continue;
                }

                $subtotal = $product->price * $quantity;
                $totalPrice += $subtotal;

                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                StockOut::create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'reason' => 'Sold',
                    'used_date' => now(),
                    'token_order' => $order->token_order,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                // Reduce product stock
                $product->decrement('stock', $quantity);

                // If stock is zero, update status
                if ($product->stock <= 0) {
                    $product->update(['status' => 'out of stock']);
                }
            }

            // Update total price for the order
            $order->update(['total_price' => $totalPrice]);

            // Create a transaction
            Transaction::create([
                'order_id' => $order->id,
                'token_order' => $order->token_order,
                'total_price' => $totalPrice,
                'paid' => $totalPrice,
                'changes' => 0,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            $order->update(['status' => 'paid']);
        }
    }
}
