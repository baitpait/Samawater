<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ClientDeposit;
use App\Models\ClientDepositItem;
use App\Models\InventoryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryItemActiveDepositTotalsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Business Purpose: عمود المخزون يجب أن يجمع الأمانات النشطة فقط حسب اسم الصنف.
     */
    public function test_active_deposit_totals_exclude_withdrawn_deposits(): void
    {
        $client = Client::create(['name' => 'عميل أمانات']);

        $stand = InventoryItem::create(['item_name' => 'ستاند', 'quantity' => 50]);
        InventoryItem::create(['item_name' => 'كولر لف', 'quantity' => 10]);

        $activeDeposit = ClientDeposit::create([
            'client_id' => $client->id,
            'date_given' => '2026-06-01',
            'is_withdrawn' => false,
        ]);
        ClientDepositItem::create([
            'client_deposit_id' => $activeDeposit->id,
            'item_name' => 'ستاند',
            'quantity' => 7,
        ]);
        ClientDepositItem::create([
            'client_deposit_id' => $activeDeposit->id,
            'item_name' => 'كولر لف',
            'quantity' => 3,
        ]);

        $withdrawnDeposit = ClientDeposit::create([
            'client_id' => $client->id,
            'date_given' => '2026-06-02',
            'is_withdrawn' => true,
            'withdrawn_at' => now(),
        ]);
        ClientDepositItem::create([
            'client_deposit_id' => $withdrawnDeposit->id,
            'item_name' => 'ستاند',
            'quantity' => 100,
        ]);

        $totals = InventoryItem::activeDepositTotalsByItemName();

        $this->assertSame(7, $totals['ستاند']);
        $this->assertSame(3, $totals['كولر لف']);
        $this->assertSame(7, $stand->fresh()->activeDepositQuantityOnClients());
        $this->assertSame(57, (int) $stand->quantity + ($totals['ستاند'] ?? 0));
    }
}
