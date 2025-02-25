<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use App\Models\Product;
use App\Models\StockOut;
use App\Models\Transaction;
use Livewire\Component;
use Mary\Traits\Toast;

class ShowOrders extends Component
{
    use Toast;

    public bool $myModal1 = false;

    public function cancel($token_order)
    {
        $order = Order::where('token_order', $token_order)->where('status', 'pending')->first();

        if (! $order) {
            return back()->with('error', 'Order cannot be canceled.');
        }

        $stockOuts = StockOut::where('token_order', $order->token_order)->get();

        foreach ($stockOuts as $stockOut) {
            $product = Product::find($stockOut->product_id);
            if ($product) {
                $product->increment('stock', $stockOut->quantity);
            }
            $stockOut->delete();
        }

        // Delete the transaction linked to this order
        Transaction::where('order_id', $order->id)->delete();

        // Update order status and token in one go
        $order->update([
            'token_order' => null,
            'status' => 'canceled',
        ]);

        $this->success(
            title: 'Order successfully canceled!',
            description: null,
            position: 'toast-top toast-end',
            icon: 'o-information-circle',
            css: 'alert-success',
            timeout: 3000,
            redirectTo: null
        );
    }

    public function render()
    {
        $orders = Order::with('user')->paginate(10);

        return view('livewire.orders.show-orders', [
            'orders' => $orders,
        ]);
    }
}
