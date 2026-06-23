<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Business Purpose: تحميل بيانات تقرير تسليمات المشترك (صفحة + PDF) بشكل موحّد.
 */
final class ClientDeliveryReportService
{
    /**
     * @return array{
     *     client: Client,
     *     bottleSnapshot: array<string, int>,
     *     accountSnapshot: array<string, mixed>,
     *     filterMeta: array{
     *         from: ?string,
     *         to: ?string,
     *         filtered_count: int,
     *         total_count: int,
     *         earliest_delivery_date: ?string,
     *         latest_delivery_date: ?string
     *     }
     * }
     */
    public function load(Request $request, int $clientId): array
    {
        $client = Client::with(['city', 'distributor'])->findOrFail($clientId);
        $familyIds = $client->familyClientIds();

        [$from, $to] = $this->resolveDateRange($request);

        $deliveries = $this->queryFamilyDeliveries($familyIds, $from, $to);
        $client->setRelation('deliveries', $deliveries);

        $allTimeBounds = Delivery::query()
            ->whereIn('client_id', $familyIds)
            ->selectRaw('MIN(delivery_date) as earliest, MAX(delivery_date) as latest, COUNT(*) as total')
            ->first();

        return [
            'client' => $client,
            'bottleSnapshot' => $client->familyBottleBalanceFromDeliveries(),
            'accountSnapshot' => $client->accountStatementSnapshot(),
            'filterMeta' => [
                'from' => $from,
                'to' => $to,
                'filtered_count' => $deliveries->count(),
                'total_count' => (int) ($allTimeBounds->total ?? 0),
                'earliest_delivery_date' => $this->formatDate($allTimeBounds->earliest ?? null),
                'latest_delivery_date' => $this->formatDate($allTimeBounds->latest ?? null),
            ],
        ];
    }

    /**
     * Business Purpose: تطبيع نطاق التاريخ (تصحيح عكس من/إلى) لمنع جدول فارغ بسبب خطأ إدخال.
     *
     * @return array{0: ?string, 1: ?string}
     */
    private function resolveDateRange(Request $request): array
    {
        $from = $request->filled('from') ? (string) $request->input('from') : null;
        $to = $request->filled('to') ? (string) $request->input('to') : null;

        if ($from !== null && $to !== null && $from > $to) {
            return [$to, $from];
        }

        return [$from, $to];
    }

    /**
     * Business Purpose: جلب تسليمات ملف العائلة (الأب + العناوين الفرعية) ضمن الفترة المحددة.
     *
     * @param  list<int>  $familyIds
     */
    private function queryFamilyDeliveries(array $familyIds, ?string $from, ?string $to): Collection
    {
        $query = Delivery::query()
            ->whereIn('client_id', $familyIds)
            ->with('distributor');

        if ($from !== null) {
            $query->whereDate('delivery_date', '>=', $from);
        }

        if ($to !== null) {
            $query->whereDate('delivery_date', '<=', $to);
        }

        return $query->orderByDesc('delivery_date')->get();
    }

    /**
     * Business Purpose: تحويل تاريخ قاعدة البيانات إلى Y-m-d للعرض في التقرير.
     */
    private function formatDate(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return date('Y-m-d', strtotime((string) $value));
    }
}
