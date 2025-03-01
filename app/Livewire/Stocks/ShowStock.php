<?php

namespace App\Livewire\Stocks;

use App\Models\Stock;
use Livewire\Component;
use Livewire\WithPagination;

class ShowStock extends Component
{
    use WithPagination;

    public function render()
    {

        return view('livewire.stocks.show-stock', [
            'stocks' => Stock::latest()->paginate(10),
        ]);
    }
}
