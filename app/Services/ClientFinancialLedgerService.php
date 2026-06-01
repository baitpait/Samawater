<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Client;
use App\Models\Delivery;
use Carbon\Carbon;

/**
 * Business Purpose: بناء كشف حساب تراكمي للمشترك (افتتاحي، فواتير، مدفوعات مستقلة، تسليمات) مع أرصدة جارية.
 * يطبّق ADR-003: مدفوعات التسليم لا تُطرح من مسار الفواتير؛ تظهر ضمن سطر التسليم فقط.
 */
final class ClientFinancialLedgerService
{
    private const TYPE_OPENING = 'opening';

    private const TYPE_INVOICE = 'invoice';

    private const TYPE_PAYMENT = 'payment';

    private const TYPE_DELIVERY = 'delivery';

    /**
     * @return array{
     *     billing_parent_id: int,
     *     display_client_id: int,
     *     display_name: string,
     *     period: array{from: string|null, to: string|null},
     *     summary: array<string, float|int>,
     *     rows: list<array<string, mixed>>
     * }
     */
    public function build(Client $client, ?string $from = null, ?string $to = null): array
    {
        $parent = $client->getParentClient();
        if ($parent === null) {
            return $this->emptyLedger($client, $from, $to);
        }

        $familyIds = $client->familyClientIds();
        $opening = round((float) ($parent->opening_balance_amount ?? 0), 2);
        $openingDate = $parent->opening_balance_as_of
            ? $parent->opening_balance_as_of->format('Y-m-d')
            : null;

        /** @var list<array<string, mixed>> $events */
        $events = [];

        if (abs($opening) > 0.00001 || $openingDate !== null) {
            $events[] = $this->event(
                self::TYPE_OPENING,
                $openingDate ?? '1970-01-01',
                'رصيد افتتاحي',
                $openingDate ? 'تاريخ اعتماد: '.$openingDate : '—',
                $opening > 0 ? $opening : 0.0,
                $opening < 0 ? abs($opening) : 0.0,
                0
            );
        }

        $invoiceQuery = $parent->invoices()->where('status', 'confirmed');
        if ($from !== null) {
            $invoiceQuery->whereDate('invoice_date', '>=', $from);
        }
        if ($to !== null) {
            $invoiceQuery->whereDate('invoice_date', '<=', $to);
        }
        foreach ($invoiceQuery->orderBy('invoice_date')->orderBy('id')->get() as $invoice) {
            $date = $this->dateString($invoice->invoice_date);
            $events[] = $this->event(
                self::TYPE_INVOICE,
                $date,
                'فاتورة مؤكّدة',
                (string) ($invoice->invoice_number ?? '#'.$invoice->id),
                (float) $invoice->total_amount,
                0.0,
                1,
                (int) $invoice->id
            );
        }

        $paymentQuery = $parent->payments()->whereDoesntHave('linkedDelivery');
        if ($from !== null) {
            $paymentQuery->whereDate('payment_date', '>=', $from);
        }
        if ($to !== null) {
            $paymentQuery->whereDate('payment_date', '<=', $to);
        }
        foreach ($paymentQuery->orderBy('payment_date')->orderBy('id')->get() as $payment) {
            $date = $this->dateString($payment->payment_date);
            $events[] = $this->event(
                self::TYPE_PAYMENT,
                $date,
                'دفعة (مسار الفواتير)',
                (string) ($payment->reference_number ?: 'دفعة #'.$payment->id),
                0.0,
                (float) $payment->amount,
                3,
                (int) $payment->id
            );
        }

        $deliveryQuery = Delivery::query()->whereIn('client_id', $familyIds);
        if ($from !== null) {
            $deliveryQuery->whereDate('delivery_date', '>=', $from);
        }
        if ($to !== null) {
            $deliveryQuery->whereDate('delivery_date', '<=', $to);
        }
        foreach ($deliveryQuery->orderBy('delivery_date')->orderBy('id')->get() as $delivery) {
            $date = $this->dateString($delivery->delivery_date);
            $required = (float) ($delivery->required_amount ?? 0);
            $paid = (float) ($delivery->paymant ?? 0);
            $events[] = $this->event(
                self::TYPE_DELIVERY,
                $date,
                'تسليم',
                'تسليم #'.$delivery->id,
                $required,
                $paid,
                2,
                (int) $delivery->id
            );
        }

        usort($events, static function (array $a, array $b): int {
            $dateCmp = strcmp((string) $a['date'], (string) $b['date']);
            if ($dateCmp !== 0) {
                return $dateCmp;
            }
            $orderCmp = ((int) $a['type_order']) <=> ((int) $b['type_order']);
            if ($orderCmp !== 0) {
                return $orderCmp;
            }

            return ((int) $a['source_id']) <=> ((int) $b['source_id']);
        });

        $invoiceRunning = 0.0;
        $rows = [];
        foreach ($events as $event) {
            if ($event['type'] === self::TYPE_OPENING) {
                $invoiceRunning = round($invoiceRunning + (float) $event['debit'] - (float) $event['credit'], 2);
            } elseif ($event['type'] === self::TYPE_INVOICE) {
                $invoiceRunning = round($invoiceRunning + (float) $event['debit'], 2);
            } elseif ($event['type'] === self::TYPE_PAYMENT) {
                $invoiceRunning = round($invoiceRunning - (float) $event['credit'], 2);
            }

            $deliveryOutstanding = $this->deliveryOutstandingAsOf($familyIds, (string) $event['date']);
            $combined = round($invoiceRunning + $deliveryOutstanding, 2);

            $rows[] = array_merge($event, [
                'invoice_balance_running' => $invoiceRunning,
                'delivery_outstanding_running' => $deliveryOutstanding,
                'combined_balance_running' => $combined,
            ]);
        }

        $snapshot = $client->accountStatementSnapshot();

        return [
            'billing_parent_id' => (int) $parent->id,
            'display_client_id' => (int) $client->id,
            'display_name' => (string) ($client->name ?? $parent->name ?? ''),
            'period' => [
                'from' => $from,
                'to' => $to,
            ],
            'summary' => [
                'opening' => $opening,
                'sales_invoices_total' => (float) ($snapshot['sales_total'] ?? 0),
                'deliveries_required_total' => (float) ($snapshot['deliveries_total'] ?? 0),
                'final_invoice_path_balance' => round((float) $client->balance, 2),
                'final_delivery_outstanding' => round($client->deliveryOutstandingTotal(), 2),
                'final_combined_debt' => round((float) $client->combined_subscriber_debt, 2),
            ],
            'rows' => $rows,
        ];
    }

    /**
     * @param  list<int>  $familyClientIds
     */
    private function deliveryOutstandingAsOf(array $familyClientIds, string $asOfDate): float
    {
        $collection = Delivery::query()
            ->whereIn('client_id', $familyClientIds)
            ->whereDate('delivery_date', '<=', $asOfDate)
            ->get();

        $total = 0.0;
        foreach ($collection as $delivery) {
            $total += max(0.0, (float) ($delivery->required_amount ?? 0) - (float) ($delivery->paymant ?? 0));
        }

        return round($total, 2);
    }

    /**
     * @return array<string, mixed>
     */
    private function event(
        string $type,
        string $date,
        string $label,
        string $reference,
        float $debit,
        float $credit,
        int $typeOrder,
        int $sourceId = 0
    ): array {
        return [
            'type' => $type,
            'date' => $date,
            'label' => $label,
            'reference' => $reference,
            'debit' => round($debit, 2),
            'credit' => round($credit, 2),
            'type_order' => $typeOrder,
            'source_id' => $sourceId,
        ];
    }

    private function dateString(mixed $value): string
    {
        if ($value instanceof Carbon) {
            return $value->format('Y-m-d');
        }

        return Carbon::parse((string) $value)->format('Y-m-d');
    }

    /**
     * @return array<string, mixed>
     */
    private function emptyLedger(Client $client, ?string $from, ?string $to): array
    {
        return [
            'billing_parent_id' => (int) $client->id,
            'display_client_id' => (int) $client->id,
            'display_name' => (string) ($client->name ?? ''),
            'period' => ['from' => $from, 'to' => $to],
            'summary' => [
                'opening' => 0.0,
                'sales_invoices_total' => 0.0,
                'deliveries_required_total' => 0.0,
                'final_invoice_path_balance' => 0.0,
                'final_delivery_outstanding' => 0.0,
                'final_combined_debt' => 0.0,
            ],
            'rows' => [],
        ];
    }
}
