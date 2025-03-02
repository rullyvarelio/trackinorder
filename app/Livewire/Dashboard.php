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
    public array $chart1 = [
        'type' => 'pie',
        'data' => [
            'labels' => ['Mary', 'Joe', 'Ana'],
            'datasets' => [
                [
                    'label' => '# of Votes',
                    'data' => [12, 19, 3],
                ],
            ],
        ],
    ];

    public array $chart2 = [
        'type' => 'line',
        'data' => [
            'labels' => [1500, 1600, 1700, 1750, 1800, 1850, 1900, 1950, 1999, 2050],
            'datasets' => [
                [
                    'data' => [86, 114, 106, 106, 107, 111, 133, 221, 783, 2478],
                    'label' => 'Africa',
                    'borderColor' => '#3e95cd',
                    'fill' => false,
                ],
                [
                    'data' => [282, 350, 411, 502, 635, 809, 947, 1402, 3700, 5267],
                    'label' => 'Asia',
                    'borderColor' => '#8e5ea2',
                    'fill' => false,
                ],
                [
                    'data' => [168, 170, 178, 190, 203, 276, 408, 547, 675, 734],
                    'label' => 'Europe',
                    'borderColor' => '#3cba9f',
                    'fill' => false,
                ],
                [
                    'data' => [40, 20, 10, 16, 24, 38, 74, 167, 508, 784],
                    'label' => 'Latin America',
                    'borderColor' => '#e8c3b9',
                    'fill' => false,
                ],
                [
                    'data' => [6, 3, 2, 2, 7, 26, 82, 172, 312, 433],
                    'label' => 'North America',
                    'borderColor' => '#c45850',
                    'fill' => false,
                ],
            ],
        ],
        'options' => [
            'title' => [
                'display' => true,
                'text' => 'World population per region (in millions)',
            ],
        ],

    ];

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
