<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return response()->file(public_path('dark/index.html'));
});

// Route::get('/styles', function () {
//     return response()->file(public_path('dark/assets/styles.css'));
// });

// Route::get('/scripts', function () {
//     return response()->file(public_path('dark/assets/scripts.js'));
// });


Route::get('/api/revenue', function () {
    // Define your raw SQL query
    $query = "
      select
          COUNT(id) as orders
        , COUNT(distinct customer_id) as customers
        , SUM(amount) as amount
        , SUM(price_paid) as revenue

      from orders o

      where
      order_date between '2024-09-01' and current_date-1
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

Route::get('/api/revenue_today', function () {
  // Define your raw SQL query
  $query = "
    select
      SUM(price_paid) * 1.4 as goal

    from orders o

    where
    order_date = current_date-10
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

Route::get('/api/goals', function () {
  // Define your raw SQL query
  $query = "
    select
      SUM(price_paid) * 1.2 as goal

    from orders o

    where
    order_date between '2024-09-01' and current_date-1
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

Route::get('/api/goals_today', function () {
  // Define your raw SQL query
  $query = "
    select
      SUM(price_paid) * 1.2 as goal

    from orders o

    where
    order_date = current_date-10
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

Route::get('/api/devolutions', function () {
  // Define your raw SQL query
  $query = "
      select
		  ROUND(COUNT(id) * 0.1) as orders
		, ROUND(COUNT(distinct customer_id) * 0.1) as customers
		, ROUND(SUM(amount) * 0.1) as amount
		, ROUND(SUM(price_paid) * 0.1) as devolutions

      from orders o

      where
      order_date between '2024-09-01' and current_date-1
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
