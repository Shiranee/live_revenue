<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\dispatchesService;

class crmDispatchesController extends Controller
{
    protected $dispatchesService;

    // Inject the dispatchesService dependency
    public function __construct(dispatchesService $dispatchesService)
    {
        $this->dispatchesService = $dispatchesService;
    }

    public function crmDispatchesIndex(Request $request)
    {
        try {
            // Get dates from the request (fallback to default range if not provided)
            $startDate = $request->get('startDate', '2024-11-01');
            $endDate = $request->get('endDate', '2024-11-01');
    
            // Fetch data based on dates
            $responseCampaigns = $this->dispatchesService->getCampaigns();
            $responseDispatches = $this->dispatchesService->getDispatches($startDate, $endDate, null);
    
            // Process campaigns
            $campaigns = array_map(fn($campaign) => $campaign->name, $responseCampaigns);
    
            // Process dispatches
            $dispatches = array_map(function ($dispatch) {
                return [
                    // 'template_key' => $dispatch->template_key,
                    // 'dispatches' => $dispatch->dispatches,
                    'dispatches_confimed' => $dispatch->dispatches_confimed
                    // 'dispatches_pending' => $dispatch->dispatches_pending,
                    // 'dispatches_inactive' => $dispatch->dispatches_inactive,
                    // 'dispatches_failed' => $dispatch->dispatches_failed,
                ];
            }, $responseDispatches);

            $totalDispatches = collect($dispatches)->sum('dispatches_confimed');
    
            // Handle AJAX request
            if ($request->ajax()) {
                // Return the view with updated data for AJAX requests
                return response()->view('dashboards.crmDispatches', compact('campaigns', 'dispatches', 'totalDispatches'));
            }

            // Return the full page view for non-AJAX requests
            return view('dashboards.crmDispatches', compact('campaigns', 'dispatches', 'totalDispatches'));

        } catch (\Exception $e) {
            logger()->error("Error fetching dispatch data: " . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to load dispatch data: ' . $e->getMessage()]);
        }
    }
}
