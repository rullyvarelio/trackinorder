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
    public array $chartPie = [];

    public array $chartLine = [];

    public function mount()
    {
        $this->loadChartDataPie();
        $this->loadChartLineData();
    }

    public function loadChartDataPie()
    {
        // Ambil jumlah order berdasarkan kategori produk
        $data = DB::table('categories')
            ->join('products', 'categories.id', '=', 'products.category_id')
            ->join('order_product', 'products.id', '=', 'order_product.product_id')
            ->join('orders', 'order_product.order_id', '=', 'orders.id')
            ->whereIn('orders.status', ['paid', 'completed'])
            ->whereBetween('orders.created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->now(),
            ])
            ->selectRaw('categories.name as category, SUM(order_product.quantity) as total_orders')
            ->groupBy('categories.name')
            ->orderByDesc('total_orders')
            ->get();

        // Ubah data ke format yang cocok untuk chart.js

        $labels =  $data->pluck('category')->toArray();
        $values = $data->pluck('total_orders')->toArray();

        $backgroundColors = array_map(fn() => sprintf("#%06X", mt_rand(0, 0xFFFFFF)), range(1, count($labels)));

        $this->chartPie = [
            'type' => 'pie',
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Total Ordered Product',
                        'data' => $values,
                        'backgroundColor' => $backgroundColors,
                    ],
                ],
            ],
            'options' => [
                'plugins' => [
                    'legend' => [
                        'display' => false, // Ensure legend is shown
                    ],
                ],
            ],
        ];
    }


    public function loadChartLineData()
    {

        $monthlyRevenue = DB::table('transactions')
            ->selectRaw("CAST(strftime('%m', created_at) AS INTEGER) as month, SUM(total_price) as revenue")
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthsMap = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];

        $labels = array_values($monthsMap);

        $values = array_fill(1, 12, 0); // Initialize all months with 0 revenue
        foreach ($monthlyRevenue as $data) {
            $values[$data->month] = $data->revenue;
        }
        $values = array_values($values); // Convert to simple indexed array

        $this->chartLine = [
            'type' => 'line',
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'data' => $values,
                        'label' => 'Revenue',
                        'borderColor' => '#28a745', // Green line color
                        'backgroundColor' => 'rgba(40, 167, 69, 0.2)', // Light green fill
                        'fill' => true,
                    ],
                ],
            ],
            'options' => [
                'plugins' => [
                    'legend' => [
                        'display' => false, // Ensure legend is shown
                    ],
                ],
                'title' => [
                    'display' => true,
                    'text' => 'Monthly Revenue ($)',
                ],
                'elements' => [
                    'line' => [
                        'tension' => 0.4, // Global setting for smooth lines
                    ],
                ],
            ],
        ];
    }

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
                    Carbon::now()->startOfYear(),
                    Carbon::now()->now(),
                ])
                ->select(
                    'products.*',
                    DB::raw('COALESCE(SUM(order_product.quantity), 0) as total_sales'),
                    DB::raw('COALESCE(SUM(order_product.subtotal), 0) as monthly_revenue'),
                    DB::raw('MAX(orders.created_at) as latest_order_date') // Get the most recent order date
                )
                ->groupBy('products.id')
                ->orderByDesc('latest_order_date')
                ->paginate(10),
            'orderThisYear' => Order::totalOrdersThisYear(),

        ]);
    }
}
