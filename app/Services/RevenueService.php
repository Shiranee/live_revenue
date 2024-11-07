<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Exception;

class RevenueService
{
    public function getRevenue($date_start, $date_end, $operation, $invoiced = null)
    {
        // Validate the dates
        // $this->validateDates($date_start, $date_end);
        
        // Initialize the query
        $query = DB::table('orders')
            ->selectRaw('
                COUNT(id) as orders,
                COUNT(DISTINCT customer_id) as customers,
                SUM(amount) as amount,
                SUM(price_paid) as revenue
            ')
            ->whereBetween('order_date', [$date_start, $date_end]);

        $queryPeriod = DB::table('orders')
            ->selectRaw('
                TO_CHAR(order_date, \'DD/MM/YYYY\') AS period, 
                SUM(price_paid) as revenue
            ')
            ->whereBetween('order_date', [$date_start, $date_end])
            ->groupBy('period')
            ->orderBy('period', 'asc');

        if ($invoiced !== null) {
            $query->where('invoiced', $invoiced);
            $queryPeriod->where('invoiced', $invoiced);
        }

        // Determine the operation to perform
        switch ($operation) {
            case 'summary':
                return $query->first();

            case 'status':
                return DB::table('orders')
                    ->selectRaw('
                        CASE WHEN order_status <> \'Pending\' THEN TRUE ELSE FALSE END AS status,
                        COUNT(id) as orders
                    ')
                    ->whereBetween('order_date', [$date_start, $date_end])
                    ->groupBy('status')
                    ->get();
            
            case 'statusInvoiced':
                return DB::table('orders') // Add return here
                    ->selectRaw('
                        invoiced AS status,
                        COUNT(id) as orders
                    ')
                    ->whereBetween('order_date', [$date_start, $date_end])
                    ->groupBy('status')
                    ->get();

            case 'today':
                return DB::table('orders')
                    ->selectRaw('
                        date_trunc(\'hour\', order_time) AS period,
                        SUM(price_paid) as revenue
                    ')
                    ->whereDate('order_date', $date_end)
                    ->groupBy('period')
                    ->orderBy('period', 'asc')
                    ->get();

            case 'period':
                return $queryPeriod->get();

            default:
                throw new Exception('Invalid operation'); // Handle invalid operation
        }
    }

    public function getDevolutions($date_start, $date_end, $operation, $invoiced = null)
    {
        // Validate the dates
        // $this->validateDates($date_start, $date_end);
        
        // Initialize the base query
        $query = DB::table('orders')
            ->whereBetween('order_date', [$date_start, $date_end]);
    
        // Add additional condition based on $invoiced if provided
        if ($invoiced !== null) {
            $query->where('invoiced', $invoiced);
        }
    
        // Determine the operation to perform
        switch ($operation) {
            case 'summary':
                // Fetch aggregated summary
                return $query->selectRaw('
                    COUNT(id) as orders,
                    COUNT(DISTINCT customer_id) as customers,
                    SUM(amount) as amount,
                    SUM(price_paid) * 0.2 as revenue
                ')->first();
    
            case 'statusInvoiced':
                // Fetch counts grouped by invoiced status
                return $query->selectRaw('
                    invoiced AS status,
                    COUNT(id) as orders
                ')
                ->groupBy('status')
                ->get();
    
            default:
                throw new \InvalidArgumentException('Invalid operation specified.');
        }
    }

    public function getGoals($date_start, $date_end)
    {
        // Assuming you're using a model like Order for fetching the data, otherwise use DB facade.
        return DB::table('orders') // Replace 'orders' with your actual table name
            ->whereBetween('created_at', [$date_start, $date_end]) // Adjust 'created_at' to match your date field
            ->selectRaw('
                SUM(price_paid) * 1.2 as goal,
                SUM(price_paid) * 1.5 as goal_super,
                SUM(price_paid) * 2 as goal_board
            ')
            ->get();
    }
    


    private function validateDates($date_start, $date_end)
    {
        $format = 'Y-m-d';
        $startDateTime = \DateTime::createFromFormat($format, $date_start);
        $endDateTime = \DateTime::createFromFormat($format, $date_end);

        if (!$startDateTime || !$endDateTime) {
            throw new Exception('Invalid date format. Please use YYYY-MM-DD.');
        }

        if ($startDateTime > $endDateTime) {
            throw new Exception('Start date must be before or equal to end date.');
        }

        $currentDate = new \DateTime();
        if ($startDateTime > $currentDate || $endDateTime > $currentDate) {
            throw new Exception('Dates must not be in the future.');
        }
    }
}
