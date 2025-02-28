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

            $availableStock = $product->stock;
            $stockOutQuantity = min($stockOut->quantity, $availableStock);

            $stockOut = StockOut::factory()->create([
                'product_id' => $product->id,
                'quantity' => $stockOutQuantity,
            ]);

            // Decrease product and stock table
            $newStock = max(0, $availableStock - $stockOutQuantity);
            $product->update(['stock' => $newStock]);
            if ($product->stock == 0) {
                $product->update(['status' => 'out of stock']);
            }
            $product->stock()->create([
                'product_id' => $product->id,
                'quantity' => $stockOutQuantity,
                'type' => 'out',
            ]);
        });
    }
}
