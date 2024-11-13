<?php

namespace App\Services;

use Illuminate\Support\Facades\DB; 
use Exception;

class dispatchesService 
{
    public function getDispatches($date_start, $date_end, $campaign)
    {
        $queryCampaigns = "
            SELECT
                            id
                        , chave AS name
                        , tipo AS type
                        , ativo AS status

            FROM live_db.cashback_twilio_template
        ";

        // if ($campaign !== null) {
        //     $query->where('invoiced', $campaign);
        // }

        switch ($campaign) {
            case 'campaigns':
                return DB::connection('ocomm')->select($queryCampaigns, [$date_start, $date_end]);
        
            default:
                    throw new Exception('Invalid operation');
        }
    }
}