<?php

namespace App\Services;

use App\Models\CashWithdraw;
use App\Models\Delivery;
use App\Models\Distributor;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Business Purpose: تجميع مالي لفصل العهدة (النقد مع الموزّع عن التحصيل) عن صندوق المقر المركزي
 * (المبلغ الذي دخل حقيقةً عبر سجل السحب لحظة تسليم الموِّزع للشركة ضمن الفترة).
 *
 * يُرجِع أيضاً:
 * - مجاميع تاريخية تراكمية (كل التحصيل / كل السحوبات).
 * - تقسيم شهر داخل الفترة المختارة مع تراكم تشغيلي من بداية الفترة حتى نهاية كل جزء.
 *
 * المعاملات المرجعية:
 * - تحصيل ميداني: مجموع deliveries.paymant بحدود delivery_date ومُوزِّع محدَّد (>0).
 * - دخول صندوق المقر: مجموع cash_withdraws.total_amount بحدود created_at ضمن الفترة أو الجزء.
 */
final class TreasuryCustodyAggregationService
{
    public function summarize(Carbon $fromInclusive, Carbon $toInclusive): array
    {
        $rangeStart = $fromInclusive->copy()->startOfDay();
        $rangeEnd = $toInclusive->copy()->endOfDay();

        /** @var Collection<int, float> */
        $collectionsInPeriodByDistributor = $this->sumDeliveriesPaymantByDistributorBetween(
            $fromInclusive->toDateString(),
            $toInclusive->toDateString()
        );

        /** @var Collection<int, float> */
        $withdrawsInPeriodByDistributor = $this->sumWithdrawsByDistributorBetween($rangeStart, $rangeEnd);

        $custodyNowByDistributor = $this->custodyOutstandingByDistributor();

        $lifetimeFieldCollectionsTotal = $this->sumLifetimeFieldCollections();
        $lifetimeTreasuryWithdrawalsTotal = $this->sumLifetimeTreasuryWithdrawals();

        $periodTotalCollections = (float) $collectionsInPeriodByDistributor->sum();
        $periodTotalTreasuryIn = (float) $withdrawsInPeriodByDistributor->sum();
        $custodyOutstandingTotalNow = (float) $custodyNowByDistributor->sum();

        $distributors = Distributor::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        $rows = $distributors->map(function (Distributor $d) use (
            $collectionsInPeriodByDistributor,
            $withdrawsInPeriodByDistributor,
            $custodyNowByDistributor
        ): array {
            $id = (int) $d->id;

            return [
                'distributor_id' => $id,
                'name' => $d->name,
                'custody_now' => (float) ($custodyNowByDistributor[$id] ?? 0),
                'period_collections' => (float) ($collectionsInPeriodByDistributor[$id] ?? 0),
                'period_withdrawals_to_hq' => (float) ($withdrawsInPeriodByDistributor[$id] ?? 0),
                'period_net_delivery_vs_withdrawal' =>
                    (float) (($collectionsInPeriodByDistributor[$id] ?? 0) - ($withdrawsInPeriodByDistributor[$id] ?? 0)),
            ];
        })->filter(function (array $row): bool {
            return ($row['custody_now'] > 0.0001)
                || ($row['period_collections'] > 0.0001)
                || ($row['period_withdrawals_to_hq'] > 0.0001);

        })->values();

        $periodSlices = $this->buildMonthlyMovementSlicesRunningWithinRange(
            $fromInclusive->copy()->startOfDay(),
            $toInclusive->copy()->endOfDay()
        );

        return [
            'period' => [
                'from_date' => $fromInclusive->toDateString(),
                'to_date' => $toInclusive->toDateString(),
            ],
            'totals' => [
                'custody_with_distributors_now' => $custodyOutstandingTotalNow,
                'period_field_collections_total' => $periodTotalCollections,
                'period_treasury_in_from_withdrawals_total' => $periodTotalTreasuryIn,
            ],
            /** مجاميع تاريخية (منذ بدء النظام) — للقيم التراكمية المرجعية */
            'lifetime' => [
                'total_field_collections' => $lifetimeFieldCollectionsTotal,
                'total_treasury_withdrawals_registered' => $lifetimeTreasuryWithdrawalsTotal,
            ],
            /** حركة شهرية داخل الفترة + تراكمي من بداية الفترة كلّها */
            'period_slices' => $periodSlices,
            'rows' => $rows,
        ];
    }

    /** تحصيل ميداني شامل (عهدة بحوزة الموزَّع كمنبع قبل السحوبات). */
    private function sumLifetimeFieldCollections(): float
    {
        return (float) Delivery::query()
            ->whereNotNull('distributor_id')
            ->where('distributor_id', '>', 0)
            ->sum('paymant');
    }

    /** إجمالي ما سُجِّل صعوداً إلى صندوق الشركة من السحوبات (كل الزمن). */
    private function sumLifetimeTreasuryWithdrawals(): float
    {
        return (float) CashWithdraw::query()->sum('total_amount');
    }

    /**
     * Business Purpose: تقسيم الفترة المختارة إلى أشهر جزئية يتقاطع كل منها مع [from,to]،
     * مع مجموع كل شهر ومجاميع تراكمية داخل الفترة فقط من أول يوم منتقى إلى نهاية الشهر المعروض.
     *
     * @return array<int, array<string, float|string>>
     */
    private function buildMonthlyMovementSlicesRunningWithinRange(Carbon $fromDay, Carbon $toDayEnd): array
    {
        $slicesRaw = [];

        $cursorMonth = $fromDay->copy()->startOfMonth();
        $terminalMonth = $toDayEnd->copy()->startOfMonth();

        while ($cursorMonth->lte($terminalMonth)) {
            $bucketFromDateStr = max(
                $fromDay->toDateString(),
                $cursorMonth->copy()->startOfMonth()->toDateString()
            );
            $bucketToDateStr = min(
                $toDayEnd->toDateString(),
                $cursorMonth->copy()->endOfMonth()->toDateString()
            );

            if ($bucketFromDateStr > $bucketToDateStr) {
                $cursorMonth->addMonth();

                continue;
            }

            $bucketStartCarbon = Carbon::parse($bucketFromDateStr)->startOfDay();
            $bucketEndCarbon = Carbon::parse($bucketToDateStr)->endOfDay();

            $fieldCollections = (float) Delivery::query()
                ->whereNotNull('distributor_id')
                ->where('distributor_id', '>', 0)
                ->whereBetween('delivery_date', [$bucketFromDateStr, $bucketToDateStr])
                ->sum('paymant');

            $treasuryInFromWithdrawals = (float) CashWithdraw::query()
                ->whereBetween('created_at', [$bucketStartCarbon, $bucketEndCarbon])
                ->sum('total_amount');

            $label = $cursorMonth->copy()->locale('ar')->translatedFormat('M Y');

            $slicesRaw[] = [
                'label' => $label,
                'from_date' => $bucketFromDateStr,
                'to_date' => $bucketToDateStr,
                'field_collections' => $fieldCollections,
                'treasury_in_from_withdrawals' => $treasuryInFromWithdrawals,
            ];

            $cursorMonth->addMonth();
        }

        $runningCollections = 0.0;
        $runningTreasury = 0.0;

        $out = [];
        foreach ($slicesRaw as $slice) {
            $runningCollections += $slice['field_collections'];
            $runningTreasury += $slice['treasury_in_from_withdrawals'];
            $out[] = [
                ...$slice,
                'running_field_collections_within_filter' => (float) $runningCollections,
                'running_treasury_in_within_filter' => (float) $runningTreasury,
            ];
        }

        return $out;
    }

    /**
     * @return Collection<int, float>
     */
    private function sumDeliveriesPaymantByDistributorBetween(string $fromDate, string $toDate): Collection
    {
        return Delivery::query()
            ->whereNotNull('distributor_id')
            ->where('distributor_id', '>', 0)
            ->whereBetween('delivery_date', [$fromDate, $toDate])
            ->selectRaw('distributor_id, COALESCE(SUM(paymant), 0) as total_paymant')
            ->groupBy('distributor_id')
            ->pluck('total_paymant', 'distributor_id');
    }

    /**
     * رصيد العهدة الحالي لكل موزِّع (كلّ التحصيل − كلّ السحوبات).
     *
     * @return Collection<int, float>
     */
    private function custodyOutstandingByDistributor(): Collection
    {

        /** @var Collection<int, float> $collected */
        $collected = Delivery::query()
            ->whereNotNull('distributor_id')
            ->where('distributor_id', '>', 0)
            ->selectRaw('distributor_id, COALESCE(SUM(paymant), 0) as total_paymant')
            ->groupBy('distributor_id')
            ->pluck('total_paymant', 'distributor_id');

        /** @var Collection<int, float> $withdrawn */
        $withdrawn = CashWithdraw::query()
            ->selectRaw('distributor_id, COALESCE(SUM(total_amount), 0) as total_withdraw')
            ->groupBy('distributor_id')
            ->pluck('total_withdraw', 'distributor_id');

        $ids = $collected->keys()->merge($withdrawn->keys())->unique()->sort()->values();

        return $ids->mapWithKeys(static function ($id) use ($collected, $withdrawn): array {
            $id = (int) $id;

            return [$id => (float) (($collected[$id] ?? 0) - ($withdrawn[$id] ?? 0))];
        });
    }

    /**
     * سحوبات أودعت لمقرّ الشركة بحسب وقت تسجيل السحب ضمن الفترة.
     *
     * @return Collection<int, float>
     */
    private function sumWithdrawsByDistributorBetween(Carbon $fromStart, Carbon $toEnd): Collection
    {
        return CashWithdraw::query()
            ->whereBetween('created_at', [$fromStart, $toEnd])
            ->selectRaw('distributor_id, COALESCE(SUM(total_amount), 0) as total_amount')
            ->groupBy('distributor_id')
            ->pluck('total_amount', 'distributor_id');
    }

}
