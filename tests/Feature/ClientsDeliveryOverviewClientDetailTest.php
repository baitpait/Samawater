<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Http\Controllers\Admin\ClientsDeliveryOverviewController;
use App\Models\Client;
use App\Models\Delivery;
use App\Models\InventoryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use ReflectionMethod;
use Tests\TestCase;

class ClientsDeliveryOverviewClientDetailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Business Purpose: عند اختيار مشترك محدد يجب عرض كل تسليماته وليس آخر تسليم فقط.
     */
    public function test_client_filter_builds_one_row_per_delivery(): void
    {
        $item = InventoryItem::create(['item_name' => 'BottleOverview', 'quantity' => 100]);
        $client = Client::create(['name' => 'فادي الصبار', 'parent_id' => null]);

        $defaults = [
            'client_id' => $client->id,
            'bottle_received' => 1,
            'bottle_empty' => 0,
            'required_amount' => '10.00',
            'paymant' => '10.00',
            'inventory_item_id' => $item->id,
            'distributor_id' => null,
        ];

        foreach (['2026-06-01', '2026-06-05', '2026-06-10', '2026-06-15'] as $date) {
            Delivery::create(array_merge($defaults, ['delivery_date' => $date]));
        }

        $controller = new ClientsDeliveryOverviewController();
        $method = new ReflectionMethod($controller, 'resolveReportRows');
        $method->setAccessible(true);

        $rows = $method->invoke($controller, Request::create('/', 'GET', [
            'search' => '1',
            'client_id' => $client->id,
        ]));

        $this->assertCount(4, $rows);
        $this->assertSame(
            ['2026-06-15', '2026-06-10', '2026-06-05', '2026-06-01'],
            $rows->map(static fn ($row): string => \Carbon\Carbon::parse($row->last_delivery_date_actual)->format('Y-m-d'))->all()
        );
    }
}
