<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Http\Request;

/**
 * Business Purpose: تحميل بيانات تقرير تسليمات المشترك (صفحة + PDF) بشكل موحّد.
 */
final class ClientDeliveryReportService
{
    /**
     * @return array{
     *     client: Client,
     *     bottleSnapshot: array<string, int>,
     *     accountSnapshot: array<string, mixed>
     * }
     */
    public function load(Request $request, int $clientId): array
    {
        $client = Client::with($this->relations($request))
            ->findOrFail($clientId);

        return [
            'client' => $client,
            'bottleSnapshot' => $client->bottleBalanceFromDeliveriesFormula(),
            'accountSnapshot' => $client->accountStatementSnapshot(),
        ];
    }

    /**
     * @return array<int|string, mixed>
     */
    private function relations(Request $request): array
    {
        return [
            'city',
            'distributor',
            'deliveries' => function ($q) use ($request) {
                if ($request->filled('from')) {
                    $q->whereDate('delivery_date', '>=', $request->from);
                }
                if ($request->filled('to')) {
                    $q->whereDate('delivery_date', '<=', $request->to);
                }
                $q->with('distributor')->orderBy('delivery_date', 'desc');
            },
        ];
    }
}
