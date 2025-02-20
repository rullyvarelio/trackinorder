<?php

use App\Http\Controllers\LogoutController;
use App\Livewire\Dashboard;
use App\Livewire\Login;
use App\Livewire\Product;
use App\Livewire\Products;
use Illuminate\Support\Facades\Route;

Route::get('/', Login::class)->name('login')->middleware('guest');

Route::get('dashboard', function () {
    return redirect()->route('dashboard');
})->middleware('auth');

Route::get('dashboard/overview', Dashboard::class)->name('dashboard')->middleware('auth');

Route::get('dashboard/products', Product::class)->name('products')->middleware('auth');

Route::post('logout', LogoutController::class)->name('logout')->middleware('auth');
