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

        // Add additional condition based on $invoiced if it's not null
        if ($invoiced !== null) {
            $query->where('invoiced', $invoiced);
        }

        // Determine the operation to perform
        switch ($operation) {
            case 'summary':
                return $query->first(); // Get summary

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
                        date_trunc(\'hour\', order_time) AS hour,
                        COUNT(id) as orders,
                        COUNT(DISTINCT customer_id) as customers,
                        SUM(amount) as amount,
                        SUM(price_paid) as revenue
                    ')
                    ->whereDate('order_date', $date_end)
                    ->groupBy('hour')
                    ->orderBy('hour', 'desc')
                    ->get();

            case 'period':
                return DB::table('orders')
                    ->selectRaw('
                        order_date,
                        COUNT(id) as orders,
                        COUNT(DISTINCT customer_id) as customers,
                        SUM(amount) as amount,
                        SUM(price_paid) as revenue
                    ')
                    ->whereBetween('order_date', [$date_start, $date_end])
                    ->groupBy('order_date')
                    ->orderBy('order_date', 'desc')
                    ->get();

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
