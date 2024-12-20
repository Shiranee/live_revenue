<?php

namespace App\Services;

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
    public function fetchConciliation(string $startDate, string $endDate, string $type): ?array
    {
        $url = "http://127.0.0.1:5000/api/conciliation/{$startDate}/{$endDate}/{$type}";

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                return $response->json();
            } else {
                // Log the error or handle accordingly
                return null;
            }
        } catch (\Exception $e) {
            // Log the exception
            logger()->error('API Fetch Error: ' . $e->getMessage());
            return null;
        }
    }
}