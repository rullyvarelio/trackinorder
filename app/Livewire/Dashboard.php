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
        $revenue_year = Transaction::whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->sum('total_price');

        $total_order = Order::where('status', 'paid')
            ->whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ])
            ->count();

        $revenue_thismonth = Transaction::whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ])->sum('total_price');

        $revenue_lastmonth = Transaction::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth(),
        ])->sum('total_price');

        if ($revenue_lastmonth > 0) {
            $growth_rate = (($revenue_thismonth - $revenue_lastmonth) / $revenue_lastmonth) * 100;
        } else {
            $growth_rate = 0;
        }

        $total_rev = Transaction::sum('total_price');
        $total_ord = Order::where('status', 'paid')->count();
        $arpo = $total_rev / $total_ord ?? 0;

        $entries = Product::leftJoin('order_product', 'products.id', '=', 'order_product.product_id')
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
            ->paginate(10);

        return view('livewire.home', [
            'revenue' => $revenue_year,
            'total_order' => $total_order,
            'growth_rate' => $growth_rate,
            'arpo' => $arpo,
            'entries' => $entries,
        ]);
    }
}
