@extends(backpack_view('blank'))

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">
@endsection

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-3 align-items-center d-print-none"
        bp-section="page-header"
        style="background: var(--primary-deep) !important; border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 1rem; box-shadow: var(--shadow-md) !important;">
        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <div style="width: 56px; height: 56px; background: rgba(255,255,255,0.1); border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                <i class="la la-balance-scale" style="font-size: 28px; color: #fff;"></i>
            </div>
            <div>
                <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 800;">الصندوق المالي</h1>
                <div class="mt-1" style="color: rgba(255,255,255,0.85); font-size: 14px;">
                    النقد مع الموزِّع حتى السحب · الوصول إلى الشركة عند السحب
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
<div class="container-fluid pb-5">
    <div class="card filter-card mb-4 shadow-sm border-0" style="border-radius: 16px;">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('reports.treasury-custody') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold">من تاريخ</label>
                    <input type="date" name="from" class="form-control" value="{{ $fromInput }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">إلى تاريخ</label>
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

    @php
        $t = $summary['totals'];
        $p = $summary['period'];
        $lifetime = $summary['lifetime'];
        $slices = $summary['period_slices'] ?? [];
    @endphp

    <div class="alert alert-info border-0 mb-4" style="border-radius: 14px;">
        <div class="fw-bold mb-1">الفترة</div>
        <span>{{ $p['from_date'] }}</span>
        <span class="mx-1">←</span>
        <span>{{ $p['to_date'] }}</span>
    </div>

    <h6 class="fw-bold mb-3 text-secondary">منذ البداية</h6>
    <div class="row g-3 mb-4">
        <div class="col-lg-4 col-md-6">
            <div class="p-4 h-100 dashboard-stat-card" style="background: linear-gradient(135deg,#312e81,#4338ca); border-radius: 18px; color: #fff;">
                <div class="small text-white-50 mb-1">كل التحصيلات</div>
                <div class="fs-4 fw-bold">₪ {{ number_format($lifetime['total_field_collections'], 2) }}</div>
                <div class="small mt-2 opacity-75">من التسليمات</div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="p-4 h-100 dashboard-stat-card" style="background: linear-gradient(135deg,#92400e,#d97706); border-radius: 18px; color: #fff;">
                <div class="small text-white-50 mb-1">كل السحوبات للشركة</div>
                <div class="fs-4 fw-bold">₪ {{ number_format($lifetime['total_treasury_withdrawals_registered'], 2) }}</div>
                <div class="small mt-2 opacity-75">من سجل السحب</div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="p-4 h-100 dashboard-stat-card" style="background: linear-gradient(135deg,#1e3a5f,#2d5a87); border-radius: 18px; color: #fff;">
                <div class="small text-white-50 mb-1">الباقي مع الموزِّعين</div>
                <div class="fs-4 fw-bold">₪ {{ number_format($t['custody_with_distributors_now'], 2) }}</div>
                <div class="small mt-2 opacity-75">تحصيل ناقص سحوبات</div>
            </div>
        </div>
    </div>

    <h6 class="fw-bold mb-3 text-secondary">خلال الفترة</h6>
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="p-4 h-100 dashboard-stat-card" style="background: linear-gradient(135deg,#0f766e,#0d9488); border-radius: 18px; color: #fff;">
                <div class="small text-white-50 mb-1">تحصيل في الفترة</div>
                <div class="fs-3 fw-bold">₪ {{ number_format($t['period_field_collections_total'], 2) }}</div>
                <div class="small mt-2 opacity-75">بحسب أيام التسليم</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-4 h-100 dashboard-stat-card" style="background: linear-gradient(135deg,#7c2d12,#b45309); border-radius: 18px; color: #fff;">
                <div class="small text-white-50 mb-1">وصل الشركة من السحب</div>
                <div class="fs-3 fw-bold">₪ {{ number_format($t['period_treasury_in_from_withdrawals_total'], 2) }}</div>
                <div class="small mt-2 opacity-75">بحسب وقت تسجيل السحب في الفترة</div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
            <h5 class="mb-1 fw-bold">شهراً شهراً ضمن الفترة</h5>
            <small class="text-muted">آخر عمودَين: مجموع مرّة مع الأشهر حتى ذلك الشهر (منذ بداية الفترة المعروضة)</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-clean align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">الشهر</th>
                            <th>اليوم الأول — الأخير</th>
                            <th>تحصيل</th>
                            <th>سحب للشركة</th>
                            <th>مجموع تحصيل</th>
                            <th class="pe-4">مجموع سحب</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($slices as $slice)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $slice['label'] }}</td>
                            <td class="small text-muted">{{ $slice['from_date'] }} — {{ $slice['to_date'] }}</td>
                            <td>₪ {{ number_format($slice['field_collections'], 2) }}</td>
                            <td>₪ {{ number_format($slice['treasury_in_from_withdrawals'], 2) }}</td>
                            <td class="text-primary fw-bold">₪ {{ number_format($slice['running_field_collections_within_filter'], 2) }}</td>
                            <td class="pe-4 fw-bold" style="color: #b45309;">₪ {{ number_format($slice['running_treasury_in_within_filter'], 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">لا بيانات</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="mb-0 fw-bold">بحسب الموِّزِع</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-clean align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">الموزِّع</th>
                            <th>معه الآن</th>
                            <th>تحصيل الفترة</th>
                            <th>سحب الفترة</th>
                            <th class="pe-4">الفرق</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($summary['rows'] as $row)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $row['name'] }}</td>
                            <td>₪ {{ number_format($row['custody_now'], 2) }}</td>
                            <td>₪ {{ number_format($row['period_collections'], 2) }}</td>
                            <td>₪ {{ number_format($row['period_withdrawals_to_hq'], 2) }}</td>
                            <td class="pe-4 fw-bold {{ $row['period_net_delivery_vs_withdrawal'] >= 0 ? 'text-success' : 'text-danger' }}">
                                ₪ {{ number_format($row['period_net_delivery_vs_withdrawal'], 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">لا بيانات</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4 small text-muted">
        <p class="mb-1"><strong>تنبيهات:</strong></p>
        <ul class="mb-0 ps-3">
            <li>معه الآن = كل التحصيلات ناقص كل السحوبات لهذا الموزِّع من الأول.</li>
            <li>تاريخ السحب هو وقت التسجيل في النظام، وليس تاريخ التسليم.</li>
            <li>دفعات الزبائن في شاشات أخرى؛ هنا نظهر عهد السحوبات فقط.</li>
        </ul>
    </div>
</div>
@endsection
