<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockOut;
use Illuminate\Database\Seeder;

class StockOutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        $products->each(function ($product) {
            $stockOut = StockOut::factory()->make(['product_id' => $product->id]);

            // Ensure stock-out quantity does not exceed available stock
            $availableStock = $product->stock;
            $stockOutQuantity = min($stockOut->quantity, $availableStock);

            // Create stock-out entry with adjusted quantity
            $stockOut = StockOut::factory()->create([
                'product_id' => $product->id,
                'quantity' => $stockOutQuantity,
            ]);

            // Decrease product and stock table
            $newStock = max(0, $availableStock - $stockOutQuantity);
            $product->update(['stock' => $newStock]);
            $product->stock()->create([
                'product_id' => $product->id,
                'quantity' => $stockOutQuantity,
                'type' => 'out',
            ]);
        });
    }
}
