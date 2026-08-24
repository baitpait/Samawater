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
            overflow-x: hidden;
        }

        .reports-filters-container > .container-fluid {
            max-width: 100%;
            min-width: 0;
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
            overflow: visible;
        }

        /** تمرير أفقي للجدول فقط حتى لا يخرج عن عرض الشاشة */
        .reports-filters-table-scroll-wrap {
            width: 100%;
            max-width: 100%;
            min-width: 0;
            overflow-x: auto;
            overflow-y: visible;
            -webkit-overflow-scrolling: touch;
        }

        .reports-filters-table-scroll-wrap .table-modern {
            min-width: 1120px;
            width: 100%;
            table-layout: auto;
        }

        .bottle-balance-cell {
            min-width: 80px;
        }

        .bottle-balance-value {
            color: var(--primary-deep);
            font-size: 1.25rem;
            font-weight: 800;
            line-height: 1.2;
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
            border-bottom: 2px solid #111111;
            font-size: 14px;
        }
        
        .table-modern tbody td {
            padding: 1rem;
            border-bottom: 1px solid #111111;
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
        
        a.client-filter-name-link {
            color: var(--primary-deep) !important;
            text-decoration: none !important;
        }
        a.client-filter-name-link:hover {
            text-decoration: underline !important;
            opacity: 0.92;
        }

        .btn-delivery-on-demand {
            font-size: 0.95rem;
            font-weight: 700;
            padding: 0.4rem 0.5rem;
            border-radius: 10px;
            line-height: 1;
        }

        .btn-delivery-on-demand i.la {
            margin: 0;
            vertical-align: middle;
        }

        .btn-delivery-on-demand-cancel,
        .btn-delivery-on-demand-cancel:hover,
        .btn-delivery-on-demand-cancel:focus,
        .btn-delivery-on-demand-cancel:active {
            background: #dc2626 !important;
            border-color: #dc2626 !important;
            color: #fff !important;
            box-shadow: none !important;
        }

        .btn-delivery-on-demand-cancel:hover,
        .btn-delivery-on-demand-cancel:focus {
            background: #b91c1c !important;
            border-color: #b91c1c !important;
            color: #fff !important;
        }

        .btn-delivery-on-demand-enable {
            background: var(--primary-deep) !important;
            border: none !important;
            color: #fff !important;
        }

        .btn-delivery-on-demand.is-loading {
            opacity: 0.65;
            pointer-events: none;
        }

        .delivery-on-demand-toast {
            position: fixed;
            top: 1.25rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1080;
            background: #065f46;
            color: #fff;
            font-weight: 700;
            padding: 0.75rem 1.25rem;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18);
            max-width: min(92vw, 480px);
            text-align: center;
        }

        .delivery-on-demand-toast.is-error {
            background: #b91c1c;
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

        @if(session('success'))
            <div class="alert alert-success border-0 mb-4" style="border-radius: 14px; font-weight: 600;">
                <i class="la la-check-circle"></i> {{ session('success') }}
            </div>
        @endif

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
                            <option value="" @selected($selectedSubscriptionStatusId === null || $selectedSubscriptionStatusId === '')>الكل</option>
                            @foreach($subscriptionStatuses as $subStatus)
                                <option value="{{ $subStatus->id }}" @selected((string) $selectedSubscriptionStatusId === (string) $subStatus->id)>{{ $subStatus->status_name }}</option>
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
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label-modern">بحث في اسم نوع الاشتراك</label>
                        <input type="text" name="subscription_type_contains" class="form-control form-control-modern w-100" placeholder="مثال: محدد" value="{{ request('subscription_type_contains') }}" autocomplete="off">
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
            <div class="reports-filters-table-scroll-wrap px-3 px-md-0">
                <div class="table-responsive border-0">
                    <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="min-width: 200px;">المشترك</th>
                            <th>المدينة / العنوان</th>
                            <th style="min-width: 140px;">طريقة التعامل</th>
                            <th>دين المشترك</th>
                            <th style="min-width: 160px;" class="text-center">رصيد القوارير</th>
                            <th style="min-width: 170px;">آخر استلام والأيام</th>
                            <th style="min-width: 120px;">نوع الاشتراك</th>
                            <th style="min-width: 56px; width: 56px;" class="text-center">حسب الطلب</th>
                            <th style="min-width: 160px;">ملاحظات العميل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                        <tr>
                            <td class="ps-4" style="min-width: 200px;">
                                <a href="{{ backpack_url('client/'.$client->id.'/show') }}" class="client-filter-name-link fw-bold d-inline-block">{{ $client->name }}</a>
                                <small class="text-muted d-block mt-1">{{ $client->phone_one ?? '-' }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $client->city->city_name ?? '-' }}</div>
                                <div class="text-muted small">{{ $client->address ?? '-' }}</div>
                            </td>
                            <td class="small" style="max-width: 200px;" title="{{ $client->interaction_method ?? '' }}">
                                {{ Str::limit($client->interaction_method ?? '-', 50) }}
                            </td>
                            <td class="fw-bold" title="إجمالي الدين = رصيد الفواتير والافتتاحي + متبقّي التسليمات (نفس تقرير رصيد المشترك)">
                                @php
                                    $balance = $client->combined_subscriber_debt ?? 0;
                                    $balanceClass = $balance > 0 ? 'text-danger' : ($balance < 0 ? 'text-success' : 'text-muted');
                                @endphp
                                <span class="{{ $balanceClass }}">{{ number_format((float) $balance, 2) }} ₪</span>
                            </td>
                            <td class="text-center align-middle">
                                @include('admin.reports.partials.bottle_balance_cell', [
                                    'snapshot' => $bottleSnapshotsByClientId[$client->id] ?? [
                                        'total_bottle_received' => 0,
                                        'total_bottle_empty' => 0,
                                        'bottle_balance' => 0,
                                    ],
                                    'showFormula' => false,
                                ])
                            </td>
                            <td style="min-width: 170px;">
                                <div class="fw-semibold">{{ $client->lastDelivery ? \Carbon\Carbon::parse($client->lastDelivery->delivery_date)->format('Y-m-d') : '-' }}</div>
                                <div class="mt-1">
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
                                </div>
                            </td>
                            <td class="fw-semibold" style="min-width: 120px;">{{ $client->subscriptionType->type_name ?? '-' }}</td>
                            <td class="text-center align-middle pe-2" style="min-width: 56px;">
                                <form method="POST" action="{{ route('reports.filters.toggle_delivery_on_demand', $client) }}" class="d-inline js-delivery-on-demand-form" data-client-id="{{ $client->id }}">
                                    @csrf
                                    <input type="hidden" name="enabled" value="{{ $client->delivery_on_demand ? '0' : '1' }}">
                                    @foreach(request()->only(['q', 'city_id', 'subscription_type_id', 'subscription_type_contains', 'from', 'to', 'page']) as $filterKey => $filterValue)
                                        @if($filterValue !== null && $filterValue !== '')
                                            <input type="hidden" name="{{ $filterKey }}" value="{{ $filterValue }}">
                                        @endif
                                    @endforeach
                                    @if(request()->has('subscription_status_id'))
                                        <input type="hidden" name="subscription_status_id" value="{{ request('subscription_status_id') }}">
                                    @endif
                                    @if($client->delivery_on_demand)
                                        <button type="submit" class="btn btn-sm btn-delivery-on-demand btn-delivery-on-demand-cancel" title="إلغاء التسليم حسب الطلب">
                                            <span class="sr-only visually-hidden">إلغاء التسليم حسب الطلب</span>
                                            <i class="la la-times" aria-hidden="true"></i>
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-sm text-white btn-delivery-on-demand btn-delivery-on-demand-enable" title="يظهر المشترك في قائمة التسليم حتى دون استحقاق الأيام؛ يُعاد الإلغاء بعد التسليم">
                                            <span class="sr-only visually-hidden">تفعيل التسليم حسب الطلب</span>
                                            <i class="la la-truck" aria-hidden="true"></i>
                                        </button>
                                    @endif
                                </form>
                            </td>
                            <td class="text-end small" style="max-width: 220px;" title="{{ $client->notes ?? '' }}">{{ Str::limit($client->notes ?? '-', 60) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
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
@endsection

@section('after_scripts')
<script>
(function () {
    'use strict';

    function showToast(message, isError) {
        var existing = document.querySelector('.delivery-on-demand-toast');
        if (existing) {
            existing.remove();
        }
        var toast = document.createElement('div');
        toast.className = 'delivery-on-demand-toast' + (isError ? ' is-error' : '');
        toast.setAttribute('role', 'status');
        toast.textContent = message;
        document.body.appendChild(toast);
        window.setTimeout(function () {
            toast.remove();
        }, 2800);
    }

    function renderButton(enabled) {
        var button = document.createElement('button');
        button.type = 'submit';
        button.className = 'btn btn-sm btn-delivery-on-demand ' + (enabled
            ? 'btn-delivery-on-demand-cancel'
            : 'btn-delivery-on-demand-enable text-white');
        button.title = enabled
            ? 'إلغاء التسليم حسب الطلب'
            : 'يظهر المشترك في قائمة التسليم حتى دون استحقاق الأيام؛ يُعاد الإلغاء بعد التسليم';

        var label = document.createElement('span');
        label.className = 'sr-only visually-hidden';
        label.textContent = enabled ? 'إلغاء التسليم حسب الطلب' : 'تفعيل التسليم حسب الطلب';

        var icon = document.createElement('i');
        icon.className = enabled ? 'la la-times' : 'la la-truck';
        icon.setAttribute('aria-hidden', 'true');

        button.appendChild(label);
        button.appendChild(icon);
        return button;
    }

    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!(form instanceof HTMLFormElement) || !form.classList.contains('js-delivery-on-demand-form')) {
            return;
        }

        event.preventDefault();

        var button = form.querySelector('button[type="submit"]');
        var enabledInput = form.querySelector('input[name="enabled"]');
        if (!button || !enabledInput) {
            return;
        }

        button.classList.add('is-loading');
        button.disabled = true;

        var body = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: body,
            credentials: 'same-origin'
        })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('toggle_failed');
                }
                return response.json();
            })
            .then(function (data) {
                var enabled = !!data.enabled;
                enabledInput.value = enabled ? '0' : '1';
                button.replaceWith(renderButton(enabled));
                showToast(data.message || (enabled ? 'تم التفعيل' : 'تم الإلغاء'), false);
            })
            .catch(function () {
                button.classList.remove('is-loading');
                button.disabled = false;
                showToast('تعذر تحديث التسليم حسب الطلب. أعد المحاولة.', true);
            });
    });
})();
</script>
@endsection
