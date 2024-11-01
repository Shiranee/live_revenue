<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RevenueService;

class DashboardController extends Controller
{
    protected $orderService;

    public function __construct(RevenueService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $default = "Carregando...";
        $start_date = '2024-09-01';
        $end_date = '2024-09-30';
        $cards = [];
        $cardsOperations = ['today', 'summary', 'invoiced'];
        $cardsRevenueTitles = ['Hoje', 'Acumulada', 'Faturada'];

        foreach ($cardsOperations as $index => $operation) {        
            // Initialize confirmed and pending payments for each operation
            $confirmed = 0;
            $pending = 0;

            // Fetch order summaries based on the operation type
            if ($operation === 'today') {
                $response = $this->orderService->getOrderSummary($end_date, $end_date, 'summary');
                $responseSub = $this->orderService->getOrderSummary($end_date, $end_date, 'status');
            } elseif ($operation === 'invoiced') {
                $response = $this->orderService->getOrderSummary($start_date, $end_date, 'summary', true);
                $responseSub = $this->orderService->getOrderSummary($start_date, $end_date, 'statusInvoiced');
            } else {
                $response = $this->orderService->getOrderSummary($start_date, $end_date, $operation);
                $responseSub = $this->orderService->getOrderSummary($start_date, $end_date, 'status');
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
                    $confirmed += $status->orders; // Sum orderss for 'Pago'
                } else {
                    $pending += $status->orders; // Sum amounts for 'Aguardando Pagamento'
                }
            }
        
            // Populate the cards array with data for each operation
            $cards[] = [
                'titleFirst' => 'Receita ' . $cardsRevenueTitles[$index],
                'tooltip' => 'Comparação ao dia anterior',
                'comparison' => '-6.8%', // You might want to calculate this based on previous data
                'titleSecond' => 'Capturada',
                'revenue' => 'R$ ' . number_format(round($response->revenue ?? $default), 0, ',', '.'),
                'graphId' => 'chart-revenue-' . $cardsOperations[$index], // Unique ID for each chart
                'customers' => $response->customers ?? 0,
                'orders' => $response->orders ?? 0,
                'amount' => $response->amount ?? 0, // Ensure this is set to 0 if not available
                'subtitleMain' => 'Pagamentos',
                'subtitleFirst' => 'Confirmados:',
                'subtitleSecond' => 'Pendentes:',
                'valueFirst' => $confirmed, // Amount for confirmed payments
                'valueSecond' => $pending, // Amount for pending payments
            ];
        }

        // Pass the cards data to the view
        return view('dashboard', compact('cards'));
    }
    public function divergencesIndex() {
        return view('dashboards.ordersDivergences');
    }
}




// public function index()
// {
//     $cards = [
//         [
//             'titleFirst' => 'Receita Hoje',
//             'tooltip' => 'Comparação ao dia anterior',
//             'comparison' => '-6.8%',
//             'titleSecond' => 'Capturada',
//             'revenue' => 5000,
//             'graphId' => 'revenue-chart-1',
//             'customers' => 100,
//             'orders' => 50,
//             'amount' => 2000,
//             'subtitleMain' => 'Pagamentos',
//             'subtitleFirst' => 'Confirmados:',
//             'subtitleSecond' => 'Pendentes:',
//             'valueFirst' => 1200,
//             'valueSecond' => 800,
//         ],
//         [
//             'titleFirst' => 'Receita Ontem',
//             'tooltip' => 'Comparação ao dia anterior',
//             'comparison' => '+4.5%',
//             'titleSecond' => 'Capturada',
//             'revenue' => 4500,
//             'graphId' => 'revenue-chart-2',
//             'customers' => 90,
//             'orders' => 45,
//             'amount' => 1800,
//             'subtitleMain' => 'Pagamentos',
//             'subtitleFirst' => 'Confirmados:',
//             'subtitleSecond' => 'Pendentes:',
//             'valueFirst' => 1100,
//             'valueSecond' => 700,
//         ],
//         [
//             'titleFirst' => 'Receita Semana',
//             'tooltip' => 'Comparação à semana passada',
//             'comparison' => '+12.0%',
//             'titleSecond' => 'Capturada',
//             'revenue' => 30000,
//             'graphId' => 'revenue-chart-3',
//             'customers' => 500,
//             'orders' => 300,
//             'amount' => 12000,
//             'subtitleMain' => 'Pagamentos',
//             'subtitleFirst' => 'Confirmados:',
//             'subtitleSecond' => 'Pendentes:',
//             'valueFirst' => 9000,
//             'valueSecond' => 3000,
//         ],
//     ];

//     return view('dashboard', compact('cards'));
// }
