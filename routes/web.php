<?php

use App\Livewire\Login;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoutController;
use App\Livewire\Products\Create;
use App\Livewire\Products\CreateProducts;
use App\Livewire\Products\EditProducts;
use App\Livewire\Products\ShowProducts;

Route::get('/', Login::class)->name('login')->middleware('guest');

Route::get('dashboard', function () {
    return redirect()->route('dashboard');
})->middleware('auth');

Route::get('dashboard/overview', Dashboard::class)->name('dashboard')->middleware('auth');

Route::get('dashboard/products', ShowProducts::class)->name('products.index')->middleware('auth');
Route::get('dashboard/products/create', CreateProducts::class)->name('products.create')->middleware('auth');
Route::get('dashboard/products/{slug}/edit', EditProducts::class)->name('products.edit')->middleware('auth');

Route::post('logout', LogoutController::class)->name('logout')->middleware('auth');
