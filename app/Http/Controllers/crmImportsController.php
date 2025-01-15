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
					SELECT
										ca.cpf_cnpj AS cpf
									,	c.name
									, c.phone AS phone
									, os.cnpj AS store_cnpj
									, CASE
													WHEN os.franchising IS NOT NULL THEN 'loja'
													WHEN ca.preference_channel = 'E-commerce' OR os.cnpj <> '00000000000000' OR ca.channel = 'Multicanal' THEN 'ecommerce'
										END AS channel

					FROM crm.customers_active ca
					LEFT JOIN crm.customers c ON ca.cpf_cnpj = c.cpf_cnpj
					LEFT JOIN crm.our_stores os ON ca.preference_store_cnpj = os.cnpj AND os.status = 'TRUE' AND os.cnpj <> '00000000000000' AND os.url IS NOT NULL AND os.franchising NOT REGEXP 'Outlet'

					WHERE
					(os.cnpj IS NOT NULL OR ca.channel IN ('Exclusivo E-commerce', 'Multicanal'))
        ";

        $listPreview = $this->dispatchesService->getQueryPreview($listQuery);

        $campaigns = array_map(fn($campaign) => $campaign->name, $responseCampaigns);

        return view('utilities.crmImports', compact('campaigns', 'listPreview'));
    }

		public function handleActions(Request $request)
		{
			$action = $request->input('action');
			$listQuery = $request->input('listQuery');
			$listFile = $request->file('crmImportFile');
			$action = $request->input('action');
			$campaign = explode(',', $request->input('campaign'));
			$channel = explode(',', $request->input('channel'));
			$query = $request->input('query');
			$job = $request->input('job');
	
			// \Log::debug('Request received', [
			// 	'campaign' => $campaign,
			// 	'channel' => $channel,
			// 	'query' => $query,
			// 	'job' => $job,
			// 	// 'file' => json_encode(array_map('addslashes', $this->parseUploadedFile($listFile)['rows']))
			// ]);

			switch ($action) {
				case 'preview':
					if ($listFile || $listQuery) {
							$data = $this->handleSourceChoice($listQuery, $listFile);

							return view('components.dinamicTable', [
									'title' => 'Preview',
									'tableData' => $data['data'],
									'headerData' => $data['columns'],
									'pageSize' => 20,
							]);
					} else {
							return response()->json(['error' => 'No query or file provided'], 400);
					}

				case 'submit':
					if ($job) {
							// $query = htmlspecialchars($query, ENT_QUOTES, 'UTF-8');
							
							if($listFile != '') {
								$fileContent = $this->parseUploadedFile($listFile)['rows'];
								$fileContent = array_map(function ($row) {
										return is_string($row) ? htmlspecialchars($row, ENT_QUOTES, 'UTF-8') : $row;
								}, $fileContent);
							} else {
								$fileContent = '';
							}
							// $campaign = implode(',', $campaign);
							// $channel = implode(',', $channel);
			
							$listData = [
									'campaign' => $campaign,
									'channel' => $channel,
									'job' => $job,
									'query' => $query,
									'file' => $fileContent,
							];
			
							// Post the data to the API
							$response = $this->dispatchesService->postTwillioList($listData);
			
							if ($response) {
									return response()->json($response, 200);
							} else {
									return response()->json(['error' => 'Failed to dispatch to Twilio'], 500);
							}
					} else {
							return response()->json(['error' => 'Invalid job'], 400);
					}

				default: return response()->json(['error' => 'Invalid action'], 400);
			}
		}

		private function handleSourceChoice($query, $file)
		{
				if (!empty($query)) {
						$data = $this->dispatchesService->getQueryPreview($query);
		
						// Normalize structure for query results
						return [
								'data' => $data['data'],
								'columns' => $data['columns'],
						];
				} elseif ($file) {
						$data = $this->parseUploadedFile($file);
		
						// Normalize structure for file results
						return [
								'data' => $data['rows'],
								'columns' => $data['headers'],
						];
				}
		
				return null; // Handle cases where neither query nor file is provided
		}

		private function parseUploadedFile($listFile)
		{
				$rows = [];
				$headers = [];
		
				if (($handle = fopen($listFile->getRealPath(), 'r')) !== false) {
						$headers = fgetcsv($handle); // First row as headers
						while (($data = fgetcsv($handle)) !== false) {
								$rows[] = array_combine($headers, $data);
						}
						fclose($handle);
				}
		
				return [
						'headers' => $headers,
						'rows' => $rows,
				];
		}
}
