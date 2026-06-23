<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ClientPayment;
use App\Models\Delivery;
use App\Models\InventoryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientPaymentDeleteSyncsDeliveryTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleting_delivery_backed_payment_zeros_delivery_paymant(): void
    {
        $item = InventoryItem::create(['item_name' => 'BottlePayDel', 'quantity' => 100]);
        $client = Client::create(['name' => 'Pay Delete Client']);

        $payment = ClientPayment::create([
            'client_id' => $client->id,
            'amount' => '110.00',
            'payment_date' => '2026-06-30',
            'payment_method' => 'cash',
            'notes' => 'دفعة من تسليم #796',
        ]);

        $delivery = Delivery::create([
            'client_id' => $client->id,
            'delivery_date' => '2026-06-30',
            'bottle_received' => 5,
            'bottle_empty' => 0,
            'required_amount' => '100.00',
            'inventory_item_id' => $item->id,
            'paymant' => '110.00',
            'client_payment_id' => $payment->id,
            'distributor_id' => null,
        ]);

        $payment->delete();

        $this->assertDatabaseMissing('client_payments', ['id' => $payment->id]);
        $delivery->refresh();
        self::assertEquals('0.00', (string) $delivery->paymant);
        self::assertNull($delivery->client_payment_id);
    }

    public function test_deleting_standalone_payment_does_not_touch_unrelated_delivery(): void
    {
        $item = InventoryItem::create(['item_name' => 'BottleStandalone', 'quantity' => 100]);
        $client = Client::create(['name' => 'Standalone Pay Client']);

        $otherPayment = ClientPayment::create([
            'client_id' => $client->id,
            'amount' => '50.00',
            'payment_date' => '2026-06-30',
            'payment_method' => 'cash',
            'notes' => 'دفعة من تسليم #1',
        ]);

        Delivery::create([
            'client_id' => $client->id,
            'delivery_date' => '2026-06-30',
            'bottle_received' => 2,
            'bottle_empty' => 0,
            'required_amount' => '50.00',
            'inventory_item_id' => $item->id,
            'paymant' => '50.00',
            'client_payment_id' => $otherPayment->id,
            'distributor_id' => null,
        ]);

        $standalone = ClientPayment::create([
            'client_id' => $client->id,
            'amount' => '25.00',
            'payment_date' => '2026-06-30',
            'payment_method' => 'cash',
            'notes' => 'دفعة يدوية مستقلة',
        ]);

        $standalone->delete();

        $otherPayment->refresh();
        $delivery = Delivery::query()->where('client_payment_id', $otherPayment->id)->first();
        self::assertNotNull($delivery);
        self::assertEquals('50.00', (string) $delivery->paymant);
    }
}
