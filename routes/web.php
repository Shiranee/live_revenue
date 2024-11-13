<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\crmDispatchesController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/divergences', [DashboardController::class, 'divergencesIndex']);
    Route::get('/dispatches', [crmDispatchesController::class, 'crmDispatchesIndex']);
});
Route::get('/api/revenue/{start_date}/{end_date}/{operation}/{group?}', [OrderController::class, 'getOrderSummary']);