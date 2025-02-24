<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use App\Models\Transaction;

class Dashboard extends Component
{
    public function render()
    {
        $revenue = Transaction::whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])->sum('total_price');

        $total_order = Order::where('status', 'completed')
            ->whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])
            ->count();

        $totalMRR = Transaction::whereYear('created_at', Carbon::now()->year)->sum('total_price');
        $currentMonth = Carbon::now()->month;

        // Avoid division by zero
        $monthly_recurring_revenue = $currentMonth > 0 ? $totalMRR / $currentMonth : 0;
        $dash_table = Product::with('category')->get();
        $headers = [
            ['key' => 'product', 'label' => 'Product'],
            ['key' => 'category.name', 'label' => 'Category'],
            ['key' => 'stock', 'label' => 'Stock'],
            ['key' => 'sales_day', 'label' => 'Sales/Day'],
            ['key' => 'sales_month', 'label' => 'Sales/Month'],
            ['key' => 'sales', 'label' => 'Sales'],
            ['key' => 'revenue', 'label' => 'Revenue'],
            ['key' => 'updated_at', 'label' => 'Last Update'],
        ];

        return view('livewire.home', [
            'revenue' => $revenue,
            'total_order' => $total_order,
            'monthly_recurring_revenue' => $monthly_recurring_revenue,
            'headers' => $headers,
            'dash_table' => $dash_table
        ]);
    }
}
