<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockIn;
use Illuminate\Database\Seeder;

class StockInSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $products->each(function ($product) {
            $stockIn = StockIn::factory()->create(['product_id' => $product->id]);

            Stock::factory()->create([
                'product_id' => $product->id,
                'quantity' => $stockIn->quantity,
                'type' => 'in',
            ]);

            // Update product stock
            $product->update(['stock' => $stockIn->quantity, 'status' => 'available']);
        });
    }
}
