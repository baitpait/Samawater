<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * التحقق من الوصول لتقرير الصندوق والعهدة ضمن مجموعة مسارات الإدارة.
 */
class TreasuryCustodyReportTest extends TestCase
{
    /** رئيسي: الزوار غير الموثَّقين يُعاد توجيههم لتسجيل الدخول. */
    public function test_guest_redirected_from_treasury_custody_report(): void
    {
        $response = $this->get(route('reports.treasury-custody'));

        $response->assertRedirect();
    }
}
