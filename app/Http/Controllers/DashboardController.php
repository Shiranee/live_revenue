<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RevenueService;
use App\Services\divergencesService;
use Carbon\Carbon;

class DashboardController extends Controller
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
    
    public function index()
    {
        $default = "0";
        $contents = [
            'operations' => ['today', 'summary', 'invoiced'],
            'titles' => ['Hoje', 'Acumulada', 'Faturada'],
            'subTitles' => ['Captado', 'Líquido', 'Líquido'],
        ];
    
        foreach ($contents['operations'] as $index => $operation) {        
            $confirmed = 0;
            $pending = 0;
            // $ly_date_start = new \DateTime($this->date_start);
            // $ly_date_end = new \DateTime($this->date_end);
            $params = [
                'start' => new \DateTime($this->date_start),
                'end' => new \DateTime($this->date_end),
                'summary' => 'summary',
                'status' => 'status',
                'period' => 'period',
                'isInvoiced' => null,
                'dateInterval' => '-1 day',
                'tooltip' => 'Periodo Comparado: ' . (new \DateTime($this->date_start))->modify('-1 day')->format('d/m/Y') . ' e ' . (new \DateTime($this->date_end))->modify('-1 day')->format('d/m/Y')
            ];
            
            // Modify parameters based on the operation type
            switch ($operation) {
                case 'today':
                    $params['start'] = clone $params['end'];
                    $params['summary'] = 'summary';
                    $params['period'] = 'today';
                    $params['tooltip'] = 'Periodo Comparado: ' . (new \DateTime($this->date_end))->modify($params['dateInterval'])->format('d/m/Y');
                    break;

                case 'invoiced':
                    $params['isInvoiced'] = true;
                    $params['status'] = 'statusInvoiced';
                    $params['dateInterval'] = '-1 day';
                    break;
            
                default:
                    // Use default values without change
                    break;
            }

            // Fetch data with the set parameters
            $response = $this->orderService->getRevenue($params['start'], $params['end'], $params['summary'], $params['isInvoiced']);
            $responsePeriod = $this->orderService->getRevenue($params['start'], $params['end'], $params['period']);
            $responseDevolutions = $this->orderService->getDevolutions($params['start'], $params['end'], $params['summary'], $params['isInvoiced']);
            $responseSub = $this->orderService->getRevenue($params['start'], $params['end'], $params['status']);
            
            // Modify dates for previous period and fetch previous data
            $params['start']->modify($params['dateInterval'])->format('d/m/Y');
            $params['end']->modify($params['dateInterval'])->format('d/m/Y');
            $responseLy = $this->orderService->getRevenue($params['start'], $params['end'], $params['summary'], $params['isInvoiced']);
            $responseDevolutionsLy = $this->orderService->getDevolutions($params['start'], $params['end'], $params['summary'], $params['isInvoiced']);

            // Handle potential exceptions if no response is retrieved
            try {
                if (!$response) {
                    throw new \Exception('No data found for the specified date range');
                }
            } catch (\Exception $e) {
                logger()->error("Error fetching order summary: " . $e->getMessage());
                return back()->withErrors(['error' => 'Failed to load dashboard data: ' . $e->getMessage()]);
            }
    
            foreach ($responseSub as $status) {
                if ($status->status === true) {
                    $confirmed += $status->orders;
                } else {
                    $pending += $status->orders;
                }
            }
    
            $cardsRevenue[] = [
                'titleFirst' => 'Receita ' . $contents['titles'][$index],
                'tooltip' => $params['tooltip'],
                'comparison' => $responseLy->revenue != 0 
                    ? number_format((($response->revenue - $responseLy->revenue) / $responseLy->revenue) * 100, 0, ',', '.') . '%' 
                    : 'N/A',
                'titleSecond' => $contents['subTitles'][$index],
                'revenue' => 'R$' . (
                    $contents['titles'][$index] === 'Hoje'
                        ? number_format(round($response->revenue ?? $default), 0, ',', '.')
                        : number_format(round(($response->revenue ?? 0) - ($responseDevolutions->revenue ?? 0)), 0, ',', '.')
               ) ,
                'graphId' => 'chart-revenue-' . $contents['operations'][$index],
                'customers' => $response->customers ?? 0,
                'orders' => $response->orders ?? 0,
                'amount' => $response->amount ?? 0,
                'subtitleMain' => 'Status',
                'subtitleFirst' => 'Confirmados:',
                'subtitleSecond' => 'Pendentes:',
                'valueFirst' => $confirmed,
                'valueSecond' => $pending,
                'invoicedShare' => $confirmed ? round(($confirmed / ($confirmed + $pending)) * 100) : 0,
                'revenuePeriod' => $responsePeriod->map(function($item) {
                    return [
                        'period' => $item->period, 
                        'revenue' => number_format($item->revenue, 2, ',', '.')
                    ];
                }),
            ];
            $cardsDevolution[] = [
                'title' => 'Devoluções ' . $contents['titles'][$index],
                'tooltip' => $params['tooltip'],
                'comparison' => $responseDevolutionsLy->revenue != 0 
                    ? number_format((($response->revenue - $responseDevolutionsLy->revenue) / $responseDevolutionsLy->revenue) * 100, 0, ',', '.') . '%' 
                    : 'N/A',
                'devolutions' => 'R$' . number_format(round($responseDevolutions->revenue ?? $default), 0, ',', '.'),
            ];
        }
    
        // Pass the cards data to the view
        return view('dashboard', compact('cardsRevenue', 'cardsDevolution'));
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