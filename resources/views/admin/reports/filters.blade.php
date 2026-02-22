@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    <style>
        /* ===============================
           Reports Filters Page - تحسين صفحة التقارير الإحصائية
        =============================== */
        
        .reports-filters-container {
            background: var(--bg-light);
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        /* Header Section */
        .reports-header {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%) !important;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg) !important;
            position: relative;
            overflow: hidden;
        }
        
        .reports-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            z-index: 0;
        }
        
        .reports-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            z-index: 0;
        }
        
        .reports-header-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .reports-header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .reports-header-icon {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 18px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .reports-header-icon i {
            font-size: 32px;
            color: #fff;
            font-weight: 900;
        }
        
        .reports-header-title {
            color: #fff;
            font-size: 28px;
            font-weight: 900;
            margin: 0;
            font-family: 'Cairo', sans-serif;
        }
        
        .reports-header-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        
        .btn-export {
            background: rgba(255, 255, 255, 0.95) !important;
            color: var(--primary-deep) !important;
            font-weight: 700 !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            border: none !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
        }
        
        .btn-export:hover {
            background: #fff !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15) !important;
        }
        
        /* Filter Card */
        .filter-card-modern {
            background: #fff;
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            border: none;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        .filter-card-header {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%);
            padding: 1.25rem 2rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .filter-card-header i {
            font-size: 22px;
            color: #fff;
        }
        
        .filter-card-header h6 {
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }
        
        .filter-card-body {
            padding: 2rem;
        }
        
        .filter-form-rtl {
            direction: rtl;
        }
        
        .results-count-box {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%);
            border-radius: 16px;
            padding: 1rem 1.5rem;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        
        .results-count-box i {
            font-size: 28px;
            flex-shrink: 0;
        }
        
        .results-count-box span {
            font-size: 20px;
            font-weight: 800;
        }
        
        .form-label-modern {
            font-weight: 700;
            color: var(--primary-deep);
            margin-bottom: 0.75rem;
            font-size: 14px;
        }
        
        .form-control-modern,
        .form-select-modern {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #fff;
        }
        
        .form-control-modern:focus,
        .form-select-modern:focus {
            border-color: var(--primary-deep);
            box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.1);
            outline: none;
        }
        
        .btn-filter-submit {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%) !important;
            color: #fff !important;
            font-weight: 700 !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            border: none !important;
            height: 48px;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 12px rgba(30, 58, 95, 0.3) !important;
        }
        
        .btn-filter-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 58, 95, 0.4) !important;
        }
        
        .btn-add-client {
            background: linear-gradient(135deg, var(--success-gradient) 0%, #10b981 100%) !important;
            color: #fff !important;
            font-weight: 700 !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            border: none !important;
            height: 48px;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0.5rem !important;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3) !important;
        }
        
        .btn-add-client:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4) !important;
            color: #fff !important;
        }
        
        /* Table Card */
        .table-card-modern {
            background: #fff;
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            border: none;
            overflow: hidden;
        }
        
        .table-card-header-modern {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .table-card-header-modern i {
            font-size: 22px;
            color: #fff;
        }
        
        .table-card-header-modern h5 {
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }
        
        .table-modern {
            margin: 0;
        }
        
        .table-modern thead {
            background: var(--bg-light);
        }
        
        .table-modern thead th {
            font-weight: 700;
            color: var(--primary-deep);
            padding: 1rem;
            border-bottom: 2px solid #e2e8f0;
            font-size: 14px;
        }
        
        .table-modern tbody td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }
        
        .table-modern tbody tr:hover {
            background: var(--bg-light);
        }
        
        .badge-modern {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
        }
        
        .badge-primary-modern {
            background: var(--primary-deep) !important;
            color: #fff !important;
        }
        
        .badge-success-modern {
            background: var(--success-gradient) !important;
            color: #fff !important;
        }
        
        .badge-warning-modern {
            background: var(--warning-color) !important;
            color: #fff !important;
        }
        
        .badge-danger-modern {
            background: var(--danger-color) !important;
            color: #fff !important;
        }
        
        .badge-secondary-modern {
            background: #64748b !important;
            color: #fff !important;
        }
        
        .btn-action-modern {
            background: var(--primary-deep) !important;
            color: #fff !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease !important;
            font-size: 14px !important;
        }
        
        .btn-action-modern:hover {
            background: #254a7a !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 58, 95, 0.3);
        }
        
        .dropdown-menu-modern {
            border-radius: 12px !important;
            box-shadow: var(--shadow-lg) !important;
            border: 1px solid #f1f5f9 !important;
            padding: 0.5rem !important;
        }
        
        .dropdown-item-modern {
            border-radius: 8px !important;
            padding: 0.75rem 1rem !important;
            transition: all 0.2s ease !important;
            font-size: 14px !important;
        }
        
        .dropdown-item-modern:hover {
            background: var(--bg-light) !important;
            color: var(--primary-deep) !important;
        }
        
        .pagination-modern {
            direction: rtl;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .pagination-modern .pagination-modern-inner {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }
        .pagination-modern .pagination-modern-inner .pagination-info {
            flex-shrink: 0;
        }
        .pagination-modern .pagination-modern-inner .pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .pagination-modern .pagination-modern-inner .pagination .page-item {
            display: inline-block;
        }
        .pagination-modern .page-link {
            border-radius: 10px !important;
            border: 2px solid #e2e8f0 !important;
            color: var(--primary-deep) !important;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease !important;
        }
        
        .pagination-modern .page-link:hover {
            background: var(--primary-deep) !important;
            color: #fff !important;
            border-color: var(--primary-deep) !important;
        }
        
        .pagination-modern .page-item.active .page-link {
            background: var(--primary-deep) !important;
            border-color: var(--primary-deep) !important;
            color: #fff !important;
        }
        
        /* Responsive - موبايل وويب */
        @media (max-width: 991.98px) {
            .reports-header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .reports-header-actions {
                width: 100%;
                justify-content: flex-start;
                flex-wrap: wrap;
            }
            
            .filter-card-body {
                padding: 1.25rem;
            }
            
            .results-count-box {
                padding: 1rem;
            }
            
            .results-count-box span {
                font-size: 1rem;
            }
            
            .filter-form-rtl .col-12 {
                margin-bottom: 0.5rem;
            }
        }
        
        @media (max-width: 575.98px) {
            .reports-header {
                padding: 1.25rem;
            }
            
            .reports-header-title {
                font-size: 1.35rem;
            }
            
            .reports-header-icon {
                width: 48px;
                height: 48px;
            }
            
            .reports-header-icon i {
                font-size: 24px;
            }
            
            .filter-card-body {
                padding: 1rem;
            }
            
            .btn-filter-submit,
            .btn-add-client {
                height: 48px;
                width: 100%;
            }
        }
    </style>
@endsection

@extends(backpack_view('blank'))

@section('header')
    <section class="reports-header">
        <div class="reports-header-content">
            <div class="reports-header-left">
                <div class="reports-header-icon">
                    <i class="la la-users"></i>
                </div>
                <h1 class="reports-header-title">المشتركين</h1>
            </div>
            <div class="reports-header-actions">
                @if($clients->count() > 0)
                <a href="{{ route('reports.filters.export.excel', request()->all()) }}" class="btn-export">
                    <i class="la la-file-excel"></i> Excel
                </a>
                <a href="{{ route('reports.filters.export.pdf', request()->all()) }}" class="btn-export">
                    <i class="la la-file-pdf"></i> PDF
                </a>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('content')
<div class="reports-filters-container">
    <div class="container-fluid pb-5">

        {{-- ======================= فلاتر البحث ======================= --}}
        <div class="filter-card-modern">
            <div class="filter-card-header">
                <i class="la la-filter"></i>
                <h6>فلاتر البحث</h6>
            </div>
            <div class="filter-card-body">
                <div class="results-count-box">
                    <i class="la la-users"></i>
                    <span>عدد المشتركين المطابقين: {{ number_format($clients->total()) }}</span>
                </div>

                <form method="GET" action="{{ route('reports.filters') }}" class="row g-3 g-md-4 filter-form-rtl">
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label-modern">المدينة</label>
                        <select name="city_id" class="form-select form-select-modern w-100">
                            <option value="">الكل</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" @selected(request('city_id') == $city->id)>{{ $city->city_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label-modern">حالة الاشتراك</label>
                        <select name="subscription_status_id" class="form-select form-select-modern w-100">
                            <option value="" @selected(empty($selectedSubscriptionStatusId))>الكل</option>
                            @foreach($subscriptionStatuses as $subStatus)
                                <option value="{{ $subStatus->id }}" @selected(isset($selectedSubscriptionStatusId) && (string)$selectedSubscriptionStatusId === (string)$subStatus->id)>{{ $subStatus->status_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label-modern">نوع الاشتراك</label>
                        <select name="subscription_type_id" class="form-select form-select-modern w-100">
                            <option value="">الكل</option>
                            @foreach($subscriptions as $sub)
                                <option value="{{ $sub->id }}" @selected(request('subscription_type_id') == $sub->id)>{{ $sub->type_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label-modern">بحث سريع</label>
                        <input type="text" name="q" class="form-control form-control-modern" placeholder="اسم المشترك، رقم الهاتف، أو العنوان" value="{{ request('q') }}">
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-filter-submit w-100">
                            <i class="la la-search"></i> عرض النتائج
                        </button>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 d-flex align-items-end">
                        <a href="{{ url(config('backpack.base.route_prefix').'/client/create') }}" class="btn-add-client w-100">
                            <i class="la la-plus"></i> إضافة مشترك
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- ======================= جدول النتائج ======================= --}}
        @if($clients->count())
        <div class="table-card-modern">
            <div class="table-card-header-modern">
                <i class="la la-list"></i>
                <h5>نتائج البحث</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="min-width: 200px;">المشترك</th>
                            <th>المدينة / العنوان</th>
                            <th>الرصيد المالي</th>
                            <th style="min-width: 130px;">آخر استلام</th>
                            <th>أيام بدون استلام</th>
                            <th style="min-width: 160px;">ملاحظات العميل</th>
                            <th style="width: 80px;">إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                        <tr>
                            <td class="ps-4" style="min-width: 200px;">
                                <div class="fw-bold" style="color: var(--primary-deep);">{{ $client->name }}</div>
                                <small class="text-muted">{{ $client->phone_one ?? '-' }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $client->city->city_name ?? '-' }}</div>
                                <div class="text-muted small">{{ $client->address ?? '-' }}</div>
                            </td>
                            <td class="fw-bold">
                                @php
                                    $balance = $client->balance ?? 0;
                                    $balanceClass = $balance > 0 ? 'text-danger' : ($balance < 0 ? 'text-success' : 'text-muted');
                                @endphp
                                <span class="{{ $balanceClass }}">{{ number_format($balance, 2) }} ₪</span>
                            </td>
                            <td class="fw-semibold" style="min-width: 130px;">{{ $client->lastDelivery ? \Carbon\Carbon::parse($client->lastDelivery->delivery_date)->format('Y-m-d') : '-' }}</td>
                            <td>
                                @if($client->lastDelivery)
                                    @php
                                        $days = (int) \Carbon\Carbon::parse($client->lastDelivery->delivery_date)->startOfDay()->diffInDays(now()->startOfDay());
                                    @endphp
                                    <span class="badge badge-modern @if($days <= 1) badge-success-modern @elseif($days <= 10) badge-warning-modern @else badge-danger-modern @endif">
                                        @if($days === 0) اليوم @elseif($days === 1) أمس @else منذ {{ $days }} يوم @endif
                                    </span>
                                @else
                                    <span class="badge badge-modern badge-secondary-modern">لم يستلم</span>
                                @endif
                            </td>
                            <td class="text-end small" style="max-width: 220px;" title="{{ $client->notes ?? '' }}">{{ Str::limit($client->notes ?? '-', 60) }}</td>
                            <td class="pe-4">
                                <div class="btn-group dropdown">
                                    <button type="button" class="btn btn-action-modern btn-sm dropdown-toggle" data-toggle="dropdown">
                                        <i class="la la-cog"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-modern dropdown-menu-right">
                                        <a class="dropdown-item dropdown-item-modern" href="{{ backpack_url('client/'.$client->id.'/show') }}">
                                            <i class="la la-eye"></i> معاينة
                                        </a>
                                        <a class="dropdown-item dropdown-item-modern" href="{{ backpack_url('client/'.$client->id.'/edit') }}">
                                            <i class="la la-edit"></i> تعديل
                                        </a>
                                        <a class="dropdown-item dropdown-item-modern" href="{{ url('admin/delivery/create?client_id='.$client->id) }}">
                                            <i class="la la-truck"></i> تسليم
                                        </a>
                                        <a class="dropdown-item dropdown-item-modern" href="{{ route('client.report', ['client_id' => $client->id]) }}">
                                            <i class="la la-list"></i> تقرير العميل
                                        </a>
                                        <a class="dropdown-item dropdown-item-modern" href="{{ route('reports.client-balance', ['client_id' => $client->id]) }}">
                                            <i class="la la-file-invoice-dollar"></i> تقرير الرصيد
                                        </a>
                                        <a class="dropdown-item dropdown-item-modern" href="{{ url(config('backpack.base.route_prefix') . '/client-deposit/create?client_id=' . $client->id) }}">
                                            <i class="la la-box-open"></i> أمانة المشترك
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item dropdown-item-modern text-danger btn-delete" data-url="{{ backpack_url('client/'.$client->id) }}">
                                            <i class="la la-trash"></i> حذف
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-top">
                <div class="pagination-modern">
                    {{ $clients->withQueryString()->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Delete Action
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            if (confirm('هل أنت متأكد من الحذف؟')) {
                fetch(this.dataset.url, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                })
                .then(res => { if (res.ok) this.closest('tr').remove(); })
                .catch(() => alert('حدث خطأ أثناء الحذف'));
            }
        });
    });
});
</script>
@endsection
