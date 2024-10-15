<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

Route::get('/goals', function () {
    // Define your raw SQL query
    $query = "
        SELECT
            id,
            status,
            cnpj,
            state_inscription,
            name,
            name_company,
            delivery_point,
            inaugurated_at::date as inaugurated_at,
            closured_at::date as closured_at,
            created_at::date as created_at,
            updated_at::date as updated_at
        FROM public.stores
        ORDER BY id;
    ";

    try {
        // Execute the query using Laravel's DB facade
        $results = DB::select($query);
        
        // Return results as JSON response
        return response()->json($results, 200);
    } catch (\Exception $e) {
        // Return error message in case of failure
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
