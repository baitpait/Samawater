<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Delivery;
use App\Models\InventoryItem;
use App\Services\ClientDeliveryReportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class ClientDeliveryReportServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Business Purpose: التأكد أن فلترة يونيو 2026 تعرض تسليمات العائلة بينما 2025 تُرجع صفراً مع بيانات وصفية صحيحة.
     */
    public function test_family_deliveries_filter_by_year_and_normalize_reversed_dates(): void
    {
        $item = InventoryItem::create(['item_name' => 'BottleReport', 'quantity' => 100]);
        $parent = Client::create(['name' => 'فادي الصبار', 'parent_id' => null]);
        $child = Client::create(['name' => 'عنوان فرعي', 'parent_id' => $parent->id]);

        $deliveryDefaults = [
            'bottle_received' => 1,
            'bottle_empty' => 0,
            'required_amount' => '10.00',
            'paymant' => '10.00',
            'inventory_item_id' => $item->id,
            'distributor_id' => null,
        ];

        Delivery::create(array_merge($deliveryDefaults, [
            'client_id' => $parent->id,
            'delivery_date' => '2026-06-01',
        ]));
        Delivery::create(array_merge($deliveryDefaults, [
            'client_id' => $child->id,
            'delivery_date' => '2026-06-15',
        ]));
        Delivery::create(array_merge($deliveryDefaults, [
            'client_id' => $parent->id,
            'delivery_date' => '2025-01-10',
        ]));

        $service = app(ClientDeliveryReportService::class);

        $june2026 = $service->load(Request::create('/', 'GET', [
            'from' => '2026-06-01',
            'to' => '2026-06-30',
        ]), $parent->id);

        self::assertSame(2, $june2026['filterMeta']['filtered_count']);
        self::assertSame(3, $june2026['filterMeta']['total_count']);
        self::assertCount(2, $june2026['client']->deliveries);

        $june2025 = $service->load(Request::create('/', 'GET', [
            'from' => '2025-06-01',
            'to' => '2025-06-30',
        ]), $parent->id);

        self::assertSame(0, $june2025['filterMeta']['filtered_count']);
        self::assertSame(3, $june2025['filterMeta']['total_count']);

        $reversed = $service->load(Request::create('/', 'GET', [
            'from' => '2026-06-30',
            'to' => '2026-06-01',
        ]), $parent->id);

        self::assertSame(2, $reversed['filterMeta']['filtered_count']);
        self::assertSame('2026-06-01', $reversed['filterMeta']['from']);
        self::assertSame('2026-06-30', $reversed['filterMeta']['to']);
    }
}
