<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// });

Route::get('/dashboard', [DashboardController::class, 'index']);


Route::get('/api/revenue/{start_date}/{end_date}/{operation}/{group?}', [OrderController::class, 'getOrderSummary']);