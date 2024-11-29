<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Exception;

class dispatchesService 
{
    public function getCampaigns(): array
    {
        try {
            $queryCampaigns = "
                SELECT
                    id,
                    chave AS name,
                    tipo AS type,
                    ativo AS status
                FROM live_db.cashback_twilio_template
            ";

            return DB::connection('oecomm')->select($queryCampaigns);
        } catch (Exception $e) {
            throw new Exception("Error retrieving dispatch data: " . $e->getMessage());
        }
    }

    public function getDispatches($date_start, $date_end, $campaign = null)
    {
        try {
            // Start building the query
            $queryDispatches = "
                SELECT
                              IF(d.source LIKE '%loja%', 'Loja', 'Site') source
                            , CASE
                                    WHEN UPPER(source) LIKE '%UTILITY%' THEN 'Utility'
                                    WHEN UPPER(SOURCE) LIKE '%MARKET%' THEN 'Marketing'
                                    ELSE 'Utility'
                              END AS dispatch_modality
                            , TRIM(REGEXP_REPLACE(d.template_key, 'cta|[^A-Za-z]', ' ')) AS template_key
                            , COUNT(d.id) AS dispatches
                            , COUNT(CASE WHEN d.sended_at IS NOT NULL AND d.has_error <> 1 THEN d.id END) AS dispatches_confirmed
                            , COUNT(CASE WHEN d.sended_at IS NULL AND d.ready_to_send = 1 AND (dt.ativo = 1) AND d.has_error <> 1 THEN d.id END) AS dispatches_pending
                            , COUNT(CASE WHEN (dt.ativo <> 1 OR dt.ativo IS NULL) AND d.sended_at IS NULL THEN d.id END) AS dispatches_inactive
                            , COUNT(CASE WHEN d.has_error = 1 THEN d.id END) AS dispatches_failed

                FROM live_db.customer_queue_notifications d
                LEFT JOIN live_db.cashback_twilio_template dt ON d.template_key = dt.chave
                WHERE
                DATE(d.scheduled_send_date) BETWEEN ? AND ?
            ";
    
            // Add condition for campaign if provided
            $params = [$date_start, $date_end];
            if ($campaign !== null) {
                $queryDispatches .= " AND d.template_key = ?";
                $params[] = $campaign;
            }
    
            // Add grouping to get count per source and template key
            $queryDispatches .= "
                GROUP BY
                    IF(d.source LIKE '%loja%', 'Loja', 'Site'),
                    CASE
                        WHEN UPPER(d.source) LIKE '%UTILITY%' THEN 'UTILITY'
                        WHEN UPPER(d.source) LIKE '%MARKET%' THEN 'MARKETING'
                    END,
                    d.template_key,
                    d.source
            ";
    
            // Execute the query with parameters
            return DB::connection('oecomm')->select($queryDispatches, $params);
        } catch (Exception $e) {
            throw new Exception("Error retrieving dispatch data: " . $e->getMessage());
        }
    }
}