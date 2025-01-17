<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class conciliationService
{
    /**
     * Fetch data from the given API endpoint.
     *
     * @param string $startDate
     * @param string $endDate
     * @param string $type
     * @return array|null
     */
		public function fetchConciliation(string $startDate, string $endDate, string $type, $params = ''): ?array
		{
				$FLASK_URL = config('app.flask_url');
				$url = "{$FLASK_URL}/api/conciliation/{$startDate}/{$endDate}/{$type}{$params}";
		
				Log::debug('Constructed URL for API request: ' . $url);
		
				try {
						$response = Http::get($url);
		
						if ($response->successful()) {
								$jsonResponse = $response->json();
								Log::debug('API Response:', ['url' => $url, 'response' => $jsonResponse]);
		
								return $jsonResponse;
						} else {
								Log::error('API Request failed.', [
										'url' => $url,
										'status' => $response->status(),
										'response' => $response->body(),
								]);
								return null;
						}
				} catch (\Exception $e) {
						Log::error('API Fetch Exception:', [
								'url' => $url,
								'message' => $e->getMessage(),
								'trace' => $e->getTraceAsString(),
						]);
						return null;
				}
		}
		
}