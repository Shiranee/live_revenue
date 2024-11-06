<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RevenueService;
use App\Services\divergencesService;

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
        $this->date_start = '2024-09-01';
        $this->date_end = '2024-09-30';
    }
    
    public function index()
    {
        $default = "0";
        $cardsOperations = ['today', 'summary', 'invoiced'];
        $cardsRevenueTitles = ['Hoje', 'Acumulada', 'Faturada'];
        $cardsRevenueSubTitle = ['Captado', 'Líquido', 'Líquido'];
    
        foreach ($cardsOperations as $index => $operation) {        
            // Initialize confirmed and pending payments for each operation
            $confirmed = 0;
            $pending = 0;
    
            // Create new DateTime instances for each operation
            $ly_date_start = new \DateTime($this->date_start);
            $ly_date_end = new \DateTime($this->date_end);
    
            // Fetch order summaries based on the operation type
            if ($operation === 'today') {
                $response = $this->orderService->getRevenue($this->date_end, $this->date_end, 'summary');
                $responsePeriod = $this->orderService->getRevenue($this->date_end, $this->date_end, 'today');
                $responseDevolutions = $this->orderService->getDevolutions($this->date_end, $this->date_end, 'summary');
                $responseSub = $this->orderService->getRevenue($this->date_end, $this->date_end, 'status');
    
                // Modify a clone for the previous day
                $ly_date_end->modify('-1 day')->format('Y-m-d');
                $responseLy = $this->orderService->getRevenue(
                    $ly_date_end, 
                    $ly_date_end, 
                    'summary'
                );
    

            } elseif ($operation === 'invoiced') {
                $response = $this->orderService->getRevenue($this->date_start, $this->date_end, 'summary', true);
                $responseDevolutions = $this->orderService->getDevolutions($this->date_start, $this->date_end, 'summary', true);
                $responseSub = $this->orderService->getRevenue($this->date_start, $this->date_end, 'statusInvoiced');
    
                // Modify a clone for the previous day
                $ly_date_start->modify('-1 day')->format('Y-m-d');
                $ly_date_end->modify('-1 day')->format('Y-m-d');
                $responseLy = $this->orderService->getRevenue(
                    $ly_date_start, 
                    $ly_date_end, 
                    'summary', 
                    true
                );
    
            } else {
                $response = $this->orderService->getRevenue($this->date_start, $this->date_end, $operation);
                $responsePeriod = $this->orderService->getRevenue($this->date_start, $this->date_end, 'period');
    
                // Modify a clone for the previous day
                $ly_date_start->modify('-1 day')->format('Y-m-d');
                $ly_date_end->modify('-1 day')->format('Y-m-d');
                $responseLy = $this->orderService->getRevenue(
                    $ly_date_start, 
                    $ly_date_end, 
                    $operation
                );
    
                $responseDevolutions = $this->orderService->getDevolutions($this->date_start, $this->date_end, $operation);
                $responseSub = $this->orderService->getRevenue($this->date_start, $this->date_end, 'status');
            }
    
            try {
                if (!$response) {
                    throw new \Exception('No data found for the specified date range');
                }
            } catch (\Exception $e) {
                logger()->error("Error fetching order summary: " . $e->getMessage());
                return back()->withErrors(['error' => 'Failed to load dashboard data: ' . $e->getMessage()]);
            }
        
            // Iterate through the status data to calculate confirmed and pending amounts
            foreach ($responseSub as $status) {
                if ($status->status === true) {
                    $confirmed += $status->orders; // Sum orders for 'Pago'
                } else {
                    $pending += $status->orders; // Sum amounts for 'Aguardando Pagamento'
                }
            }

            // Populate the cards array with data for each operation
            $cards[] = [
                'titleFirst' => 'Receita ' . $cardsRevenueTitles[$index],
                'tooltip' => 'Comparação ao dia anterior',
                'comparison' => $responseLy->revenue != 0 
                    ? number_format((($response->revenue - $responseLy->revenue) / $responseLy->revenue) * 100, 0, ',', '.') . '%' 
                    : 'N/A',
                'titleSecond' => $cardsRevenueSubTitle[$index],
                'revenue' => 'R$ ' . (
                    $cardsRevenueTitles[$index] === 'Hoje'
                        ? number_format(round($response->revenue ?? $default), 0, ',', '.')
                        : number_format(round(($response->revenue ?? 0) - ($responseDevolutions->revenue ?? 0)), 0, ',', '.')
                ),
                'graphId' => 'chart-revenue-' . $cardsOperations[$index], // Unique ID for each chart
                'customers' => $response->customers ?? 0,
                'orders' => $response->orders ?? 0,
                'amount' => $response->amount ?? 0, // Ensure this is set to 0 if not available
                'subtitleMain' => 'Pagamentos',
                'subtitleFirst' => 'Confirmados:',
                'subtitleSecond' => 'Pendentes:',
                'valueFirst' => $confirmed, // Amount for confirmed payments
                'valueSecond' => $pending, // Amount for pending payments
                'invoicedShare' => $confirmed ? round(($confirmed / ($confirmed + $pending)) * 100) : 0,
                'revenuePeriod' => $responsePeriod->map(function($item) {
                    return [
                        'period' => $item->period, 
                        'revenue' => number_format($item->revenue, 2, ',', '.')
                    ];
                }),
            ];
            $cardsDevolution[] = [
                'dTitle' => 'Devoluções ' . $cardsRevenueTitles[$index],
                'dComparison' => '-6.8%', // You might want to calculate this based on previous data
                'devolutions' => 'R$ ' . number_format(round($responseDevolutions->revenue ?? $default), 0, ',', '.'),
            ];
        }
    
        // Pass the cards data to the view
        return view('dashboard', compact('cards', 'cardsDevolution'));
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
                , 'order_discount' => 'R$ ' . number_format(round($item->order_discount), 0, ',', '.')
                , 'order_value' => 'R$ ' . number_format(round($item->order_value), 0, ',', '.')
                , 'payment_value' => 'R$ ' . number_format(round($item->payment_value), 0, ',', '.')
                , 'itens_value' => 'R$ ' . number_format(round($item->itens_value), 0, ',', '.')
                , 'divergence' => 'R$ ' . number_format(round($item->divergence), 0, ',', '.')
                , 'transporter' => $item->transporter
                // , 'divergence_type' => $item->divergence_type
            ];
        });

        $cardData = [
            'orders' => count($response), // Total number of orders
            'customers' => collect($response)->pluck('customer_id')->unique()->count(), // Count unique customers
            'amount' => collect($response)->sum('amount'), // Sum of amounts
        ];

        $divergencesType = collect($response)->groupBy('divergence_type')->map(function ($items, $divergenceType) {
            return [
                'value' => $items->count(),
                'name' => $divergenceType // 'Positivas' or 'Negativas'
            ];
        });

        $divergencesTypeGraph = $divergencesType->values();
    
        return view('dashboards.ordersDivergences', compact('tableData', 'cardData', 'divergencesType', 'divergencesTypeGraph'));
    }    
}