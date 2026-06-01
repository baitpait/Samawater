<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: إعادة إنشاء view التسليمات بعد استيراد SQL قديم يحذف الـ views بينما migrations مسجّلة كمنفّذة.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('v_clients_delivery_overview')) {
            return;
        }

        DB::statement('DROP VIEW IF EXISTS v_clients_delivery_overview');
        DB::statement(<<<'SQL'
CREATE SQL SECURITY INVOKER VIEW v_clients_delivery_overview AS
WITH bals AS (
    SELECT d.client_id,
           SUM(d.bottle_received) AS total_bottle_received,
           SUM(d.bottle_empty) AS total_bottle_empty,
           SUM(d.bottle_received - d.bottle_empty) AS net_bottles_delta
    FROM deliveries d
    GROUP BY d.client_id
),
status_map AS (
    SELECT c.id AS client_id,
           0 AS percentage_delivery_rate
    FROM clients c
),
last_delivery AS (
    SELECT d1.client_id,
           d1.distributor_id,
           d1.paymant
    FROM deliveries d1
    JOIN (
        SELECT deliveries.client_id AS client_id,
               MAX(deliveries.delivery_date) AS max_date
        FROM deliveries
        GROUP BY deliveries.client_id
    ) d2 ON d1.client_id = d2.client_id AND d1.delivery_date = d2.max_date
)
SELECT
    c.id AS client_id,
    c.contract_no AS contract_no,
    c.name AS client_name,
    c.phone_one AS phone_one,
    c.phone_two AS phone_two,
    c.city_id AS city_id,
    c.latitude AS latitude,
    c.longitude AS longitude,
    c.address AS address,
    c.subscription_status_id AS subscription_status_id,
    ss.status_name AS subscription_status_name,
    st.type_name AS subscription_type_name,
    st.distribution_days AS distribution_days,
    c.subscription_start_date AS subscription_start_date,
    PERIOD_DIFF(DATE_FORMAT(CURDATE(), '%Y%m'), DATE_FORMAT(c.subscription_start_date, '%Y%m')) AS subscription_months,
    MAX(d.delivery_date) AS last_delivery_date,
    COUNT(d.id) AS total_deliveries,
    TO_DAYS(CURDATE()) - TO_DAYS(MAX(d.delivery_date)) AS days_since_last_delivery,
    COALESCE(c.bottle_balance, 0) AS bottle_balance_stored,
    COALESCE(b.total_bottle_received, 0) AS total_bottle_received,
    COALESCE(b.total_bottle_empty, 0) AS total_bottle_empty,
    COALESCE(c.bottle_balance, 0) + COALESCE(b.net_bottles_delta, 0) AS bottle_on_hand_calculated,
    sm.percentage_delivery_rate AS percentage_delivery_rate,
    cs.status_name AS client_status_name,
    MAX(d.id) AS last_delivery_id,
    ld.paymant AS paymant,
    ld.distributor_id AS distributor_id,
    dist.name AS distributor_name
FROM clients c
LEFT JOIN deliveries d ON d.client_id = c.id
LEFT JOIN bals b ON b.client_id = c.id
LEFT JOIN status_map sm ON sm.client_id = c.id
LEFT JOIN subscription_types st ON st.id = c.subscription_type_id
LEFT JOIN subscription_statuses ss ON ss.id = c.subscription_status_id
LEFT JOIN client_statuses cs ON sm.percentage_delivery_rate BETWEEN cs.min_percentage AND cs.max_percentage
LEFT JOIN last_delivery ld ON ld.client_id = c.id
LEFT JOIN distributors dist ON dist.id = ld.distributor_id
GROUP BY
    c.id, c.contract_no, c.name, c.address, c.phone_one, c.phone_two, c.city_id,
    c.latitude, c.longitude, c.subscription_status_id, ss.status_name, st.type_name,
    st.distribution_days, c.subscription_start_date, c.bottle_balance,
    b.total_bottle_received, b.total_bottle_empty, b.net_bottles_delta,
    sm.percentage_delivery_rate, cs.status_name, ld.distributor_id, ld.paymant, dist.name
SQL);
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_clients_delivery_overview');
    }
};
