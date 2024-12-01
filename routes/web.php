<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\divergencesController;
use App\Http\Controllers\crmDispatchesController;
use App\Http\Controllers\revenueController;
use App\Http\Controllers\AjaxController;

Route::get('/crm-dispatches/filter', [crmDispatchesController::class, 'crmDispatchesIndex'])->name('crmDispatches.filter');

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('dashboard')->group(function () {
    Route::get('/revenue', [revenueController::class, 'revenueIndex']);
    Route::get('/divergences', [divergencesController::class, 'divergencesIndex']);
    Route::get('/dispatches', [crmDispatchesController::class, 'crmDispatchesIndex']);
});
