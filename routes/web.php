<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return response()->file(public_path('dark/index.html'));
// });

Route::get('api/revenue/{startDate}&{endDate}/{operation}', [OrderController::class, 'getOrderSummary']);

Route::get('/main', function () {
    return response()->file(public_path('dashboards/revenue_ecomm/index.php'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
});
