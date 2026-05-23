<?php

namespace Tests\Feature;

use Tests\TestCase;

class UnifiedFinancialLedgerReportTest extends TestCase
{
    public function test_guest_redirected_from_unified_financial_ledger(): void
    {
        $this->get(route('reports.financial-movements-unified'))
            ->assertRedirect();
    }
}
