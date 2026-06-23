<?php

namespace App\Observers;

use App\Models\ExpenseBeneficiary;
use App\Services\ExpenseBeneficiaryVendorLinkService;

/**
 * Business Purpose: ربط أصحاب المصروف بالموردين عند الحفظ.
 */
class ExpenseBeneficiaryObserver
{
    public function __construct(
        private readonly ExpenseBeneficiaryVendorLinkService $vendorLinkService,
    ) {
    }

    /**
     * Business Purpose: بعد الحفظ، محاولة الربط التلقائي بمورد بنفس الاسم.
     */
    public function saved(ExpenseBeneficiary $beneficiary): void
    {
        $this->vendorLinkService->syncVendorLink($beneficiary);
    }
}
