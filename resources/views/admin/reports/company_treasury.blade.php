@extends(backpack_view('blank'))

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">
    <style>
        /* نصوص صفحة صندوق الشركة بالأسود للوضوح */
        .page-company-treasury-black,
        .page-company-treasury-black h1,
        .page-company-treasury-black h5,
        .page-company-treasury-black h6,
        .page-company-treasury-black p,
        .page-company-treasury-black label,
        .page-company-treasury-black th,
        .page-company-treasury-black td,
        .page-company-treasury-black .small,
        .page-company-treasury-black small,
        .page-company-treasury-black li,
        .page-company-treasury-black ul,
        .page-company-treasury-black strong,
        .page-company-treasury-black span,
        .page-company-treasury-black .alert,
        .page-company-treasury-black .text-muted,
        .page-company-treasury-black .text-secondary,
        .page-company-treasury-black .text-success,
        .page-company-treasury-black .text-danger {
            color: #000 !important;
        }
        .page-company-treasury-black .btn-primary {
            background-color: #000 !important;
            border-color: #000 !important;
            color: #fff !important;
        }
        .page-company-treasury-black .form-control {
            color: #000 !important;
        }
        .page-company-treasury-black a {
            color: #000 !important;
            text-decoration: underline;
        }
    </style>
@endsection

@section('header')
    <section class="page-company-treasury-black header-operation container-fluid animated fadeIn d-flex mb-3 align-items-center d-print-none"
        bp-section="page-header"
        style="background: #f1f3f5 !important; border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 1rem; border: 1px solid #dee2e6;">
        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <div style="width: 56px; height: 56px; background: rgba(0,0,0,0.06); border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                <i class="la la-coins" style="font-size: 28px; color: #000;"></i>
            </div>
            <div>
                <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #000 !important; font-size: 24px; font-weight: 800;">صندوق الشركة</h1>
                <div class="mt-1" style="color: #000 !important; font-size: 14px;">
                    داخل الصندوق: تسليمات، فواتير، ومدفوعات المشتركين المسجّلة · خارج الصندوق: المشتريات والمصروفات — بحسب الفترة
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
@php
    $p = $summary['period'];
    $inflow = $summary['inflow'];
    $outflow = $summary['outflow'];
    $net = $summary['net_period_movement'];
@endphp

<div class="page-company-treasury-black container-fluid pb-5">
    @if(session('error'))
        <div class="alert alert-warning border-0 mb-3" style="border-radius: 12px;">{{ session('error') }}</div>
    @endif

    <div class="card filter-card mb-4 shadow-sm border-0" style="border-radius: 16px;">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('reports.company-treasury') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold">من</label>
                    <input type="date" name="from" class="form-control" value="{{ $fromInput }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">إلى</label>
                    <input type="date" name="to" class="form-control" value="{{ $toInput }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100" style="height: 46px; font-weight: 700; border-radius: 12px;">
                        <i class="la la-search"></i> عرض
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="alert alert-light border mb-4" style="border-radius: 12px;">
        <span class="fw-bold">الفترة:</span>
        <span>{{ $p['from'] }}</span>
        <span class="mx-1">←</span>
        <span>{{ $p['to'] }}</span>
    </div>

    <h6 class="fw-bold mb-3 text-secondary">داخل الصندوق (وارد)</h6>
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="p-4 h-100 border rounded-3 bg-success bg-opacity-10">
                <div class="small text-muted mb-1">تسليمات — نقد مسجّل على التسليم</div>
                <div class="fs-4 fw-bold">₪ {{ number_format($inflow['deliveries_cash_on_delivery'], 2) }}</div>
                <div class="small text-muted mt-2">مجموع حقل الدفع في التسليمات بحسب تاريخ التسليم</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="p-4 h-100 border rounded-3 bg-primary bg-opacity-10">
                <div class="small text-muted mb-1">مبيعات — فواتير مؤكّدة</div>
                <div class="fs-4 fw-bold">₪ {{ number_format($inflow['confirmed_invoice_sales'], 2) }}</div>
                <div class="small text-muted mt-2">إجمالي فواتير الحالة «مؤكّد» بحسب تاريخ الفاتورة</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="p-4 h-100 border rounded-3 bg-info bg-opacity-10">
                <div class="small text-muted mb-1">مدفوعات المشتركين المسجّلة</div>
                <div class="fs-4 fw-bold">₪ {{ number_format($inflow['registered_client_payments'], 2) }}</div>
                <div class="small text-muted mt-2">مبالغ مسجَّلة من «مدفوعات المشتركين» بحسب تاريخ الدفع؛ تُحتسب كلها في الإجمالي</div>
                <div class="small text-muted mt-2 border-top pt-2">منها مدفوعات مفعّل لها «لدين مستقبلي» عند الإدخال: <span class="fw-bold">₪ {{ number_format($inflow['registered_client_payments_future_obligation'], 2) }}</span></div>
            </div>
        </div>
        <div class="col-12">
            <div class="p-4 border rounded-3 border-success border-2">
                <div class="small text-muted mb-1">إجمالي الوارد (+ تسليمات + فواتير + مدفوعات مسجّلة)</div>
                <div class="fs-3 fw-bold text-success">₪ {{ number_format($inflow['total_in'], 2) }}</div>
            </div>
        </div>
    </div>

    <h6 class="fw-bold mb-3 text-secondary">خارج الصندوق (صادر)</h6>
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="p-4 h-100 border rounded-3 bg-danger bg-opacity-10">
                <div class="small text-muted mb-1">مشتريات — مدفوعات الموردين</div>
                <div class="fs-4 fw-bold">₪ {{ number_format($outflow['vendor_purchases'], 2) }}</div>
                <div class="small text-muted mt-2">مجموع «مدفوعات الموردين» في النظام بحسب تاريخ الدفع؛ يطابق مجموع عمود هذه الفترة في الكشف التفصيلي</div>
                <div class="small mt-2">
                    <a href="{{ backpack_url('vendor-payment?' . http_build_query(['date_from' => $p['from'], 'date_to' => $p['to']])) }}" class="fw-bold">عرض قائمة مدفوعات المورد لهذه الفترة</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="p-4 h-100 border rounded-3 bg-warning bg-opacity-10">
                <div class="small text-muted mb-1">مصروفات</div>
                <div class="fs-4 fw-bold">₪ {{ number_format($outflow['expenses'], 2) }}</div>
                <div class="small text-muted mt-2">بحسب تاريخ دفع المصروف</div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4">
            <div class="p-4 h-100 border rounded-3 border-danger border-2">
                <div class="small text-muted mb-1">إجمالي الصادر (مشتريات + مصروفات)</div>
                <div class="fs-3 fw-bold text-danger">₪ {{ number_format($outflow['total_out'], 2) }}</div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <div class="fw-bold mb-1">صافي حركة الفترة (وارد − صادر)</div>
                    <div class="small text-muted">مؤشر للفترة المختارة؛ ليس رصيد كاش نهائياً في اليد دون رصيد افتتاحي أو جرد</div>
                </div>
                <div class="fs-2 fw-bold @if($net >= 0) text-success @else text-danger @endif">
                    ₪ {{ number_format($net, 2) }}
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-secondary border-0 small mb-0" style="border-radius: 12px;">
        <p class="fw-bold mb-2">قراءة مهمة</p>
        <ul class="mb-0 ps-3">
            <li>فعِّل خيار «لدين مستقبلي» عند تسجيل دفعة تحصيل لمستحقات لاحقة كي تظهر مفصَّلة في هذا التقرير؛ المبلغ لا يُضاف مرتين — هو جزء من «مدفوعات المشتركين».</li>
            <li>قد يتداخل سطر التسليمات أو الفواتير مع المدفوعات المسجّلة؛ استخدم الأرقام كملخص تشغيلي.</li>
            <li><a href="{{ backpack_url('vendor-payment?' . http_build_query(['date_from' => $p['from'], 'date_to' => $p['to']])) }}" class="fw-bold">صفحة مدفوعات الموردين</a> لفترة التقرير تعرض نفس الأسطر التي يُجمَّع مجموعها في «مشتريات — مدفوعات الموردين». قد تتداخل أحياناً مسجَّلات المصروفات مع دفع مورد مرتبط؛ راجع السجل عند المواءمة.</li>
            <li>لتفصيل الحركة من كل الأبواب راجع <a href="{{ route('reports.financial-movements-unified') }}" class="fw-bold">الحركة المالية الشاملة</a>.</li>
        </ul>
    </div>
</div>
@endsection
