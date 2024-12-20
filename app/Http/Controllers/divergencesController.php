<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RevenueService;
use App\Services\divergencesService;
use Carbon\Carbon;

class divergencesController extends Controller
{
    protected $orderService;
    protected $divergencesService;
    protected $date_start;
    protected $date_end;

    public function __construct(RevenueService $orderService, DivergencesService $divergencesService)
    {
        $this->orderService = $orderService;
        $this->divergencesService = $divergencesService;
        $this->date_start = '2024-11-01';
        $this->date_end = '2024-11-30';
    }

    public function divergencesIndex() {
        // Fetch divergences data
        $response = $this->divergencesService->getDivergences($this->date_start, $this->date_end);
    
        try {
            // Check if there is data in the response
            if (!$response || count($response) === 0) {
                throw new \Exception('No data found for the specified date range');
            }
        } catch (\Exception $e) {
            logger()->error("Error fetching order summary: " . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to load dashboard data: ' . $e->getMessage()]);
        }
    
        // Process data for view
        $tableData = collect($response)->map(function($item) {
            return [
                  'order_date' => $item->order_date
                , 'order_id' => $item->order_id
                , 'status' => $item->status
                , 'payment' => $item->payment
                , 'coupon_discount' => $item->coupon_discount
                , 'coupon_seller' => $item->coupon_seller
                , 'nf' => $item->nf
                , 'amount' => $item->amount
                , 'order_discount' => 'R$' . number_format(round($item->order_discount), 0, ',', '.')
                , 'order_value' => 'R$' . number_format(round($item->order_value), 0, ',', '.')
                , 'payment_value' => 'R$' . number_format(round($item->payment_value), 0, ',', '.')
                , 'itens_value' => 'R$' . number_format(round($item->itens_value), 0, ',', '.')
                , 'divergence' => 'R$' . number_format(round($item->divergence), 0, ',', '.')
                , 'transporter' => $item->transporter
                // , 'divergence_type' => $item->divergence_type
            ];
        });

        $cardData = [
            'orders' => count($response),
            'customers' => collect($response)->pluck('customer_id')->unique()->count(),
            'amount' => collect($response)->sum('amount'),
        ];

        $divergencesType = collect($response)->groupBy('payment')->map(function ($items, $divergenceType) {
            return [
                'value' => $items->count(),
                'name' => $divergenceType,
                'revenue' => 'R$' . number_format(round($items->sum('divergence')), 0, ',', '.')
            ];
        });

        $divergencesHour = collect($response)->groupBy('order_hour')->map(function ($items, $hour) {
            return [
                'period' => $hour,
                'orders' => $items->count()
            ];
        })->sortBy('period')->values();

        $divergencesDay = collect($response)->groupBy('order_date')->map(function ($items, $date) {
            return [
                'period' => \Carbon\Carbon::parse($date)->format('d/m/Y'), // Convert the date string to a Carbon instance
                'orders' => $items->count()
            ];
        })->values();

        $divergencesTypeGraph = $divergencesType->values();
    
        return view('dashboards.ordersDivergences', compact('tableData', 'cardData', 'divergencesType', 'divergencesTypeGraph', 'divergencesHour', 'divergencesDay'));
    }
}