@extends(backpack_view('blank'))

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    <style>
        .payment-show-header {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%);
            border-radius: 20px;
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            color: #fff;
        }
        .payment-show-header h2 { margin: 0; font-weight: 800; font-size: 1.5rem; }
        .payment-show-header .sub { opacity: 0.9; font-size: 0.95rem; margin-top: 0.35rem; }
        .payment-amount-hero {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            color: #fff;
            margin-bottom: 1.25rem;
            box-shadow: var(--shadow-md);
        }
        .payment-amount-hero .label { font-size: 0.9rem; opacity: 0.9; }
        .payment-amount-hero .value { font-size: 2.25rem; font-weight: 900; line-height: 1.2; }
        .detail-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            margin-bottom: 1.25rem;
            overflow: hidden;
        }
        .detail-card .card-head {
            background: #f8fafc;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 700;
            color: var(--primary-deep);
        }
        .detail-card .card-body { padding: 1.25rem 1.5rem; }
        .detail-row { margin-bottom: 0.75rem; }
        .detail-row strong {
            color: #64748b;
            font-weight: 600;
            display: inline-block;
            min-width: 155px;
        }
        .detail-row span { color: #1e293b; font-weight: 600; }
    </style>
@endsection

@section('content')
@php
    $paymentMethodLabels = [
        'cash' => 'نقدي',
        'bank_transfer' => 'تحويل بنكي',
        'check' => 'شيك',
        'credit_card' => 'بطاقة ائتمان',
        'other' => 'أخرى',
    ];
    $amount = (float) ($entry->amount ?? 0);
    $linkedDelivery = $entry->linkedDelivery;
    $isInvoiceNote = is_string($entry->notes ?? null) && str_contains($entry->notes, 'فاتورة');
@endphp

<div class="container-fluid pb-4">
    <div class="payment-show-header d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2><i class="la la-money-bill-wave"></i> معاينة دفعة مشترك</h2>
            <div class="sub">#{{ $entry->id }} — {{ $entry->client->name ?? '—' }}</div>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ url($crud->route) }}" class="btn btn-light btn-sm">
                <i class="la la-arrow-right"></i> قائمة المدفوعات
            </a>
            <a href="{{ url($crud->route.'/'.$entry->id.'/edit') }}" class="btn btn-light btn-sm">
                <i class="la la-edit"></i> تعديل
            </a>
            @if($entry->client_id)
            <a href="{{ backpack_url('client/'.$entry->client_id.'/show') }}" class="btn btn-light btn-sm">
                <i class="la la-user"></i> ملف المشترك
            </a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="payment-amount-hero h-100 d-flex flex-column justify-content-center">
                <div class="label">مبلغ الدفعة</div>
                <div class="value">₪ {{ number_format($amount, 2) }}</div>
                <div class="mt-2 small">
                    {{ $paymentMethodLabels[$entry->payment_method] ?? $entry->payment_method }}
                    @if($entry->payment_date)
                        — {{ $entry->payment_date->format('Y-m-d') }}
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="detail-card h-100">
                <div class="card-head">بيانات المشترك</div>
                <div class="card-body">
                    <div class="detail-row"><strong>المشترك:</strong>
                        @if($entry->client)
                        <a href="{{ backpack_url('client/'.$entry->client_id.'/show') }}">{{ $entry->client->name }}</a>
                        @else
                        <span>—</span>
                        @endif
                    </div>
                    <div class="detail-row"><strong>رقم العقد:</strong>
                        <span>{{ $entry->client->contract_no ?? '—' }}</span>
                    </div>
                    <div class="detail-row"><strong>الهاتف:</strong>
                        <span>{{ $entry->client->phone_one ?? '—' }}</span>
                    </div>
                    <div class="detail-row"><strong>دفعة لدين مستقبلي:</strong>
                        @if($entry->for_future_obligation)
                        <span class="badge bg-info">نعم — تحصيل مقدّم</span>
                        @else
                        <span class="badge bg-secondary">لا — خصم من مسار الفواتير</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="detail-card h-100">
                <div class="card-head">تفاصيل الدفع</div>
                <div class="card-body">
                    <div class="detail-row"><strong>تاريخ الدفع:</strong>
                        <span>{{ $entry->payment_date ? $entry->payment_date->format('Y-m-d') : '—' }}</span>
                    </div>
                    <div class="detail-row"><strong>طريقة الدفع:</strong>
                        <span>{{ $paymentMethodLabels[$entry->payment_method] ?? $entry->payment_method }}</span>
                    </div>
                    <div class="detail-row"><strong>الرقم المرجعي:</strong>
                        <span>{{ $entry->reference_number ?: '—' }}</span>
                    </div>
                    <div class="detail-row"><strong>سجّلها:</strong>
                        <span>{{ $entry->creator->name ?? '—' }}</span>
                    </div>
                    <div class="detail-row"><strong>تاريخ التسجيل:</strong>
                        <span>{{ $entry->created_at ? $entry->created_at->format('Y-m-d H:i') : '—' }}</span>
                    </div>
                    @if($entry->updated_at && $entry->updated_at->ne($entry->created_at))
                    <div class="detail-row"><strong>آخر تحديث:</strong>
                        <span>{{ $entry->updated_at->format('Y-m-d H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="detail-card h-100">
                <div class="card-head">مصدر الدفعة والربط</div>
                <div class="card-body">
                    @if($linkedDelivery)
                    <div class="alert alert-warning mb-3" style="border-radius: 12px;">
                        <strong><i class="la la-truck"></i> مرتبطة بتسليم</strong>
                        <p class="mb-2 small mt-1">هذه الدفعة مُسجَّلة على سطر التسليم ولا تُخصم مرة أخرى من رصيد الفواتير (ADR-003).</p>
                        <ul class="mb-0 small ps-3">
                            <li>رقم التسليم: #{{ $linkedDelivery->id }}</li>
                            <li>التاريخ: {{ $linkedDelivery->delivery_date ? \Carbon\Carbon::parse($linkedDelivery->delivery_date)->format('Y-m-d') : '—' }}</li>
                            <li>المطلوب: ₪ {{ number_format((float) ($linkedDelivery->required_amount ?? 0), 2) }}</li>
                            <li>المدفوع على التسليم: ₪ {{ number_format((float) ($linkedDelivery->paymant ?? 0), 2) }}</li>
                        </ul>
                        <a href="{{ backpack_url('delivery/'.$linkedDelivery->id.'/edit') }}" class="btn btn-sm btn-outline-dark mt-2">
                            <i class="la la-external-link-alt"></i> فتح التسليم
                        </a>
                    </div>
                    @elseif($isInvoiceNote)
                    <div class="alert alert-info mb-3" style="border-radius: 12px;">
                        <strong><i class="la la-file-invoice"></i> دفعة من فاتورة مبيعات</strong>
                        <p class="mb-0 small mt-1">تم إنشاؤها تلقائياً عند حفظ الفاتورة (راجع الملاحظات أدناه).</p>
                    </div>
                    @else
                    <div class="alert alert-success mb-3" style="border-radius: 12px;">
                        <strong><i class="la la-wallet"></i> دفعة مستقلة</strong>
                        <p class="mb-0 small mt-1">تُخصم من مسار الفواتير والرصيد الافتتاحي للمشترك (ليست مرتبطة بتسليم).</p>
                    </div>
                    @endif

                    @if($entry->notes)
                    <div class="detail-row mt-2 pt-2 border-top"><strong>ملاحظات:</strong></div>
                    <p class="mb-0" style="white-space: pre-wrap; color: #334155;">{{ $entry->notes }}</p>
                    @else
                    <div class="detail-row"><strong>ملاحظات:</strong> <span class="text-muted">—</span></div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('reports.client-ledger', ['client_id' => $entry->client_id]) }}" class="btn btn-outline-primary btn-sm">
            <i class="la la-book"></i> كشف حساب مالي للمشترك
        </a>
        <a href="{{ route('reports.client-balance', ['client_id' => $entry->client_id]) }}" class="btn btn-outline-warning btn-sm">
            <i class="la la-file-invoice-dollar"></i> تقرير الرصيد
        </a>
    </div>
</div>
@endsection
