<?php

use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ReportExportController;
use App\Livewire\Admin\Categories\CreateCategories;
use App\Livewire\Admin\Categories\EditCategories;
use App\Livewire\Admin\Categories\ShowCategories;
use App\Livewire\Admin\Roles\CreateRoles;
use App\Livewire\Admin\Roles\EditRoles;
use App\Livewire\Admin\Roles\ShowRoles;
use App\Livewire\Dashboard;
use App\Livewire\Employees\CreateEmployees;
use App\Livewire\Employees\EditEmployees;
use App\Livewire\Employees\ShowEmployees;
use App\Livewire\Login;
use App\Livewire\Orders\CreateOrders;
use App\Livewire\Orders\PayOrders;
use App\Livewire\Orders\ShowOrders;
use App\Livewire\Products\CreateProducts;
use App\Livewire\Products\EditProducts;
use App\Livewire\Products\ShowProducts;
use App\Livewire\Reports\ShowReports;
use App\Livewire\Stocks\ShowStock;
use App\Livewire\Stocks\StockIns;
use App\Livewire\Stocks\StockOuts;
use Illuminate\Support\Facades\Route;

Route::get('/', Login::class)->name('login')->middleware('guest');
Route::post('logout', LogoutController::class)->name('logout')->middleware('auth');
Route::middleware('auth')->group(function () {

    Route::get('dashboard', fn () => redirect()->route('dashboard'));
    Route::get('dashboard/overview', Dashboard::class)->name('dashboard');

    Route::prefix('dashboard/products')->name('products.')->group(function () {
        Route::get('/', ShowProducts::class)->name('index');
        Route::get('create', CreateProducts::class)->name('create');
        Route::get('{slug}/edit', EditProducts::class)->name('edit');
    });

    Route::prefix('dashboard/stocks')->name('stocks.')->group(function () {
        Route::get('/', ShowStock::class)->name('index');
        Route::get('stock-in', StockIns::class)->name('in')->middleware('admin');
        Route::get('stock-out', StockOuts::class)->name('out')->middleware('admin');
    });

    Route::prefix('dashboard/employees')->name('employees.')->group(function () {
        Route::get('/', ShowEmployees::class)->name('index');
        Route::get('create', CreateEmployees::class)->name('create');
        Route::get('{slug}/edit', EditEmployees::class)->name('edit');
    });

    Route::prefix('dashboard/orders')->name('orders.')->group(function () {
        Route::get('/', ShowOrders::class)->name('index');
        Route::get('create', CreateOrders::class)->name('create');
        Route::get('{token_order}/pay', PayOrders::class)->name('pay');
    });

    Route::prefix('dashboard/reports')->name('reports.')->group(function () {
        Route::get('/', ShowReports::class)->name('index');
    });

    Route::get('reports/export/{format}', [ReportExportController::class, 'export'])->name('reports.export');
});

Route::middleware('admin')->group(function () {
    Route::prefix('dashboard/admin/categories')->name('categories.')->group(function () {
        Route::get('/', ShowCategories::class)->name('index');
        Route::get('create', CreateCategories::class)->name('create');
        Route::get('{slug}/edit', EditCategories::class)->name('edit');
    });

    Route::prefix('dashboard/admin/roles')->name('roles.')->group(function () {
        Route::get('/', ShowRoles::class)->name('index');
        Route::get('create', CreateRoles::class)->name('create');
        Route::get('{slug}/edit', EditRoles::class)->name('edit');
    });
});
