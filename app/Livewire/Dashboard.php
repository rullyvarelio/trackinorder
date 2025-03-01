<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {

        return view('livewire.home', [
            'revenue' => Transaction::revenueThisYear(),
            'total_order' => Order::totalOrdersThisMonth(),
            'growth_rate' => Transaction::calculateGrowthRate(),
            'arpo' => Order::countARPO(),
            'entries' => Product::with('category')->leftJoin('order_product', 'products.id', '=', 'order_product.product_id')
                ->leftJoin('orders', 'order_product.order_id', '=', 'orders.id')
                ->whereIn('orders.status', ['paid', 'completed'])
                ->whereBetween('orders.created_at', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth(),
                ])
                ->select(
                    'products.*',
                    DB::raw('COALESCE(SUM(order_product.quantity), 0) as total_sales'),
                    DB::raw('COALESCE(SUM(order_product.subtotal), 0) as monthly_revenue')
                )
                ->groupBy('products.id')
                ->paginate(10),
        ]);
    }
}
