<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use App\Models\Transaction;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class PayOrders extends Component
{
    use Toast;

    public $order_id;

    #[Validate('required')]
    public $token_order;

    #[Validate('required')]
    public $total_price;

    #[Validate('required')]
    public $paid;

    #[Validate('required')]
    public $changes;

    public $status;

    public function updatedPaid()
    {
        $this->changes = max($this->paid - $this->total_price, 0);
    }

    public function mount($token_order)
    {
        $this->token_order = $token_order;

        $order = Order::where('token_order', $token_order)->first();

        if (! $order) {
            abort(404);
        }

        $this->order_id = $order->order_id;
        $this->token_order = $order->token_order;
        $this->total_price = $order->total_price;
        $this->paid = $order->paid;
        $this->changes = $order->changes;
    }

    public function save()
    {
        if ($this->paid < $this->total_price) {
            $this->error(
                title: 'Not Enough Money!',
                description: null,
                position: 'toast-top toast-end',
                icon: 'o-information-circle',
                css: 'alert-error',
                timeout: 3000,
                redirectTo: null
            );
        }

        $validated = $this->validate();

        $order = Order::where('order_id', $this->order_id);
        $order->update(['status' => 'paid']);

        $transaction = Transaction::where('token_order', $this->token_order)->first();
        $transaction->update([
            'paid' => $validated['paid'],
            'changes' => $validated['changes'],
        ]);

        $this->success(
            title: 'Order Successfully Paid!',
            description: null,
            position: 'toast-top toast-end',
            icon: 'o-information-circle',
            css: 'alert-success',
            timeout: 3000,
            redirectTo: route('orders.index')
        );
    }

    public function render()
    {
        return view('livewire.orders.pay-orders');
    }
}
