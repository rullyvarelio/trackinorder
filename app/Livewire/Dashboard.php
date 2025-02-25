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

        $total_order = Order::where('status', 'completed')
            ->whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ])
            ->count();

        $totalMRR = Transaction::whereYear('created_at', Carbon::now()->year)->sum('total_price');
        $currentMonth = Carbon::now()->month;

        // Avoid division by zero
        $monthly_recurring_revenue = $currentMonth > 0 ? $totalMRR / $currentMonth : 0;
        $daysPassed = max(Carbon::now()->month, 1);
        $dash_table = Product::with('category')
            ->leftJoin('order_product', 'products.id', '=', 'order_product.product_id')
            ->leftJoin('orders', 'order_product.order_id', '=', 'orders.id')
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

        $headers = [
            ['key' => 'product', 'label' => 'Product'],
            ['key' => 'category.name', 'label' => 'Category'],
            ['key' => 'stock', 'label' => 'Stock'],
            ['key' => 'sales', 'label' => 'Sales'],
            ['key' => 'revenue', 'label' => 'Revenue'],
            ['key' => 'updated_at', 'label' => 'Last Update'],
        ];

        return view('livewire.home', [
            'revenue' => $revenue,
            'total_order' => $total_order,
            'monthly_recurring_revenue' => $monthly_recurring_revenue,
            'headers' => $headers,
            'dash_table' => $dash_table,
        ]);
    }
}
