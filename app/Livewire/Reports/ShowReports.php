<?php

namespace App\Livewire\Reports;

use App\Models\Order;
use Livewire\Component;
use Mary\Traits\Toast;

class ShowReports extends Component
{
    use Toast;

    public bool $myModal1 = false;

    public bool $myModal2 = false;

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
        $orders = Order::where('status', '!=', 'pending')->where('status', '!=', 'canceled')->paginate(10);

        return view('livewire.reports.show-reports', [
            'orders' => $orders,
        ]);
    }
}
