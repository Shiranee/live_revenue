<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\dispatchesService;
use function Symfony\Component\Translation\t;

class crmImportsController extends Controller
{
    protected $dispatchesService;

    // Inject the dispatchesService dependency
    public function __construct(dispatchesService $dispatchesService)
    {
        $this->dispatchesService = $dispatchesService;
    }

    public function crmImportsIndex(Request $request)
    {   
        $responseCampaigns = $this->dispatchesService->getCampaigns();
        
        $listQuery = "
            SELECT * FROM crm.customers_active
        ";

        $listPreview = $this->dispatchesService->getQueryPreview($listQuery);

        $campaigns = array_map(fn($campaign) => $campaign->name, $responseCampaigns);

        return view('utilities.crmImports', compact('campaigns', 'listPreview'));
    }

    public function handleActions(Request $request)
    {
        $action = $request->input('action');
        $listQuery = $request->input('listQuery');
    
        if ($action === 'preview' && $listQuery) {
            $listPreview = $this->dispatchesService->getQueryPreview($listQuery);
    
            // Return only the table view for rendering
            return view('components.dinamicTable', [
                'title' => 'Preview',
                'tableData' => $listPreview['data'],
                'headerData' => $listPreview['columns'],
                'pageSize' => 20,
            ]);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }
}
