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
        $date_start = '2024-09-01';
        $date_end = '2024-09-30';
        $ly_date_start = new \DateTime($date_start);
        $ly_date_end = new \DateTime($date_end);
        $cards = [];
        $cardsOperations = ['today', 'summary', 'invoiced'];
        $cardsRevenueTitles = ['Hoje', 'Acumulada', 'Faturada'];
        $cardsRevenueSubTitle = ['Captado', 'Líquido', 'Líquido'];


        foreach ($cardsOperations as $index => $operation) {        
            // Initialize confirmed and pending payments for each operation
            $confirmed = 0;
            $pending = 0;

            // Fetch order summaries based on the operation type
            if ($operation === 'today') {
                $response = $this->orderService->getRevenue($date_end, $date_end, 'summary');
                $responseLy = $this->orderService->getRevenue($ly_date_end->modify('-1 day')->format('Y-m-d'), $ly_date_end->modify('-1 day')->format('Y-m-d'), 'summary');
                $responseDevolutions = $this->orderService->getDevolutions($date_end, $date_end, 'summary');
                $responseSub = $this->orderService->getRevenue($date_end, $date_end, 'status');
            } elseif ($operation === 'invoiced') {
                $response = $this->orderService->getRevenue($date_start, $date_end, 'summary', true);
                $responseLy = $this->orderService->getRevenue($ly_date_start->modify('-1 day')->format('Y-m-d'), $ly_date_end->modify('-1 day')->format('Y-m-d'), 'summary', true);
                $responseDevolutions = $this->orderService->getDevolutions($date_start, $date_end, 'summary', true);
                $responseSub = $this->orderService->getRevenue($date_start, $date_end, 'statusInvoiced');
            } else {
                $response = $this->orderService->getRevenue($date_start, $date_end, $operation);
                $responseLy = $this->orderService->getRevenue($ly_date_start->modify('-1 day')->format('Y-m-d'), $ly_date_end->modify('-1 day')->format('Y-m-d'), $operation);
                $responseDevolutions = $this->orderService->getDevolutions($date_start, $date_end, $operation);
                $responseSub = $this->orderService->getRevenue($date_start, $date_end, 'status');
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
                'comparison' => $responseLy->revenue != 0 
                    ? number_format((($response->revenue - $responseLy->revenue) / $responseLy->revenue) * 100, 2, ',', '.') . '%' 
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
            ];
            $cardsDevolution[] = [
                'dTitle' => 'Devoluções ' . $cardsRevenueTitles[$index],
                // 'tooltip' => 'Comparação ao dia anterior',
                'dComparison' => '-6.8%', // You might want to calculate this based on previous data
                'devolutions' => 'R$ ' . number_format(round($responseDevolutions->revenue ?? $default), 0, ',', '.'),
            ];
        }

        // Pass the cards data to the view
        return view('dashboard', compact('cards', 'cardsDevolution'));
    }
    public function divergencesIndex() {
        return view('dashboards.ordersDivergences');
    }
}
