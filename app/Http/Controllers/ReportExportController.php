<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class ReportExportController extends Controller
{
    public function export($format)
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        $orders->update(['status' => 'completed']);

        if ($format === 'csv') {
            return $this->exportCSV($orders);
        } elseif ($format === 'pdf') {
            return $this->exportPDF($orders);
        }

        return back()->with('error', 'Invalid format requested');
    }

    private function exportCSV($orders)
    {
        $filename = "orders_report_" . date('Y-m-d') . ".csv";
        $handle = fopen('php://temp', 'w+');

        // Header row
        fputcsv($handle, ['Token Order', 'Total Price', 'Status', 'Date']);

        // Data rows
        foreach ($orders as $order) {
            fputcsv($handle, [
                $order->token_order,
                $order->total_price,
                ucfirst($order->status),
                $order->created_at->format('Y-m-d'),
            ]);
        }

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    private function exportPDF($orders)
    {
        $pdf = Pdf::loadView('file.pdf-format', compact('orders'));
        return $pdf->download('orders_report_' . date('Y-m-d') . '.pdf');
    }
}
