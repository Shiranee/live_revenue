<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\conciliationService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use function Symfony\Component\Translation\t;

class conciliationController extends Controller
{
    protected $conciliationService;

    // Inject the conciliationService dependency
    public function __construct(conciliationService $conciliationService)
    {
        $this->conciliationService = $conciliationService;
    }

		public function conciliationIndex(Request $request)
		{
				try {
						$startDate = $request->get('startDate', now()->startOfMonth()->toDateString());
						$endDate = $request->get('endDate', now()->toDateString());
						
						// Fetch data from the API
						$responseOverview = $this->conciliationService->fetchConciliation($startDate, $endDate, 'overview');
						$responseTable = $this->conciliationService->fetchConciliation($startDate, $endDate, 'table', '?page=1&page_size=1');
		
						// Log the raw responses
						Log::debug('Overview Response:', ['response' => $responseOverview]);
						Log::debug('Table Response:', ['response' => $responseTable]);
		
						// Extract the "data" array from responses
						$conciliationOverview = $responseOverview['data'] ?? [];
						
						$conciliationTable = $responseTable['data'] ?? [];
						$conciliationTableNames = [];
						if (!empty($conciliationTable)) {
								$conciliationTableNames = array_keys((array) $conciliationTable[0]); // First row contains the column names
						}
		
						return view('dashboards.revenueConciliation', compact('conciliationOverview', 'conciliationTable', 'conciliationTableNames'));
		
				} catch (\Exception $e) {
						Log::error("Error fetching dispatch data: " . $e->getMessage());
						return back()->withErrors(['error' => 'Failed to load dispatch data: ' . $e->getMessage()]);
				}
		}
		
}
