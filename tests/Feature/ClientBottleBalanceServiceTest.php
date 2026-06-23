<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Delivery;
use App\Models\InventoryItem;
use App\Services\ClientBottleBalanceService;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientBottleBalanceServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesSeeder::class);
    }

    /**
     * Business Purpose: رصيد القوارير يجمع تسليمات الأب وجميع العناوين الفرعية.
     */
    public function test_family_snapshot_sums_parent_and_child_deliveries(): void
    {
        $item = InventoryItem::create(['item_name' => 'BottleFamily', 'quantity' => 100]);
        $parent = Client::create(['name' => 'أب العائلة', 'parent_id' => null]);
        $child = Client::create(['name' => 'عنوان فرعي', 'parent_id' => $parent->id]);

        $defaults = [
            'bottle_received' => 5,
            'bottle_empty' => 2,
            'required_amount' => '10.00',
            'paymant' => '10.00',
            'inventory_item_id' => $item->id,
            'distributor_id' => null,
            'delivery_date' => '2026-06-01',
        ];

        Delivery::create(array_merge($defaults, ['client_id' => $parent->id]));
        Delivery::create(array_merge($defaults, [
            'client_id' => $child->id,
            'bottle_received' => 3,
            'bottle_empty' => 1,
        ]));

        $service = app(ClientBottleBalanceService::class);
        $snapshots = $service->familySnapshotsForClients(collect([$parent, $child]));

        $this->assertSame(8, $snapshots[$parent->id]['total_bottle_received']);
        $this->assertSame(3, $snapshots[$parent->id]['total_bottle_empty']);
        $this->assertSame(5, $snapshots[$parent->id]['bottle_balance']);
        $this->assertSame($snapshots[$parent->id], $snapshots[$child->id]);

        $summary = $service->filteredFamilySummary([(int) $parent->id, (int) $child->id]);
        $this->assertSame(1, $summary['family_count']);
        $this->assertSame(5, $summary['bottle_balance']);
    }
}
