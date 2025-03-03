<?php

namespace App\Livewire\Stocks;

use App\Models\Stock;
use Livewire\Component;

class ShowStock extends Component
{
    public $searchStocks = '';

    public function render()
    {

        return view('livewire.stocks.show-stock', [
            'stocks' => Stock::search($this->searchStocks)->with('product')->latest()->paginate(10),
        ]);
    }
}
