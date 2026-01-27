@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
@endsection

@extends(backpack_view('blank'))

@section('content')
<div class="container-fluid pb-4">

    {{-- ===============================
        Header - Unified Design
    =============================== --}}
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header">
        <div class="header-content-wrapper" style="display: flex; align-items: center; gap: 1rem; width: 100%; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div class="icon-box" style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.2); border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);">
                    <i class="la la-truck" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
                </div>
                <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 700; margin: 0; font-family: 'Cairo', sans-serif;">قائمة التسليم</h1>
            </div>
            <div>
                @php
                    $bulkEntryUrl = route('delivery.bulk-entry', request()->query());
                @endphp
                <a href="{{ $bulkEntryUrl }}" class="btn btn-light" style="color: #6f6af8; font-weight: 600;">
                    <i class="la la-table"></i> إدخال جماعي
                </a>
            </div>
        </div>
    </section>

    {{-- Unified Header CSS --}}
    <style>
        section.header-operation {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
            border-radius: 20px !important;
            padding: 1.5rem 2rem !important;
            margin-bottom: 2rem !important;
            box-shadow: 0 10px 30px rgba(111, 106, 248, 0.3) !important;
        }
        /* تثبيت الجدول داخل البطاقة مع شريط أفقي */
        .filter-card .card-body {
            overflow-x: auto !important;
        }
        .filter-card .table-responsive {
            overflow-x: auto !important;
        }
        .filter-card .table-clean {
            min-width: 1400px;
        }
    </style>

    {{-- ===============================
        Filters
    =============================== --}}
    <div class="card filter-card mb-4">
        <div class="card-body">
            @if(request()->has('search') && $clients instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="results-header-modern">
                        <div class="results-header-item results-count-item">
                            <div class="results-count-wrapper">
                                <span class="results-label">عدد المشتركين:</span>
                                <strong class="results-value">{{ number_format($clients->total()) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <form method="GET" class="row g-3 align-items-end">

                {{-- صف مستقل للبحث --}}
                <div class="col-12">
                    <label class="form-label">بحث</label>
                    <input type="text"
                           name="q"
                           class="form-control modern-input"
                           placeholder="اسم / هاتف / عقد / عنوان"
                           value="{{ request('q') }}">
                </div>

                {{-- الصف الثاني --}}
                <div class="col-12 col-lg-3">
                    <label class="form-label">المدينة</label>
                    <select name="city_id" class="form-select modern-select">
                        <option value="">الكل</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" @selected(request('city_id') == $city->id)>
                                {{ $city->city_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-lg-3">
                    <label class="form-label">نوع الاشتراك</label>
                    <select name="subscription_type_id" class="form-select modern-select">
                        <option value="">الكل</option>
                        @foreach($subscriptionTypes as $type)
                            <option value="{{ $type->id }}" @selected(request('subscription_type_id') == $type->id)>
                                {{ $type->type_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-lg-3">
                    <label class="form-label">حالة الاشتراك</label>
                    <select name="subscription_status_name" class="form-select modern-select">
                        <option value="">الكل</option>
                        @foreach($subscriptionStatuses as $status)
                            <option value="{{ $status->status_name }}" @selected(request('subscription_status_name') == $status->status_name)>
                                {{ $status->status_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- الصف الثالث --}}
                <div class="col-12 col-lg-9">
                    <label class="form-label">أيام بدون تسليم</label>
                    <div class="days-filter-wrapper">
                        <select name="days_operator" class="form-select modern-select days-operator-select">
                            <option value=">=" @selected(request('days_operator', '>=') == '>=')>أكبر أو يساوي</option>
                            <option value="<=" @selected(request('days_operator') == '<=')>أصغر أو يساوي</option>
                            <option value="=" @selected(request('days_operator') == '=')>يساوي</option>
                        </select>
                        <input type="number"
                               name="min_days"
                               class="form-control modern-input days-input"
                               placeholder="عدد الأيام"
                               min="0"
                               value="{{ request('min_days') }}">
                    </div>
                </div>

                <div class="col-12 col-lg-3">
                    <label class="form-label invisible-label">&nbsp;</label>
                    <button type="submit" name="search" value="1" class="btn btn-filter w-100">
                        <i class="la la-search"></i>
                        <span>بحث</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===============================
        Results Table
    =============================== --}}
    @if(request()->has('search') && $clients instanceof \Illuminate\Pagination\LengthAwarePaginator && $clients->count() > 0)
        <div class="card filter-card mb-4">
            <div class="card-body" style="position: relative; z-index: 1; overflow: visible;">
                {{-- Per Page Selector --}}
                @php
                    $perPage = request('per_page', 10);
                    $perPage = in_array($perPage, [10, 50, 100, 'all']) ? $perPage : 10;
                @endphp
                <div class="per-page-selector">
                    <div class="per-page-left">
                        <label>عرض:</label>
                        <select id="perPageSelect" class="form-select modern-select per-page-select">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                            <option value="all" {{ $perPage == 'all' ? 'selected' : '' }}>الكل</option>
                        </select>
                    </div>
                    <span class="total-count">إجمالي: <strong>{{ number_format($clients->total()) }}</strong> مشترك</span>
                </div>
                
                <div class="table-responsive" style="position: relative; z-index: 1; overflow-x: auto !important; overflow-y: hidden !important; max-width: 100%; width: 100%;">
                    <table class="table table-clean align-middle mb-0" style="min-width: 1400px; width: 100%;">
                        <thead>
                            <tr style="background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%); color: #fff;">
                                <th style="padding: 16px 20px; text-align: right; font-weight: 700; font-size: 15px; font-family: 'Cairo', sans-serif; border: none;">المشترك</th>
                                <th style="padding: 16px 20px; text-align: center; font-weight: 700; font-size: 15px; font-family: 'Cairo', sans-serif; border: none;">المدينة / العنوان</th>
                                <th style="padding: 16px 20px; text-align: center; font-weight: 700; font-size: 15px; font-family: 'Cairo', sans-serif; border: none;">الهاتف</th>
                                <th style="padding: 16px 20px; text-align: center; font-weight: 700; font-size: 15px; font-family: 'Cairo', sans-serif; border: none; min-width: 220px;">معلومات الاشتراك</th>
                                <th style="padding: 16px 12px; text-align: center; font-weight: 700; font-size: 15px; font-family: 'Cairo', sans-serif; border: none; min-width: 100px; max-width: 120px;">نسبة الالتزام</th>
                                <th style="padding: 16px 20px; text-align: center; font-weight: 700; font-size: 15px; font-family: 'Cairo', sans-serif; border: none;">تاريخ آخر تسليم</th>
                                <th style="padding: 16px 20px; text-align: center; font-weight: 700; font-size: 15px; font-family: 'Cairo', sans-serif; border: none;">أيام بدون تسليم</th>
                                <th style="padding: 16px 20px; text-align: center; font-weight: 700; font-size: 15px; font-family: 'Cairo', sans-serif; border: none;">الموزع</th>
                                <th style="padding: 16px 20px; text-align: center; font-weight: 700; font-size: 15px; font-family: 'Cairo', sans-serif; border: none;">إجراء</th>
                                <th style="padding: 16px 20px; text-align: center; font-weight: 700; font-size: 15px; font-family: 'Cairo', sans-serif; border: none;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                                <tr style="border-bottom: 1px solid #e5e7eb; transition: background-color 0.2s ease;">
                                    <td style="padding: 16px 20px; text-align: right;">
                                        <div style="font-weight: 600; color: #1f2937; font-size: 15px;">{{ $client->client_name ?? '-' }}</div>
                                        <div style="color: #6b7280; font-size: 13px; margin-top: 4px;">{{ $client->contract_no ?? '-' }}</div>
                                    </td>
                                    <td style="padding: 16px 20px; text-align: center; color: #374151;">
                                        <div style="font-weight: 600;">{{ $client->city_name ?? '-' }}</div>
                                        @if(!empty($client->address))
                                            <div style="color: #6b7280; font-size: 13px; margin-top: 4px;">{{ $client->address }}</div>
                                        @endif
                                    </td>
                                    <td style="padding: 16px 20px; text-align: center;">
                                        @if($client->phone_one)
                                            <div style="color: #374151;">{{ $client->phone_one }}</div>
                                        @endif
                                        @if($client->phone_two)
                                            <div style="color: #9ca3af; font-size: 13px; margin-top: 4px;">{{ $client->phone_two }}</div>
                                        @endif
                                        @if(!$client->phone_one && !$client->phone_two)
                                            <span style="color: #9ca3af;">-</span>
                                        @endif
                                    </td>
                                    <td style="padding: 14px 20px; text-align: center; font-size: 14px; font-family: 'Cairo', sans-serif; min-width: 220px; white-space: normal;">
                                        @php
                                            $clientTypeMap = [
                                                1 => 'فردي',
                                                2 => 'مؤسسة',
                                                3 => 'تجاري',
                                            ];
                                            $clientTypeName = isset($client->client_type) && $client->client_type ? ($clientTypeMap[$client->client_type] ?? $client->client_type) : '-';
                                            $subscriptionTypeName = $client->subscription_type_name ?? '-';
                                            $subscriptionStatusName = $client->subscription_status_name ?? '-';
                                        @endphp
                                        <div style="display: flex; flex-direction: column; gap: 6px; align-items: center;">
                                            {{-- نوع الاشتراك --}}
                                            @if($subscriptionTypeName !== '-')
                                                <span style="display: inline-block; padding: 5px 12px; border-radius: 8px; font-weight: 600; font-size: 13px; background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%); color: #fff; box-shadow: 0 2px 8px rgba(111, 106, 248, 0.25);">
                                                    {{ $subscriptionTypeName }}
                                                </span>
                                            @endif
                                            
                                            {{-- حالة الاشتراك --}}
                                            @if($subscriptionStatusName !== '-')
                                                <span style="display: inline-block; padding: 5px 12px; border-radius: 8px; font-weight: 600; font-size: 13px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);">
                                                    {{ $subscriptionStatusName }}
                                                </span>
                                            @endif
                                            
                                            {{-- نوع المشترك --}}
                                            @if($clientTypeName !== '-')
                                                <span style="display: inline-block; padding: 5px 12px; border-radius: 8px; font-weight: 500; font-size: 12px; background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb;">
                                                    {{ $clientTypeName }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td style="padding: 14px 12px; text-align: center; font-size: 14px; font-family: 'Cairo', sans-serif; min-width: 100px; max-width: 120px;">
                                        @php
                                            // استخدام percentage_delivery_rate من الـ view مباشرة
                                            $percentageDeliveryRate = $client->percentage_delivery_rate ?? 0;
                                            
                                            // تحديد لون حسب النسبة
                                            $badgeColor = '#6b7280';
                                            if ($percentageDeliveryRate >= 90) {
                                                $badgeColor = '#10b981';
                                            } elseif ($percentageDeliveryRate >= 75) {
                                                $badgeColor = '#3b82f6';
                                            } elseif ($percentageDeliveryRate >= 50) {
                                                $badgeColor = '#f59e0b';
                                            } elseif ($percentageDeliveryRate > 0) {
                                                $badgeColor = '#ef4444';
                                            }
                                        @endphp
                                        <span style="display: inline-block; padding: 5px 10px; border-radius: 8px; font-weight: 600; font-size: 13px; background: {{ $badgeColor }}15; color: {{ $badgeColor }}; border: 1px solid {{ $badgeColor }}30; white-space: nowrap;">
                                            {{ number_format($percentageDeliveryRate, 2) }}%
                                        </span>
                                    </td>
                                    <td style="padding: 16px 20px; text-align: center;">
                                        @if($client->last_delivery_date)
                                            <span style="color: #6f6af8; font-weight: 600;">{{ \Carbon\Carbon::parse($client->last_delivery_date)->format('Y-m-d') }}</span>
                                        @else
                                            <span style="color: #6b7280;">لم يتسلم بعد</span>
                                        @endif
                                    </td>
                                    <td style="padding: 16px 20px; text-align: center;">
                                        <span style="color: #ef4444; font-weight: 700; font-size: 16px;">{{ $client->days_since_last_delivery ?? 0 }}</span>
                                    </td>
                                    <td style="padding: 16px 20px; text-align: center; color: #374151;">
                                        {{ $client->distributor_name ?? '-' }}
                                    </td>
                                    <td style="padding: 16px 20px; text-align: center; position: relative; z-index: 1; overflow: visible;">
                                        @if($client->client_id)
                                            <div class="btn-group unified-actions-dropdown" style="position: relative; z-index: 10000;">
                                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%); border: none; border-radius: 8px; padding: 6px 12px; font-weight: 600; box-shadow: 0 2px 8px rgba(111, 106, 248, 0.3);">
                                                    <i class="la la-cog"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" style="direction: rtl; position: absolute; right: 0; left: auto; top: 100%; margin-top: 4px; z-index: 99999;">
                                                    <a class="dropdown-item" href="{{ url(config('backpack.base.route_prefix') . '/client/' . $client->client_id . '/show') }}">
                                                        <i class="la la-eye"></i> معاينة
                                                    </a>
                                                    <a class="dropdown-item" href="{{ url(config('backpack.base.route_prefix') . '/client-report?client_id=' . $client->client_id) }}">
                                                        <i class="la la-file-alt"></i> تقرير
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="{{ backpack_url('delivery/create?client_id=' . $client->client_id) }}">
                                                        <i class="la la-truck"></i> تسليم
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                            <span style="color: #9ca3af;">-</span>
                                        @endif
                                    </td>
                                    <td style="padding: 16px 20px; text-align: center;">
                                        {{-- عمود فارغ --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Pagination --}}
        @if($clients->hasPages())
            <div class="pagination-wrapper">
                {{ $clients->withQueryString()->links('pagination::bootstrap-5') }}
                <div class="pagination-info-arabic">
                    <p class="small text-muted">
                        عرض
                        <span class="fw-semibold">{{ $clients->firstItem() }}</span>
                        إلى
                        <span class="fw-semibold">{{ $clients->lastItem() }}</span>
                        من
                        <span class="fw-semibold">{{ number_format($clients->total()) }}</span>
                        نتيجة
                    </p>
                </div>
            </div>
        @endif
    @elseif(request()->has('search'))
        <div class="card filter-card mb-4">
            <div class="card-body text-center py-5">
                <i class="la la-search" style="font-size: 48px; color: #9ca3af; margin-bottom: 16px;"></i>
                <div style="font-weight: 600; color: #374151; font-size: 18px; margin-bottom: 8px;">لا توجد نتائج مطابقة</div>
                <div style="color: #6b7280;">جرب تغيير معايير البحث</div>
            </div>
        </div>
    @else
        <div class="card filter-card mb-4">
            <div class="card-body text-center py-5">
                <i class="la la-search" style="font-size: 48px; color: #9ca3af; margin-bottom: 16px;"></i>
                <div style="font-weight: 600; color: #374151; font-size: 18px; margin-bottom: 8px;">لم يتم عرض أي نتائج بعد</div>
                <div style="color: #6b7280;">اختر الفلاتر ثم اضغط على زر البحث</div>
            </div>
        </div>
    @endif

</div>

@push('after_styles')
<style>
    /* ===============================
       Filter Card - Unified Design
       بناءً على التحليل الكامل
    =============================== */
    
    /* Card Container */
    .filter-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 28px;
        margin-bottom: 30px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
        border: none;
    }
    
    .filter-card .card-body {
        padding: 0;
    }
    
    /* Form Layout */
    .filter-card form {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }
    
    /* Labels */
    .filter-card .form-label {
        font-weight: 700;
        color: #374151;
        margin-bottom: 10px;
        display: block;
        font-size: 14px;
        font-family: 'Cairo', sans-serif;
    }
    
    .filter-card .invisible-label {
        opacity: 0;
        margin-bottom: 10px;
        display: block;
    }
    
    /* Form Controls */
    .filter-card .form-control,
    .filter-card .form-select {
        height: 56px;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        font-size: 15px;
        font-weight: 600;
        color: #374151;
        padding: 14px 20px;
        transition: all 0.3s ease;
        font-family: 'Cairo', sans-serif;
        background: #ffffff;
        width: 100%;
    }
    
    .filter-card .form-control:focus,
    .filter-card .form-select:focus {
        border-color: #6f6af8;
        box-shadow: 0 0 0 4px rgba(111, 106, 248, 0.1);
        outline: none;
        background: #ffffff;
    }
    
    .filter-card .form-control::placeholder {
        color: #9ca3af;
        font-weight: 500;
    }
    
    /* Days Filter Wrapper */
    .filter-card .days-filter-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .filter-card .days-operator-select {
        width: 180px;
        flex-shrink: 0;
    }
    
    .filter-card .days-input {
        flex-grow: 1;
    }
    
    /* Button */
    .filter-card .btn-filter {
        background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%);
        border: none;
        color: #fff;
        border-radius: 12px;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(111, 106, 248, 0.3);
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .filter-card .btn-filter i {
        font-size: 22px;
    }
    
    .filter-card .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(111, 106, 248, 0.4);
        color: #fff;
    }
    
    /* Per Page Selector */
    .per-page-selector {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding: 16px 24px;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }
    
    .per-page-selector .per-page-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .per-page-selector label {
        font-weight: 700;
        color: #374151;
        font-size: 15px;
        font-family: 'Cairo', sans-serif;
        margin: 0;
    }
    
    .per-page-selector .per-page-select {
        width: auto;
        min-width: 100px;
        height: 56px;
    }
    
    .per-page-selector .total-count {
        font-weight: 600;
        color: #6b7280;
        font-size: 14px;
        font-family: 'Cairo', sans-serif;
    }
    
    .per-page-selector .total-count strong {
        color: #6f6af8;
    }
    
    /* Pagination */
    .pagination-wrapper {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin-top: 24px;
        padding-top: 24px;
        border-top: 2px solid #e5e7eb;
        gap: 12px;
    }
    
    .pagination-info-arabic {
        text-align: center;
        margin-top: 8px;
    }
    
    .pagination-info-arabic p {
        margin: 0;
        font-family: 'Cairo', sans-serif;
        color: #6b7280;
        font-size: 14px;
    }
    
    .pagination-info-arabic .fw-semibold {
        font-weight: 600;
        color: #6f6af8;
    }
    
    .pagination {
        direction: rtl !important;
        justify-content: center !important;
        margin: 0 !important;
        padding: 0 !important;
        gap: 8px;
    }
    
    .pagination .page-item {
        margin: 0 !important;
    }
    
    .pagination .page-link {
        border-radius: 10px !important;
        margin: 0 4px !important;
        color: #6f6af8 !important;
        border-color: #e5e7eb !important;
        padding: 10px 16px !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        font-family: 'Cairo', sans-serif !important;
        transition: all 0.3s ease !important;
        background: #ffffff !important;
    }
    
    .pagination .page-link:hover {
        background: #6f6af8 !important;
        color: #fff !important;
        border-color: #6f6af8 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(111, 106, 248, 0.3) !important;
    }
    
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #6f6af8, #7c7cff) !important;
        border-color: #6f6af8 !important;
        color: #fff !important;
        box-shadow: 0 4px 12px rgba(111, 106, 248, 0.3) !important;
    }
    
    .pagination .page-item.disabled .page-link {
        color: #9ca3af !important;
        border-color: #e5e7eb !important;
        background: #f3f4f6 !important;
        cursor: not-allowed !important;
    }
    
    /* Hide "Showing X to Y" text */
    nav[aria-label="Pagination Navigation"] .d-none,
    nav[aria-label="Pagination Navigation"] .flex-sm-fill,
    nav[aria-label="Pagination Navigation"] .d-none.flex-sm-fill,
    nav[aria-label="Pagination Navigation"] .d-none.flex-sm-fill.d-sm-flex,
    nav[aria-label="Pagination Navigation"] p.small.text-muted,
    nav[aria-label="Pagination Navigation"] p,
    nav[aria-label="Pagination Navigation"] .d-flex.justify-content-between > div:first-child,
    nav[aria-label="Pagination Navigation"] > div.d-none,
    nav.d-flex.justify-items-center.justify-content-between > div.d-none.flex-sm-fill.d-sm-flex.align-items-sm-center.justify-content-sm-between > div:first-child {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        height: 0 !important;
        width: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    /* Results Header */
    .results-header-modern {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border-radius: 16px;
        padding: 24px 32px;
        box-shadow: 0 8px 24px rgba(239, 68, 68, 0.3);
        margin-bottom: 24px;
    }
    
    .results-count-wrapper {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 16px;
    }
    
    .results-label {
        color: #fff;
        font-size: 56px;
        font-weight: 800;
        font-family: 'Cairo', sans-serif;
    }
    
    .results-value {
        color: #fff;
        font-size: 56px;
        font-weight: 800;
        font-family: 'Cairo', sans-serif;
    }
    
    /* Table Styles */
    .table-clean {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table-clean tbody tr:hover {
        background-color: #f9fafb;
    }
    
    .table-clean tbody tr:last-child {
        border-bottom: none;
    }
    
    /* Dropdown Menu */
    .unified-actions-dropdown {
        position: relative !important;
        z-index: 10000 !important;
    }
    
    .unified-actions-dropdown .dropdown-menu {
        min-width: 180px;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        border: none;
        padding: 8px;
        z-index: 99999 !important;
        margin-top: 4px !important;
        position: absolute !important;
        right: 0 !important;
        left: auto !important;
        top: 100% !important;
        transform: none !important;
    }
    
    .unified-actions-dropdown .dropdown-menu.show {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
    
    .unified-actions-dropdown .dropdown-item {
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
    }
    
    .unified-actions-dropdown .dropdown-item:hover {
        background: #f3f4f6;
    }
    
    /* Ensure dropdown is above table and other elements */
    .table-responsive {
        overflow: visible !important;
        position: relative;
        z-index: 1;
    }
    
    .table {
        position: relative;
        z-index: 1;
    }
    
    .table tbody tr {
        position: relative;
        z-index: 1;
    }
    
    .table tbody tr td {
        overflow: visible !important;
        position: relative;
    }
    
    /* Ensure card and body don't clip dropdown */
    .card {
        overflow: visible !important;
        position: relative;
    }
    
    .card-body {
        overflow: visible !important;
        position: relative;
    }
    
    /* Ensure main container doesn't clip */
    .container-fluid {
        overflow: visible !important;
    }
</style>
@endpush

@push('after_scripts')
<script>
(function() {
    'use strict';
    
    // Helper functions
    function $(selector) {
        return document.querySelector(selector);
    }
    
    function $$(selector) {
        return document.querySelectorAll(selector);
    }
    
    function hasClass(element, className) {
        return element.classList.contains(className);
    }
    
    function addClass(element, className) {
        element.classList.add(className);
    }
    
    function removeClass(element, className) {
        element.classList.remove(className);
    }
    
    function closest(element, selector) {
        while (element && element.nodeType === 1) {
            if (element.matches(selector)) {
                return element;
            }
            element = element.parentElement;
        }
        return null;
    }
    
    // دالة لإغلاق جميع dropdowns
    function closeAllDropdowns() {
        var allDropdowns = $$('.unified-actions-dropdown');
        allDropdowns.forEach(function(dropdown) {
            var menu = dropdown.querySelector('.dropdown-menu');
            if (menu) {
                removeClass(menu, 'show');
                menu.style.display = 'none';
            }
        });
    }
    
    // تهيئة Bootstrap dropdown يدوياً
    function initBootstrapDropdowns() {
        // إزالة event listeners القديمة
        var oldToggles = $$('.unified-actions-dropdown .dropdown-toggle');
        oldToggles.forEach(function(toggle) {
            var newToggle = toggle.cloneNode(true);
            toggle.parentNode.replaceChild(newToggle, toggle);
        });
        
        // تهيئة جميع dropdowns
        var toggles = $$('.unified-actions-dropdown .dropdown-toggle');
        toggles.forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var dropdown = closest(toggle, '.unified-actions-dropdown');
                if (!dropdown) return;
                
                var menu = dropdown.querySelector('.dropdown-menu');
                if (!menu) return;
                
                var isOpen = hasClass(menu, 'show');
                
                // إغلاق جميع dropdowns الأخرى أولاً
                closeAllDropdowns();
                
                // إذا كان dropdown مفتوحاً، أغلقه
                if (isOpen) {
                    removeClass(menu, 'show');
                    menu.style.display = 'none';
                } else {
                    // فتح dropdown الحالي
                    addClass(menu, 'show');
                    menu.style.display = 'block';
                    
                    // استخدام position: absolute
                    menu.style.position = 'absolute';
                    menu.style.right = '0';
                    menu.style.left = 'auto';
                    menu.style.top = '100%';
                    menu.style.marginTop = '4px';
                    menu.style.zIndex = '99999';
                    menu.style.transform = 'none';
                    
                    // رفع z-index للصف الذي يحتوي على dropdown
                    var tr = closest(toggle, 'tr');
                    if (tr) {
                        tr.style.zIndex = '1000';
                        tr.style.position = 'relative';
                    }
                    
                    // رفع z-index للـ td
                    var td = closest(toggle, 'td');
                    if (td) {
                        td.style.zIndex = '10000';
                        td.style.position = 'relative';
                        td.style.overflow = 'visible';
                    }
                    
                    // رفع z-index للـ btn-group
                    var btnGroup = closest(toggle, '.unified-actions-dropdown');
                    if (btnGroup) {
                        btnGroup.style.zIndex = '10001';
                        btnGroup.style.position = 'relative';
                    }
                }
            });
        });
        
        // إغلاق dropdown عند النقر خارجها
        document.addEventListener('click', function(e) {
            var clickedElement = e.target;
            var isInsideDropdown = closest(clickedElement, '.unified-actions-dropdown');
            
            if (!isInsideDropdown) {
                closeAllDropdowns();
            }
        }, true);
    }
    
    // دالة لتغيير عدد الصفوف المعروضة
    function changePerPage(value) {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', value);
        url.searchParams.delete('page'); // إعادة تعيين الصفحة إلى 1
        window.location.href = url.toString();
    }
    
    // تهيئة per page selector
    function initPerPageSelector() {
        var perPageSelect = document.getElementById('perPageSelect');
        if (perPageSelect) {
            perPageSelect.addEventListener('change', function() {
                changePerPage(this.value);
            });
        }
    }
    
    // تشغيل الكود بعد تحميل DOM
    function init() {
        initBootstrapDropdowns();
        initPerPageSelector();
    }
    
    // تشغيل عند تحميل الصفحة
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(init, 100);
            setTimeout(init, 500);
            setTimeout(init, 1000);
        });
    } else {
        setTimeout(init, 100);
        setTimeout(init, 500);
        setTimeout(init, 1000);
    }
})();
</script>
@endpush

@endsection

