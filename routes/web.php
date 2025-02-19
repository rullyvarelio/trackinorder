<?php

use App\Http\Controllers\LogoutController;
use App\Livewire\Dashboard;
use App\Livewire\Login;
use Illuminate\Support\Facades\Route;

Route::get('/', Login::class)->name('login')->middleware('guest');
Route::get('dashboard', Dashboard::class)->middleware('auth');
Route::post('logout', LogoutController::class)->name('logout')->middleware('auth');
