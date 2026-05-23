<?php

namespace App\Services;

use App\Models\CashWithdraw;
use App\Models\ClientPayment;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\VendorPayment;
use Carbon\Carbon;

/**
 * Business Purpose: دمج نقاط مسجَّلة مختلفة لتقرير «حَركة مالية ظاهرة» في فترة
 * بدون عدّ ضعف لدفعات العملاء مع التحصيل الميداني (لا نُضاعف عمود التسليم لأنه يخلق عموماً مدفوعاً في client_payments).
 */
final class UnifiedFinancialLedgerService
{
    /** @internal حد تنبيه لتوسيع الطلب الزمني */
    public const DEFAULT_MAX_RANGE_DAYS = 366;

    /**
     * @return array<string, mixed>
     */
    public function buildLedger(Carbon $fromInclusive, Carbon $toInclusive): array
    {
        $fromD = $fromInclusive->format('Y-m-d');
        $toD = $toInclusive->format('Y-m-d');

        $tsStart = $fromInclusive->copy()->startOfDay();
        $tsEnd = $toInclusive->copy()->endOfDay();

        /** @var list<array<string, mixed>> $rows */
        $rows = [];

        foreach ($this->loadClientPayments($fromD, $toD) as $row) {
            $rows[] = $row;
        }

        foreach ($this->loadVendorPayments($fromD, $toD) as $row) {
            $rows[] = $row;
        }

        foreach ($this->loadCashWithdrawals($tsStart, $tsEnd) as $row) {
            $rows[] = $row;
        }

        foreach ($this->loadConfirmedInvoices($fromD, $toD) as $row) {
            $rows[] = $row;
        }

        foreach ($this->loadExpenses($fromD, $toD) as $row) {
            $rows[] = $row;
        }

        usort($rows, static function (array $a, array $b): int {
            /** @phpstan-ignore-next-next-line */
            return (($b['sort_key'] ?? 0) <=> ($a['sort_key'] ?? 0));
        });

        /** @phpstan-ignore-next-next-line numeric values */
        $sumCashInClients = ClientPayment::query()
            ->whereBetween('payment_date', [$fromD, $toD])
            ->sum('amount');
        /** @phpstan-ignore-next-next-line */
        $sumCashOutVendors = VendorPayment::query()
            ->whereBetween('payment_date', [$fromD, $toD])
            ->sum('amount');
        /** @phpstan-ignore-next-next-line */
        $sumCashInFromWithdrawsToHq = CashWithdraw::query()
            ->whereBetween('created_at', [$tsStart, $tsEnd])
            ->sum('total_amount');

        /** @phpstan-ignore-next-next-line */
        $sumInvoiceConfirmed = Invoice::query()
            ->where('status', 'confirmed')
            ->whereBetween('invoice_date', [$fromD, $toD])
            ->sum('total_amount');

        /** @phpstan-ignore-next-next-line */
        $sumExpensesRecorded = Expense::query()
            ->whereBetween('payment_date', [$fromD, $toD])
            ->sum('total_amount');

        $netOperationalCashSuggested = ((float) $sumCashInClients + (float) $sumCashInFromWithdrawsToHq) - (float) $sumCashOutVendors;

        return [
            'period' => [
                'from' => $fromD,
                'to' => $toD,
            ],
            'summary' => [
                'cash_in_from_clients' => (float) $sumCashInClients,
                'cash_out_to_vendors' => (float) $sumCashOutVendors,
                'cash_in_from_distributors_withdraw_to_hq' => (float) $sumCashInFromWithdrawsToHq,
                'sales_on_invoices_confirmed' => (float) $sumInvoiceConfirmed,
                'expenses_recorded_dates' => (float) $sumExpensesRecorded,
                /** قد لا يساوي الخزينة الحقيقية — يعتمد سياساتك المحاسبية */
                'net_cash_formula_clients_plus_dist_minus_vendors' => (float) $netOperationalCashSuggested,
            ],
            'rows' => $rows,
        ];
    }

    /**
     * @return iterable<int, array<string, mixed>>
     */
    private function loadClientPayments(string $fromD, string $toD): iterable
    {
        foreach (ClientPayment::query()
                     ->with('client')
                     ->whereBetween('payment_date', [$fromD, $toD])
                     ->orderByDesc('payment_date')
                     ->get() as $p) {

            /** @phpstan-ignore-next-next-line Carbon */
            $d = $p->payment_date;
            /** @phpstan-ignore-next-next-line Carbon */
            $sort = $d instanceof \Carbon\CarbonInterface ? (float) $d->timestamp : (float) strtotime((string) $d);

            $clientName = $p->client?->name ?? '—';
            $futureTag = ($p->for_future_obligation ?? false) ? ' · لسداد التزام مستقبلي' : '';

            yield [
                'sort_key' => $sort + 0.1,
                /** @phpstan-ignore-next-next-line */
                'occurred_date' => $d->format('Y-m-d'),
                'gate_ar' => 'دفعات المشتركين',
                'detail' => $clientName . ($p->notes ? ' · ' . $p->notes : '') . $futureTag,
                /** @phpstan-ignore-next-next-line */
                'cash_in' => (float) $p->amount,
                'cash_out' => null,
                'non_cash_amount' => null,
                /** @phpstan-ignore-next-next-line */
                'ledger_ref_id' => (int) $p->id,
            ];
        }
    }

    /**
     * @return iterable<int, array<string, mixed>>
     */
    private function loadVendorPayments(string $fromD, string $toD): iterable
    {
        foreach (VendorPayment::query()
                     ->with(['vendor'])
                     ->whereBetween('payment_date', [$fromD, $toD])
                     ->orderByDesc('payment_date')
                     ->get() as $p) {
            /** @phpstan-ignore-next-next-line Carbon */
            $d = $p->payment_date;
            /** @phpstan-ignore-next-next-line Carbon */
            $sort = $d instanceof \Carbon\CarbonInterface ? (float) $d->timestamp : (float) strtotime((string) $d);
            yield [
                'sort_key' => $sort + 0.2,
                /** @phpstan-ignore-next-next-line */
                'occurred_date' => $d->format('Y-m-d'),
                'gate_ar' => 'مدفوعات الموردين',
                /** @phpstan-ignore-next-next-line */
                'detail' => ($p->vendor?->name ?? '—') . ($p->notes ? ' · ' . $p->notes : ''),
                'cash_in' => null,
                /** @phpstan-ignore-next-next-line */
                'cash_out' => (float) $p->amount,
                'non_cash_amount' => null,
                /** @phpstan-ignore-next-next-line */
                'ledger_ref_id' => (int) $p->id,
            ];
        }
    }

    /**
     * @return iterable<int, array<string, mixed>>
     */
    private function loadCashWithdrawals(Carbon $start, Carbon $end): iterable
    {
        foreach (CashWithdraw::query()
                     ->with('distributor')
                     ->whereBetween('created_at', [$start, $end])
                     ->orderByDesc('created_at')
                     ->get() as $w) {

            /** @phpstan-ignore-next-next-line Carbon|\DateTime|string */
            $at = $w->created_at;
            $sort = $at instanceof \Carbon\CarbonInterface ? $at->timestamp : strtotime((string) $at);

            yield [
                'sort_key' => (float) $sort,
                /** @phpstan-ignore-next-next-line */
                'occurred_date' => $at instanceof \Carbon\CarbonInterface ? $at->format('Y-m-d H:i') : (string) $at,
                'gate_ar' => 'سحوبات الموِّعين',
                'detail' => 'تسليم نقد لمقرّ الشركة من: ' . ($w->distributor?->name ?? '—'),
                /** @phpstan-ignore-next-next-line */
                'cash_in' => (float) $w->total_amount,
                'cash_out' => null,
                'non_cash_amount' => null,
                /** @phpstan-ignore-next-next-line */
                'ledger_ref_id' => (int) $w->id,
            ];
        }
    }

    /**
     * @return iterable<int, array<string, mixed>>
     */
    private function loadConfirmedInvoices(string $fromD, string $toD): iterable
    {
        foreach (Invoice::query()
                     ->with(['client'])
                     ->where('status', 'confirmed')
                     ->whereBetween('invoice_date', [$fromD, $toD])
                     ->orderByDesc('invoice_date')
                     ->get() as $inv) {
            /** @phpstan-ignore-next-next-line Carbon */
            $d = $inv->invoice_date;
            /** @phpstan-ignore-next-next-line Carbon */
            $sort = $d instanceof \Carbon\CarbonInterface ? (float) $d->timestamp : (float) strtotime((string) $d);

            yield [
                'sort_key' => $sort + 0.05,
                /** @phpstan-ignore-next-next-line */
                'occurred_date' => $d->format('Y-m-d'),
                'gate_ar' => 'فواتير مبيعات (مؤكدة)',
                'detail' => ($inv->invoice_number ?? '-') . ' · ' . ($inv->client?->name ?? ''),
                'cash_in' => null,
                'cash_out' => null,
                /** مبيع مستحق وفق تأكيد الفاتورة؛ قد لا تساوي نقداً واحداً بذات اليوم */
                /** @phpstan-ignore-next-next-line */
                'non_cash_amount' => (float) $inv->total_amount,
                /** @phpstan-ignore-next-next-line */
                'ledger_ref_id' => (int) $inv->id,
            ];
        }
    }

    /**
     * @return iterable<int, array<string, mixed>>
     */
    private function loadExpenses(string $fromD, string $toD): iterable
    {
        foreach (Expense::query()
                     ->with(['category', 'vendor'])
                     ->whereBetween('payment_date', [$fromD, $toD])
                     ->orderByDesc('payment_date')
                     ->get() as $e) {

            /** @phpstan-ignore-next-next-line Carbon */
            $d = $e->payment_date;
            /** @phpstan-ignore-next-next-line Carbon */
            $sort = $d instanceof \Carbon\CarbonInterface ? (float) $d->timestamp : (float) strtotime((string) $d);

            $cat = $e->category?->name ?? '—';

            yield [
                'sort_key' => $sort + 0.06,
                /** @phpstan-ignore-next-next-line */
                'occurred_date' => $d->format('Y-m-d'),
                'gate_ar' => 'المصروفات',
                'detail' => $cat . ' · ' . ($e->vendor?->name ?? '—'),
                'cash_in' => null,
                'cash_out' => null,
                /** المبلغ المسجل كمصروف في يوم هذا التاريخ — قد تتداخل مع مدفوع مورد */
                /** @phpstan-ignore-next-next-line */
                'non_cash_amount' => (float) $e->total_amount,
                /** @phpstan-ignore-next-next-line */
                'ledger_ref_id' => (int) $e->id,
            ];
        }
    }
}
