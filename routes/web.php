<?php

use App\Http\Controllers\LogoutController;
use App\Livewire\Dashboard;
use App\Livewire\Employees\CreateEmployees;
use App\Livewire\Employees\EditEmployees;
use App\Livewire\Employees\ShowEmployees;
use App\Livewire\Login;
use App\Livewire\Products\CreateProducts;
use App\Livewire\Products\EditProducts;
use App\Livewire\Products\ShowProducts;
use App\Livewire\Stocks\ShowStock;
use App\Livewire\Stocks\StockIns;
use App\Livewire\Stocks\StockOuts;
use Illuminate\Support\Facades\Route;

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

Route::post('logout', LogoutController::class)->name('logout')->middleware('auth');
