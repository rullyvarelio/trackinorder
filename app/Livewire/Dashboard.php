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

    public array $chart2 = [];

    public function mount()
    {
        $this->loadChartDataPie();
        $this->loadChart2Data();
    }

    public function loadChartDataPie()
    {
        // Ambil jumlah order berdasarkan kategori produk
        $data = DB::table('categories')
            ->join('products', 'categories.id', '=', 'products.category_id')
            ->join('order_product', 'products.id', '=', 'order_product.product_id')
            ->join('orders', 'order_product.order_id', '=', 'orders.id')
            ->whereIn('orders.status', ['paid', 'completed'])
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
                        'label' => 'Total Orders',
                        'data' => $values,
                        'backgroundColor' => $backgroundColors,
                    ],
                ],
            ],
        ];
    }


    public function loadChart2Data()
    {
        $data = Transaction::selectRaw('
        strftime("%m", created_at) as month, 
        SUM(total_price) as total_revenue
    ')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Mapping bulan dari angka ke nama bulan
        $monthsMap = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        // Konversi bulan ke nama bulan dan ambil nilai revenue
        $labels = $data->pluck('month')->map(fn($m) => $monthsMap[$m] ?? $m);
        $values = $data->pluck('total_revenue');

        // Simpan data ke array chart
        $this->chart2 = [
            'type' => 'line',
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'data' => $values,
                        'label' => 'Revenue',
                        'borderColor' => '#1A56DB',
                        'backgroundColor' => 'rgba(26, 86, 219, 0.2)',
                        'fill' => true,
                    ],
                ],
            ],
            'options' => [
                'title' => [
                    'display' => true,
                    'text' => 'Revenue per Month (in USD)',
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
