<?php

namespace App\Livewire\Reports;

use App\Models\Order;
use Livewire\Component;
use Mary\Traits\Toast;

class ShowReports extends Component
{
    use Toast;

    public $searchReports = '';

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

        return view('livewire.reports.show-reports', [
            'orders' => Order::search($this->searchReports)->whereIn('status', ['paid', 'completed'])->paginate(10),
        ]);
    }
}
