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
        $stocks = Stock::orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.stocks.show-stock', [
            'stocks' => $stocks,
        ]);
    }
}
