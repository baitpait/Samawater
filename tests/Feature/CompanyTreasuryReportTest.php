<?php

namespace Tests\Feature;

use Tests\TestCase;

class CompanyTreasuryReportTest extends TestCase
{
    public function test_guest_redirected_from_company_treasury_report(): void
    {
        $this->get(route('reports.company-treasury'))
            ->assertRedirect();
    }
}
