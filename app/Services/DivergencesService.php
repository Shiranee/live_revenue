<?php

namespace App\Services;

use Illuminate\Support\Facades\DB; 
use Exception;

class divergencesService 
{
    public function getDivergences($date_start, $date_end)
    {
        try {
            $query = `
                SELECT
                            *
                        , CASE	WHEN divergence > 0 THEN 'Positiva'
                                        ELSE 'Negativa'
                            END AS divergence_type

                FROM
                        (SELECT
                                    o.order_date::date,
                                        DATE_PART('hour', o.order_date) || ':00:00' AS order_hour,
                                    oi.order_id,
                                    os."name" status,
                                    pm."name" AS pagamento,
                                    cd.code AS coupon_discount,
                                    cs.code AS coupon_seller,
                                    oi2."number" || '-' || oi2.series AS nf,
                                    SUM(oi.amount) AS amount,
                                    total_amount::numeric AS order_value,
                                    op.value::numeric AS payment_value,
                                    (SUM(oi.amount * oi.price) + od.price)::numeric AS itens_value,
                                    o.discount_amount::numeric AS order_discount,
                                    (SUM(oi.amount * oi.price) + od.price)::numeric - 
                                        CASE
                                                WHEN op.payment_method_id = 39 THEN o.total_amount
                                                ELSE op.value
                                        END::numeric AS divergence,
                                    c."name" AS transporter,
                                    'CEP: ' || oa.zip_code || ' Cidade: ' || oa.city || '/' || oa.state || ' Rua: ' || oa.address || ' ' || oa."number" AS adress
                        
                        FROM orders o
                        JOIN order_items oi ON oi.order_id = o.id
                        JOIN order_deliveries od ON od.order_id = o.id AND od."type" != 'reverse'
                        JOIN order_addresses oa ON oa.order_id = o.id
                        JOIN order_statuses os ON os.id = o.order_status_id
                        JOIN order_payments op ON op.order_id = o.id
                        JOIN payment_methods pm ON pm.id = op.payment_method_id
                        LEFT JOIN coupons cd ON cd.id = o.coupon_id
                        LEFT JOIN coupons cs ON cs.id = o.seller_coupon_id
                        JOIN carriers c ON od.carrier_id = c.id
                        LEFT JOIN order_invoices oi2 ON oi2.order_id = o.id AND oi2."xml" != 'devolution'
                        
                        WHERE
                        op.payment_method_id NOT IN (52)
                        AND o.id > 2000000 
                        AND o.order_date BETWEEN ? AND ?
                        
                        GROUP BY
                                        o.order_date,
                                        oi.order_id,
                                        os."name",
                                        pm."name",
                                        cd.code,
                                        cs.code,
                                        oi2."number",
                                        oi2.series,
                                        o.total_amount,
                                        op.value::numeric,
                                        od.price,
                                        o.discount_amount::numeric,
                                        op.payment_method_id,
                                        op.value,
                                        c."name",
                                        od.tracking,
                                        oa.zip_code,
                                        oa.city,
                                        oa.state,
                                        oa.address,
                                        oa."number"
                        
                        HAVING
                        ROUND((SUM(oi.amount * oi.price) + od.price)::numeric,2) - ROUND(CASE
                            WHEN op.payment_method_id = 39 THEN total_amount
                            ELSE op.value
                        END::numeric,2) NOT BETWEEN -2 AND 2
                        ) ds
            `;

            return DB::connection('necomm')->select($query, [$date_start, $date_end]);
            
        } catch (Exception $e) {
            throw new Exception("Error retrieving divergences: " . $e->getMessage());
        }
    }}
