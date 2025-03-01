<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
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
            'entries' => Product::getSalesEntries(),
        ]);
    }
}
