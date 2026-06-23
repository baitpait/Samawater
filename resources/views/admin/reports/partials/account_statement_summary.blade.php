@php
    /** @var array<string, mixed> $statement */
    $statement = $statement ?? [];
    $amountDue = (float) ($statement['amount_due'] ?? 0);
    $deposits = $statement['deposit_totals_by_item'] ?? [];
    $billingParentId = (int) ($statement['billing_parent_id'] ?? 0);
    $bottleSnapshot = $statement['bottle_snapshot'] ?? [
        'total_bottle_received' => 0,
        'total_bottle_empty' => 0,
        'bottle_balance' => (int) ($statement['bottles_on_hand'] ?? 0),
    ];
@endphp

<div class="account-statement-panel mb-4">
    <div class="client-identity-bar mb-4 p-3" style="background: #f8fafc; border-radius: 14px; border: 1px solid #e2e8f0;">
        <div class="fw-bold fs-5" style="color: var(--primary-deep);">{{ $statement['display_name'] ?? '—' }}</div>
        <div class="small text-muted mt-1">
            @if(!empty($statement['contract_no']))
                <span>عقد: {{ $statement['contract_no'] }}</span>
                <span class="mx-2">·</span>
            @endif
            @if(!empty($statement['phone_one']))
                <span>هاتف: {{ $statement['phone_one'] }}</span>
            @endif
        </div>
    </div>

    <div class="row g-3 g-md-4 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card-modern">
                <div class="stat-card-icon"><i class="la la-file-invoice"></i></div>
                <div class="stat-card-label">مجموع المبيعات</div>
                <p class="stat-card-value mb-0">{{ number_format((float) ($statement['sales_total'] ?? 0), 2) }} ₪</p>
                <p class="small text-muted mb-0 mt-1">فواتير مؤكّدة</p>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card-modern">
                <div class="stat-card-icon"><i class="la la-truck"></i></div>
                <div class="stat-card-label">مجموع التسليمات</div>
                <p class="stat-card-value mb-0">{{ number_format((float) ($statement['deliveries_total'] ?? 0), 2) }} ₪</p>
                <p class="small text-muted mb-0 mt-1">إجمالي المطلوب على التسليمات</p>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card-modern">
                <div class="stat-card-icon"><i class="la la-chart-line"></i></div>
                <div class="stat-card-label">مجموع المبيعات والتسليمات</div>
                <p class="stat-card-value mb-0">{{ number_format((float) ($statement['sales_and_deliveries_gross'] ?? 0), 2) }} ₪</p>
                <p class="small text-muted mb-0 mt-1">حجم التعامل (قبل خصم المدفوعات)</p>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card-modern stat-card-danger">
                <div class="stat-card-icon stat-icon-danger"><i class="la la-balance-scale"></i></div>
                <div class="stat-card-label">الرصيد المستحق</div>
                @if($amountDue > 0.0001)
                    <p class="stat-card-value mb-0">{{ number_format($amountDue, 2) }} ₪</p>
                    <p class="small text-danger mb-0 mt-1">مستحق على المشترك</p>
                @elseif($amountDue < -0.0001)
                    <p class="stat-card-value mb-0" style="color: var(--success-gradient);">{{ number_format(abs($amountDue), 2) }} ₪</p>
                    <p class="small text-success mb-0 mt-1">زائد لصالح المشترك</p>
                @else
                    <p class="stat-card-value mb-0">0.00 ₪</p>
                    <p class="small text-muted mb-0 mt-1">لا يوجد مستحق</p>
                @endif
                <p class="small text-muted mb-0 mt-1">مطابق لـ «دين المشترك» في الفلاتر</p>
            </div>
        </div>
    </div>

    <div class="row g-3 g-md-4">
        <div class="col-md-4">
            <div class="stat-card-modern h-100 text-center">
                <div class="stat-card-icon mx-auto"><i class="la la-wine-bottle"></i></div>
                <div class="stat-card-label">رصيد القوارير عنده</div>
                <p class="stat-card-value mb-2">{{ (int) ($bottleSnapshot['bottle_balance'] ?? 0) }}</p>
                <p class="mb-0 small fw-bold text-muted px-2 py-2" style="background: #f1f5f9; border-radius: 12px;">
                    {{ (int) ($bottleSnapshot['total_bottle_received'] ?? 0) }}
                    <span class="opacity-75">−</span>
                    {{ (int) ($bottleSnapshot['total_bottle_empty'] ?? 0) }}
                    <span class="opacity-75">=</span>
                    {{ (int) ($bottleSnapshot['bottle_balance'] ?? 0) }}
                </p>
                <p class="small text-muted mb-0 mt-2">ممتلئة − فارغة (كل التسليمات)</p>
            </div>
        </div>
        <div class="col-md-8">
            <div class="stat-card-modern h-100">
                <div class="stat-card-icon"><i class="la la-hand-holding"></i></div>
                <div class="stat-card-label">الأمانات (غير مسحوبة)</div>
                @if(count($deposits) > 0)
                    <table class="table table-sm mb-0 mt-2">
                        <thead>
                            <tr>
                                <th>الصنف</th>
                                <th class="text-end">الكمية</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deposits as $itemName => $qty)
                                <tr>
                                    <td>{{ $itemName }}</td>
                                    <td class="text-end fw-bold">{{ (int) $qty }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p class="small text-muted mb-0 mt-2">{{ (int) ($statement['active_deposit_count'] ?? 0) }} سجل أمانة نشط</p>
                @else
                    <p class="text-muted mb-0 mt-2">لا توجد أمانات معارة حالياً.</p>
                @endif
            </div>
        </div>
    </div>

    @if($billingParentId > 0)
        <div class="d-flex flex-wrap gap-2 mt-4 justify-content-start">
            <a href="{{ backpack_url('client/' . $billingParentId . '/show') }}" class="btn btn-sm btn-outline-primary" style="border-radius: 10px;">
                <i class="la la-eye"></i> ملف المشترك
            </a>
            <a href="{{ backpack_url('client-deposit?client_id=' . $billingParentId) }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 10px;">
                <i class="la la-hand-holding"></i> أمانات المشترك
            </a>
            <a href="{{ route('client.report', ['client_id' => (int) ($statement['display_client_id'] ?? $billingParentId)]) }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 10px;">
                <i class="la la-list"></i> سجل التسليمات
            </a>
        </div>
    @endif
</div>
