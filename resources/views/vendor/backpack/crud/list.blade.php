@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">

    {{-- CRUD LIST CONTENT - crud_list_styles stack --}}
    @stack('crud_list_styles')
    
    {{-- ============================================
         Unified Visual Identity - All CRUD Pages
         الهوية البصرية الموحدة لجميع صفحات CRUD
         ============================================ --}}
    <style>
        /* ============================================
           Page Header - Unified Design
           ============================================ */
        section.header-operation,
        section.header-operation.container-fluid,
        section.header-operation.animated,
        section.header-operation.fadeIn {
            background: var(--primary-deep) !important;
            border-radius: 20px !important;
            padding: 1.5rem 2rem !important;
            margin-bottom: 2rem !important;
            box-shadow: var(--shadow-md) !important;
            position: relative !important;
            overflow: visible !important;
            height: auto !important;
            min-height: auto !important;
            max-height: none !important;
            width: 100% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-wrap: wrap !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
        }

        section.header-operation::before {
            display: none !important;
        }

        section.header-operation h1,
        section.header-operation h1.text-capitalize,
        section.header-operation h1.mb-0 {
            color: #fff !important;
            font-size: 24px !important;
            font-weight: 800 !important;
            margin: 0 !important;
            margin-bottom: 0 !important;
            font-family: 'Cairo', sans-serif !important;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2) !important;
            position: relative !important;
            z-index: 1 !important;
            display: flex !important;
            align-items: center !important;
            gap: 1rem !important;
            padding-right: 70px !important;
            padding-left: 0 !important;
            line-height: 1.2 !important;
        }

        section.header-operation h1::before {
            content: '' !important;
            width: 56px !important;
            height: 56px !important;
            background: rgba(255, 255, 255, 0.1) !important;
            border-radius: 16px !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
            position: absolute !important;
            right: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        section.header-operation h1::after {
            content: '\f500' !important; /* user-friends icon - Line Awesome */
            font-family: 'Line Awesome Free' !important;
            font-weight: 900 !important;
            font-size: 24px !important;
            color: #fff !important;
            position: absolute !important;
            right: 16px !important;
            z-index: 2 !important;
        }
        
        /* إخفاء أيقونة الشخص من HTML لصفحة قائمة الموزعين */
        section.header-operation i.la-user-tie {
            display: none !important;
        }
        /* صفحة المخزون: إظهار أيقونة المستودع فقط دون تكرار مع ::before/::after */
        section.header-operation.inventory-list-page h1::before,
        section.header-operation.inventory-list-page h1::after {
            display: none !important;
        }
        /* صفحة المدن: إظهار أيقونة الموقع فقط */
        section.header-operation.city-list-page h1::before,
        section.header-operation.city-list-page h1::after {
            display: none !important;
        }
        /* صفحة المدن: ترتيب أعمدة الجدول وعرضها */
        .city-crud-table #crudTable { table-layout: auto; width: 100%; }
        .city-crud-table #crudTable thead th[data-column-name="city_name"],
        .city-crud-table #crudTable tbody td:nth-child(1) { text-align: right; min-width: 200px; }
        .city-crud-table #crudTable thead th[data-column-name="actions"],
        .city-crud-table #crudTable tbody td:nth-child(2) { text-align: center; width: 120px; min-width: 120px; }
        /* صفحة المخزون: توحيد مظهر أزرار الإجراءات مع الهوية البصرية */
        .inventory-list-page #crudTable tbody td:last-child .btn-group {
            display: inline-flex !important;
            gap: 0 !important;
        }
        .inventory-list-page #crudTable tbody td:last-child .btn-group .btn-link {
            min-width: 2rem;
            padding: 0.35rem 0.5rem;
            color: var(--primary-deep) !important;
        }
        .inventory-list-page #crudTable tbody td:last-child .btn-group .btn-link.text-danger {
            color: var(--danger-color, #dc3545) !important;
        }
        
        /* زر إضافة موزع في header */
        .btn-success-unified {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 700 !important;
            font-family: 'Cairo', sans-serif !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
        }
        
        .btn-success-unified:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            transform: translateY(-2px) !important;
            color: #fff !important;
        }

        section.header-operation p,
        section.header-operation p.ms-2,
        section.header-operation p.ml-2,
        section.header-operation p.mb-0 {
            color: rgba(255, 255, 255, 0.8) !important;
            font-size: 14px !important;
            margin: 0 !important;
            margin-top: 4px !important;
            margin-right: 0 !important;
            margin-bottom: 0 !important;
            font-weight: 500 !important;
            position: relative !important;
            z-index: 1 !important;
            line-height: 1.4 !important;
        }

        .header-operation p:empty {
            display: none;
        }

        /* Buttons in header */
        section.header-operation .btn,
        section.header-operation a.btn,
        section.header-operation button.btn,
        section.header-operation .btn-success,
        section.header-operation .btn-primary,
        section.header-operation a.btn-success,
        section.header-operation a.btn-primary {
            height: 42px !important;
            border-radius: 12px !important;
            font-weight: 700 !important;
            font-size: 13px !important;
            padding: 0 18px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            transition: all 0.2s ease !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            position: relative !important;
            z-index: 1 !important;
            text-decoration: none !important;
            white-space: nowrap !important;
            background: rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
        }

        section.header-operation .btn:hover,
        section.header-operation a.btn:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important;
        }

        /* إزالة أي تعارضات من Bootstrap أو Backpack */
        section.header-operation.container-fluid {
            padding-left: 2rem !important;
            padding-right: 2rem !important;
        }

        /* إخفاء breadcrumbs وروابط العودة */
        .breadcrumb, .breadcrumb-item, nav[aria-label="breadcrumb"], ol.breadcrumb {
            display: none !important;
        }

        /* ============================================
           Table Container - Unified Design
           ============================================ */
        .row[bp-section="crud-operation-list"] > div {
            background: #ffffff !important;
            border-radius: 20px !important;
            padding: 28px !important;
            box-shadow: var(--shadow-md) !important;
            border: 1px solid #f1f5f9 !important;
        }

        /* ============================================
           DataTable - Unified Design
           ============================================ */
        table.dataTable thead th {
            background: var(--primary-deep) !important;
            color: #ffffff !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            border: none !important;
            padding: 14px 20px !important;
            text-align: center !important;
        }

        table.dataTable tbody tr:hover {
            background: #f8f6ff !important;
        }

        /* ===============================
           Badges Styles for Delivery List
        =============================== */
        .badge-soft-purple {
            background: var(--primary-deep) !important;
            color: #fff !important;
        }

        .badge-danger-custom {
            background: var(--danger-color) !important;
            color: #fff !important;
        }

        .badge-warning-custom {
            background: var(--warning-color) !important;
            color: #fff !important;
        }

        .badge-success-custom {
            background: var(--success-gradient) !important;
            color: #fff !important;
        }
        
        /* ===============================
           Users Table - تحسين جدول المستخدمين
        =============================== */
        @if(request()->is('*/user') || request()->is('*/user/*'))
        table.dataTable thead th,
        table#crudTable thead th {
            text-align: center !important;
        }
        
        table.dataTable tbody td,
        table#crudTable tbody td {
            text-align: center !important;
            vertical-align: middle !important;
            padding: 15px 20px !important;
        }
        
        table.dataTable tbody td:first-child,
        table#crudTable tbody td:first-child {
            text-align: right !important;
            font-weight: 600 !important;
            color: var(--primary-deep) !important;
        }
        
        table.dataTable tbody td:nth-child(2),
        table#crudTable tbody tbody td:nth-child(2) {
            text-align: center !important;
            color: #64748b !important;
        }
        
        table.dataTable tbody td .badge,
        table#crudTable tbody td .badge {
            padding: 6px 12px !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            font-size: 13px !important;
        }
        
        table.dataTable tbody td .fw-semibold,
        table#crudTable tbody td .fw-semibold {
            font-weight: 600 !important;
        }
        
        table.dataTable tbody tr:hover,
        table#crudTable tbody tr:hover {
            background: #f8f6ff !important;
            transition: background 0.2s ease !important;
        }
        @endif
        
        /* ===============================
           Clients Table - تحسين جدول العملاء
        =============================== */
        .clients-table-wrapper {
            background: #ffffff !important;
            border-radius: 20px !important;
            padding: 25px !important;
            box-shadow: var(--shadow-md) !important;
            border: 1px solid #f1f5f9 !important;
            overflow-x: auto !important;
        }
        
        .clients-table {
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
        }
        
        .clients-table thead th {
            background: var(--primary-deep) !important;
            color: #ffffff !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            padding: 15px 20px !important;
            text-align: center !important;
            border: none !important;
            white-space: nowrap !important;
        }
        
        .clients-table tbody td {
            padding: 15px 20px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            vertical-align: middle !important;
        }
        
        .clients-table tbody tr:hover {
            background: #f8f6ff !important;
        }
        
        .clients-table tbody tr:last-child td {
            border-bottom: none !important;
        }
        
        /* ===============================
           Pagination - إصلاح Pagination
        =============================== */
        .pagination-wrapper {
            margin-top: 30px !important;
            padding: 20px 0 !important;
        }
        
        .pagination-wrapper .pagination {
            margin: 0 !important;
            justify-content: center !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }
        
        .pagination-wrapper .pagination .page-link,
        .pagination-wrapper .pagination .page-item .page-link {
            padding: 10px 16px !important;
            border-radius: 10px !important;
            border: 1px solid #e2e8f0 !important;
            color: var(--primary-deep) !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            background: #ffffff !important;
            min-width: 42px !important;
            height: 42px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-decoration: none !important;
            transition: all 0.2s ease !important;
        }
        
        .pagination-wrapper .pagination .page-link:hover {
            background: var(--primary-deep) !important;
            color: #ffffff !important;
            border-color: var(--primary-deep) !important;
            transform: translateY(-2px) !important;
        }
        
        .pagination-wrapper .pagination .page-item.active .page-link {
            background: var(--primary-deep) !important;
            color: #ffffff !important;
            border-color: var(--primary-deep) !important;
            box-shadow: 0 4px 12px rgba(111, 106, 248, 0.3) !important;
        }
        
        .pagination-wrapper .pagination .page-item.disabled .page-link {
            opacity: 0.5 !important;
            cursor: not-allowed !important;
            background: #f8f9fa !important;
            color: #6c757d !important;
        }
        
        /* إخفاء الأسهم الكبيرة */
        .pagination-wrapper .pagination .page-link svg,
        .pagination-wrapper .pagination .page-link i[class*="chevron"],
        .pagination-wrapper .pagination .page-link i[class*="arrow"] {
            font-size: 14px !important;
            width: auto !important;
            height: auto !important;
            margin: 0 !important;
        }
        
        /* إصلاح أي عناصر pagination كبيرة */
        .pagination-wrapper * {
            max-width: 100% !important;
            box-sizing: border-box !important;
        }
        
        /* إخفاء أي عناصر pagination غير مرئية */
        .pagination-wrapper .pagination .page-item:not(.active):not(:hover) .page-link {
            opacity: 1 !important;
        }

        /* أزرار الإجراءات: إظهار الأيقونة فقط وإخفاء النص (معاينة، تعديل، حذف) */
        #crudTable tbody td a.btn.btn-link span {
            display: none !important;
        }
        #crudTable tbody td a.btn.btn-link {
            min-width: 2rem;
            padding: 0.35rem 0.5rem;
        }
        /* ترتيب أزرار الإجراءات بدون فراغات بينها */
        #crudTable tbody td:last-child {
            display: flex !important;
            flex-wrap: nowrap !important;
            gap: 0 !important;
            align-items: center !important;
            justify-content: center !important;
            white-space: nowrap !important;
        }
        #crudTable tbody td:last-child a.btn.btn-link {
            margin: 0 !important;
            border-radius: 0 !important;
        }
        #crudTable tbody td:last-child a.btn.btn-link:not(:last-child) {
            border-left-width: 0 !important;
        }
        #crudTable tbody td:last-child a.btn.btn-link:first-child {
            border-radius: 0.25rem 0 0 0.25rem !important;
        }
        #crudTable tbody td:last-child a.btn.btn-link:last-child {
            border-radius: 0 0.25rem 0.25rem 0 !important;
        }

        /* غلاف الجدول مع سكرول أفقي - يبقي الجدول داخل الديف */
        .crud-table-scroll-x {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 20px;
        }
        .crud-table-scroll-x .dataTables_wrapper,
        .crud-table-scroll-x #crudTable_wrapper {
            min-width: 100%;
        }
    </style>
@endsection

@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.list') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none {{ request()->is('*/inventory-item*') ? 'inventory-list-page' : '' }} {{ request()->is('*/city*') ? 'city-list-page' : '' }}" bp-section="page-header">
        <div class="header-content-wrapper" style="display: flex; align-items: center; gap: 1rem; width: 100%; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                @if(request()->is('*/client') || request()->is('*/client/*'))
                <i class="la la-users" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
                @elseif(request()->is('*/delivery') || request()->is('*/delivery/*'))
                <i class="la la-truck" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
                @elseif(request()->is('*/client-type*'))
                <i class="la la-tags" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
                @elseif(request()->is('*/client-deposit') || request()->is('*/client-deposit/*'))
                <i class="la la-box-open" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
                @elseif(request()->is('*/client-payment') || request()->is('*/client-payment/*'))
                <i class="la la-money-bill" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
                @elseif(request()->is('*/inventory-item') || request()->is('*/inventory-item/*'))
                <i class="la la-warehouse" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
                @elseif(request()->is('*/city') || request()->is('*/city/*'))
                <i class="la la-map-marker-alt" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
                @endif
                <h1 class="text-capitalize mb-0" bp-section="page-heading">
                    @if(request()->is('*/delivery') || request()->is('*/delivery/*'))
                        إضافة تسليم
                    @elseif(request()->is('*/client') || request()->is('*/client/*'))
                        العملاء
                    @elseif(request()->is('*/client-deposit') || request()->is('*/client-deposit/*'))
                        أمانات العملاء
                    @elseif(request()->is('*/client-payment') || request()->is('*/client-payment/*'))
                        مدفوعات المشتركين
                    @elseif(request()->is('*/inventory-item') || request()->is('*/inventory-item/*'))
                        المخزون
                    @elseif(request()->is('*/city') || request()->is('*/city/*'))
                        المدن
                    @else
                        {!! $crud->getHeading() ?? $crud->entity_name_plural !!}
                    @endif
                </h1>
            </div>
            
            @php
                $isDistributorList = request()->is('*/distributor') && !request()->is('*/distributor/*');
            @endphp
            
            <div class="page-header-actions" style="display: flex; gap: 0.75rem;">
                @if($isDistributorList && $crud->hasAccess('create'))
                <a href="{{ backpack_url('distributor/create') }}" class="btn btn-success-unified">
                    <i class="la la-plus"></i> إضافة موزع
                </a>
                @elseif((request()->is('*/client') || request()->is('*/client/*')) && $crud->hasAccess('create'))
                <a href="{{ backpack_url('client/create') }}" class="btn btn-primary-unified" style="background: rgba(255,255,255,0.1) !important; border: 1px solid rgba(255,255,255,0.2) !important; border-radius: 12px; padding: 10px 20px; font-weight: 700;">
                    <i class="la la-plus"></i> إضافة عميل
                </a>
                @elseif((request()->is('*/client-type') || request()->is('*/client-type/*')) && $crud->hasAccess('create'))
                <a href="{{ backpack_url('client-type/create') }}" class="btn btn-success-unified">
                    <i class="la la-plus"></i> إضافة نوع عميل
                </a>
                @elseif($crud->hasAccess('create'))
                @php
                    $routePath = $crud->route;
                    $prefix = config('backpack.base.route_prefix', 'admin');
                    if (strpos($routePath, $prefix . '/') === 0) {
                        $routePath = substr($routePath, strlen($prefix) + 1);
                    }
                    $addButtonText = 'إضافة';
                    if (request()->is('*/client-deposit') || request()->is('*/client-deposit/*')) {
                        $addButtonText = 'إضافة أمانة';
                    } elseif (request()->is('*/client-payment') || request()->is('*/client-payment/*')) {
                        $addButtonText = 'إضافة دفعة';
                    } elseif (request()->is('*/inventory-item') || request()->is('*/inventory-item/*')) {
                        $addButtonText = 'إضافة صنف';
                    } elseif (request()->is('*/city') || request()->is('*/city/*')) {
                        $addButtonText = 'إضافة مدينة';
                    }
                @endphp
                <a href="{{ backpack_url($routePath . '/create') }}" class="btn btn-success-unified">
                    <i class="la la-plus"></i> {{ $addButtonText }}
                </a>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('content')
  {{-- Default box --}}
  <div class="row" bp-section="crud-operation-list">

    {{-- THE ACTUAL CONTENT --}}
    <div class="{{ $crud->getListContentClass() }}">

        {{-- إضافة فلاتر موحدة لصفحة الموزعين --}}
        @if(request()->is('*/distributor*') && !request()->is('*/distributor/*/show') && !request()->is('*/distributor/*/edit') && !request()->is('*/distributor/*/create'))
            @include('admin.distributor_filters')
        @endif

        {{-- فلاتر الفواتير (صفحة قائمة الفواتير فقط) --}}
        @php $path = request()->path(); @endphp
        @if(str_contains($path, 'invoice') && !str_contains($path, 'invoice/'))
            @include('admin.invoice_filters')
        @endif

        {{-- فلاتر مدفوعات المشتركين --}}
        @if(str_contains($path, 'client-payment') && !str_contains($path, 'client-payment/'))
            @include('admin.client_payment_filters')
        @endif

        {{-- فلاتر أمانات المشتركين --}}
        @if(str_contains($path, 'client-deposit') && !str_contains($path, 'client-deposit/'))
            @include('admin.client_deposit_filters')
        @endif

        {{-- فلاتر المصروفات --}}
        @if(str_contains($path, 'expense') && !str_contains($path, 'expense/'))
            @include('admin.expense_filters')
        @endif

        {{-- فلاتر مدفوعات الموردين --}}
        @if(str_contains($path, 'vendor-payment') && !str_contains($path, 'vendor-payment/'))
            @include('admin.vendor_payment_filters')
        @endif

        {{-- فلاتر المخزون + عرض المجموع --}}
        @if(str_contains($path, 'inventory-item') && !str_contains($path, 'inventory-item/'))
            @include('admin.inventory_item_filters')
            @php $inventoryTotal = $crud->get('inventoryQuantityTotal'); @endphp
            @if($inventoryTotal !== null)
            <div class="alert alert-light border mb-3 d-flex align-items-center" style="background: #f8fafc; border-radius: 12px;">
                <i class="la la-calculator la-lg me-2" style="color: var(--primary-deep);"></i>
                <strong class="text-dark" style="margin-inline-end: 4.5rem;">مجموع الكميات (النتائج المفلترة):</strong>
                <span class="fw-bold" style="color: var(--primary-deep); font-size: 1.5rem;">{{ number_format($inventoryTotal) }}</span>
            </div>
            @endif
        @endif

        {{-- إضافة فلاتر موحدة لصفحة العملاء --}}
        @if(request()->is('*/client') && !request()->is('*/client-type*') && !request()->is('*/client/*/show') && !request()->is('*/client/*/edit') && !request()->is('*/client/*/create'))
            @include('admin.client_filters')
            
            {{-- جدول العملاء - عرض مباشر من قاعدة البيانات --}}
            @php
                $perPage = request('per_page', 50);
                $perPage = in_array($perPage, [10, 50, 100, 'all']) ? $perPage : 50;
                
                $clientsQuery = \App\Models\Client::query()->with(['city', 'subscriptionStatus', 'subscriptionType', 'distributor', 'lastDelivery', 'deliveries']);
                // تطبيق الفلاتر
                if (request("city_id")) $clientsQuery->where("city_id", request("city_id"));
                if (request("client_type")) $clientsQuery->where("client_type", request("client_type"));
                if (request("client_status_id")) $clientsQuery->where("client_status_id", request("client_status_id"));
                if (request("subscription_type_id")) $clientsQuery->where("subscription_type_id", request("subscription_type_id"));
                if (request("subscription_status_id")) $clientsQuery->where("subscription_status_id", request("subscription_status_id"));
                
                $searchTerm = request("search");
                if ($searchTerm) {
                    $clientsQuery->where(function($q) use ($searchTerm) {
                        $q->where("name", "like", "%" . $searchTerm . "%")
                          ->orWhere("phone_one", "like", "%" . $searchTerm . "%")
                          ->orWhere("address", "like", "%" . $searchTerm . "%");
                    });
                }

                $totalClients = $clientsQuery->count();
                $clients = $perPage === 'all' ? $clientsQuery->orderBy('id', 'desc')->get() : $clientsQuery->orderBy('id', 'desc')->paginate($perPage);
            @endphp
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="clients-table-wrapper">
                        <table class="clients-table table table-clean align-middle mb-0" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th class="ps-4">معلومات العميل</th>
                                <th>الموقع</th>
                                <th class="text-center">الهاتف</th>
                                <th class="text-center">معلومات الاشتراك</th>
                                <th class="pe-4 text-center">إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $client)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-primary-deep">{{ $client->name }}</div>
                                        <div class="text-muted small">{{ $client->contract_no }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $client->city ? $client->city->city_name : '-' }}</div>
                                        <div class="text-muted small">{{ $client->address }}</div>
                                    </td>
                                    <td class="text-center">{{ $client->phone_one }}</td>
                                    <td class="text-center" style="text-align: center !important;">
                                        <div style="display: flex; flex-direction: column; align-items: center; gap: 5px;">
                                            <span class="badge bg-primary-deep text-white">{{ $client->subscriptionType ? $client->subscriptionType->type_name : '-' }}</span>
                                            <span class="badge bg-success text-white">{{ $client->subscriptionStatus ? $client->subscriptionStatus->status_name : '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="pe-4 text-center">
                                        <a href="{{ backpack_url('client/' . $client->id . '/show') }}" class="btn btn-sm btn-primary"><i class="la la-eye"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-5 text-muted">لا توجد بيانات</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                    @if($perPage !== 'all' && $clients->hasPages())
                        <div class="mt-4 pagination-wrapper" style="display: flex; justify-content: center; align-items: center;">
                            {{ $clients->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- الجدول الافتراضي لـ CRUD - يظهر فقط إذا لم تكن صفحة العملاء أو التسليم --}}
        @if(!request()->is('*/client') && !request()->is('*/client/*') && !request()->is('*/delivery') && !request()->is('*/delivery/*'))
            <div class="crud-table-scroll-x {{ (str_contains($path, 'city') && !str_contains($path, 'city/')) ? 'city-crud-table' : '' }}">
                <div class="{{ backpack_theme_config('classes.tableWrapper') }}">
                <table id="crudTable" class="table table-clean align-middle mb-0" cellspacing="0">
                <thead>
                  <tr>
                    @foreach ($crud->columns() as $column)
                      <th data-column-name="{{ $column['name'] }}">{!! $column['label'] !!}</th>
                    @endforeach
                    @php
                      $hasCustomActionsColumn = collect($crud->columns())->contains('name', 'actions');
                      $hasLineButtons = $crud->buttons()->where('stack', 'line')->count() > 0;
                    @endphp
                    @if ( $hasLineButtons && !$hasCustomActionsColumn )
                      <th data-action-column="true">{{ trans('backpack::crud.actions') }}</th>
                    @endif
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
                </div>
            </div>
        @endif

    </div>
  </div>
@endsection

@section('after_scripts')
  @include('crud::inc.datatables_logic')
  <script>
      // Force unified styling on standard DataTables
      document.addEventListener('DOMContentLoaded', function() {
          if (typeof jQuery !== 'undefined') {
              jQuery('#crudTable').on('draw.dt', function() {
                  jQuery(this).find('thead th').css('background-color', 'var(--primary-deep)');
                  jQuery(this).find('thead th').css('color', '#ffffff');
              });
          }
      });
      
      // إخفاء عمود الإجراءات الافتراضي إذا كان هناك عمود actions مخصص (تفادي التكرار)
      (function() {
          function hideDefaultActionsColumn() {
              const hasCustomActionsColumn = document.querySelector('th[data-column-name="actions"]') !== null;
              if (!hasCustomActionsColumn) return;
              const defaultActionColumn = document.querySelector("th[data-action-column=\"true\"]");
              if (!defaultActionColumn) return;
              const columnIndex = Array.from(defaultActionColumn.parentElement.children).indexOf(defaultActionColumn);
              defaultActionColumn.style.display = "none";
              document.querySelectorAll("#crudTable tbody tr").forEach(function(row) {
                  const cell = row.children[columnIndex];
                  if (cell) cell.style.display = "none";
              });
          }
          
          // تنفيذ فوراً
          if (document.readyState === "loading") {
              document.addEventListener("DOMContentLoaded", hideDefaultActionsColumn);
          } else {
              hideDefaultActionsColumn();
          }
          
          // تنفيذ بعد رسم DataTable
          if (typeof jQuery !== "undefined" && jQuery("#crudTable").length) {
              jQuery("#crudTable").on("draw.dt", function() {
                  setTimeout(hideDefaultActionsColumn, 100);
              });
          }
      })();
  </script>
@endsection
