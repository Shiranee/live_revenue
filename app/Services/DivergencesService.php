<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Exception;

class DivergenceService
{
    public function getDivergences($date_start, $date_end, $operation, $invoiced = null)
    {
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
}