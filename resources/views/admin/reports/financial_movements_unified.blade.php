@extends(backpack_view('blank'))

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">
    <style>
        /* نصوص هذه الصفحة كلها سوداء للوضوح */
        .page-financial-unified-black,
        .page-financial-unified-black h1,
        .page-financial-unified-black h5,
        .page-financial-unified-black h6,
        .page-financial-unified-black p,
        .page-financial-unified-black label,
        .page-financial-unified-black th,
        .page-financial-unified-black td,
        .page-financial-unified-black .small,
        .page-financial-unified-black small,
        .page-financial-unified-black li,
        .page-financial-unified-black ul,
        .page-financial-unified-black strong,
        .page-financial-unified-black span,
        .page-financial-unified-black .alert,
        .page-financial-unified-black .text-muted,
        .page-financial-unified-black .text-secondary,
        .page-financial-unified-black .text-success,
        .page-financial-unified-black .text-danger {
            color: #000 !important;
        }
        .page-financial-unified-black .btn-primary {
            background-color: #000 !important;
            border-color: #000 !important;
            color: #fff !important;
        }
        .page-financial-unified-black .form-control {
            color: #000 !important;
        }
        .page-financial-unified-black a {
            color: #000 !important;
            text-decoration: underline;
        }
    </style>
@endsection

@section('header')
    <section class="page-financial-unified-black header-operation container-fluid animated fadeIn d-flex mb-3 align-items-center d-print-none"
        bp-section="page-header"
        style="background: #f1f3f5 !important; border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 1rem; border: 1px solid #dee2e6;">
        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <div style="width: 56px; height: 56px; background: rgba(0,0,0,0.06); border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                <i class="la la-stream" style="font-size: 28px; color: #000;"></i>
            </div>
            <div>
                <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #000 !important; font-size: 24px; font-weight: 800;">الحركة المالية الشاملة</h1>
                <div class="mt-1" style="color: #000 !important; font-size: 14px;">
                    دفعات المشتركين، موردين، فواتير مؤكّدة، ومصروفات — بحسب كل باب وفترة
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
@php
    $s = $ledger['summary'];
@endphp
<div class="page-financial-unified-black container-fluid pb-5">
    @if(session('error'))
        <div class="alert alert-warning border-0 mb-3" style="border-radius: 12px;">{{ session('error') }}</div>
    @endif

    <div class="card filter-card mb-4 shadow-sm border-0" style="border-radius: 16px;">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('reports.financial-movements-unified') }}" class="row g-3 align-items-end">
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
                        عرض
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="alert alert-secondary border-0 mb-3">
        الفترة: <strong>{{ $ledger['period']['from'] }}</strong> إلى <strong>{{ $ledger['period']['to'] }}</strong>
    </div>

    <div class="alert alert-light border mb-4" style="border-radius: 12px;" role="note">
        <p class="fw-bold mb-2"><i class="la la-info-circle" aria-hidden="true"></i> رصيد الصندوق والكاش الفعلي</p>
        <p class="small mb-2 mb-md-1">
            الأرقام أدناه <strong>مجاميع لنفس الفترة</strong> وليست «كم كاش معي الآن في الدرج». رصيد الصندوق الحقيقي = <strong>رصيد افتتاحي قبل الفترة</strong> ثم + وارد نقدي − صادر نقدي (حتى تاريخك)، أو <strong>عدّ/جرد</strong> على أرض الواقع.
        </p>
        <p class="small mb-2 mb-md-1">
            <strong>صافي نقود تجريبي</strong> (عملاء − موردين) مؤشر مختصر للفترة ومطابق لمنطق صندوق الشركة؛ الفواتير المؤكّدة والمصروفات تُعرَض بمعنى مختلف في البطاقات.
        </p>
        <p class="small mb-0">
            <strong>سحوبات الموزّعين</strong> (تسليم عهدة للمقر) لا تظهر هنا لتجنّب الازدواج مع مدفوعات المشتركين — راجع <a href="{{ route('reports.treasury-custody') }}" class="fw-bold text-decoration-underline">الصندوق المالي (عهدة)</a>.
        </p>
    </div>

    <h6 class="fw-bold mb-3 text-secondary">خلاصات سريعة (نقد وذمة)</h6>
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="p-3 rounded-3 border bg-success bg-opacity-10">
                <div class="small text-muted">ما دفعته العملاء (نقد)</div>
                <div class="fs-5 fw-bold">₪ {{ number_format($s['cash_in_from_clients'], 2) }}</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="p-3 rounded-3 border bg-danger bg-opacity-10">
                <div class="small text-muted">ما دفعتم للموردين (نقد)</div>
                <div class="fs-5 fw-bold">₪ {{ number_format($s['cash_out_to_vendors'], 2) }}</div>
                <div class="small mt-2">
                    <a href="{{ backpack_url('vendor-payment?' . http_build_query(['date_from' => $ledger['period']['from'], 'date_to' => $ledger['period']['to']])) }}" class="text-decoration-underline">قائمة مدفوعات الموردين لهذه الفترة</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="p-3 rounded-3 border">
                <div class="small text-muted">مبيعات الفواتير المؤكّدة (عملاء)</div>
                <div class="fs-6 fw-bold">₪ {{ number_format($s['sales_on_invoices_confirmed'], 2) }}</div>
                <div class="small text-muted mt-1">ليست كلها كاش اليوم؛ تُقيَّد وفق تأكيد الفاتورة</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="p-3 rounded-3 border">
                <div class="small text-muted">مجموع مصروفات بنفس أيام الدفع المعروضة</div>
                <div class="fs-6 fw-bold">₪ {{ number_format($s['expenses_recorded_dates'], 2) }}</div>
                <div class="small text-muted mt-1">قد يتوازى جزئياً مع دفع مورد</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="p-3 rounded-3 border border-warning">
                <div class="small text-muted">صافي نقود تجريبي (عملاء − موردين)</div>
                <div class="fs-6 fw-bold">₪ {{ number_format($s['net_cash_clients_minus_vendors'], 2) }}</div>
                <div class="small text-muted mt-1">مطابق لصافي وارد صندوق الشركة في الفترة</div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0">جدول الحركة (الأحدث أولاً)</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-clean align-middle mb-0 small">
                    <thead>
                        <tr>
                            <th class="ps-4">اليوم</th>
                            <th>الباب</th>
                            <th>التفاصيل</th>
                            <th class="text-end">وارد نقد</th>
                            <th class="text-end">صادر نقد</th>
                            <th class="text-end pe-4">مبلغ آخر غير نقود*</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($ledger['rows'] as $row)
                        <tr>
                            <td class="ps-4 text-nowrap">{{ $row['occurred_date'] }}</td>
                            <td>{{ $row['gate_ar'] }}</td>
                            <td>{{ $row['detail'] }}</td>
                            <td class="text-end text-success">{{ $row['cash_in'] !== null ? '₪ ' . number_format($row['cash_in'], 2) : '—' }}</td>
                            <td class="text-end text-danger">{{ $row['cash_out'] !== null ? '₪ ' . number_format($row['cash_out'], 2) : '—' }}</td>
                            <td class="text-end pe-4">{{ $row['non_cash_amount'] !== null ? '₪ ' . number_format($row['non_cash_amount'], 2) : '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">لا حركة مسجَّلة لهذه الفترة</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4 small text-muted">
        <p class="fw-bold mb-1">قراءات مهمة:</p>
        <ul class="mb-1 ps-3">
            <li>لا يُكرَّر تحصيل التسليم المعادل لدفعة عميل: نعرض مسار <strong>مدفوعات المشتركين</strong> وحده كنقد من الزبائن.</li>
            <li>سحوبات الموزّعين (عهدة → المقر) في <a href="{{ route('reports.treasury-custody') }}">الصندوق المالي (عهدة)</a> وليس هنا.</li>
            <li>الفاتورة المؤكّدة والمصروف في عمود «غير نقد بالمعنى الضيق» لتفريقها عن عمود الوارد أو الصادر النقدى.</li>
        </ul>
        <span id="footnote-star">*</span> فواتير مؤكّدة ومصروفات مسجّلة بتواريخ مختلفة عن نقد بعضها الآخر.
    </div>
</div>
@endsection
