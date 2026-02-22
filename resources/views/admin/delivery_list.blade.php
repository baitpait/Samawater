@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    <style>
        /* ===============================
           Delivery List Page - تحسين صفحة قائمة التسليم
        =============================== */
        
        .delivery-list-container {
            background: var(--bg-light);
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        /* Header Section */
        .delivery-header {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%) !important;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg) !important;
            position: relative;
            overflow: hidden;
        }
        
        .delivery-header::before {
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
        
        .delivery-header::after {
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
        
        .delivery-header-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .delivery-header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .delivery-header-icon {
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
        
        .delivery-header-icon i {
            font-size: 32px;
            color: #fff;
            font-weight: 900;
        }
        
        .delivery-header-title {
            color: #fff;
            font-size: 28px;
            font-weight: 900;
            margin: 0;
            font-family: 'Cairo', sans-serif;
        }
        
        .btn-bulk-entry {
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
        
        .btn-bulk-entry:hover {
            background: #fff !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15) !important;
            color: var(--primary-deep) !important;
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
        
        /* Table Card - overflow: visible حتى لا يُقص الدروب داون */
        .delivery-list-container .table-card-modern {
            background: #fff;
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            border: none;
            overflow: visible !important;
        }
        .delivery-list-container .table-card-modern .table-scroll-wrapper {
            border-radius: 0 0 20px 20px;
        }
        /* ضمان ظهور قائمة الإجراءات فوق كل العناصر */
        .delivery-list-container .table-modern tbody tr {
            position: relative;
        }
        .delivery-list-container .table-modern tbody tr .unified-actions-dropdown.show {
            position: relative;
            z-index: 1050 !important;
        }
        .delivery-list-container .table-modern tbody tr .unified-actions-dropdown .dropdown-menu {
            z-index: 1060 !important;
        }
        
        /* غلاف التمرير الأفقي للجدول - شريط يمين/شمال */
        .delivery-list-container .table-card-modern .table-responsive.table-scroll-wrapper,
        .table-card-modern .table-scroll-wrapper {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            overflow-x: auto !important;
            overflow-y: visible !important;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: var(--primary-deep) var(--bg-light);
        }
        .delivery-list-container .table-scroll-wrapper::-webkit-scrollbar {
            height: 10px;
        }
        .delivery-list-container .table-scroll-wrapper::-webkit-scrollbar-track {
            background: var(--bg-light);
            border-radius: 10px;
        }
        .delivery-list-container .table-scroll-wrapper::-webkit-scrollbar-thumb {
            background: var(--primary-deep);
            border-radius: 10px;
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
            min-width: 1200px;
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
        
        .alert-modern {
            border-radius: 16px !important;
            padding: 1.5rem !important;
            border: none !important;
            box-shadow: var(--shadow-sm) !important;
        }
        
        .pagination-modern {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            direction: rtl;
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
        
        /* Responsive */
        @media (max-width: 768px) {
            .delivery-header {
                padding: 1.5rem;
            }
            
            .delivery-header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .filter-card-body {
                padding: 1.5rem;
            }
        }
    </style>
@endsection

@extends(backpack_view('blank'))

@section('content')
<div class="delivery-list-container">
    <div class="container-fluid pb-4">

        {{-- ===============================
            Header - Modern Design
        =============================== --}}
        <section class="delivery-header">
            <div class="delivery-header-content">
                <div class="delivery-header-left">
                    <div class="delivery-header-icon">
                        <i class="la la-truck"></i>
                    </div>
                    <h1 class="delivery-header-title">قائمة التسليم</h1>
                </div>
                <div>
                    @php
                        $bulkEntryUrl = route('delivery.bulk-entry', request()->query());
                    @endphp
                    <a href="{{ $bulkEntryUrl }}" class="btn-bulk-entry">
                        <i class="la la-table"></i> إدخال جماعي
                    </a>
                </div>
            </div>
        </section>

        {{-- ======================= فلاتر البحث ======================= --}}
        <div class="filter-card-modern">
            <div class="filter-card-header">
                <i class="la la-filter"></i>
                <h6>فلاتر البحث</h6>
            </div>
            <div class="filter-card-body">
                <form method="GET" class="row g-3 g-md-4 filter-form-rtl">
                    <div class="col-12 col-md-6">
                        <label class="form-label-modern">بحث سريع</label>
                        <input type="text" name="q" class="form-control form-control-modern" placeholder="اسم المشترك / رقم الهاتف / رقم العقد / العنوان" value="{{ request('q') }}">
                    </div>
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
                        <label class="form-label-modern">نوع الاشتراك</label>
                        <select name="subscription_type_id" class="form-select form-select-modern w-100">
                            <option value="">الكل</option>
                            @foreach($subscriptionTypes as $type)
                                <option value="{{ $type->id }}" @selected(request('subscription_type_id') == $type->id)>{{ $type->type_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label-modern">حالة الاشتراك</label>
                        <select name="subscription_status_name" class="form-select form-select-modern w-100">
                            <option value="">الكل</option>
                            @foreach($subscriptionStatuses as $status)
                                <option value="{{ $status->status_name }}" @selected(request('subscription_status_name') == $status->status_name)>{{ $status->status_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 d-flex align-items-end">
                        <button type="submit" name="search" value="1" class="btn btn-filter-submit w-100">
                            <i class="la la-search"></i> بحث وتصفية
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ===============================
            Results Table
        =============================== --}}
        @if(request()->has('search') && $clients instanceof \Illuminate\Pagination\LengthAwarePaginator && $clients->count() > 0)
            <div class="table-card-modern">
                <div class="table-card-header-modern">
                    <i class="la la-list"></i>
                    <h5>نتائج البحث</h5>
                </div>
                <div class="table-responsive table-scroll-wrapper">
                    <table class="table table-modern align-middle mb-0">
                        <thead>
                            <tr>
                                <th>المشترك</th>
                                <th>المدينة / العنوان</th>
                                <th>الهاتف</th>
                                <th>معلومات الاشتراك</th>
                                <th>نسبة الالتزام</th>
                                <th>تاريخ آخر تسليم</th>
                                <th>أيام بدون تسليم</th>
                                <th>الموزع</th>
                                <th>إجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold" style="color: var(--primary-deep);">{{ $client->client_name ?? '-' }}</div>
                                        <div class="text-muted small">{{ $client->contract_no ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $client->city_name ?? '-' }}</div>
                                        <div class="text-muted small">{{ $client->address ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div>{{ $client->phone_one ?? '-' }}</div>
                                        @if($client->phone_two) <div class="text-muted small">{{ $client->phone_two }}</div> @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-modern badge-primary-modern">{{ $client->subscription_type_name ?? '-' }}</span>
                                        <span class="badge badge-modern badge-success-modern">{{ $client->subscription_status_name ?? '-' }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $rate = $client->percentage_delivery_rate ?? 0;
                                            $color = $rate >= 80 ? 'success' : ($rate >= 50 ? 'warning' : 'danger');
                                        @endphp
                                        <span class="badge badge-modern badge-{{ $color }}-modern">{{ number_format($rate, 1) }}%</span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold" style="color: var(--primary-deep);">{{ $client->last_delivery_date ? \Carbon\Carbon::parse($client->last_delivery_date)->format('Y-m-d') : 'لم يتسلم' }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold" style="color: var(--danger-color);">{{ $client->days_since_last_delivery ?? 0 }} يوم</span>
                                    </td>
                                    <td>{{ $client->distributor_name ?? '-' }}</td>
                                    <td class="pe-4">
                                        <div class="btn-group unified-actions-dropdown dropdown">
                                            <button type="button" class="btn btn-action-modern btn-sm dropdown-toggle" data-toggle="dropdown">
                                                <i class="la la-cog"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-modern dropdown-menu-right">
                                                <a class="dropdown-item dropdown-item-modern" href="{{ url('admin/client/' . $client->client_id . '/show') }}">
                                                    <i class="la la-eye"></i> معاينة
                                                </a>
                                                <a class="dropdown-item dropdown-item-modern" href="{{ url('admin/client-report?client_id=' . $client->client_id) }}">
                                                    <i class="la la-file-alt"></i> تقرير
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item dropdown-item-modern text-success" href="{{ backpack_url('delivery/create?client_id=' . $client->client_id) }}">
                                                    <i class="la la-truck"></i> تسليم
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                <div class="p-4 border-top">
                    <div class="pagination-modern">
                        {{ $clients->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        @elseif(request()->has('search'))
            <div class="alert alert-warning alert-modern text-center">
                <i class="la la-exclamation-circle" style="font-size: 24px;"></i>
                <p class="mt-2 mb-0">لا توجد نتائج تطابق معايير البحث.</p>
            </div>
        @endif

    </div>
</div>
@endsection
