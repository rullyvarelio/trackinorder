<?php

namespace App\Livewire\Stocks;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockOut;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class StockOuts extends Component
{
    use Toast;

    #[Validate('required')]
    public $product_id;

    #[Validate('required')]
    public $quantity;

    #[Validate('nullable')]
    public $reason;

    #[Validate('required')]
    public $used_date;

    #[Validate('nullable')]
    public $token_order;

    #[Validate('required')]
    public $type = 'out';

    public function save()
    {
        $validated = $this->validate();

        $product = Product::find($this->product_id);

        if (! $product || $product->stock < $this->quantity) {
            $this->error(
                title: 'Not enough stock available!',
                description: null,
                position: 'toast-top toast-end',
                icon: 'o-information-circle',
                css: 'alert-error',
                timeout: 3000,
                redirectTo: null
            );
        } else {
            StockOut::create($validated);
            $product->decrement('stock', $this->quantity);
            if ($product->stock <= 0) {
                $product->update(['status' => 0]);
            }

            Stock::create([
                'product_id' => $this->product_id,
                'quantity' => $this->quantity,
                'type' => $this->type,
            ]);

            $this->success(
                title: 'Stock removed successfully!',
                description: null,
                position: 'toast-top toast-end',
                icon: 'o-information-circle',
                css: 'alert-success',
                timeout: 3000,
                redirectTo: route('stocks.index')
            );
        }
    }

    public function render()
    {
        $products = Product::all();
        $reasons = [
            ['id' => 1, 'name' => 'Expired'],
            ['id' => 2, 'name' => 'Damaged'],
            ['id' => 3, 'name' => 'Sold'],
            ['id' => 4, 'name' => 'Other'],
        ];

        return view('livewire.stocks.stock-out', [
            'products' => $products,
            'reasons' => $reasons,
        ]);
    }
}
