<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\CashWithdraw;
use App\Models\Client;
use App\Models\ClientPayment;
use App\Models\Distributor;
use App\Services\UnifiedFinancialLedgerService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnifiedFinancialLedgerExcludesWithdrawsTest extends TestCase
{
    use RefreshDatabase;

    public function test_ledger_excludes_distributor_withdrawals_from_rows_and_net(): void
    {
        $client = Client::create(['name' => 'Ledger Client']);
        $distributor = Distributor::create(['name' => 'Dist A', 'status' => 'active']);

        ClientPayment::create([
            'client_id' => $client->id,
            'amount' => '100.00',
            'payment_date' => '2026-06-15',
            'payment_method' => 'cash',
        ]);

        CashWithdraw::create([
            'distributor_id' => $distributor->id,
            'total_amount' => '70.00',
            'notes' => 'test',
            'created_at' => '2026-06-15 09:51:00',
            'updated_at' => '2026-06-15 09:51:00',
        ]);

        $ledger = app(UnifiedFinancialLedgerService::class)->buildLedger(
            Carbon::parse('2026-06-01'),
            Carbon::parse('2026-06-30'),
        );

        $gates = array_column($ledger['rows'], 'gate_ar');
        self::assertNotContains('سحوبات الموِّعين', $gates);
        self::assertEquals(100.0, round((float) $ledger['summary']['cash_in_from_clients'], 2));
        self::assertEquals(100.0, round((float) $ledger['summary']['net_cash_clients_minus_vendors'], 2));
        self::assertArrayNotHasKey('cash_in_from_distributors_withdraw_to_hq', $ledger['summary']);
    }
}
