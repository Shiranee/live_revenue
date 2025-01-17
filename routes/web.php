<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\divergencesController;
use App\Http\Controllers\crmDispatchesController;
use App\Http\Controllers\revenueController;
use App\Http\Controllers\conciliationController;
use App\Http\Controllers\crmImportsController;
ini_set('memory_limit', '256M');
ini_set('max_execution_time', '300');

Route::get('/crm-dispatches/filter', [crmDispatchesController::class, 'crmDispatchesIndex'])->name('crmDispatches.filter');

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('dashboard')->middleware('web')->group(function () {
    Route::get('/revenue', [revenueController::class, 'revenueIndex']);
    Route::get('/divergences', [divergencesController::class, 'divergencesIndex']);
    Route::get('/dispatches', [crmDispatchesController::class, 'crmDispatchesIndex']);
    Route::get('/dispatchesImport', [crmImportsController::class, 'crmImportsIndex']);
    Route::post('/dispatchesImport/actions', [crmImportsController::class, 'handleActions'])->name('dispatchesImport.actions');
    Route::get('/conciliation', [conciliationController::class, 'conciliationIndex']);
});