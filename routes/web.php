<?php

use App\Livewire\Login;
use App\Livewire\Dashboard;
use App\Livewire\Stocks\StockIns;
use App\Livewire\Orders\PayOrders;
use App\Livewire\Stocks\ShowStock;
use App\Livewire\Stocks\StockOuts;
use App\Livewire\Orders\ShowOrders;
use App\Livewire\Orders\CreateOrders;
use App\Livewire\Reports\ShowReports;
use Illuminate\Support\Facades\Route;
use App\Livewire\Products\EditProducts;
use App\Livewire\Products\ShowProducts;
use App\Livewire\Reports\FormatReports;
use App\Livewire\Employees\EditEmployees;
use App\Livewire\Employees\ShowEmployees;
use App\Livewire\Products\CreateProducts;
use App\Http\Controllers\LogoutController;
use App\Livewire\Employees\CreateEmployees;
use App\Http\Controllers\ReportExportController;

Route::get('/', Login::class)->name('login')->middleware('guest');

Route::get('dashboard', function () {
    return redirect()->route('dashboard');
})->middleware('auth');

Route::get('dashboard/overview', Dashboard::class)->name('dashboard')->middleware('auth');

Route::get('dashboard/products', ShowProducts::class)->name('products.index')->middleware('auth');
Route::get('dashboard/products/create', CreateProducts::class)->name('products.create')->middleware('auth');
Route::get('dashboard/products/{slug}/edit', EditProducts::class)->name('products.edit')->middleware('auth');

Route::get('dashboard/stocks', ShowStock::class)->name('stocks.index')->middleware('auth');
Route::get('dashboard/stock/stock-in', StockIns::class)->name('stocks.in')->middleware('auth');
Route::get('dashboard/stock/stock-out', StockOuts::class)->name('stocks.out')->middleware('auth');

Route::get('dashboard/employees', ShowEmployees::class)->name('employees.index')->middleware('auth');
Route::get('dashboard/employees/create', CreateEmployees::class)->name('employees.create')->middleware('auth');
Route::get('dashboard/employees/{slug}/edit', EditEmployees::class)->name('employees.edit')->middleware('auth');

Route::get('dashboard/orders', ShowOrders::class)->name('orders.index')->middleware('auth');
Route::get('dashboard/orders/create', CreateOrders::class)->name('orders.create')->middleware('auth');
Route::get('dashboard/orders/{token_order}/pay', PayOrders::class)->name('orders.pay')->middleware('auth');

Route::get('dashboard/reports', ShowReports::class)->name('reports.index')->middleware('auth');
Route::get('/reports/export/{format}', [ReportExportController::class, 'export'])->name('reports.export');


Route::post('logout', LogoutController::class)->name('logout')->middleware('auth');
