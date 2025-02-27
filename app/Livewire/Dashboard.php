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
        $revenue = Transaction::whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ])->sum('total_price');

        $total_order = Order::where('status', 'paid')
            ->whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ])
            ->count();

        $totalMRR = Transaction::whereYear('created_at', Carbon::now()->year)->sum('total_price');
        $currentMonth = Carbon::now()->month;

        // Avoid division by zero
        $monthly_recurring_revenue = $currentMonth > 0 ? $totalMRR / $currentMonth : 0;
        $entries = Product::with('category')
            ->leftJoin('order_product', 'products.id', '=', 'order_product.product_id')
            ->leftJoin('orders', 'order_product.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid')
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
            ->paginate(5);

        return view('livewire.home', [
            'revenue' => $revenue,
            'total_order' => $total_order,
            'monthly_recurring_revenue' => $monthly_recurring_revenue,
            'entries' => $entries,
        ]);
    }
}
