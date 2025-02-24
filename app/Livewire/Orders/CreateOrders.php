<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use App\Models\Product;
use App\Models\StockOut;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class CreateOrders extends Component
{
    use Toast;

    #[Validate('required')]
    public array $selected;

    public array $products;

    public function mount()
    {
        $this->products = Product::where('stock', '>', 0)->get()->keyBy('id')->toArray();
    }

    public function save()
    {
        // Validate input
        $this->validate([
            'products.*.quantity' => 'integer|min:1',
        ]);

        // Get selected products with quantity
        $selectedProducts = collect($this->products)->filter(fn($product) => isset($product['quantity']) && $product['quantity'] > 0);

        if ($selectedProducts->isEmpty()) {
            $this->error(
                title: 'No products selected!',
                description: null,
                position: 'toast-top toast-end',
                icon: 'o-information-circle',
                css: 'alert-error',
                timeout: 3000,
                redirectTo: null
            );

            return;
        }

        $tokenOrder = Str::random(20);

        // Create the order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => 0, // Will be updated later
            'status' => 'pending',
            'token_order' => $tokenOrder,
        ]);

        $totalPrice = 0;
        $stockOutEntries = [];

        // Create order items and update stock
        foreach ($selectedProducts as $productId => $product) {
            // Fetch product as an object from DB
            $product_draft = Product::find($productId);

            if (! $product_draft) {
                continue; // Skip if product not found
            }

            $quantity = (int) $product['quantity'];

            if ($quantity <= 0 || $quantity > $product_draft->stock) {
                $this->error(
                    title: "Invalid quantity for {$product_draft->name}!",
                    description: null,
                    position: 'toast-top toast-end',
                    icon: 'o-information-circle',
                    css: 'alert-error',
                    timeout: 3000,
                    redirectTo: null
                );

                continue;
            }

            $subtotal = $product_draft->price * $quantity;
            $totalPrice += $subtotal;

            // Attach to order
            $order->products()->attach($product_draft->id, [
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ]);

            // Stock out entry
            $stockOut = StockOut::create([
                'product_id' => $product_draft->id,
                'quantity' => $quantity,
                'reason' => 'Sold', // Reason for stock out
                'used_date' => now(),
                'token_order' => $tokenOrder,
            ]);

            $stockOutEntries[] = $stockOut->id;

            // Reduce stock
            $product_draft->decrement('stock', $quantity);

            if ($product_draft->stock <= 0) {
                $product_draft->update(['status' => 0]);
            }
        }

        // Update order total price
        $order->update(['total_price' => $totalPrice]);

        // Create transaction
        Transaction::create([
            'order_id' => $order->id,
            'token_order' => $tokenOrder,
            'total_price' => $totalPrice,
        ]);
        $this->success(
            title: 'Order successfully created!',
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
        $products = Product::all()->where('stock', '>', 0);
        $headers = [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'price', 'label' => 'Price', 'format' => ['currency', '2,.', '$ ']],
            ['key' => 'stock', 'label' => 'Stock'],
            ['key' => 'quantity', 'label' => 'Qty.'],
        ];

        return view('livewire.orders.create-orders', [
            'products' => $products,
            'headers' => $headers,
        ]);
    }
}
