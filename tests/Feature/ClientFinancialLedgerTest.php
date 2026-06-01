<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ClientPayment;
use App\Models\Delivery;
use App\Models\InventoryItem;
use App\Services\ClientFinancialLedgerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientFinancialLedgerTest extends TestCase
{
    use RefreshDatabase;

    public function test_ledger_builds_running_balances_with_delivery_and_standalone_payment(): void
    {
        $item = InventoryItem::create(['item_name' => 'BottleL', 'quantity' => 100]);
        $client = Client::create([
            'name' => 'Ledger Client',
            'opening_balance_amount' => 100,
            'opening_balance_as_of' => '2026-01-01',
        ]);

        $deliveryPay = ClientPayment::create([
            'client_id' => $client->id,
            'amount' => '80.00',
            'payment_date' => '2026-02-01',
            'payment_method' => 'cash',
            'created_by' => null,
        ]);

        Delivery::create([
            'client_id' => $client->id,
            'delivery_date' => '2026-02-01',
            'bottle_received' => 5,
            'bottle_empty' => 0,
            'required_amount' => '150.00',
            'inventory_item_id' => $item->id,
            'paymant' => '80.00',
            'client_payment_id' => $deliveryPay->id,
            'distributor_id' => null,
        ]);

        ClientPayment::create([
            'client_id' => $client->id,
            'amount' => '50.00',
            'payment_date' => '2026-02-15',
            'payment_method' => 'cash',
            'created_by' => null,
        ]);

        $ledger = app(ClientFinancialLedgerService::class)->build($client->fresh());

        self::assertNotEmpty($ledger['rows']);
        $last = end($ledger['rows']);
        self::assertEquals(70.0, round((float) $last['delivery_outstanding_running'], 2));
        self::assertEquals(120.0, round((float) $last['combined_balance_running'], 2));
        self::assertEquals(120.0, round((float) $ledger['summary']['final_combined_debt'], 2));
        self::assertEquals(120.0, round((float) $client->fresh()->combined_subscriber_debt, 2));
    }
}
