<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Add this if needed
use Illuminate\Support\Facades\Http; // Add this if you’re making HTTP requests

class DashboardController extends Controller
{
    public function index()
    {
        // Example values - these could come from an API or other data source
        $titleFirst = 'Revenue Today';
        $tooltip = 'Revenue comparison with yesterday';
        $comparison = '-6.8%';
        $titleSecond = 'Total Captured';
        $revenue = '$5,000';
        $graphId = 'revenue-chart';
        $customers = '250';
        $orders = '150';
        $amount = '500';
        $subtitleMain = 'Pagamentos';
        $subtitleFirst = 'Confirmados:';
        $subtitleSecond = 'Pendentes:';
        $valueFirst = '$4,000';
        $valueSecond = '$1,000';
    
        // Pass data to the view
        return view('dashboard', compact(
            'titleFirst', 'tooltip', 'comparison', 'titleSecond', 
            'revenue', 'graphId', 'customers', 'orders', 'amount',
            'subtitleMain', 'subtitleFirst', 'subtitleSecond', 'valueFirst', 'valueSecond'
        ));
    }

    // public function index()
    // {
    //     $default = "Carregando";
    //     $response = []; // Initialize response as an empty array
    
    //     try {
    //         $start_date = '2024-09-01';
    //         $end_date = '2024-09-30';
    //         $operation = 'summary';
    
    //         $url = "http://192.168.100.95:8000/api/revenue/{$start_date}/{$end_date}/{$operation}";
    
    //         // Log the API call
    //         logger()->info("Calling API: " . $url);
    
    //         $apiResponse = Http::get($url);
    
    //         if ($apiResponse->successful()) {
    //             $response = $apiResponse->json('response'); // Get the actual data from the response
    //             logger()->info("API response: ", $response); // Log successful response
    //         } else {
    //             // Log if the API call was not successful
    //             logger()->error("API call failed: " . $apiResponse->status() . " - " . $apiResponse->body());
    //         }
    //     } catch (\Exception $e) {
    //         logger()->error("API call failed: " . $e->getMessage());
    //     }
    
    //     // Set default values in case the API response doesn't have the expected structure
    //     $titleFirst = 'Receita Hoje';
    //     $tooltip = 'Comparação ao dia anterior';
    //     $comparison = '-6.8%';
    //     $titleSecond = 'Capturada';
    //     $revenue = isset($response['revenue']) ? $response['revenue'] : $default;
    //     $graphId = 'revenue-chart';
    //     $customers = isset($response['customers']) ? $response['customers'] : 0;
    //     $orders = isset($response['orders']) ? $response['orders'] : 0;
    //     $amount = isset($response['amount']) ? $response['amount'] : 0;
    //     $subtitleMain = 'Pagamentos';
    //     $subtitleFirst = 'Confirmados:';
    //     $subtitleSecond = 'Pendentes:';
    //             // $valueFirst = isset($response['confirmedPayments']) ? '$' . number_format($response['confirmedPayments'], 2) : $default; // Assuming the key for confirmed payments
    //     // $valueSecond = isset($response['pendingPayments']) ? '$' . number_format($response['pendingPayments'], 2) : $default; // Assuming the key for pending payments
    //     $valueFirst = 0; // Assuming you will set these from response later
    //     $valueSecond = 0;
    
    //     // Pass the data to the view
    //     return view('dashboard', compact(
    //         'titleFirst', 'tooltip', 'comparison', 'titleSecond', 
    //         'revenue', 'graphId', 'customers', 'orders', 'amount',
    //         'subtitleMain', 'subtitleFirst', 'subtitleSecond', 'valueFirst', 'valueSecond'
    //     ));
    // }
    
}
