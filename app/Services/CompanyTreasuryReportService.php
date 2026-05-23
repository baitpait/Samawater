<?php

namespace App\Services;

use App\Models\ClientPayment;
use App\Models\Delivery;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\VendorPayment;
use Carbon\Carbon;

/**
 * Business Purpose: تجميع مؤشرات «صندوق الشركة» في فترة: وارد التسليمات والمبيعات (فواتير مؤكّدة)
 * ومدفوعات المشتركين من جدول client_payments، مقابل صادر المشتريات (vendor_payments بنفس شرط الفترة في الحركة الشاملة) والمصروفات.
 */
final class CompanyTreasuryReportService
{
    /** @internal نفس حد النطاق الزمني للحركة الشاملة */
    public const DEFAULT_MAX_RANGE_DAYS = 366;

    /**
     * Business Purpose: إرجاع مجاميع الفترة لبناء لوحة صندوق الشركة.
     *
     * @return array<string, mixed>
     */
    public function summarize(Carbon $fromInclusive, Carbon $toInclusive): array
    {
        $fromD = $fromInclusive->format('Y-m-d');
        $toD = $toInclusive->format('Y-m-d');

        /** @phpstan-ignore-next-line */
        $deliveriesCash = (float) Delivery::query()
            ->whereBetween('delivery_date', [$fromD, $toD])
            ->sum('paymant');

        /** @phpstan-ignore-next-line */
        $confirmedInvoiceSales = (float) Invoice::query()
            ->where('status', 'confirmed')
            ->whereBetween('invoice_date', [$fromD, $toD])
            ->sum('total_amount');

        /** @phpstan-ignore-next-line */
        $registeredClientPayments = (float) ClientPayment::query()
            ->whereBetween('payment_date', [$fromD, $toD])
            ->sum('amount');

        /** @phpstan-ignore-next-line */
        $registeredClientPaymentsFutureObligation = (float) ClientPayment::query()
            ->where('for_future_obligation', true)
            ->whereBetween('payment_date', [$fromD, $toD])
            ->sum('amount');

        /** مطابق لتجميع «الحركة المالية الشاملة» على payment_date ضمن الفترة */
        /** @phpstan-ignore-next-line */
        $vendorPurchases = (float) VendorPayment::query()
            ->whereBetween('payment_date', [$fromD, $toD])
            ->sum('amount');

        /** @phpstan-ignore-next-line */
        $expensesPaid = (float) Expense::query()
            ->whereBetween('payment_date', [$fromD, $toD])
            ->sum('total_amount');

        $totalIn = $deliveriesCash + $confirmedInvoiceSales + $registeredClientPayments;
        $totalOut = $vendorPurchases + $expensesPaid;
        $netPeriod = $totalIn - $totalOut;

        return [
            'period' => [
                'from' => $fromD,
                'to' => $toD,
            ],
            'inflow' => [
                'deliveries_cash_on_delivery' => $deliveriesCash,
                'confirmed_invoice_sales' => $confirmedInvoiceSales,
                'registered_client_payments' => $registeredClientPayments,
                'registered_client_payments_future_obligation' => $registeredClientPaymentsFutureObligation,
                'total_in' => $totalIn,
            ],
            'outflow' => [
                'vendor_purchases' => $vendorPurchases,
                'expenses' => $expensesPaid,
                'total_out' => $totalOut,
            ],
            'net_period_movement' => $netPeriod,
        ];
    }
}
