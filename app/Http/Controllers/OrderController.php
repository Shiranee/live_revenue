<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function getOrderSummary($start_date, $end_date, $operation, $group)
    {
        try {
            // Validate date format (YYYY-MM-DD)
            $this->validateDates($start_date, $end_date);

            // Initialize variable for query results
            $results = [];

            // Switch case to handle different operations
            switch ($operation) {
                case 'summary':
                    $results = DB::table('orders')
                        ->selectRaw('
                            COUNT(id) as total_orders,
                            COUNT(DISTINCT customer_id) as unique_customers,
                            SUM(amount) as total_amount,
                            SUM(price_paid) as total_revenue
                        ')
                        ->whereBetween('order_date', [$start_date, $end_date])
                        ->first();
                    break;
                default:
                    return response()->json(['error' => 'Invalid operation'], 400);
            }

            // Switch case to handle different grouping
            switch ($group) {
                case 'status':
                    $results = DB::table('orders')
                        ->selectRaw('
                            CASE WHEN order_status <> \'Pending\' THEN \'Pago\' ELSE \'Aguardando Pagamento\' END AS status, 
                            COUNT(id) as total_orders,
                            COUNT(DISTINCT customer_id) as unique_customers,
                            SUM(amount) as total_amount,
                            SUM(price_paid) as total_revenue
                        ')
                        ->whereBetween('order_date', [$start_date, $end_date])
                        ->groupBy('status')
                        ->get();
                    break;

                case 'invoiced':
                    $results = DB::table('orders')
                        ->selectRaw('
                            invoiced,
                            COUNT(id) as total_orders,
                            COUNT(DISTINCT customer_id) as unique_customers,
                            SUM(amount) as total_amount,
                            SUM(price_paid) as total_revenue
                        ')
                        ->whereBetween('order_date', [$start_date, $end_date])
                        ->groupBy('invoiced')
                        ->get();
                    break;

                case 'today':
                    $results = DB::table('orders')
                        ->selectRaw('
                            date_trunc(\'hour\', order_time) AS hour,
                            COUNT(id) as total_orders,
                            COUNT(DISTINCT customer_id) as unique_customers,
                            SUM(amount) as total_amount,
                            SUM(price_paid) as total_revenue
                        ')
                        ->whereDate('order_date', $end_date) // Corrected
                        ->groupBy('hour')
                        ->orderBy('hour', 'desc')
                        ->get();
                    break;

                case 'period':
                    $results = DB::table('orders')
                        ->selectRaw('
                            order_date,
                            COUNT(id) as total_orders,
                            COUNT(DISTINCT customer_id) as unique_customers,
                            SUM(amount) as total_amount,
                            SUM(price_paid) as total_revenue
                        ')
                        ->whereBetween('order_date', [$start_date, $end_date])
                        ->groupBy('order_date')
                        ->orderBy('order_date', 'desc')
                        ->get();
                    break;

                default:
                    return response()->json(['error' => 'Invalid group option'], 400);
            }

            // Check if results are empty
            if (empty($results)) {
                return response()->json(['message' => 'No results found.'], 204);
            }

            // Return results as JSON response
            return response()->json($results, 200);
        } catch (\Exception $e) {
            // Return error message in case of failure
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function validateDates($start_date, $end_date)
    {
        $format = 'Y-m-d';
        $startDateTime = \DateTime::createFromFormat($format, $start_date);
        $endDateTime = \DateTime::createFromFormat($format, $end_date);

        if (!$startDateTime || !$endDateTime) {
            throw new \Exception('Invalid date format. Please use YYYY-MM-DD.');
        }

        if ($startDateTime > $endDateTime) {
            throw new \Exception('Start date must be before or equal to end date.');
        }

        // Optional: Check if dates are not in the future
        $currentDate = new \DateTime();
        if ($startDateTime > $currentDate || $endDateTime > $currentDate) {
            throw new \Exception('Dates must not be in the future.');
        }
    }
}
