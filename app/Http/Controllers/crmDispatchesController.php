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

    public function crmDispatchesIndex()
    {
        try {
            // Fetch dispatch data
            $responseCampaigns = $this->dispatchesService->getCampaigns();
            $responseDispatches = $this->dispatchesService->getDispatches('2024-11-01', '2024-11-30', null);
    
            // Process campaigns
            $campaigns = array_map(function ($campaign) {
                return $campaign->name;
            }, $responseCampaigns);
    
            // Process dispatches
            $dispatches = array_map(function ($dispatch) {
                return [
                    'template_key' => $dispatch->template_key,
                    'dispatches' => $dispatch->dispatches,
                    'dispatches_confimed' => $dispatch->dispatches_confimed,
                    'dispatches_pending' => $dispatch->dispatches_pending,
                    'dispatches_inactive' => $dispatch->dispatches_inactive,
                    'dispatches_failed' => $dispatch->dispatches_failed,
                ];
            }, $responseDispatches);
    
            // Pass 'campaigns' and 'dispatches' to the view
            return view('dashboards.crmDispatches', compact('campaigns', 'dispatches'));
        } catch (\Exception $e) {
            logger()->error("Error fetching dispatch data: " . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to load dispatch data: ' . $e->getMessage()]);
        }
    }
    
    
}
