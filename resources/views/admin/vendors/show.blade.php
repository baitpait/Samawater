@extends(backpack_view('blank'))

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    <style>
        .vendor-show-header {
            background: linear-gradient(135deg, #0f766e 0%, #115e59 100%);
            border-radius: 20px;
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            color: #fff;
        }
        .vendor-show-header h2 { margin: 0; font-weight: 800; font-size: 1.5rem; }
        .vendor-show-header .sub { opacity: 0.9; font-size: 0.95rem; margin-top: 0.35rem; }
        .balance-hero {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%);
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            color: #fff;
            box-shadow: var(--shadow-md);
        }
        .balance-hero .value { font-size: 2rem; font-weight: 900; }
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
            color: #0f766e;
        }
        .detail-card .card-body { padding: 1.25rem 1.5rem; }
        .detail-row { margin-bottom: 0.65rem; }
        .detail-row strong {
            color: #64748b;
            font-weight: 600;
            display: inline-block;
            min-width: 140px;
        }
        .summary-pill {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.85rem 1rem;
            text-align: center;
        }
        .summary-pill .label { font-size: 0.8rem; color: #64748b; }
        .summary-pill .val { font-size: 1.1rem; font-weight: 800; color: #1e293b; }
        .action-btn {
            border-radius: 12px;
            font-weight: 700;
            padding: 12px;
            color: #fff;
        }
        .mini-table th { font-size: 12px; background: #f8fafc; }
        .mini-table td { font-size: 13px; }
    </style>
@endsection

@section('content')
@php
    $vendor = $entry;
    $summary = $financialSummary ?? [];
    $balance = (float) ($summary['balance'] ?? 0);
    $paymentStatusLabels = [
        'paid' => 'مدفوع',
        'partial' => 'جزئي',
        'unpaid' => 'غير مدفوع',
    ];
    $invoiceStatusLabels = [
        'draft' => 'مسودة',
        'confirmed' => 'مؤكدة',
        'cancelled' => 'ملغاة',
    ];
    $methodLabels = [
        'cash' => 'نقدي',
        'bank_transfer' => 'تحويل بنكي',
        'check' => 'شيك',
        'credit_card' => 'بطاقة ائتمان',
        'other' => 'أخرى',
    ];
@endphp

<div class="container-fluid pb-4">
    <div class="vendor-show-header d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2><i class="la la-truck"></i> معاينة مورد</h2>
            <div class="sub">{{ $vendor->name }}</div>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ url($crud->route) }}" class="btn btn-light btn-sm">
                <i class="la la-arrow-right"></i> قائمة الموردين
            </a>
            <a href="{{ url($crud->route.'/'.$vendor->id.'/edit') }}" class="btn btn-light btn-sm">
                <i class="la la-edit"></i> تعديل
            </a>
        </div>
    </div>

    <div class="card mb-4" style="border-radius: 20px; border: none; box-shadow: var(--shadow-sm);">
        <div class="card-body p-4">
            <div class="row g-3">
                @if(config('features.purchase_invoices', true))
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ backpack_url('purchase-invoice/create?vendor_id='.$vendor->id) }}" class="btn w-100 action-btn" style="background: #059669;">
                        <i class="la la-plus"></i> فاتورة مشتريات
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ backpack_url('purchase-invoice?vendor_id='.$vendor->id) }}" class="btn w-100 action-btn" style="background: #0d9488;">
                        <i class="la la-shopping-cart"></i> فواتير المشتريات
                    </a>
                </div>
                @endif
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ backpack_url('vendor-payment/create?vendor_id='.$vendor->id) }}" class="btn w-100 action-btn" style="background: #6366f1;">
                        <i class="la la-money-bill"></i> إضافة دفعة
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ backpack_url('vendor-payment?vendor_id='.$vendor->id) }}" class="btn w-100 action-btn" style="background: #3b82f6;">
                        <i class="la la-list"></i> مدفوعات المورد
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ backpack_url('expense?vendor_id='.$vendor->id) }}" class="btn w-100 action-btn" style="background: #f59e0b;">
                        <i class="la la-receipt"></i> مصروفات مرتبطة
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="balance-hero h-100 d-flex flex-column justify-content-center">
                <div class="small opacity-90">الرصيد الحالي (مستحق للمورد)</div>
                <div class="value {{ $balance >= 0 ? '' : 'text-warning' }}">₪ {{ number_format($balance, 2) }}</div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row g-3 h-100">
                <div class="col-6 col-md-3">
                    <div class="summary-pill h-100">
                        <div class="label">رصيد افتتاحي</div>
                        <div class="val">₪ {{ number_format((float) ($summary['opening_balance'] ?? 0), 2) }}</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="summary-pill h-100">
                        <div class="label">مصروفات</div>
                        <div class="val">₪ {{ number_format((float) ($summary['total_expenses'] ?? 0), 2) }}</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="summary-pill h-100">
                        <div class="label">مشتريات مؤكدة</div>
                        <div class="val">₪ {{ number_format((float) ($summary['total_purchases'] ?? 0), 2) }}</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="summary-pill h-100">
                        <div class="label">مدفوعات</div>
                        <div class="val">₪ {{ number_format((float) ($summary['total_payments'] ?? 0), 2) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="detail-card h-100">
                <div class="card-head">بيانات المورد</div>
                <div class="card-body">
                    <div class="detail-row"><strong>الاسم:</strong> <span>{{ $vendor->name }}</span></div>
                    <div class="detail-row"><strong>الهاتف:</strong> <span>{{ $vendor->phone ?: '—' }}</span></div>
                    <div class="detail-row"><strong>البريد:</strong> <span>{{ $vendor->email ?: '—' }}</span></div>
                    <div class="detail-row"><strong>العنوان:</strong> <span>{{ $vendor->address ?: '—' }}</span></div>
                    <div class="detail-row"><strong>الحالة:</strong>
                        @if($vendor->is_active)
                        <span class="badge bg-success">نشط</span>
                        @else
                        <span class="badge bg-secondary">غير نشط</span>
                        @endif
                    </div>
                    @if($vendor->notes)
                    <div class="detail-row mt-2 pt-2 border-top"><strong>ملاحظات:</strong></div>
                    <p class="mb-0" style="white-space: pre-wrap;">{{ $vendor->notes }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="detail-card h-100">
                <div class="card-head">معادلة الرصيد</div>
                <div class="card-body small text-muted">
                    <p class="mb-2">الرصيد = الرصيد الافتتاحي + المصروفات المرتبطة + فواتير المشتريات المؤكدة − المدفوعات</p>
                    <p class="mb-0 fw-bold text-dark">
                        ₪ {{ number_format((float) ($summary['opening_balance'] ?? 0), 2) }}
                        + ₪ {{ number_format((float) ($summary['total_expenses'] ?? 0), 2) }}
                        + ₪ {{ number_format((float) ($summary['total_purchases'] ?? 0), 2) }}
                        − ₪ {{ number_format((float) ($summary['total_payments'] ?? 0), 2) }}
                        = <span class="{{ $balance >= 0 ? 'text-success' : 'text-danger' }}">₪ {{ number_format($balance, 2) }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if(($recentPurchaseInvoices ?? collect())->isNotEmpty())
    <div class="detail-card">
        <div class="card-head d-flex justify-content-between align-items-center">
            <span>آخر فواتير المشتريات</span>
            <a href="{{ backpack_url('purchase-invoice?vendor_id='.$vendor->id) }}" class="btn btn-sm btn-outline-secondary">عرض الكل</a>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-sm mini-table mb-0">
                <thead>
                    <tr>
                        <th>الرقم</th>
                        <th>التاريخ</th>
                        <th>الإجمالي</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentPurchaseInvoices as $inv)
                    <tr>
                        <td><a href="{{ backpack_url('purchase-invoice/'.$inv->id.'/show') }}">{{ $inv->invoice_number }}</a></td>
                        <td>{{ $inv->invoice_date?->format('Y-m-d') }}</td>
                        <td>₪ {{ number_format((float) $inv->total_amount, 2) }}</td>
                        <td>{{ $invoiceStatusLabels[$inv->status] ?? $inv->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if(($recentPayments ?? collect())->isNotEmpty())
    <div class="detail-card">
        <div class="card-head d-flex justify-content-between align-items-center">
            <span>آخر المدفوعات</span>
            <a href="{{ backpack_url('vendor-payment?vendor_id='.$vendor->id) }}" class="btn btn-sm btn-outline-secondary">عرض الكل</a>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-sm mini-table mb-0">
                <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>المبلغ</th>
                        <th>الطريقة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentPayments as $pay)
                    <tr>
                        <td>{{ $pay->payment_date?->format('Y-m-d') }}</td>
                        <td>₪ {{ number_format((float) $pay->amount, 2) }}</td>
                        <td>{{ $methodLabels[$pay->method] ?? $pay->method }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if(($recentExpenses ?? collect())->isNotEmpty())
    <div class="detail-card">
        <div class="card-head d-flex justify-content-between align-items-center">
            <span>آخر المصروفات المرتبطة (قديمة)</span>
            <a href="{{ backpack_url('expense?vendor_id='.$vendor->id) }}" class="btn btn-sm btn-outline-secondary">عرض الكل</a>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-sm mini-table mb-0">
                <thead>
                    <tr>
                        <th>تاريخ الدفع</th>
                        <th>المبلغ</th>
                        <th>حالة الدفع</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentExpenses as $exp)
                    <tr>
                        <td>{{ $exp->payment_date?->format('Y-m-d') }}</td>
                        <td>₪ {{ number_format((float) $exp->total_amount, 2) }}</td>
                        <td>{{ $paymentStatusLabels[$exp->payment_status] ?? $exp->payment_status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
