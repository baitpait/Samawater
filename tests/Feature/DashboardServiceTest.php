<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ClientPayment;
use App\Models\Delivery;
use App\Models\InventoryItem;
use App\Services\DashboardService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Business Purpose: تسليمات اليوم تُحسب بتاريخ التسليم وليس created_at.
     */
    public function test_hero_deliveries_today_uses_delivery_date(): void
    {
        $client = Client::create(['name' => 'عميل لوحة']);
        $item = InventoryItem::create(['item_name' => 'DashBottle', 'quantity' => 100]);

        Delivery::create([
            'client_id' => $client->id,
            'delivery_date' => Carbon::today()->format('Y-m-d'),
            'bottle_received' => 2,
            'bottle_empty' => 1,
            'required_amount' => '10.00',
            'paymant' => '10.00',
            'inventory_item_id' => $item->id,
        ]);

        Delivery::create([
            'client_id' => $client->id,
            'delivery_date' => Carbon::yesterday()->format('Y-m-d'),
            'bottle_received' => 5,
            'bottle_empty' => 0,
            'required_amount' => '10.00',
            'paymant' => '10.00',
            'inventory_item_id' => $item->id,
        ]);

        $dashboard = app(DashboardService::class)->buildForOwner();

        $this->assertSame(1, (int) ($dashboard['hero']['deliveries_today'] ?? 0));
    }

    /**
     * Business Purpose: الكاش اليوم = مجموع مدفوعات المشتركين في نفس اليوم.
     */
    public function test_hero_cash_today_sums_client_payments(): void
    {
        $client = Client::create(['name' => 'دافع']);

        ClientPayment::create([
            'client_id' => $client->id,
            'amount' => '150.50',
            'payment_date' => Carbon::today()->format('Y-m-d'),
            'payment_method' => 'cash',
        ]);

        ClientPayment::create([
            'client_id' => $client->id,
            'amount' => '50.00',
            'payment_date' => Carbon::yesterday()->format('Y-m-d'),
            'payment_method' => 'cash',
        ]);

        $dashboard = app(DashboardService::class)->buildForOwner();

        $this->assertSame(150.5, (float) ($dashboard['hero']['cash_today'] ?? 0));
    }
}
