<?php

namespace App\Livewire\Stocks;

use App\Models\Stock;
use Livewire\Component;

class ShowStock extends Component
{
    public function render()
    {

        return view('livewire.stocks.show-stock', [
            'stocks' => Stock::with('product')->latest()->paginate(10),
        ]);
    }
}
