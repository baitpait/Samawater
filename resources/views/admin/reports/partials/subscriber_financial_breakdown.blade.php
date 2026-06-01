@php
    /** @var array<string, mixed> $f */
    $f = $f ?? [];
    $clientId = (int) ($clientId ?? ($f['billing_parent_id'] ?? 0));
    $balancePerInvoices = (float) ($f['balance_per_invoices'] ?? 0);
    $deliveryOutstanding = (float) ($f['delivery_outstanding'] ?? 0);
    $combinedDebt = round($balancePerInvoices + $deliveryOutstanding, 2);
@endphp
<div class="p-4 financial-breakdown-panel" style="background: linear-gradient(180deg,#f8fafc 0%,#fff 100%); border-radius: 16px; border: 1px solid #e2e8f0; text-align: right;" dir="rtl">
    <div class="fw-bold mb-2" style="color: #1e3a5f; font-size: 1.05rem;">
        <i class="la la-coins"></i> تفصيل الحركة المالية (شفاف)
    </div>
    <p class="small text-muted mb-3 mb-md-4">
        المدفوعات المسجّلة على التسليم تظهر في الجدول للتدقيق، لكنها <strong>لا تُطرح مرتين</strong> من مسار الفواتير والافتتاحي.
        «إجمالي الدين» = رصيد الفواتير + متبقّي التسليمات (نفس عمود «دين المشترك» في تقرير الفلاتر).
    </p>
    <table class="table table-sm mb-0" style="font-size: 0.92rem;">
        <tbody>
            <tr>
                <td class="text-muted">رصيد افتتاحي</td>
                <td class="fw-bold text-end" style="min-width: 140px;">₪ {{ number_format((float) ($f['opening'] ?? 0), 2) }}</td>
            </tr>
            @if (! empty($f['opening_as_of']))
                <tr>
                    <td class="text-muted small" colspan="2">تاريخ اعتماد الرصيد الافتتاحي: {{ $f['opening_as_of'] }}</td>
                </tr>
            @endif
            <tr>
                <td class="text-muted">إجمالي الفواتير المؤكّدة</td>
                <td class="fw-bold text-end">₪ {{ number_format((float) ($f['invoices_confirmed'] ?? 0), 2) }}</td>
            </tr>
            <tr>
                <td class="text-muted">إجمالي المدفوعات المسجّلة («مدفوعات المشتركين»)</td>
                <td class="fw-bold text-end">₪ {{ number_format((float) ($f['payments_total'] ?? 0), 2) }}</td>
            </tr>
            <tr>
                <td class="text-muted ps-4">↳ منها على تسليمات (مُسجَّلة مع البيع؛ لا تُخصم من مسار الفواتير)</td>
                <td class="text-end text-muted">₪ {{ number_format((float) ($f['payments_from_deliveries'] ?? 0), 2) }}</td>
            </tr>
            <tr>
                <td class="text-muted ps-4">↳ تُخصم من الرصيد (مدفوعات مستقلة / غير مرتبطة بتسليم)</td>
                <td class="fw-bold text-end">₪ {{ number_format((float) ($f['payments_standalone'] ?? 0), 2) }}</td>
            </tr>
            <tr class="border-top border-2">
                <td class="text-muted">رصيد مسار الفواتير والافتتاحي<br><span class="small">(افتتاحي + فواتير − مدفوعات مستقلة)</span></td>
                <td class="fw-bold text-end @if($balancePerInvoices > 0) text-danger @elseif($balancePerInvoices < 0) text-success @endif">
                    ₪ {{ number_format($balancePerInvoices, 2) }}
                </td>
            </tr>
            <tr>
                <td class="text-muted">متبقّي على التسليمات<br><span class="small">∑ max(0، المطلوب − المسدّد على السطر)</span></td>
                <td class="fw-bold text-end @if($deliveryOutstanding > 0.0001) text-warning @endif">
                    ₪ {{ number_format($deliveryOutstanding, 2) }}
                </td>
            </tr>
            <tr>
                <td class="text-muted small">تسليمات فيها فرق / إجمالي تسليمات العائلة</td>
                <td class="text-end small">{{ (int) ($f['deliveries_with_gap'] ?? 0) }} / {{ (int) ($f['delivery_count_family'] ?? 0) }}</td>
            </tr>
            <tr class="border-top border-3">
                <td class="fw-bold" style="color: #1e3a5f;">إجمالي الدين على المشترك<br><span class="small fw-normal text-muted">(مطابق لتقرير الفلاتر)</span></td>
                <td class="fw-bold text-end fs-5 @if($combinedDebt > 0) text-danger @elseif($combinedDebt < 0) text-success @endif">
                    ₪ {{ number_format($combinedDebt, 2) }}
                </td>
            </tr>
        </tbody>
    </table>
    @if ($clientId > 0)
        <div class="d-flex flex-wrap gap-2 mt-3 justify-content-start">
            <a href="{{ backpack_url('client/' . $clientId . '/show') }}" class="btn btn-sm btn-outline-primary" style="border-radius: 10px;">
                <i class="la la-eye"></i> ملف المشترك
            </a>
            <a href="{{ backpack_url('client-payment?client_id=' . $clientId) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 10px;">
                <i class="la la-money-bill"></i> المدفوعات
            </a>
            <a href="{{ route('reports.filters') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 10px;">
                <i class="la la-filter"></i> تقرير الفلاتر
            </a>
        </div>
    @endif
</div>
