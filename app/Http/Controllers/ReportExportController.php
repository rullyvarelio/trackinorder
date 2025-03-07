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

        $orders_transaction = Order::where('status', 'paid')->get();
        foreach ($orders_transaction as $order) {
            $order->update(['status' => 'completed']);
        }

        if ($format === 'csv') {
            return $this->exportCSV($orders);
        } elseif ($format === 'pdf') {
            return $this->exportPDF($orders);
        }

        return back()->with('error', 'Invalid format requested');
    }

    private function exportCSV($orders)
    {
        $filename = 'orders_report_'.date('Y-m-d').'.csv';
        $handle = fopen('php://temp', 'w+');

        fwrite($handle, "\xEF\xBB\xBF");

        fputcsv($handle, ['Token Order', 'Total Price', 'Status', 'Date'], ',');

        foreach ($orders as $order) {
            fputcsv($handle, [
                $order->token_order,
                number_format($order->total_price, 2, '.', ''),
                ucfirst($order->status),
                $order->created_at->format('Y-m-d H:i:s'),
            ]);
        }

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    private function exportPDF($orders)
    {
        $pdf = Pdf::loadView('file.pdf-format', compact('orders'));

        return $pdf->download('orders_report_'.date('Y-m-d').'.pdf');
    }
}
