<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Business Purpose: إضافة عمود عبوات آخر تسليم إلى القراءات المجمّعة لمشروع قائمة التسليم والعميل المستحق.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_clients_due_by_type_days_ids');

        DB::statement(<<<'SQL'
CREATE SQL SECURITY INVOKER VIEW v_clients_due_by_type_days_ids AS
WITH bals AS (
    SELECT d.client_id,
           SUM(d.bottle_received) AS total_bottle_received,
           SUM(d.bottle_empty) AS total_bottle_empty,
           SUM(d.bottle_received - d.bottle_empty) AS net_bottles_delta
    FROM deliveries d
    GROUP BY d.client_id
),
month_deliveries AS (
    SELECT d.client_id,
           COUNT(0) AS deliveries_this_month
    FROM deliveries d
    WHERE d.delivery_date >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
      AND d.delivery_date < DATE_FORMAT(CURDATE() + INTERVAL 1 MONTH, '%Y-%m-01')
    GROUP BY d.client_id
),
status_map AS (
    SELECT c.id AS client_id,
           ROUND(CASE
                     WHEN st.distribution_days > 0
                         THEN 100.0 * COALESCE(md.deliveries_this_month, 0) / st.distribution_days
                     ELSE 0
                 END, 2) AS percentage_delivery_rate
    FROM clients c
    LEFT JOIN subscription_types st ON st.id = c.subscription_type_id
    LEFT JOIN month_deliveries md ON md.client_id = c.id
)
SELECT
    c.id AS client_id,
    c.contract_no AS contract_no,
    c.name AS client_name,
    c.phone_one AS phone_one,
    c.phone_two AS phone_two,
    c.city_id AS city_id,
    c.subscription_status_id AS subscription_status_id,
    ss.status_name AS subscription_status_name,
    st.type_name AS subscription_type_name,
    st.distribution_days AS distribution_days,
    c.subscription_start_date AS subscription_start_date,
    PERIOD_DIFF(DATE_FORMAT(CURDATE(), '%Y%m'), DATE_FORMAT(c.subscription_start_date, '%Y%m')) AS subscription_months,
    MAX(d.delivery_date) AS last_delivery_date,
    (SELECT ld.bottle_received
     FROM deliveries ld
     WHERE ld.client_id = c.id
     ORDER BY ld.delivery_date DESC, ld.id DESC
     LIMIT 1) AS last_delivery_bottle_received,
    COUNT(d.id) AS total_deliveries,
    TO_DAYS(CURDATE()) - TO_DAYS(MAX(d.delivery_date)) AS days_since_last_delivery,
    c.latitude AS latitude,
    c.longitude AS longitude,
    c.address AS address,
    c.notes AS notes,
    COALESCE(c.bottle_balance, 0) AS bottle_balance_stored,
    COALESCE(b.total_bottle_received, 0) AS total_bottle_received,
    COALESCE(b.total_bottle_empty, 0) AS total_bottle_empty,
    COALESCE(c.bottle_balance, 0) + COALESCE(b.net_bottles_delta, 0) AS bottle_on_hand_calculated,
    sm.percentage_delivery_rate AS percentage_delivery_rate,
    cs.status_name AS client_status_name,
    c.image AS client_image
FROM clients c
JOIN deliveries d ON d.client_id = c.id
LEFT JOIN bals b ON b.client_id = c.id
LEFT JOIN status_map sm ON sm.client_id = c.id
LEFT JOIN subscription_types st ON st.id = c.subscription_type_id
LEFT JOIN subscription_statuses ss ON ss.id = c.subscription_status_id
LEFT JOIN client_statuses cs ON sm.percentage_delivery_rate BETWEEN cs.min_percentage AND cs.max_percentage
WHERE c.subscription_status_id = 1
GROUP BY
    c.id, c.contract_no, c.name, c.phone_one, c.phone_two, c.city_id, c.subscription_status_id,
    ss.status_name, st.type_name, st.distribution_days, c.subscription_start_date,
    c.latitude, c.longitude, c.address, c.notes, c.bottle_balance,
    b.total_bottle_received, b.total_bottle_empty, b.net_bottles_delta,
    sm.percentage_delivery_rate, cs.status_name, c.image
HAVING days_since_last_delivery >= st.distribution_days
SQL);
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_clients_due_by_type_days_ids');

        DB::statement(<<<'SQL'
CREATE SQL SECURITY INVOKER VIEW v_clients_due_by_type_days_ids AS
WITH bals AS (
    SELECT d.client_id,
           SUM(d.bottle_received) AS total_bottle_received,
           SUM(d.bottle_empty) AS total_bottle_empty,
           SUM(d.bottle_received - d.bottle_empty) AS net_bottles_delta
    FROM deliveries d
    GROUP BY d.client_id
),
month_deliveries AS (
    SELECT d.client_id,
           COUNT(0) AS deliveries_this_month
    FROM deliveries d
    WHERE d.delivery_date >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
      AND d.delivery_date < DATE_FORMAT(CURDATE() + INTERVAL 1 MONTH, '%Y-%m-01')
    GROUP BY d.client_id
),
status_map AS (
    SELECT c.id AS client_id,
           ROUND(CASE
                     WHEN st.distribution_days > 0
                         THEN 100.0 * COALESCE(md.deliveries_this_month, 0) / st.distribution_days
                     ELSE 0
                 END, 2) AS percentage_delivery_rate
    FROM clients c
    LEFT JOIN subscription_types st ON st.id = c.subscription_type_id
    LEFT JOIN month_deliveries md ON md.client_id = c.id
)
SELECT
    c.id AS client_id,
    c.contract_no AS contract_no,
    c.name AS client_name,
    c.phone_one AS phone_one,
    c.phone_two AS phone_two,
    c.city_id AS city_id,
    c.subscription_status_id AS subscription_status_id,
    ss.status_name AS subscription_status_name,
    st.type_name AS subscription_type_name,
    st.distribution_days AS distribution_days,
    c.subscription_start_date AS subscription_start_date,
    PERIOD_DIFF(DATE_FORMAT(CURDATE(), '%Y%m'), DATE_FORMAT(c.subscription_start_date, '%Y%m')) AS subscription_months,
    MAX(d.delivery_date) AS last_delivery_date,
    COUNT(d.id) AS total_deliveries,
    TO_DAYS(CURDATE()) - TO_DAYS(MAX(d.delivery_date)) AS days_since_last_delivery,
    c.latitude AS latitude,
    c.longitude AS longitude,
    c.address AS address,
    c.notes AS notes,
    COALESCE(c.bottle_balance, 0) AS bottle_balance_stored,
    COALESCE(b.total_bottle_received, 0) AS total_bottle_received,
    COALESCE(b.total_bottle_empty, 0) AS total_bottle_empty,
    COALESCE(c.bottle_balance, 0) + COALESCE(b.net_bottles_delta, 0) AS bottle_on_hand_calculated,
    sm.percentage_delivery_rate AS percentage_delivery_rate,
    cs.status_name AS client_status_name,
    c.image AS client_image
FROM clients c
JOIN deliveries d ON d.client_id = c.id
LEFT JOIN bals b ON b.client_id = c.id
LEFT JOIN status_map sm ON sm.client_id = c.id
LEFT JOIN subscription_types st ON st.id = c.subscription_type_id
LEFT JOIN subscription_statuses ss ON ss.id = c.subscription_status_id
LEFT JOIN client_statuses cs ON sm.percentage_delivery_rate BETWEEN cs.min_percentage AND cs.max_percentage
WHERE c.subscription_status_id = 1
GROUP BY
    c.id, c.contract_no, c.name, c.phone_one, c.phone_two, c.city_id, c.subscription_status_id,
    ss.status_name, st.type_name, st.distribution_days, c.subscription_start_date,
    c.latitude, c.longitude, c.address, c.notes, c.bottle_balance,
    b.total_bottle_received, b.total_bottle_empty, b.net_bottles_delta,
    sm.percentage_delivery_rate, cs.status_name, c.image
HAVING days_since_last_delivery >= st.distribution_days
SQL);
    }
};
