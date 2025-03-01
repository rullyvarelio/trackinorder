<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\StockOut;
use App\Models\Transaction;
use Livewire\Component;
use Mary\Traits\Toast;

class ShowOrders extends Component
{
    use Toast;

    public $searchOrders = '';

    public function cancel($id)
    {
        $order = Order::find($id);

        if (! $order) {
            $this->error(
                title: 'Order not found!',
                description: 'The order you are trying to cancel does not exist.',
                position: 'toast-top toast-end',
                icon: 'o-x-circle',
                css: 'alert-error',
                timeout: 3000,
                redirectTo: null
            );

            return;
        }

        $stockOuts = StockOut::where('order_id', $id)->get();

        foreach ($stockOuts as $stockOut) {
            $product = Product::find($stockOut->product_id);

            if ($product) {
                $product->increment('stock', $stockOut->quantity);
            }
            $stockOut->delete();
        }

        OrderProduct::where('order_id', $id)->delete();
        Transaction::where('order_id', $id)->delete();

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

        return view('livewire.orders.show-orders', [
            'orders' => Order::search($this->searchOrders)->latest()->paginate(10),
        ]);
    }
}
