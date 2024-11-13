<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class datesService
{
    /**
     * Return the start and end dates as Carbon instances
     *
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function fetchDataBetweenDates($startDate, $endDate)
    {
        // Convert start and end dates to Carbon instances (for proper formatting)
        $date_start = Carbon::createFromFormat('d/m/Y', $startDate)->startOfDay();  // Start of the day
        $date_end = Carbon::createFromFormat('d/m/Y', $endDate)->endOfDay();  // End of the day

        // Return both dates as an array
        return [$date_start, $date_end];
    }
}