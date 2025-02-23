<?php

namespace App\Livewire\Stocks;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockIn;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class StockIns extends Component
{
    use Toast;

    #[Validate('required')]
    public $product_id;

    #[Validate('required|integer')]
    public $quantity;

    #[Validate('required')]
    public $supplier;

    #[Validate('required|date')]
    public $received_date;

    #[Validate('required')]
    public $invoice_number;

    #[Validate('nullable')]
    public $notes;

    public function save()
    {
        $this->invoice_number = Str::random(4) . date('Ymd');

        $validated = $this->validate();

        StockIn::create($validated);

        $stock = Stock::firstOrCreate(['product_id' => $this->product_id]);
        $stock->quantity += $this->quantity;
        $stock->save();

        Product::where('id', $this->product_id)->update(['stock' => $stock->quantity]);

        if ($stock->quantity) {
            Product::where('id', $this->product_id)->update(['status' => 1]);
        }

        $this->success(
            title: 'Stock successfully updated!',
            description: null,
            position: 'toast-top toast-end',
            icon: 'o-information-circle',
            css: 'alert-success',
            timeout: 3000,
            redirectTo: route('stocks.index')
        );
    }

    public function render()
    {
        $products = Product::all();

        return view('livewire.stocks.stock-in', [
            'products' => $products,
        ]);
    }
}
