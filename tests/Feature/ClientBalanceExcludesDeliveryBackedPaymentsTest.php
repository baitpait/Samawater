<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ClientPayment;
use App\Models\Delivery;
use App\Models\InventoryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * مدفوعات التسليم لا تُطرح ضد الرصيد المحاسبي بحسب الفاتورة عندما لا توجد فواتير.
 */
class ClientBalanceExcludesDeliveryBackedPaymentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function balance_stays_zero_when_only_delivery_linked_payments_exist(): void
    {
        $item = InventoryItem::create(['item_name' => 'TestBottle', 'quantity' => 1000]);
        $client = Client::create(['name' => 'Test Parent Client']);

        $payment = ClientPayment::create([
            'client_id' => $client->id,
            'amount' => '500.00',
            'payment_date' => now()->toDateString(),
            'payment_method' => 'cash',
            'notes' => 'delivery test',
            'created_by' => null,
        ]);

        Delivery::create([
            'client_id' => $client->id,
            'delivery_date' => now()->toDateString(),
            'bottle_received' => 10,
            'bottle_empty' => 0,
            'required_amount' => '500.00',
            'inventory_item_id' => $item->id,
            'paymant' => '500.00',
            'client_payment_id' => $payment->id,
            'distributor_id' => null,
        ]);

        $client->refresh();

        self::assertEquals(500.00, round((float) $client->total_paid_amount, 2));
        self::assertEquals(0.0, round((float) $client->balance, 2));
        self::assertEquals(0.0, round((float) $client->combined_subscriber_debt, 2));
    }

    /** @test */
    public function standalone_payment_reduces_balance_without_invoices_or_opening(): void
    {
        $client = Client::create(['name' => 'Standalone Pay']);

        ClientPayment::create([
            'client_id' => $client->id,
            'amount' => '200.00',
            'payment_date' => now()->toDateString(),
            'payment_method' => 'cash',
            'notes' => 'cash at office',
            'created_by' => null,
        ]);

        $client->refresh();

        self::assertEquals(-200.0, round((float) $client->balance, 2));
    }

    /** @test */
    public function financial_snapshot_splits_delivery_and_standalone_totals(): void
    {
        $item = InventoryItem::create(['item_name' => 'Bottle2', 'quantity' => 500]);
        $client = Client::create(['name' => 'Mixed']);

        ClientPayment::create([
            'client_id' => $client->id,
            'amount' => '300.00',
            'payment_date' => now()->toDateString(),
            'payment_method' => 'cash',
            'created_by' => null,
        ]);

        $deliveryPay = ClientPayment::create([
            'client_id' => $client->id,
            'amount' => '150.00',
            'payment_date' => now()->toDateString(),
            'payment_method' => 'cash',
            'created_by' => null,
        ]);

        Delivery::create([
            'client_id' => $client->id,
            'delivery_date' => now()->toDateString(),
            'bottle_received' => 5,
            'bottle_empty' => 0,
            'required_amount' => '150.00',
            'inventory_item_id' => $item->id,
            'paymant' => '150.00',
            'client_payment_id' => $deliveryPay->id,
            'distributor_id' => null,
        ]);

        $f = $client->fresh()->financialSnapshotForShow();

        self::assertEquals(450.0, round((float) $f['payments_total'], 2));
        self::assertEquals(150.0, round((float) $f['payments_from_deliveries'], 2));
        self::assertEquals(300.0, round((float) $f['payments_standalone'], 2));
        self::assertEquals(-300.0, round((float) $f['balance_per_invoices'], 2));
    }
}
