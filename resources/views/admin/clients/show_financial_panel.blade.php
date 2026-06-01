@php
    $f = $f ?? [];
@endphp
<div class="p-4" style="background: linear-gradient(180deg,#f8fafc 0%,#fff 100%); border-radius: 16px; border: 1px solid #e2e8f0; text-align: right;" dir="rtl">
    <div class="fw-bold mb-3" style="color: #1e3a5f; font-size: 1rem;">
        <i class="la la-coins"></i> الحركة المالية (تلخيص على مستوى ملف المشترك)
    </div>
    <p class="small text-muted mb-3">تُحمَّل الفواتير والمدفوعات المسجّلة على <strong>المشترك الأب</strong>؛ أما التسليمات فتُجمع من الأب وجميع العناوين الفرعية.</p>
    <table class="table table-sm mb-0" style="font-size: 0.92rem;">
        <tbody>
            <tr>
                <td class="text-muted">رصيد افتتاحي</td>
                <td class="fw-bold text-end" style="min-width: 120px;">₪ {{ number_format((float) ($f['opening'] ?? 0), 2) }}</td>
            </tr>
            @if(!empty($f['opening_as_of']))
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
                <td class="text-muted small">منها من تسليم (بيع ومتحصّل على السطر؛ لا يُطبَّق على معادلة الفواتير)</td>
                <td class="text-end small text-muted">₪ {{ number_format((float) ($f['payments_from_deliveries'] ?? 0), 2) }}</td>
            </tr>
            <tr>
                <td class="text-muted">مدفوعات تُطبَّق ضد الرصيد (افتتاحي وفواتير)</td>
                <td class="fw-bold text-end">₪ {{ number_format((float) ($f['payments_standalone'] ?? 0), 2) }}</td>
            </tr>
            <tr class="border-top border-2">
                <td class="text-muted">الرصيد (افتتاحي + فواتير − مدفوعات ليست من تسليم)</td>
                <td class="fw-bold text-end @if(($f['balance_per_invoices'] ?? 0) > 0) text-danger @elseif(($f['balance_per_invoices'] ?? 0) < 0) text-success @endif">₪ {{ number_format((float) ($f['balance_per_invoices'] ?? 0), 2) }}</td>
            </tr>
            <tr>
                <td class="text-muted pt-3">متبقٍ على التسليمات <span class="small">مجموع (المطلوب − المسدّد بالتسليم)</span></td>
                <td class="fw-bold text-end pt-3 @if(($f['delivery_outstanding'] ?? 0) > 0.0001) text-warning @endif">₪ {{ number_format((float) ($f['delivery_outstanding'] ?? 0), 2) }}</td>
            </tr>
            <tr>
                <td class="text-muted small">تسليمات فيها فرق مستحق / إجمالي تسليمات العائلة</td>
                <td class="text-end small">{{ (int) ($f['deliveries_with_gap'] ?? 0) }} / {{ (int) ($f['delivery_count_family'] ?? 0) }}</td>
            </tr>
            @php
                $combinedDebtShow = round((float) ($f['balance_per_invoices'] ?? 0) + (float) ($f['delivery_outstanding'] ?? 0), 2);
            @endphp
            <tr class="border-top border-3">
                <td class="fw-bold" style="color: #1e3a5f;">إجمالي الدين على المشترك</td>
                <td class="fw-bold text-end @if($combinedDebtShow > 0) text-danger @endif">₪ {{ number_format($combinedDebtShow, 2) }}</td>
            </tr>
        </tbody>
    </table>
    <div class="d-flex flex-wrap gap-2 mt-3 justify-content-start">
        <a href="{{ backpack_url('client-payment?client_id=' . (int) ($f['billing_parent_id'] ?? 0)) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 10px;"><i class="la la-money-bill"></i> المدفوعات</a>
        <a href="{{ route('client.report', ['client_id' => $entry->id]) }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 10px;"><i class="la la-list"></i> جدول تسليمات العميل</a>
        <a href="{{ route('reports.client-balance', ['client_id' => (int) ($f['billing_parent_id'] ?? 0)]) }}" class="btn btn-sm btn-outline-dark" style="border-radius: 10px;"><i class="la la-file-invoice-dollar"></i> تقرير الرصيد</a>
    </div>
</div>
