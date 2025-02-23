<?php

namespace App\Livewire\Stocks;

use App\Models\Product;
use Livewire\Component;

class ShowStock extends Component
{
    public function render()
    {
        $products = Product::with('category')->paginate(5);

        $headers = [
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'stock', 'label' => 'Stock'],
            ['key' => 'status', 'label' => 'Status'],
        ];

        return view('livewire.stocks.show-stock', [
            'products' => $products,
            'headers' => $headers,
        ]);
    }
}
