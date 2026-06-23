<?php

declare(strict_types=1);

/**
 * Business Purpose: إعدادات تشغيلية لنظام مياه سما (عتبات التنبيه وغيرها).
 */
return [

    /**
     * Business Purpose: تنبيه المخزون عندما تقل كمية الصنف في المستودع عن هذا الحد.
     */
    'inventory_low_stock_threshold' => (int) env('INVENTORY_LOW_STOCK_THRESHOLD', 50),

];
