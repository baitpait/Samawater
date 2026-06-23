<?php

namespace App\Services;

use App\Models\ExpenseBeneficiary;
use App\Models\Vendor;

/**
 * Business Purpose: ربط صاحب المصروف تلقائياً بمورد إذا تطابق الاسم.
 */
class ExpenseBeneficiaryVendorLinkService
{
    /**
     * Business Purpose: عند إنشاء/تعديل صاحب مصروف، ربطه بمورد بنفس الاسم إن وُجد.
     */
    public function syncVendorLink(ExpenseBeneficiary $beneficiary): void
    {
        $name = trim((string) $beneficiary->name);
        if ($name === '') {
            return;
        }

        $vendor = Vendor::query()
            ->where('name', $name)
            ->orderBy('id')
            ->first();

        if ($vendor === null) {
            return;
        }

        if ((int) $beneficiary->vendor_id === (int) $vendor->id) {
            return;
        }

        $beneficiary->vendor_id = (int) $vendor->id;
        $beneficiary->saveQuietly();
    }
}
