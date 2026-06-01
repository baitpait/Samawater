<?php

declare(strict_types=1);

/**
 * Business Purpose: مفاتيح تفعيل/إيقاف الميزات الحساسة في الإنتاج (Kill Switch).
 */
return [

    'purchase_invoices' => env('FEATURE_PURCHASE_INVOICES', true),

];
