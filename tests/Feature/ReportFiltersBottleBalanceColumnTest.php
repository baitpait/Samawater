<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Http\Controllers\Admin\ReportFilterController;
use App\Models\Client;
use App\Models\Delivery;
use App\Models\InventoryItem;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class ReportFiltersBottleBalanceColumnTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesSeeder::class);
    }

    /**
     * Business Purpose: عمود رصيد القوارير في الفلاتر يطابق معادلة كشف الحساب (ممتلئة − فارغة للعائلة).
     */
    public function test_filters_table_shows_family_bottle_balance_formula(): void
    {
        $item = InventoryItem::create(['item_name' => 'FilterBottle', 'quantity' => 100]);
        $client = Client::create(['name' => 'مشترك فلاتر القوارير']);

        Delivery::create([
            'client_id' => $client->id,
            'delivery_date' => now()->toDateString(),
            'bottle_received' => 21,
            'bottle_empty' => 18,
            'required_amount' => '0.00',
            'paymant' => '0.00',
            'inventory_item_id' => $item->id,
            'distributor_id' => null,
        ]);

        $controller = app(ReportFilterController::class);
        $view = $controller->index(Request::create('/admin/reports/filters', 'GET', [
            'subscription_status_id' => '',
            'q' => 'فلاتر القوارير',
        ]));

        $data = $view->getData();
        $snapshots = $data['bottleSnapshotsByClientId'];
        $this->assertArrayHasKey($client->id, $snapshots);
        $this->assertSame(21, $snapshots[$client->id]['total_bottle_received']);
        $this->assertSame(18, $snapshots[$client->id]['total_bottle_empty']);
        $this->assertSame(3, $snapshots[$client->id]['bottle_balance']);

        $html = view('admin.reports.filters', $data)->render();
        $this->assertStringContainsString('رصيد القوارير', $html);
        $this->assertStringContainsString('bottle-balance-value', $html);
        $this->assertStringNotContainsString('ممتلئة − فارغة (كل التسليمات)', $html);
        $this->assertStringNotContainsString('bottle-balance-formula', $html);
        $this->assertStringContainsString((string) $client->name, $html);
    }

    /**
     * Business Purpose: تصدير Excel يستخدم مجموع العائلة وليس عمود المخزون المخزّن فقط.
     */
    public function test_filters_excel_export_uses_family_bottle_formula(): void
    {
        $item = InventoryItem::create(['item_name' => 'ExcelBottle', 'quantity' => 50]);
        $client = Client::create(['name' => 'مشترك تصدير قوارير']);

        Delivery::create([
            'client_id' => $client->id,
            'delivery_date' => now()->toDateString(),
            'bottle_received' => 10,
            'bottle_empty' => 4,
            'required_amount' => '0.00',
            'paymant' => '0.00',
            'inventory_item_id' => $item->id,
            'distributor_id' => null,
        ]);

        $controller = app(ReportFilterController::class);
        $response = $controller->exportExcel(Request::create('/admin/reports/filters/export/excel', 'GET', [
            'q' => 'تصدير قوارير',
        ]));

        $csv = $response->getContent();
        $this->assertStringContainsString('رصيد القوارير', $csv);
        $this->assertStringContainsString('دين المشترك', $csv);
        $this->assertStringContainsString('حسب الطلب', $csv);
        $this->assertStringContainsString('ملاحظات العميل', $csv);
        $this->assertStringContainsString(',"6",', $csv);
        $this->assertStringNotContainsString('10 − 4 = 6', $csv);
    }

    /**
     * Business Purpose: PDF يجب أن يمر عبر استجابة Laravel كبيانات ثنائية وليس Output(I) الفارغ.
     */
    public function test_filters_pdf_export_returns_non_empty_pdf_binary(): void
    {
        Client::create(['name' => 'مشترك تصدير PDF']);

        $response = app(ReportFilterController::class)->exportPdf(
            Request::create('/admin/reports/filters/export/pdf', 'GET', [
                'q' => 'تصدير PDF',
            ])
        );

        $content = $response->getContent();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringStartsWith('%PDF', $content);
        $this->assertGreaterThan(1000, strlen($content));
        $this->assertStringContainsString('application/pdf', (string) $response->headers->get('Content-Type'));
    }

    /**
     * Business Purpose: على الإنتاج حد PHP-FPM 64MB؛ التصدير يرفع الذاكرة حتى لا ينهار mPDF.
     */
    public function test_filters_pdf_export_raises_memory_limit_when_too_low(): void
    {
        Client::create(['name' => 'مشترك ذاكرة PDF']);

        $previous = ini_get('memory_limit');
        ini_set('memory_limit', '64M');

        try {
            $response = app(ReportFilterController::class)->exportPdf(
                Request::create('/admin/reports/filters/export/pdf', 'GET', [
                    'q' => 'ذاكرة PDF',
                ])
            );

            $this->assertSame(200, $response->getStatusCode());
            $this->assertStringStartsWith('%PDF', $response->getContent());
            $this->assertGreaterThanOrEqual(
                256 * 1024 * 1024,
                $this->phpMemoryLimitToBytes((string) ini_get('memory_limit'))
            );
        } finally {
            ini_set('memory_limit', $previous !== false ? $previous : '256M');
        }
    }

    /**
     * Business Purpose: مساعدة اختبار لتحويل memory_limit إلى بايتات.
     */
    private function phpMemoryLimitToBytes(string $limit): int
    {
        if ($limit === '' || $limit === '-1') {
            return PHP_INT_MAX;
        }

        $unit = strtolower(substr($limit, -1));
        $value = (int) $limit;

        return match ($unit) {
            'g' => $value * 1024 * 1024 * 1024,
            'm' => $value * 1024 * 1024,
            'k' => $value * 1024,
            default => (int) $limit,
        };
    }
}
