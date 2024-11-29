<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\dispatchesService;
use function Symfony\Component\Translation\t;

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
            // $startDate = $request->get('startDate', '2024-11-01');
            // $endDate = $request->get('endDate', '2024-11-10');

            $startDate = $request->get('startDate', now()->startOfMonth()->toDateString());
            $endDate = $request->get('endDate', now()->endOfMonth()->toDateString());
            
            // Fetch data based on dates
            $responseCampaigns = $this->dispatchesService->getCampaigns();
            $responseDispatches = $this->dispatchesService->getDispatches($startDate, $endDate, null);
    
            // Process campaigns
            $campaigns = array_map(fn($campaign) => $campaign->name, $responseCampaigns);
    
            // Process dispatches
            $dispatches = array_map(function ($dispatch) {
                return [
                    'source' => $dispatch->source,
                    'dispatch_modality' => ucwords($dispatch->dispatch_modality),
                    'template_key' => ucwords(preg_replace('/\s+/', ' ', $dispatch->template_key)),
                    'dispatches' => $dispatch->dispatches,
                    'dispatches_confirmed' => $dispatch->dispatches_confirmed,
                    'dispatches_pending' => $dispatch->dispatches_pending,
                    'dispatches_inactive' => $dispatch->dispatches_inactive,
                    'dispatches_failed' => $dispatch->dispatches_failed,
                ];
            }, $responseDispatches);
            
            // Initialize totals
            $totalDispatches = [];
            $totalCampaigns = [];
            
            $dispatchesCollection = collect($dispatches);

            $totalDispatches = [
                [
                    'source' => 'Total',
                    'dispatch_modality' => [],
                    'total' => $dispatchesCollection->sum('dispatches'),
                    'total_confirmed' => $dispatchesCollection->sum('dispatches_confirmed'),
                    'total_pending' => $dispatchesCollection->sum('dispatches_pending'),
                    'total_inactive' => $dispatchesCollection->sum('dispatches_inactive'),
                    'total_failed' => $dispatchesCollection->sum('dispatches_failed'),
                    'total_campaigns' => [],
                ]
            ];

            // Calculate the total campaigns and their share
            $totalCampaigns = $dispatchesCollection
                ->groupBy('template_key')
                ->map(function ($items, $template_key) use ($totalDispatches) {
                    $totalConfirmed = $totalDispatches[0]['total_confirmed'];  // Get the total confirmed dispatches
                    return [
                        'source' => 'Total',
                        'template_key' => $template_key,
                        'total_confirmed' => $items->sum('dispatches_confirmed'),
                        'share' => ($totalConfirmed > 0) ? number_format((($items->sum('dispatches_confirmed') / $totalConfirmed) * 100), 0, ',', '.') : 0,
                    ];
                })
                ->values()
                ->toArray();

            $totalDispatches[0]['total_campaigns'] = $totalCampaigns;

            $totalModalities = $dispatchesCollection
            ->groupBy('dispatch_modality')
            ->map(function ($items, $dispatch_modality) use ($totalDispatches) {
                $totalConfirmed = $totalDispatches[0]['total_confirmed'];  // Get the total confirmed dispatches
                return [
                    'source' => 'Total',
                    'dispatch_modality' => $dispatch_modality,
                    'total_confirmed' => $items->sum('dispatches_confirmed'),
                    'total_pending' => $items->sum('dispatches_pending'),
                    'total_inactive' => $items->sum('dispatches_inactive'),
                    'total_failed' => $items->sum('dispatches_failed'),
                    'share' => ($totalConfirmed > 0) ? number_format((($items->sum('dispatches_confirmed') / $totalConfirmed) * 100), 0, ',', '.') : 0,
                ];
            })
            ->values()
            ->toArray();

            $totalDispatches[0]['dispatch_modality'] = $totalModalities;

            // Totals filtered by source (e.g., Website, Stores)
            $sources = $dispatchesCollection->pluck('source')->unique();

            // Campaign totals filtered by source
            foreach ($sources as $source) {
                // Filter the dispatches by source once
                $sourceDispatches = $dispatchesCollection->where('source', $source);

                $totalConfirmed = $sourceDispatches->sum('dispatches_confirmed'); // Pre-calculate total_confirmed

                $sourceTotals = [
                    'source' => $source,
                    'dispatch_modality' => $sourceDispatches
                        ->groupBy('dispatch_modality')
                        ->map(function ($items, $dispatch_modality) use ($source, $totalConfirmed) { // Use pre-calculated value
                            return [
                                'source' => $source,
                                'dispatch_modality' => $dispatch_modality,
                                'total_confirmed' => $items->sum('dispatches_confirmed'),
                                'total_pending' => $items->sum('dispatches_pending'),
                                'total_inactive' => $items->sum('dispatches_inactive'),
                                'total_failed' => $items->sum('dispatches_failed'),
                                'share' => ($totalConfirmed > 0) ? number_format((($items->sum('dispatches_confirmed') / $totalConfirmed) * 100), 0, ',', '.') : 0,
                            ];
                        })
                        ->values()
                        ->toArray(),
                    'total' => $sourceDispatches->sum('dispatches'),
                    'total_confirmed' => $totalConfirmed,
                    'total_pending' => $sourceDispatches->sum('dispatches_pending'),
                    'total_inactive' => $sourceDispatches->sum('dispatches_inactive'),
                    'total_failed' => $sourceDispatches->sum('dispatches_failed'),
                    'total_campaigns' => $sourceDispatches
                        ->groupBy('template_key')
                        ->map(function ($items, $template_key) use ($source, $totalConfirmed) { // Use pre-calculated value
                            return [
                                'source' => $source,
                                'template_key' => $template_key,
                                'total_confirmed' => $items->sum('dispatches_confirmed'),
                                'share' => ($totalConfirmed > 0) ? number_format((($items->sum('dispatches_confirmed') / $totalConfirmed) * 100), 0, ',', '.') : 0,
                            ];
                        })
                        ->values()
                        ->toArray(),
                ];
                
                $totalDispatches[] = $sourceTotals;

                // Calculate campaigns for this source
                $sourceCampaigns = $sourceDispatches
                    ->groupBy('template_key')
                    ->map(function ($items, $template_key) use ($source, $sourceTotals) {
                        $totalConfirmed = $sourceTotals['total_confirmed'];  // Get the total confirmed dispatches for the source
                        return [
                            'source' => $source,
                            'template_key' => $template_key,
                            'total_confirmed' => $items->sum('dispatches_confirmed'),
                            'share' => ($totalConfirmed > 0) ? number_format((($items->sum('dispatches_confirmed') / $totalConfirmed) * 100), 0, ',', '.') : 0,
                        ];
                    })
                    ->values()
                    ->toArray();
                
                $sourceTotals[0]['total_campaigns'] = $sourceCampaigns;

                // Merge source-specific campaigns into the total campaigns list
                $totalCampaigns = array_merge($totalCampaigns, $sourceCampaigns);
            }        

            // Handle AJAX request
            if ($request->ajax()) {
                // Return the view with updated data for AJAX requests
                // return response()->view('dashboards.crmDispatches', compact('campaigns', 'totalCampaigns', 'totalDispatches'));
                $html = '';
                foreach ($totalDispatches as $dispatchesData) {
                    $html .= view('components.cardDispatches', compact('dispatchesData'))->render();
                }
            
                return response()->json($html);
            }

            // Return the full page view for non-AJAX requests
            return view('dashboards.crmDispatches', compact('campaigns', 'totalDispatches'));

        } catch (\Exception $e) {
            logger()->error("Error fetching dispatch data: " . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to load dispatch data: ' . $e->getMessage()]);
        }
    }
}
