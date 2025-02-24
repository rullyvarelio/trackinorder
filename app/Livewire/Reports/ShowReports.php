<?php

namespace App\Livewire\Reports;

use App\Models\Order;
use Mary\Traits\Toast;
use Livewire\Component;

class ShowReports extends Component
{
    use Toast;

    public function report($format)
    {
        if ($format === 'csv') {
            return redirect()->route('reports.export', ['format' => 'csv']);
        } elseif ($format === 'pdf') {
            return redirect()->route('reports.export', ['format' => 'pdf']);
        }

        $this->error(
            title: 'Invalid export!',
            description: null,
            position: 'toast-top toast-end',
            icon: 'o-information-circle',
            css: 'alert-error',
            timeout: 3000,
            redirectTo: null
        );
    }


    public function render()
    {
        $orders = Order::where('status', '!=', 'pending')->get();
        $headers = [
            ['key' => 'loop', 'label' => '#'],
            ['key' => 'token_order', 'label' => 'Order'],
            ['key' => 'total_price', 'label' => 'Total price'],
            ['key' => 'status', 'label' => 'Status'],
            ['key' => 'created_at', 'label' => 'Date'],
        ];

        return view('livewire.reports.show-reports', [
            'orders' => $orders,
            'headers' => $headers,
        ]);
    }
}
