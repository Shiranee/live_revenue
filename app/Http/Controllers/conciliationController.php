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
            
            $responseConciliation = $this->conciliationService->fetchConciliation($startDate, $endDate, 'overview');

            // Extract the "data" array
            $conciliationData = $responseConciliation['data'] ?? [];

            // dd($conciliationData);

            // // Handle AJAX request
            // if ($request->ajax()) {
            //     // Return the view with updated data for AJAX requests
            //     // return response()->view('dashboards.crmDispatches', compact('campaigns', 'totalCampaigns', 'totalDispatches'));
            //     $html = '';
            //     foreach ($totalDispatches as $dispatchesData) {
            //         $html .= view('components.cardDispatches', compact('dispatchesData'))->render();
            //     }
            
            //     return response()->json($html);
            // }

            // Return the full page view for non-AJAX requests
            return view('dashboards.revenueConciliation', compact('conciliationData'));

        } catch (\Exception $e) {
            logger()->error("Error fetching dispatch data: " . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to load dispatch data: ' . $e->getMessage()]);
        }
    }
}
