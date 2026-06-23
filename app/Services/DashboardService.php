<?php

namespace App\Services;

use App\Models\City;
use App\Models\Client;
use App\Models\ClientPayment;
use App\Models\ClientStatus;
use App\Models\Delivery;
use App\Models\Distributor;
use App\Models\Expense;
use App\Models\InventoryItem;
use App\Models\SubscriptionStatus;
use App\Models\VClientsDueByTypeDaysIds;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Business Purpose: تجميع بيانات لوحة التحكم للمالك بمصادر صحيحة وقابلة للاختبار.
 */
final class DashboardService
{
    public function __construct(
        private readonly TreasuryCustodyAggregationService $treasuryCustody,
    ) {
    }

    /**
     * Business Purpose: لوحة المالك — تسليمات، كاش، عهدة، مستحقات، ثم بقية المؤشرات والرسوم.
     *
     * @return array<string, mixed>
     */
    public function buildForOwner(): array
    {
        $today = Carbon::today();

        $deliveriesToday = (int) Delivery::query()
            ->whereDate('delivery_date', $today)
            ->count();

        $cashToday = (float) ClientPayment::query()
            ->whereDate('payment_date', $today)
            ->sum('amount');

        $custodySummary = $this->treasuryCustody->summarize(
            $today->copy()->startOfMonth(),
            $today
        );
        $custodyNow = (float) ($custodySummary['totals']['custody_with_distributors_now'] ?? 0);

        $duesCount = $this->countDistributionDueClients();

        $warehouseInventory = (int) InventoryItem::query()->sum('quantity');
        $onLoanInventory = (int) array_sum(InventoryItem::activeDepositTotalsByItemName());
        $bottlesReceived = (int) Delivery::query()->sum('bottle_received');
        $bottlesEmpty = (int) Delivery::query()->sum('bottle_empty');
        $bottlesAtCustomers = max(0, $bottlesReceived - $bottlesEmpty);

        $deliveriesThisMonth = (int) Delivery::query()
            ->whereYear('delivery_date', $today->year)
            ->whereMonth('delivery_date', $today->month)
            ->count();

        $lastMonth = $today->copy()->subMonth();
        $deliveriesLastMonth = (int) Delivery::query()
            ->whereYear('delivery_date', $lastMonth->year)
            ->whereMonth('delivery_date', $lastMonth->month)
            ->count();

        return [
            'hero' => [
                'deliveries_today' => $deliveriesToday,
                'cash_today' => $cashToday,
                'custody_now' => $custodyNow,
                'dues_count' => $duesCount,
            ],
            'totals' => [
                'total_clients' => Client::query()->count(),
                'active_clients' => Client::query()->where('subscription_status_id', 1)->count(),
                'distributors_count' => Distributor::query()->count(),
                'cities_count' => City::query()->count(),
                'deliveries_this_month' => $deliveriesThisMonth,
                'deliveries_last_month' => $deliveriesLastMonth,
                'warehouse_inventory' => $warehouseInventory,
                'on_loan_inventory' => $onLoanInventory,
            ],
            'bottles' => [
                'warehouse' => $warehouseInventory,
                'at_customers' => $bottlesAtCustomers,
                'on_loan' => $onLoanInventory,
                'total_accounted' => $warehouseInventory + $onLoanInventory + $bottlesAtCustomers,
            ],
            'alerts' => [
                'unpaid_expenses_count' => (int) Expense::query()
                    ->where('is_inventory', false)
                    ->where('payment_status', 'unpaid')
                    ->count(),
            ],
            'client_status_stats' => $this->clientStatusStats(),
            'subscription_status_stats' => $this->subscriptionStatusStats(),
            'city_chart' => $this->cityChartData(),
            'deliveries_today_rows' => $this->deliveriesTodayRows($today),
        ];
    }

    /**
     * Business Purpose: عدد المشتركين المستحقين للتوزيع حسب جدولهم (وليس مجرد «نشط»).
     */
    private function countDistributionDueClients(): int
    {
        try {
            return (int) VClientsDueByTypeDaysIds::query()->count();
        } catch (\Throwable) {
            return 0;
        }
    }

    /**
     * @return list<array{name: string, count: int, color: string}>
     */
    private function clientStatusStats(): array
    {
        $statuses = ClientStatus::query()->orderBy('min_percentage')->get();
        $stats = [];

        foreach ($statuses as $status) {
            $name = (string) ($status->status_name ?? 'غير محدد');
            $count = (int) Client::query()->where('client_status_id', $status->id)->count();
            $stats[] = [
                'name' => $name,
                'count' => $count,
                'color' => match ($name) {
                    'مميز' => '#22c55e',
                    'جيد جدًا', 'جيد جداً' => '#34d399',
                    'ملتزم إلى حد ما' => '#fbbf24',
                    default => '#ef4444',
                },
            ];
        }

        return $stats;
    }

    /**
     * @return list<array{name: string, count: int}>
     */
    private function subscriptionStatusStats(): array
    {
        $stats = [];
        foreach (SubscriptionStatus::query()->orderBy('id')->get() as $status) {
            $stats[] = [
                'name' => (string) $status->status_name,
                'count' => (int) Client::query()->where('subscription_status_id', $status->id)->count(),
            ];
        }

        return $stats;
    }

    /**
     * @return array{labels: list<string>, values: list<int>}
     */
    private function cityChartData(): array
    {
        $topCities = City::query()
            ->withCount('clients')
            ->orderByDesc('clients_count')
            ->take(6)
            ->get();

        return [
            'labels' => $topCities->pluck('city_name')->map(static fn ($n): string => (string) $n)->all(),
            'values' => $topCities->pluck('clients_count')->map(static fn ($c): int => (int) $c)->all(),
        ];
    }

    /**
     * @return Collection<int, Delivery>
     */
    private function deliveriesTodayRows(Carbon $today): Collection
    {
        return Delivery::query()
            ->whereDate('delivery_date', $today)
            ->with(['client.city', 'client.subscriptionType', 'distributor'])
            ->orderByDesc('delivery_date')
            ->orderByDesc('id')
            ->take(10)
            ->get();
    }
}
