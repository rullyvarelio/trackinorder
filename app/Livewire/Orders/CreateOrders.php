<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockOut;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Mary\Traits\Toast;

class CreateOrders extends Component
{
    use Toast;

    public $selectProduct = [];

    public $quantity = [];

    public function save()
    {
        if (empty(array_filter($this->selectProduct))) {
            $this->error(
                title: 'No product selected!',
                description: null,
                position: 'toast-top toast-end',
                icon: 'o-information-circle',
                css: 'alert-error',
                timeout: 3000,
                redirectTo: null
            );

            return;
        }

        $totalPrice = 0;
        $tokenOrder = uniqid('ORD'.Str::random(12), true);
        $stockOutEntries = [];
        $stockEntries = [];

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $totalPrice, // Will be updated later
            'status' => 'pending',
            'token_order' => $tokenOrder,
        ]);

        foreach ($this->selectProduct as $productId => $isSelected) {
            if ($isSelected) {
                if (! isset($this->quantity[$productId]) || $this->quantity[$productId] <= 0) {
                    $this->warning(
                        title: 'Quantity required!',
                        description: 'Please enter a valid quantity for the selected product.',
                        position: 'toast-top toast-end',
                        icon: 'o-exclamation-triangle',
                        css: 'alert-warning',
                        timeout: 3000,
                        redirectTo: null
                    );

                    return;
                }
            }

            $draft_order = Product::find($productId);
            $quantity = (int) $this->quantity[$productId];

            $subtotal = $draft_order->price * $quantity;
            $totalPrice += $subtotal;

            $order->products()->attach($draft_order->id, [
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ]);

            $stockOut = StockOut::create([
                'product_id' => $draft_order->id,
                'quantity' => $quantity,
                'reason' => 'Sold',
                'used_date' => now(),
                'token_order' => $tokenOrder,
            ]);

            $stock = Stock::create([
                'product_id' => $draft_order->id,
                'quantity' => $quantity,
                'type' => 'out',
            ]);
            $stockOutEntries[] = $stockOut->id;
            $stockEntries[] = $stock->id;

            $draft_order->decrement('stock', $quantity);

            if ($draft_order->stock <= 0) {
                $draft_order->update(['status' => 0]);
            }
        }

        $order->update(['total_price' => $totalPrice]);

        Transaction::create([
            'order_id' => $order->id,
            'token_order' => $tokenOrder,
            'total_price' => $totalPrice,
        ]);

        foreach ($this->quantity as $productId => $qty) {
            if (! isset($this->selectProduct[$productId]) || ! $this->selectProduct[$productId]) {
                if ($qty > 0) {
                    $this->warning(
                        title: 'Product not selected!',
                        description: 'Please check the product before entering quantity.',
                        position: 'toast-top toast-end',
                        icon: 'o-exclamation-triangle',
                        css: 'alert-warning',
                        timeout: 3000,
                        redirectTo: null
                    );

                    return;
                }
            }
        }

        $this->success(
            title: 'Order saved successfully!',
            description: null,
            position: 'toast-top toast-end',
            icon: 'o-exclamation-triangle',
            css: 'alert-success',
            timeout: 3000,
            redirectTo: route('orders.index')
        );
    }

    public function render()
    {
        $products = Product::all()->where('stock', '>', 0);

        return view('livewire.orders.create-orders', [
            'products' => $products,
        ]);
    }
}
