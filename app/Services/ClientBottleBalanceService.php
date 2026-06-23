<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Delivery;
use Illuminate\Support\Collection;

/**
 * Business Purpose: حساب رصيد القوارير (ممتلئة − فارغة) لملف العائلة دون استعلام N+1.
 */
class ClientBottleBalanceService
{
    /**
     * Business Purpose: مجاميع التسليمات لكل مشترك من جدول التسليمات.
     *
     * @return array<int, array{total_bottle_received: int, total_bottle_empty: int}>
     */
    public function deliveryTotalsByClientId(): array
    {
        $rows = Delivery::query()
            ->selectRaw('client_id, COALESCE(SUM(bottle_received), 0) as total_bottle_received, COALESCE(SUM(bottle_empty), 0) as total_bottle_empty')
            ->groupBy('client_id')
            ->get();

        $totals = [];
        foreach ($rows as $row) {
            $totals[(int) $row->client_id] = [
                'total_bottle_received' => (int) $row->total_bottle_received,
                'total_bottle_empty' => (int) $row->total_bottle_empty,
            ];
        }

        return $totals;
    }

    /**
     * Business Purpose: لقطة رصيد القوارير لكل مشترك في القائمة (مجموع ملف العائلة).
     *
     * @param  Collection<int, Client>  $clients
     * @return array<int, array{
     *     billing_parent_id: int,
     *     total_bottle_received: int,
     *     total_bottle_empty: int,
     *     bottle_balance: int
     * }>
     */
    public function familySnapshotsForClients(Collection $clients): array
    {
        if ($clients->isEmpty()) {
            return [];
        }

        $deliveryTotals = $this->deliveryTotalsByClientId();
        $familyMap = $this->familyMapForClientIds($clients->pluck('id')->map(static fn ($id): int => (int) $id)->all());

        $snapshots = [];
        foreach ($clients as $client) {
            $snapshots[(int) $client->id] = $this->snapshotFromFamilyMap(
                (int) $client->id,
                $familyMap,
                $deliveryTotals
            );
        }

        return $snapshots;
    }

    /**
     * Business Purpose: ملخص رصيد القوارير لكل المشتركين المفلترين دون تكرار ملفات العائلة.
     *
     * @param  list<int>  $clientIds
     * @return array{
     *     client_count: int,
     *     family_count: int,
     *     total_bottle_received: int,
     *     total_bottle_empty: int,
     *     bottle_balance: int
     * }
     */
    public function filteredFamilySummary(array $clientIds): array
    {
        if ($clientIds === []) {
            return [
                'client_count' => 0,
                'family_count' => 0,
                'total_bottle_received' => 0,
                'total_bottle_empty' => 0,
                'bottle_balance' => 0,
            ];
        }

        $deliveryTotals = $this->deliveryTotalsByClientId();
        $familyMap = $this->familyMapForClientIds($clientIds);

        $seenParents = [];
        $received = 0;
        $empty = 0;

        foreach ($clientIds as $clientId) {
            $snapshot = $this->snapshotFromFamilyMap((int) $clientId, $familyMap, $deliveryTotals);
            $parentId = $snapshot['billing_parent_id'];
            if (isset($seenParents[$parentId])) {
                continue;
            }
            $seenParents[$parentId] = true;
            $received += $snapshot['total_bottle_received'];
            $empty += $snapshot['total_bottle_empty'];
        }

        return [
            'client_count' => count($clientIds),
            'family_count' => count($seenParents),
            'total_bottle_received' => $received,
            'total_bottle_empty' => $empty,
            'bottle_balance' => $received - $empty,
        ];
    }

    /**
     * Business Purpose: ربط كل مشترك بملف العائلة (الأب + العناوين الفرعية).
     *
     * @param  list<int>  $clientIds
     * @return array<int, array{billing_parent_id: int, family_ids: list<int>}>
     */
    private function familyMapForClientIds(array $clientIds): array
    {
        $clients = Client::query()
            ->select('id', 'parent_id')
            ->get()
            ->keyBy('id');

        $childrenByParent = Client::query()
            ->select('id', 'parent_id')
            ->whereNotNull('parent_id')
            ->get()
            ->groupBy('parent_id');

        $familyMap = [];
        foreach ($clientIds as $clientId) {
            $familyMap[$clientId] = $this->familyEntryForClient(
                $clientId,
                $clients,
                $childrenByParent
            );
        }

        return $familyMap;
    }

    /**
     * Business Purpose: تحديد الأب وجميع معرفات العائلة لمشترك واحد.
     *
     * @return array{billing_parent_id: int, family_ids: list<int>}
     */
    private function familyEntryForClient(int $clientId, Collection $clients, Collection $childrenByParent): array
    {
        $client = $clients->get($clientId);
        $parentId = $client && $client->parent_id !== null
            ? (int) $client->parent_id
            : $clientId;

        $familyIds = [(int) $parentId];
        foreach ($childrenByParent->get($parentId, collect()) as $child) {
            $familyIds[] = (int) $child->id;
        }

        return [
            'billing_parent_id' => $parentId,
            'family_ids' => array_values(array_unique($familyIds)),
        ];
    }

    /**
     * Business Purpose: بناء لقطة الرصيد من خريطة العائلة ومجاميع التسليمات.
     *
     * @param  array<int, array{billing_parent_id: int, family_ids: list<int>}>  $familyMap
     * @param  array<int, array{total_bottle_received: int, total_bottle_empty: int}>  $deliveryTotals
     * @return array{
     *     billing_parent_id: int,
     *     total_bottle_received: int,
     *     total_bottle_empty: int,
     *     bottle_balance: int
     * }
     */
    private function snapshotFromFamilyMap(int $clientId, array $familyMap, array $deliveryTotals): array
    {
        $entry = $familyMap[$clientId] ?? [
            'billing_parent_id' => $clientId,
            'family_ids' => [$clientId],
        ];

        $received = 0;
        $empty = 0;
        foreach ($entry['family_ids'] as $familyClientId) {
            $totals = $deliveryTotals[$familyClientId] ?? [
                'total_bottle_received' => 0,
                'total_bottle_empty' => 0,
            ];
            $received += $totals['total_bottle_received'];
            $empty += $totals['total_bottle_empty'];
        }

        return [
            'billing_parent_id' => $entry['billing_parent_id'],
            'total_bottle_received' => $received,
            'total_bottle_empty' => $empty,
            'bottle_balance' => $received - $empty,
        ];
    }
}
