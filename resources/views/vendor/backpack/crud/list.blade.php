@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">
    
    {{-- DATA TABLES --}}
    @basset('https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css')
    @basset('https://cdn.datatables.net/fixedheader/3.3.1/css/fixedHeader.dataTables.min.css')
    @basset('https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css')

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
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
            border-radius: 20px !important;
            padding: 1.5rem 2rem !important;
            margin-bottom: 2rem !important;
            box-shadow: 0 10px 30px rgba(111, 106, 248, 0.3) !important;
            position: relative !important;
            overflow: hidden !important;
            height: auto !important;
            min-height: auto !important;
            max-height: none !important;
            width: 100% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-wrap: wrap !important;
        }

        section.header-operation::before {
            content: '' !important;
            position: absolute !important;
            top: -50% !important;
            right: -50% !important;
            width: 200% !important;
            height: 200% !important;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%) !important;
            animation: pulse 3s ease-in-out infinite !important;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 0.5;
            }
            50% {
                opacity: 0.8;
            }
        }

        section.header-operation h1,
        section.header-operation h1.text-capitalize,
        section.header-operation h1.mb-0 {
            color: #fff !important;
            font-size: 24px !important;
            font-weight: 700 !important;
            margin: 0 !important;
            margin-bottom: 0 !important;
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
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
            background: rgba(255, 255, 255, 0.2) !important;
            border-radius: 16px !important;
            backdrop-filter: blur(10px) !important;
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
        
        /* زر إضافة موزع في header */
        .btn-success-unified {
            background: rgba(255, 255, 255, 0.2) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            color: #fff !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            font-family: 'Cairo', sans-serif !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
        }
        
        .btn-success-unified:hover {
            background: rgba(255, 255, 255, 0.3) !important;
            transform: translateY(-2px) !important;
            color: #fff !important;
        }

        section.header-operation p,
        section.header-operation p.ms-2,
        section.header-operation p.ml-2,
        section.header-operation p.mb-0 {
            color: rgba(255, 255, 255, 0.9) !important;
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
            font-weight: 600 !important;
            font-size: 13px !important;
            padding: 0 18px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            transition: all 0.2s ease !important;
            border: none !important;
            position: relative !important;
            z-index: 1 !important;
            text-decoration: none !important;
            white-space: nowrap !important;
        }

        section.header-operation .btn-success,
        section.header-operation a.btn-success {
            background: rgba(34, 197, 94, 0.2) !important;
            color: #fff !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
        }

        section.header-operation .btn-success:hover,
        section.header-operation a.btn-success:hover {
            background: rgba(34, 197, 94, 0.3) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 20px rgba(34, 197, 94, 0.3) !important;
        }

        section.header-operation .btn-primary,
        section.header-operation a.btn-primary {
            background: rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
        }

        section.header-operation .btn-primary:hover,
        section.header-operation a.btn-primary:hover {
            background: rgba(255, 255, 255, 0.3) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.2) !important;
        }

        /* إزالة أي تعارضات من Bootstrap أو Backpack */
        section.header-operation.container-fluid {
            padding-left: 2rem !important;
            padding-right: 2rem !important;
        }

        section.header-operation.d-flex {
            display: flex !important;
        }

        section.header-operation.align-items-baseline {
            align-items: center !important;
        }

        section.header-operation.mb-2 {
            margin-bottom: 2rem !important;
        }

        /* إزالة أي خلفيات بيضاء أو ألوان قديمة */
        section.header-operation[style*="background"],
        section.header-operation[style*="background-color"] {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
        }

        /* إخفاء رابط العودة و breadcrumbs */
        section.header-operation small,
        section.header-operation .breadcrumb,
        section.header-operation .back-link {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            height: 0 !important;
            width: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* إخفاء روابط العودة */
        section.header-operation a[href*="back"],
        section.header-operation a[href*="العودة"] {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
        }

        /* إخفاء breadcrumbs في الصفحة */
        .breadcrumb,
        .breadcrumb-item,
        nav[aria-label="breadcrumb"],
        ol.breadcrumb {
            display: none !important;
        }

        /* ============================================
           Table Container - Unified Design
           ============================================ */
        .container-fluid[bp-section="crud-operation-list"],
        .row[bp-section="crud-operation-list"] {
            position: relative !important;
            z-index: 1 !important;
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            padding: 0 !important;
        }

        .row[bp-section="crud-operation-list"] > div {
            background: #ffffff !important;
            border-radius: 20px !important;
            padding: 28px !important;
            box-shadow: 0 6px 20px rgba(0,0,0,0.05) !important;
            margin-top: 0 !important;
            position: relative !important;
            z-index: 2 !important;
        }

        /* ============================================
           Search Input - Unified Design
           ============================================ */
        #datatable_search_stack input {
            border-radius: 16px !important;
            background: #f5f6fa !important;
            border: none !important;
        }

        /* ============================================
           Buttons - Unified Design
           ============================================ */
        a.btn-primary, button.btn-primary {
            background: #7d5bff !important;
            border-color: #7d5bff !important;
            border-radius: 14px !important;
            padding: 12px 20px !important;
            margin-bottom: 20px;
            font-size: 16px !important;
        }

        /* ============================================
           DataTable - Unified Design
           ============================================ */
        table.dataTable {
            border-radius: 18px !important;
            overflow: hidden;
            border: none !important;
        }

        table.dataTable thead th {
            background: #f5f6fa !important;
            color: #333 !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            border-bottom: none !important;
            padding: 14px 20px !important;
            text-align: center !important;
            vertical-align: middle !important;
        }

        table.dataTable tbody tr {
            background: #ffffff !important;
            border-bottom: 1px solid #f0f0f5 !important;
            transition: 0.2s ease;
        }

        table.dataTable tbody tr:hover {
            background: #f8f6ff !important;
        }

        table.dataTable tbody td {
            padding: 16px 20px !important;
            font-size: 15px !important;
            color: #333 !important;
            border: none !important;
            text-align: center !important;
            vertical-align: middle !important;
        }

        table a.btn,
        table button.btn {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            color: #7c5cff !important;
            font-weight: 600;
        }

        /* ============================================
           DataTables Info - Hide
           ============================================ */
        #crudTable_info,
        .dataTables_info {
            display: none !important;
        }

        /* ============================================
           Pagination - RTL Arabic Style
           ============================================ */
        #crudTable_paginate,
        .dataTables_paginate {
            direction: rtl !important;
            text-align: right !important;
        }

        #crudTable_paginate ul.pagination,
        .dataTables_paginate ul.pagination {
            direction: ltr !important; /* نستخدم LTR للقائمة نفسها */
            flex-direction: row !important; /* اتجاه عادي */
            justify-content: center !important;
            display: flex !important;
        }

        #crudTable_paginate .paginate_button,
        .dataTables_paginate .paginate_button {
            margin-left: 0.25rem !important;
            margin-right: 0.25rem !important;
        }

        /* ترتيب الأزرار: Previous على اليمين، Next على اليسار */
        /* في RTL: Previous يجب أن يكون أولاً (على اليمين)، Next آخراً (على اليسار) */
        #crudTable_paginate .paginate_button.previous,
        .dataTables_paginate .paginate_button.previous {
            order: 1 !important;
        }

        #crudTable_paginate .paginate_button.next,
        .dataTables_paginate .paginate_button.next {
            order: 3 !important;
        }

        /* الأرقام في المنتصف */
        #crudTable_paginate .paginate_button:not(.previous):not(.next),
        .dataTables_paginate .paginate_button:not(.previous):not(.next) {
            order: 2 !important;
        }

        /* ============================================
           Responsive Design
           ============================================ */
        @media (max-width: 768px) {
            section.header-operation {
                padding: 1.25rem 1.5rem !important;
                border-radius: 16px !important;
            }

            section.header-operation h1 {
                font-size: 20px !important;
            }

            section.header-operation h1::before {
                width: 48px !important;
                height: 48px !important;
            }

            section.header-operation h1::after {
                font-size: 20px !important;
                right: 14px !important;
            }
        }

        @media (max-width: 576px) {
            section.header-operation {
                padding: 1rem !important;
            }

            section.header-operation h1 {
                font-size: 18px !important;
                padding-right: 0 !important;
            }

            section.header-operation h1::before,
            section.header-operation h1::after {
                display: none !important;
            }
        }
        
        /* إخفاء النقاط الثلاث (dtr-control) من DataTables responsive */
        .dtr-control,
        .dtr-details,
        .dtr-details-control {
            display: none !important;
            visibility: hidden !important;
        }
        
        /* إخفاء أي خلايا تحتوي على dtr-control */
        td.dtr-control,
        th.dtr-control {
            display: none !important;
        }

        /* ============================================
           Distributor Page Specific Styles
           ============================================ */
        @php
          $isDistributorPage = false;
          try {
              if (request()->route() && request()->route()->getName()) {
                  $isDistributorPage = request()->is('*distributor*') && str_contains(request()->route()->getName(), 'distributor');
              } else {
                  $isDistributorPage = request()->is('*distributor*');
              }
          } catch (\Throwable $th) {
              $isDistributorPage = request()->is('*distributor*');
          }
        @endphp
        @if($isDistributorPage)
        table#crudTable th[data-action-column="true"]:not([data-column-name="actions"]) {
            display: none !important;
            width: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
            visibility: hidden !important;
        }

        table#crudTable tbody tr td[data-action-column="true"]:not([data-column-name="actions"]) {
            display: none !important;
            width: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
            visibility: hidden !important;
        }

        table#crudTable tbody tr td {
            position: relative;
            overflow: visible !important;
        }

        table#crudTable .btn-group {
            position: relative;
            z-index: 1000;
        }

        table#crudTable .dropdown-menu {
            z-index: 9999 !important;
            position: absolute !important;
            right: 0 !important;
            left: auto !important;
            top: 100% !important;
            margin-top: 0.125rem !important;
            min-width: 10rem !important;
        }

        table#crudTable {
            overflow: visible !important;
        }

        #crudTable_wrapper {
            overflow: visible !important;
        }

        #crudTable_wrapper .dataTables_scrollBody {
            overflow: visible !important;
        }
        @endif

        /* ============================================
           Clients Page - Hide Default Table Only
           ============================================ */
        @if(request()->is('*/client') && !request()->is('*/client-type*') && !request()->is('*/client/*/show') && !request()->is('*/client/*/edit') && !request()->is('*/client/*/create'))
        /* إخفاء الجدول الافتراضي فقط - استثناء الجدول الجديد */
        #crudTable_wrapper,
        #crudTable,
        table#crudTable,
        .dataTables_wrapper,
        .dataTables_scroll,
        .dataTables_scrollBody,
        .dataTables_scrollHead {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            height: 0 !important;
            width: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
        }

        /* إخفاء عناصر البحث الافتراضية */
        #datatable_search_stack,
        .input-icon,
        .row.mb-2.align-items-center:has(#datatable_search_stack) {
            display: none !important;
            visibility: hidden !important;
        }
        
        /* التأكد من ظهور الجدول الجديد */
        .clients-table-wrapper,
        .clients-table-wrapper *,
        table.clients-table,
        table.clients-table * {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        table.clients-table {
            display: table !important;
        }
        
        table.clients-table thead,
        table.clients-table tbody,
        table.clients-table tr,
        table.clients-table th,
        table.clients-table td {
            display: table-cell !important;
        }
        
        table.clients-table thead {
            display: table-header-group !important;
        }
        
        table.clients-table tbody {
            display: table-row-group !important;
        }
        
        table.clients-table tr {
            display: table-row !important;
        }
        
        /* ============================================
           Clients Page - Dropdown Menu Styles
           ============================================ */
        /* إصلاح overflow للشريط الأفقي */
        .clients-table-wrapper {
            overflow-x: auto !important;
            overflow-y: visible !important;
        }
        
        table.clients-table {
            overflow: visible !important;
        }
        
        table.clients-table tbody tr td:last-child a:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            opacity: 0.9;
        }
        
        /* ============================================
           تصميم زر العين الاحترافي
           ============================================ */
        .client-view-btn {
            position: relative;
            overflow: hidden;
        }
        
        .client-view-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1), height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1;
        }
        
        .client-view-btn:hover::before {
            width: 100px;
            height: 100px;
        }
        
        .client-view-btn:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 20px rgba(111, 106, 248, 0.4);
            background: linear-gradient(135deg, #5a55e8 0%, #6b6bff 100%);
        }
        
        .client-view-btn:active {
            transform: translateY(0) scale(0.98);
            box-shadow: 0 2px 8px rgba(111, 106, 248, 0.3);
        }
        
        .client-view-btn i {
            position: relative;
            z-index: 2;
            transition: transform 0.3s ease;
        }
        
        .client-view-btn:hover i {
            transform: scale(1.1);
        }
        @endif
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
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header">
        <div class="header-content-wrapper" style="display: flex; align-items: center; gap: 1rem; width: 100%; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                @if(request()->is('*/client') || request()->is('*/client/*'))
                <i class="la la-users" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
                @elseif(request()->is('*/delivery') || request()->is('*/delivery/*'))
                <i class="la la-truck" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
                @elseif(request()->is('*/client-type*'))
                <i class="la la-tags" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
                @endif
                <h1 class="text-capitalize mb-0" bp-section="page-heading">
                    @if(request()->is('*/delivery') || request()->is('*/delivery/*'))
                        إضافة تسليم
                    @elseif(request()->is('*/client') || request()->is('*/client/*'))
                        العملاء
                    @else
                        {!! $crud->getHeading() ?? $crud->entity_name_plural !!}
                    @endif
                </h1>
            </div>
            @php
                // التحقق من أننا في صفحة قائمة الموزعين فقط
                $isDistributorList = false;
                try {
                    // التحقق من entity name أو model
                    $entityName = $crud->entity_name_plural ?? '';
                    $modelClass = '';
                    try {
                        $modelClass = get_class($crud->getModel());
                    } catch (\Throwable $e) {
                        // Model غير متاح
                    }
                    
                    // التحقق من أننا في صفحة الموزعين
                    $isDistributorModel = str_contains($modelClass, 'Distributor') || 
                                         str_contains($entityName, 'موزع') || 
                                         str_contains($entityName, 'الموزعين');
                    
                    if ($isDistributorModel) {
                        $currentPath = request()->path();
                        $routeName = request()->route() ? request()->route()->getName() : '';
                        
                        // التحقق من أننا في صفحة القائمة وليس في صفحات أخرى
                        $isDistributorList = (
                            str_contains($routeName, 'distributor.index') ||
                            str_contains($routeName, 'crud.distributor.index') ||
                            ($currentPath === 'admin/distributor' || 
                             $currentPath === config('backpack.base.route_prefix', 'admin') . '/distributor') ||
                            (str_contains($currentPath, 'distributor') && 
                             !preg_match('/distributor\/\d+/', $currentPath) && 
                             !str_contains($currentPath, '/create') &&
                             !str_contains($currentPath, '/edit') &&
                             !str_contains($currentPath, '/show'))
                        );
                    }
                } catch (\Throwable $th) {
                    // Fallback: استخدام طريقة بسيطة
                    $isDistributorList = request()->is('*/distributor') && !request()->is('*/distributor/*');
                }
            @endphp
            @if($isDistributorList)
            <div class="page-header-actions" style="display: flex; gap: 0.75rem; position: relative; z-index: 2;">
                @if($crud->hasAccess('create'))
                <a href="{{ backpack_url('distributor/create') }}" class="btn btn-success-unified" style="background: rgba(255, 255, 255, 0.2) !important; border: 1px solid rgba(255, 255, 255, 0.3) !important; color: #fff !important; border-radius: 12px !important; padding: 0.75rem 1.5rem !important; font-weight: 600 !important; font-size: 14px !important; font-family: 'Cairo', sans-serif !important; transition: all 0.2s ease !important; text-decoration: none !important; display: inline-flex !important; align-items: center !important; gap: 0.5rem !important;">
                    <i class="la la-plus"></i>
                    إضافة موزع
                </a>
                @endif
            </div>
            @elseif(request()->is('*/client') || request()->is('*/client/*'))
            <div class="page-header-actions" style="display: flex; gap: 0.75rem;">
                {{-- زر إضافة عميل --}}
                @if($crud->hasAccess('create'))
                <a href="{{ backpack_url('client/create') }}" class="btn btn-primary-unified" style="background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important; border: none !important; color: #fff !important; border-radius: 12px !important; padding: 0.75rem 1.5rem !important; font-weight: 600 !important; font-size: 14px !important; font-family: 'Cairo', sans-serif !important; transition: all 0.2s ease !important; text-decoration: none !important; display: inline-flex !important; align-items: center !important; gap: 0.5rem !important; box-shadow: 0 4px 15px rgba(111, 106, 248, 0.3) !important;">
                    <i class="la la-plus"></i>
                    إضافة عميل
                </a>
                @endif
                
                {{-- أزرار التصدير --}}
                @php
                    $hasFilters = request()->has('name') || request()->has('city_id') || request()->has('client_type') || request()->has('client_status_id') || request()->has('subscription_type_id') || request()->has('subscription_status_id') || request()->has('phone');
                @endphp
                @if($hasFilters)
                <a href="{{ backpack_url('client/export/excel?' . http_build_query(request()->all())) }}" class="btn btn-success-unified" target="_blank">
                    <i class="la la-file-excel"></i>
                    تصدير Excel
                </a>
                <a href="{{ backpack_url('client/export/pdf?' . http_build_query(request()->all())) }}" class="btn btn-danger" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border: none; border-radius: 12px; padding: 10px 20px; font-weight: 600; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3); transition: all 0.2s ease;" target="_blank">
                    <i class="la la-file-pdf"></i>
                    تصدير PDF
                </a>
                @endif
            </div>
            @endif
        </div>
    </section>
    {{-- إخفاء breadcrumbs وروابط العودة --}}
    <style>
        /* إخفاء breadcrumbs */
        .breadcrumb,
        .breadcrumb-item,
        nav[aria-label="breadcrumb"],
        ol.breadcrumb {
            display: none !important;
        }

        /* إخفاء روابط العودة من button_stack */
        a[href*="back"],
        a:contains("العودة"),
        small a,
        .back-link {
            display: none !important;
        }

        /* إخفاء النص القديم والتصميم القديم */
        #datatable_info_stack,
        p#datatable_info_stack,
        section.header-operation p.ms-2,
        section.header-operation p.ml-2,
        section.header-operation p.mb-0 {
            display: none !important;
        }

        /* إخفاء أي card قديم يحتوي على عدد العملاء */
        .card.mb-3:not(.filter-card):has(.card-body:has-text("عدد العملاء")),
        .card.mb-3:not(.filter-card):has(.card-body:has-text("المطابقين")) {
            display: none !important;
        }

        /* إخفاء أزرار التصدير القديمة من Backpack */
        @if(request()->is('*/client') || request()->is('*/client/*'))
        .btn-stack .btn[href*="export"],
        .button_stack .btn[href*="export"],
        .d-print-none .with-border .btn[href*="export"]:not(.page-header-actions .btn),
        .row.mb-2 .btn[href*="export"]:not(.page-header-actions .btn) {
            display: none !important;
            visibility: hidden !important;
        }
        @endif

        /* إخفاء search bar الافتراضي لصفحة الموزعين */
        @if(request()->is('*/distributor*') && !request()->is('*/distributor/*/show') && !request()->is('*/distributor/*/edit') && !request()->is('*/distributor/*/create'))
        #datatable_search_stack,
        .input-icon,
        .row.mb-2.align-items-center {
            display: none !important;
        }
        @endif

        /* ===============================
           Badges Styles for Delivery List
        =============================== */
        .badge-soft-purple {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 12px;
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
            color: #4f46e5;
            box-shadow: 0 2px 4px rgba(79, 70, 229, 0.1);
        }

        .badge-danger-custom {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 12px;
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #dc2626;
            box-shadow: 0 2px 4px rgba(220, 38, 38, 0.1);
        }

        .badge-warning-custom {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 12px;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #d97706;
            box-shadow: 0 2px 4px rgba(217, 119, 6, 0.1);
        }

        .badge-success-custom {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 12px;
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #059669;
            box-shadow: 0 2px 4px rgba(5, 150, 105, 0.1);
        }

    </style>
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

        {{-- إضافة فلاتر موحدة لصفحة العملاء --}}
        @if(request()->is('*/client') && !request()->is('*/client-type*') && !request()->is('*/client/*/show') && !request()->is('*/client/*/edit') && !request()->is('*/client/*/create'))
            @include('admin.client_filters')
            
            {{-- جدول العملاء - عرض مباشر من قاعدة البيانات --}}
            @php
                $perPage = request('per_page', 10);
                $perPage = in_array($perPage, [10, 50, 100, 'all']) ? $perPage : 10;
                
                $clientsQuery = \App\Models\Client::query()->with(['city', 'subscriptionStatus', 'subscriptionType', 'distributor', 'lastDelivery', 'deliveries']);
                // تطبيق الفلاتر (نفس منطق client_filters.blade.php)
                $cityId = request("city_id");
                if (!empty($cityId) && $cityId !== "") {
                    $clientsQuery->where("city_id", $cityId);
                }

                $clientType = request("client_type");
                if (!empty($clientType) && $clientType !== "") {
                    $clientsQuery->where("client_type", $clientType);
                }

                $clientStatusId = request("client_status_id");
                if (!empty($clientStatusId) && $clientStatusId !== "") {
                    $clientsQuery->where("client_status_id", $clientStatusId);
                }

                $subscriptionTypeId = request("subscription_type_id");
                if (!empty($subscriptionTypeId) && $subscriptionTypeId !== "") {
                    $clientsQuery->where("subscription_type_id", $subscriptionTypeId);
                }

                $subscriptionStatusId = request("subscription_status_id");
                if (!empty($subscriptionStatusId) && $subscriptionStatusId !== "") {
                    $clientsQuery->where("subscription_status_id", $subscriptionStatusId);
                }

                $searchTerm = request("search") ?: request("phone");
                if (is_array($searchTerm)) {
                    $searchTerm = isset($searchTerm[0]) ? (string) $searchTerm[0] : "";
                } else {
                    $searchTerm = $searchTerm ? (string) $searchTerm : "";
                }
                $searchTerm = trim($searchTerm);
                if (!empty($searchTerm)) {
                    $clientsQuery->where(function($q) use ($searchTerm) {
                        $q->where("name", "like", "%" . $searchTerm . "%")
                          ->orWhere("phone_one", "like", "%" . $searchTerm . "%")
                          ->orWhere("phone_two", "like", "%" . $searchTerm . "%")
                          ->orWhere("address", "like", "%" . $searchTerm . "%");
                    });
                }

                $totalClients = $clientsQuery->count();
                
                if ($perPage === 'all') {
                    $clients = $clientsQuery->orderBy('id', 'desc')->get();
                    $currentPage = 1;
                    $lastPage = 1;
                } else {
                    $clients = $clientsQuery->orderBy('id', 'desc')->paginate($perPage);
                    $currentPage = $clients->currentPage();
                    $lastPage = $clients->lastPage();
                }
            @endphp
            
            <div class="row mt-4">
                <div class="col-md-12">
                    {{-- خيارات العرض --}}
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; background: #ffffff; border-radius: 16px; padding: 16px 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <label style="font-weight: 700; color: #374151; font-size: 15px; font-family: 'Cairo', sans-serif; margin: 0;">عرض:</label>
                            <select id="perPageSelect" onchange="changePerPage(this.value)" style="padding: 10px 16px; border-radius: 12px; border: 2px solid #e5e7eb; font-size: 15px; font-family: 'Cairo', sans-serif; font-weight: 600; color: #374151; background: #ffffff; cursor: pointer; transition: all 0.3s ease; min-width: 100px;">
                                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                                <option value="all" {{ $perPage == 'all' ? 'selected' : '' }}>الكل</option>
                            </select>
                        </div>
                        <div style="font-weight: 600; color: #6b7280; font-size: 14px; font-family: 'Cairo', sans-serif;">
                            إجمالي: <strong style="color: #6f6af8;">{{ number_format($totalClients) }}</strong> مشترك
                        </div>
                    </div>
                    
                    <div class="clients-table-wrapper" style="background: #ffffff; border-radius: 20px; padding: 28px; box-shadow: 0 6px 20px rgba(0,0,0,0.05); overflow-x: auto; position: relative; z-index: 10;">
                        <table class="clients-table" style="width: 100%; min-width: 1200px; border-collapse: collapse; display: table !important; visibility: visible !important;">
                        <thead>
                            <tr style="background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%); color: #fff; border-radius: 12px 12px 0 0;">
                                <th style="padding: 16px 20px; text-align: right; font-weight: 700; font-size: 15px; font-family: 'Cairo', sans-serif; border: none; min-width: 200px;">معلومات العميل</th>
                                <th style="padding: 16px 20px; text-align: right; font-weight: 700; font-size: 15px; font-family: 'Cairo', sans-serif; border: none; min-width: 250px;">الموقع</th>
                                <th style="padding: 16px 20px; text-align: center; font-weight: 700; font-size: 15px; font-family: 'Cairo', sans-serif; border: none;">الهاتف</th>
                                <th style="padding: 16px 20px; text-align: center; font-weight: 700; font-size: 15px; font-family: 'Cairo', sans-serif; border: none; min-width: 220px;">معلومات الاشتراك</th>
                                <th style="padding: 16px 12px; text-align: center; font-weight: 700; font-size: 15px; font-family: 'Cairo', sans-serif; border: none; min-width: 100px; max-width: 120px;">نسبة الالتزام</th>
                                <th style="padding: 16px 12px; text-align: center; font-weight: 700; font-size: 15px; font-family: 'Cairo', sans-serif; border: none; min-width: 60px; max-width: 80px;">إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $client)
                                <tr style="border-bottom: 1px solid #e5e7eb; transition: background 0.2s ease;">
                                    <td style="padding: 14px 20px; text-align: right; font-size: 14px; font-family: 'Cairo', sans-serif; min-width: 200px; white-space: normal;">
                                        <div style="display: flex; flex-direction: column; gap: 6px;">
                                            <div style="font-weight: 700; color: #6f6af8; font-size: 15px;">
                                                {{ $client->name }}
                                            </div>
                                            @if($client->contract_no)
                                                <div style="font-weight: 500; color: #10b981; font-size: 13px;">
                                                    {{ $client->contract_no }}
                                                </div>
                                            @endif
                                            @if($client->subscription_start_date)
                                                <div style="font-weight: 500; color: #f59e0b; font-size: 12px; margin-top: 2px;">
                                                    {{ \Carbon\Carbon::parse($client->subscription_start_date)->format('Y-m-d') }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td style="padding: 14px 20px; text-align: right; font-size: 14px; color: #374151; font-family: 'Cairo', sans-serif; min-width: 250px; white-space: normal;">
                                        <div style="display: flex; flex-direction: column; gap: 6px;">
                                            <div style="font-weight: 600; color: #1f2937; font-size: 14px;">
                                                {{ $client->city ? $client->city->city_name : '-' }}
                                            </div>
                                            @if($client->address)
                                                <div style="font-weight: 400; color: #6b7280; font-size: 13px; line-height: 1.4;">
                                                    {{ $client->address }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td style="padding: 14px 20px; text-align: center; font-size: 14px; color: #374151; font-family: 'Cairo', sans-serif;">
                                        @if($client->phone_one || $client->phone_two)
                                            <div style="display: flex; flex-direction: column; gap: 4px; align-items: center;">
                                                @if($client->phone_one)
                                                    <div style="font-weight: 600; color: #1f2937;">{{ $client->phone_one }}</div>
                                                @endif
                                                @if($client->phone_two)
                                                    <div style="font-weight: 500; color: #6b7280; font-size: 13px;">{{ $client->phone_two }}</div>
                                                @endif
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td style="padding: 14px 20px; text-align: center; font-size: 14px; font-family: 'Cairo', sans-serif; min-width: 220px; white-space: normal;">
                                        @php
                                            $clientTypeMap = [
                                                1 => 'فردي',
                                                2 => 'مؤسسة',
                                                3 => 'تجاري',
                                            ];
                                            $clientTypeName = $client->client_type ? ($clientTypeMap[$client->client_type] ?? $client->client_type) : '-';
                                            $subscriptionTypeName = $client->subscriptionType ? $client->subscriptionType->type_name : '-';
                                            $subscriptionStatusName = $client->subscriptionStatus ? $client->subscriptionStatus->status_name : '-';
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
                                            
                                            {{-- نوع العميل --}}
                                            @if($clientTypeName !== '-')
                                                <span style="display: inline-block; padding: 5px 12px; border-radius: 8px; font-weight: 500; font-size: 12px; background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb;">
                                                    {{ $clientTypeName }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td style="padding: 14px 12px; text-align: center; font-size: 14px; font-family: 'Cairo', sans-serif; min-width: 100px; max-width: 120px;">
                                        @php
                                            // حساب نسبة الالتزام
                                            $percentageDeliveryRate = 0;
                                            if ($client->subscription_start_date && $client->subscriptionType && $client->subscriptionType->distribution_days > 0) {
                                                $daysActive = \Carbon\Carbon::parse($client->subscription_start_date)->diffInDays(now());
                                                $expectedDeliveries = floor($daysActive / $client->subscriptionType->distribution_days);
                                                $actualDeliveries = $client->deliveries ? $client->deliveries->count() : 0;
                                                
                                                if ($expectedDeliveries > 0) {
                                                    $percentageDeliveryRate = round(($actualDeliveries / $expectedDeliveries) * 100, 2);
                                                }
                                            }
                                            
                                            // تحديد لون حسب النسبة
                                            $badgeClass = 'badge-secondary';
                                            $badgeColor = '#6b7280';
                                            if ($percentageDeliveryRate >= 90) {
                                                $badgeClass = 'badge-success';
                                                $badgeColor = '#10b981';
                                            } elseif ($percentageDeliveryRate >= 75) {
                                                $badgeClass = 'badge-info';
                                                $badgeColor = '#3b82f6';
                                            } elseif ($percentageDeliveryRate >= 50) {
                                                $badgeClass = 'badge-warning';
                                                $badgeColor = '#f59e0b';
                                            } elseif ($percentageDeliveryRate > 0) {
                                                $badgeClass = 'badge-danger';
                                                $badgeColor = '#ef4444';
                                            }
                                        @endphp
                                        <span style="display: inline-block; padding: 5px 10px; border-radius: 8px; font-weight: 600; font-size: 13px; background: {{ $badgeColor }}15; color: {{ $badgeColor }}; border: 1px solid {{ $badgeColor }}30; white-space: nowrap;">
                                            {{ $percentageDeliveryRate }}%
                                        </span>
                                    </td>
                                    <td style="padding: 14px 20px; text-align: center; font-size: 14px; font-family: 'Cairo', sans-serif; min-width: 60px; white-space: normal; vertical-align: middle;">
                                        @php
                                            $showUrl = backpack_url('client/' . $client->id . '/show');
                                        @endphp
                                        <div style="display: flex; justify-content: center; align-items: center; width: 100%; height: 100%;">
                                            {{-- زر عين احترافي - ملف العميل --}}
                                            <a href="{{ $showUrl }}" 
                                               title="ملف العميل"
                                               class="client-view-btn"
                                               style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%); color: #fff; text-decoration: none; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 3px 10px rgba(111, 106, 248, 0.3); margin: 0 auto; position: relative; overflow: hidden;">
                                                <i class="la la-eye" style="font-size: 17px; font-weight: 700; line-height: 1; display: block; position: relative; z-index: 2;"></i>
                                                <span style="position: absolute; top: 50%; left: 50%; width: 0; height: 0; background: rgba(255, 255, 255, 0.2); border-radius: 50%; transform: translate(-50%, -50%); transition: width 0.4s ease, height 0.4s ease; z-index: 1;"></span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="padding: 40px 20px; text-align: center; color: #6b7280; font-size: 16px; font-family: 'Cairo', sans-serif;">
                                        لا توجد بيانات للعرض
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                    
                    {{-- Pagination --}}
                    @if($perPage !== 'all' && $lastPage > 1)
                    <div style="display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 24px; padding-top: 24px; border-top: 2px solid #e5e7eb;">
                        {{-- زر السابق --}}
                        @if($currentPage > 1)
                            <a href="{{ request()->fullUrlWithQuery(['page' => $currentPage - 1, 'per_page' => $perPage]) }}" 
                               style="padding: 10px 20px; background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%); color: #fff; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 14px; font-family: 'Cairo', sans-serif; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(111, 106, 248, 0.2);">
                                السابق
                            </a>
                        @else
                            <span style="padding: 10px 20px; background: #e5e7eb; color: #9ca3af; border-radius: 12px; font-weight: 600; font-size: 14px; font-family: 'Cairo', sans-serif; cursor: not-allowed;">
                                السابق
                            </span>
                        @endif
                        
                        {{-- أرقام الصفحات --}}
                        @for($i = max(1, $currentPage - 2); $i <= min($lastPage, $currentPage + 2); $i++)
                            @if($i == $currentPage)
                                <span style="padding: 10px 18px; background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%); color: #fff; border-radius: 12px; font-weight: 700; font-size: 14px; font-family: 'Cairo', sans-serif; box-shadow: 0 4px 15px rgba(111, 106, 248, 0.3);">
                                    {{ $i }}
                                </span>
                            @else
                                <a href="{{ request()->fullUrlWithQuery(['page' => $i, 'per_page' => $perPage]) }}" 
                                   style="padding: 10px 18px; background: #f3f4f6; color: #374151; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 14px; font-family: 'Cairo', sans-serif; transition: all 0.3s ease;">
                                    {{ $i }}
                                </a>
                            @endif
                        @endfor
                        
                        {{-- زر التالي --}}
                        @if($currentPage < $lastPage)
                            <a href="{{ request()->fullUrlWithQuery(['page' => $currentPage + 1, 'per_page' => $perPage]) }}" 
                               style="padding: 10px 20px; background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%); color: #fff; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 14px; font-family: 'Cairo', sans-serif; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(111, 106, 248, 0.2);">
                                التالي
                            </a>
                        @else
                            <span style="padding: 10px 20px; background: #e5e7eb; color: #9ca3af; border-radius: 12px; font-weight: 600; font-size: 14px; font-family: 'Cairo', sans-serif; cursor: not-allowed;">
                                التالي
                            </span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            
            {{-- JavaScript لتغيير عدد الصفوف --}}
            <script>
                function changePerPage(value) {
                    const url = new URL(window.location.href);
                    url.searchParams.set('per_page', value);
                    url.searchParams.delete('page'); // إعادة تعيين الصفحة إلى 1
                    window.location.href = url.toString();
                }
            </script>
            
            {{-- CSS للجدول --}}
            <style>
                .clients-table-wrapper {
                    -webkit-overflow-scrolling: touch;
                }
                
                .clients-table-wrapper::-webkit-scrollbar {
                    height: 12px;
                }
                
                .clients-table-wrapper::-webkit-scrollbar-track {
                    background: #f1f1f1;
                    border-radius: 10px;
                }
                
                .clients-table-wrapper::-webkit-scrollbar-thumb {
                    background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%);
                    border-radius: 10px;
                }
                
                .clients-table-wrapper::-webkit-scrollbar-thumb:hover {
                    background: linear-gradient(135deg, #5a55e8 0%, #6b6bff 100%);
                }
                
                .clients-table tbody tr:hover {
                    background: #f9fafb !important;
                }
                
                .clients-table thead th:first-child {
                    border-top-right-radius: 12px;
                }
                
                .clients-table thead th:last-child {
                    border-top-left-radius: 12px;
                }
                
                /* Pagination Styles */
                #perPageSelect:hover {
                    border-color: #6f6af8 !important;
                    box-shadow: 0 4px 15px rgba(111, 106, 248, 0.15) !important;
                }
                
                #perPageSelect:focus {
                    outline: none !important;
                    border-color: #6f6af8 !important;
                    box-shadow: 0 4px 15px rgba(111, 106, 248, 0.25) !important;
                }
                
                a[href*="page"]:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 6px 20px rgba(111, 106, 248, 0.3) !important;
                }
            </style>
        @endif

        <div class="row mb-2 align-items-center">
          <div class="col-sm-9">
            @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
              <div class="d-print-none {{ $crud->hasAccess('create')?'with-border':'' }}">

                @include('crud::inc.button_stack', ['stack' => 'top'])

              </div>
            @endif
          </div>
          @if($crud->getOperationSetting('searchableTable'))
          <div class="col-sm-3">
            <div id="datatable_search_stack" class="mt-sm-0 mt-2 d-print-none">
              <div class="input-icon">
                <span class="input-icon-addon">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>
                </span>
                <input type="search" class="form-control" placeholder="{{ trans('backpack::crud.search') }}..."/>
              </div>
            </div>
          </div>
          @endif
        </div>

        {{-- Backpack List Filters --}}
        @if ($crud->filtersEnabled())
          @include('crud::inc.filters_navbar')
        @endif

        @if(!request()->is('*/delivery') || request()->is('*/delivery/*'))
            <div class="{{ backpack_theme_config('classes.tableWrapper') }}">
                <table
                  id="crudTable"
                  class="{{ backpack_theme_config('classes.table') ?? 'table table-striped table-hover nowrap rounded card-table table-vcenter card d-table shadow-xs border-xs' }}"
                  data-responsive-table="{{ (int) $crud->getOperationSetting('responsiveTable') }}"
                  data-has-details-row="{{ (int) $crud->getOperationSetting('detailsRow') }}"
                  data-has-bulk-actions="{{ (int) $crud->getOperationSetting('bulkActions') }}"
                  data-has-line-buttons-as-dropdown="{{ (int) $crud->getOperationSetting('lineButtonsAsDropdown') }}"
                  data-line-buttons-as-dropdown-minimum="{{ (int) $crud->getOperationSetting('lineButtonsAsDropdownMinimum') }}"
                  data-line-buttons-as-dropdown-show-before-dropdown="{{ (int) $crud->getOperationSetting('lineButtonsAsDropdownShowBefore') }}"
                  cellspacing="0">
                <thead>
                  <tr>
                    {{-- Table columns --}}
                    @foreach ($crud->columns() as $column)
                      @php
                      $exportOnlyColumn = $column['exportOnlyColumn'] ?? false;
                      $visibleInTable = $column['visibleInTable'] ?? ($exportOnlyColumn ? false : true);
                      $visibleInModal = $column['visibleInModal'] ?? ($exportOnlyColumn ? false : true);
                      $visibleInExport = $column['visibleInExport'] ?? true;
                      $forceExport = $column['forceExport'] ?? (isset($column['exportOnlyColumn']) ? true : false);
                      @endphp
                      <th
                        data-orderable="{{ var_export($column['orderable'], true) }}"
                        data-priority="{{ $column['priority'] }}"
                        data-column-name="{{ $column['name'] }}"
                        data-visible="{{ $exportOnlyColumn ? 'false' : var_export($visibleInTable) }}"
                        data-visible-in-table="{{ var_export($visibleInTable) }}"
                        data-can-be-visible-in-table="{{ $exportOnlyColumn ? 'false' : 'true' }}"
                        data-visible-in-modal="{{ var_export($visibleInModal) }}"
                        data-visible-in-export="{{ $exportOnlyColumn ? 'true' : ($visibleInExport ? 'true' : 'false') }}"
                        data-force-export="{{ var_export($forceExport) }}"
                      >
                        {{-- Bulk checkbox --}}
                        @if($loop->first && $crud->getOperationSetting('bulkActions'))
                          	{!! View::make('crud::columns.inc.bulk_actions_checkbox')->render() !!}
                        @endif
                        {!! $column['label'] !!}
                      </th>
                    @endforeach

                    @if ( $crud->buttons()->where('stack', 'line')->count() )
                      <th data-orderable="false"
                          data-priority="{{ $crud->getActionsColumnPriority() }}"
                          data-visible-in-export="false"
                          data-action-column="true"
                          >{{ trans('backpack::crud.actions') }}</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
        @endif

        @if ( $crud->buttons()->where('stack', 'bottom')->count() )
            <div id="bottom_buttons" class="d-print-none text-sm-left">
                @include('crud::inc.button_stack', ['stack' => 'bottom'])
                <div id="datatable_button_stack" class="float-right float-end text-right hidden-xs"></div>
            </div>
        @endif

    </div>

  </div>

@endsection
@include('admin.distributor_withdraw_modal')

@section('after_scripts')
  @include('crud::inc.datatables_logic')
  @include('admin.financial_report_modal')
  
  {{-- إخفاء رابط العودة و breadcrumbs --}}
  <script>
  (function() {
      function hideBackLinks() {
          // إخفاء breadcrumbs
          var breadcrumbs = document.querySelectorAll('.breadcrumb, .breadcrumb-item, nav[aria-label="breadcrumb"], ol.breadcrumb');
          breadcrumbs.forEach(function(el) {
              el.style.display = 'none';
              el.style.visibility = 'hidden';
          });

          // إخفاء روابط العودة
          var allLinks = document.querySelectorAll('a');
          allLinks.forEach(function(link) {
              var href = link.getAttribute('href') || '';
              var text = link.textContent || '';
              
              if (href.includes('back') || 
                  href.includes('العودة') || 
                  text.includes('العودة') || 
                  text.includes('back_to_all') ||
                  link.closest('small')) {
                  link.style.display = 'none';
                  link.style.visibility = 'hidden';
                  link.style.opacity = '0';
                  link.style.height = '0';
                  link.style.width = '0';
                  link.style.margin = '0';
                  link.style.padding = '0';
              }
          });

          // إخفاء عناصر small التي تحتوي على روابط
          var smallElements = document.querySelectorAll('small');
          smallElements.forEach(function(small) {
              var links = small.querySelectorAll('a');
              if (links.length > 0) {
                  small.style.display = 'none';
                  small.style.visibility = 'hidden';
              }
          });
      }

      // تنفيذ فوري
      hideBackLinks();

      // تنفيذ بعد تحميل DOM
      if (document.readyState === 'loading') {
          document.addEventListener('DOMContentLoaded', function() {
              setTimeout(hideBackLinks, 100);
              setTimeout(hideBackLinks, 500);
              setTimeout(hideBackLinks, 1000);
          });
      } else {
          setTimeout(hideBackLinks, 100);
          setTimeout(hideBackLinks, 500);
          setTimeout(hideBackLinks, 1000);
      }

      // مراقبة تغييرات DOM
      if (typeof MutationObserver !== 'undefined') {
          var observer = new MutationObserver(function(mutations) {
              hideBackLinks();
          });

          observer.observe(document.body, {
              childList: true,
              subtree: true
          });
      }
  })();
  </script>
  
  {{-- Hide DataTables Info and Fix RTL Pagination --}}
  <script>
  (function() {
      function hideInfoAndFixPagination() {
          // إخفاء معلومات الجدول
          var infoElement = document.getElementById('crudTable_info');
          if (infoElement) {
              infoElement.style.display = 'none';
          }
          
          // إخفاء جميع عناصر dataTables_info
          var allInfoElements = document.querySelectorAll('.dataTables_info');
          allInfoElements.forEach(function(el) {
              el.style.display = 'none';
          });
          
          // إصلاح Pagination للاتجاه العربي
          var paginateElement = document.getElementById('crudTable_paginate');
          if (paginateElement) {
              paginateElement.style.direction = 'rtl';
              paginateElement.style.textAlign = 'right';
              
              var paginationList = paginateElement.querySelector('ul.pagination');
              if (paginationList) {
                  paginationList.style.direction = 'ltr'; /* LTR للقائمة نفسها */
                  paginationList.style.flexDirection = 'row'; /* اتجاه عادي */
                  paginationList.style.justifyContent = 'center';
                  paginationList.style.display = 'flex';
                  
                  // ترتيب الأزرار: Previous على اليمين (order: 1)، Next على اليسار (order: 3)
                  var previousBtn = paginationList.querySelector('.paginate_button.previous');
                  var nextBtn = paginationList.querySelector('.paginate_button.next');
                  
                  if (previousBtn) {
                      previousBtn.style.order = '1';
                  }
                  if (nextBtn) {
                      nextBtn.style.order = '3';
                  }
                  
                  // الأرقام في المنتصف (order: 2)
                  var numberButtons = paginationList.querySelectorAll('.paginate_button:not(.previous):not(.next)');
                  numberButtons.forEach(function(btn) {
                      btn.style.order = '2';
                  });
              }
          }
      }
      
      // تنفيذ فوري
      hideInfoAndFixPagination();
      
      // تنفيذ بعد تحميل DOM
      if (document.readyState === 'loading') {
          document.addEventListener('DOMContentLoaded', function() {
              setTimeout(hideInfoAndFixPagination, 100);
              setTimeout(hideInfoAndFixPagination, 500);
          });
      } else {
          setTimeout(hideInfoAndFixPagination, 100);
          setTimeout(hideInfoAndFixPagination, 500);
      }
      
      // تنفيذ بعد تهيئة DataTables
      if (typeof jQuery !== 'undefined') {
          jQuery(document).ready(function() {
              var table = jQuery('#crudTable');
              if (table.length && table.DataTable) {
                  table.on('init.dt', function() {
                      setTimeout(hideInfoAndFixPagination, 100);
                  });
                  
                  table.on('draw.dt', function() {
                      setTimeout(hideInfoAndFixPagination, 100);
                  });
              }
              
              // مراقبة تغييرات Pagination
              var observer = new MutationObserver(function(mutations) {
                  hideInfoAndFixPagination();
              });
              
              var paginateContainer = document.getElementById('crudTable_paginate');
              if (paginateContainer) {
                  observer.observe(paginateContainer, {
                      childList: true,
                      subtree: true
                  });
              }
          });
      }
  })();
  </script>
  
  @php
    $isDistributorPage = false;
    $isClientPage = false;
    try {
        if (request()->route() && request()->route()->getName()) {
            $isDistributorPage = request()->is('*distributor*') && str_contains(request()->route()->getName(), 'distributor');
            $isClientPage = request()->is('*client') && !request()->is('*client-type*') && !request()->is('*client/*/show') && !request()->is('*client/*/edit') && !request()->is('*client/*/create');
        } else {
            $isDistributorPage = request()->is('*distributor*');
            $isClientPage = request()->is('*client') && !request()->is('*client-type*') && !request()->is('*client/*/show') && !request()->is('*client/*/edit') && !request()->is('*client/*/create');
        }
    } catch (\Throwable $th) {
        $isDistributorPage = request()->is('*distributor*');
        $isClientPage = request()->is('*client*') && !request()->is('*client/*/show') && !request()->is('*client/*/edit') && !request()->is('*client/*/create');
    }
  @endphp
  @if($isClientPage)
    <script>
        (function() {
            function hideActionsColumn() {
                var table = document.getElementById('crudTable');
                if (!table) return;
                
                // إخفاء عمود الإجراءات من header
                var headers = table.querySelectorAll('thead th');
                headers.forEach(function(header, index) {
                    var headerText = header.textContent.trim();
                    if (headerText === 'أجراءات' || headerText === 'Actions' || header.hasAttribute('data-action-column')) {
                        header.style.display = 'none';
                        header.style.visibility = 'hidden';
                        header.style.width = '0';
                        header.style.padding = '0';
                        header.style.margin = '0';
                    }
                });
                
                // إخفاء عمود الإجراءات من body
                var rows = table.querySelectorAll('tbody tr');
                rows.forEach(function(row) {
                    var cells = row.querySelectorAll('td');
                    cells.forEach(function(cell, index) {
                        var cellText = cell.textContent.trim();
                        var hasActionButtons = cell.querySelector('.btn-group, .btn, [data-action-column]');
                        
                        if (hasActionButtons || cellText === 'تعديل' || cellText === 'Edit') {
                            cell.style.display = 'none';
                            cell.style.visibility = 'hidden';
                            cell.style.width = '0';
                            cell.style.padding = '0';
                            cell.style.margin = '0';
                        }
                    });
                });
            }
            
            // تشغيل عند تحميل الصفحة
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(hideActionsColumn, 100);
                });
            } else {
                setTimeout(hideActionsColumn, 100);
            }
            
            // تشغيل بعد رسم DataTable
            if (typeof jQuery !== 'undefined' && jQuery.fn.dataTable) {
                jQuery(document).on('draw.dt', function() {
                    setTimeout(hideActionsColumn, 100);
                });
            }
        })();
    </script>
  @endif
  @if($isDistributorPage)
    <script>
        (function() {
            function removeEditColumn() {
                var table = document.getElementById('crudTable');
                if (!table) return;
                
                var allCells = table.querySelectorAll('tbody tr td');
                allCells.forEach(function(cell) {
                    var cellText = cell.textContent.trim();
                    var hasDropdown = cell.querySelector('.btn-group .dropdown-toggle');
                    
                    if (!hasDropdown && cellText === 'تعديل') {
                        cell.remove();
                    }
                });
                
                var headers = table.querySelectorAll('thead th');
                headers.forEach(function(header, index) {
                    var headerText = header.textContent.trim();
                    var isCustomActions = header.getAttribute('data-column-name') === 'actions';
                    var isActionColumn = header.getAttribute('data-action-column') === 'true';
                    
                    if ((isActionColumn || headerText === 'أجراءات' || headerText === 'إجراءات') && !isCustomActions) {
                        var firstRow = table.querySelector('tbody tr');
                        if (firstRow && firstRow.cells[index]) {
                            var cell = firstRow.cells[index];
                            var cellText = cell.textContent.trim();
                            var hasDropdown = cell.querySelector('.btn-group .dropdown-toggle');
                            
                            if (!hasDropdown && cellText === 'تعديل') {
                                header.remove();
                                
                                var rows = table.querySelectorAll('tbody tr');
                                rows.forEach(function(row) {
                                    if (row.cells[index]) {
                                        row.cells[index].remove();
                                    }
                                });
                            }
                        }
                    }
                });
            }
            
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    removeEditColumn();
                    setTimeout(removeEditColumn, 100);
                    setTimeout(removeEditColumn, 500);
                    setTimeout(removeEditColumn, 1000);
                });
            } else {
                removeEditColumn();
                setTimeout(removeEditColumn, 100);
                setTimeout(removeEditColumn, 500);
                setTimeout(removeEditColumn, 1000);
            }
            
            if (typeof jQuery === 'undefined') {
                var checkJQuery = setInterval(function() {
                    if (typeof jQuery !== 'undefined') {
                        clearInterval(checkJQuery);
                        initDropdownFix();
                    }
                }, 100);
                
                setTimeout(function() {
                    clearInterval(checkJQuery);
                }, 5000);
            } else {
                initDropdownFix();
            }
            
            function initDropdownFix() {
                if (typeof jQuery === 'undefined') return;
                
                jQuery(document).ready(function() {
                    function fixDropdownOverflow() {
                        var table = jQuery('#crudTable');
                        if (!table.length) return;
                        
                        removeEditColumn();
                        table.css('overflow', 'visible');
                        
                        var wrapper = jQuery('#crudTable_wrapper');
                        if (wrapper.length) {
                            wrapper.css('overflow', 'visible');
                            wrapper.find('.dataTables_scrollBody').css('overflow', 'visible');
                        }
                        
                        table.find('tbody tr td').css('overflow', 'visible');
                    }
                    
                    setTimeout(fixDropdownOverflow, 100);
                    
                    var table = jQuery('#crudTable');
                    if (table.length && table.DataTable) {
                        table.on('init.dt', function() {
                            setTimeout(fixDropdownOverflow, 100);
                        });
                        
                        table.on('draw.dt', function() {
                            setTimeout(fixDropdownOverflow, 100);
                        });
                    }
                    
                    jQuery(document).on('show.bs.dropdown', '#crudTable .dropdown', function() {
                        fixDropdownOverflow();
                        var menu = jQuery(this).find('.dropdown-menu');
                        menu.css({
                            'position': 'absolute',
                            'z-index': '9999',
                            'display': 'block',
                            'visibility': 'visible',
                            'opacity': '1'
                        });
                    });
                });
            }
        })();
    </script>
  @endif
  
  <div id="toast-message"
     style="display:none; position:fixed; top:20px; right:20px;
            background:#333; color:#fff; padding:12px 20px;
            border-radius:8px; z-index:9999;">
  </div>

  <script>
  function showToast(message, success = true) {
      const toast = $('#toast-message');
      toast
          .text(message)
          .css('background', success ? '#28a745' : '#dc3545')
          .fadeIn();

      setTimeout(() => toast.fadeOut(), 3000);
  }

  {{-- تم نقل كود withdraw modal إلى distributor_withdraw_modal.blade.php لمنع الإرسال المزدوج --}}
  {{-- $(document).on('click', '.open-withdraw-modal', function () {
      const distributorId = $(this).data('id');
      const balance = parseFloat($(this).data('balance'));

      $('#withdraw_distributor_id').val(distributorId);
      $('#currentBalance').text(balance.toFixed(2));
      $('#withdrawAmount').val('');
      $('#balanceError').addClass('d-none');
      $('#withdrawSubmit').prop('disabled', false);

      $('#withdrawModal').modal('show');
  }); --}}
  </script>

  {{-- تم نقل كود submit form إلى distributor_withdraw_modal.blade.php لمنع الإرسال المزدوج --}}
  {{-- <script>
  $(document).on('submit', '#withdrawForm', function (e) {
      e.preventDefault();

      const form = $(this);

      $.ajax({
          url: form.attr('action'),
          method: 'POST',
          data: form.serialize(),

          success: function (res) {
              $('#withdrawModal').modal('hide');
              showToast(res.message, true);
              setTimeout(() => location.reload(), 1200);
          },

          error: function (xhr) {
              showToast(
                  xhr.responseJSON?.message ?? 'حدث خطأ غير متوقع',
                  false
              );
          }
      });
  }); --}}
  </script>
  
  {{-- إخفاء الأزرار الافتراضية من جميع صفحات CRUD التي تستخدم unified-actions-dropdown --}}
  @php
    $hasUnifiedActions = false;
    try {
        // التحقق من وجود unified-actions-dropdown في الصفحة
        $hasUnifiedActions = request()->is('*client-type*') 
            || request()->is('*city*') 
            || request()->is('*subscription-type*') 
            || request()->is('*subscription-status*')
            || request()->is('*client-status*')
            || request()->is('*distributor*');
    } catch (\Throwable $th) {
        $hasUnifiedActions = false;
    }
  @endphp
  @if($hasUnifiedActions)
    <style>
        /* إخفاء الأزرار الافتراضية من عمود الإجراءات */
        #crudTable tbody tr td[data-action-column="true"] a.btn:not(.dropdown-toggle),
        #crudTable tbody tr td[data-action-column="true"] a.btn-link:not(.dropdown-toggle),
        #crudTable tbody tr td:has(a.btn-link:not(.dropdown-toggle)) a.btn-link:not(.dropdown-toggle),
        #crudTable tbody tr td:has(a[href*="/edit"]):not(:has(.btn-group)) a[href*="/edit"],
        #crudTable tbody tr td:has(a[href*="/show"]):not(:has(.btn-group)) a[href*="/show"],
        #crudTable tbody tr td:has(a[href*="/delete"]):not(:has(.btn-group)) a[href*="/delete"] {
            display: none !important;
            visibility: hidden !important;
        }
        
        /* إخفاء أي خلايا تحتوي على أزرار مباشرة بدون dropdown */
        #crudTable tbody tr td:has(a.btn-link:not(.dropdown-toggle)):not(:has(.btn-group)) {
            display: none !important;
        }
        
        /* إصلاح dropdown menu لجميع صفحات CRUD - يظهر على يمين الزر */
        #crudTable tbody tr td .unified-actions-dropdown {
            position: relative !important;
        }
        
        /* ضمان عدم إخفاء dropdown menu */
        #crudTable_wrapper,
        #crudTable_wrapper .dataTables_scrollBody,
        #crudTable_wrapper .dataTables_scroll,
        #crudTable_wrapper .table-responsive {
            overflow: visible !important;
        }
        
        #crudTable tbody tr td {
            overflow: visible !important;
            position: relative !important;
        }
        
        /* إصلاح موضع dropdown menu - يظهر على يمين الزر */
        #crudTable tbody tr td .unified-actions-dropdown .dropdown-menu {
            position: absolute !important;
            left: 100% !important;
            right: auto !important;
            top: 0 !important;
            bottom: auto !important;
            margin-left: 0.5rem !important;
            margin-top: 0 !important;
            z-index: 99999 !important;
            transform: none !important;
            display: none; /* Hidden by default */
        }
        
        /* رفع z-index عند فتح dropdown */
        #crudTable tbody tr td .unified-actions-dropdown.show {
            z-index: 99998 !important;
        }
        
        #crudTable tbody tr td .unified-actions-dropdown.show .dropdown-menu,
        #crudTable tbody tr td .unified-actions-dropdown[class*="show"] .dropdown-menu {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
    </style>
  @endif
  
  {{-- CRUD LIST CONTENT - crud_list_scripts stack --}}
  @stack('crud_list_scripts')
  
  {{-- إصلاح dropdown menu لجميع صفحات CRUD التي تستخدم unified-actions-dropdown --}}
  @php
    $hasUnifiedActions = false;
    try {
        // التحقق من وجود unified-actions-dropdown في الصفحة
        $hasUnifiedActions = request()->is('*client-type*') 
            || request()->is('*city*') 
            || request()->is('*subscription-type*') 
            || request()->is('*subscription-status*')
            || request()->is('*client-status*')
            || request()->is('*distributor*');
    } catch (\Throwable $th) {
        $hasUnifiedActions = false;
    }
  @endphp
  @if($hasUnifiedActions)
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
            
            function hideDefaultButtons() {
                var table = document.getElementById('crudTable');
                if (!table) return;
                
                // إزالة الأزرار الافتراضية من جميع الصفوف
                var rows = table.querySelectorAll('tbody tr');
                rows.forEach(function(row) {
                    var cells = row.querySelectorAll('td');
                    cells.forEach(function(cell) {
                        // إذا كانت الخلية تحتوي على أزرار مباشرة بدون dropdown menu
                        var hasDirectButtons = cell.querySelectorAll('a.btn-link:not(.dropdown-toggle), a.btn:not(.dropdown-toggle), a[href*="/edit"]:not(.dropdown-item), a[href*="/show"]:not(.dropdown-item), a[href*="/delete"]:not(.dropdown-item)');
                        var hasDropdown = cell.querySelector('.btn-group .dropdown-toggle');
                        
                        // إذا كان هناك أزرار مباشرة وليس dropdown menu، احذفها
                        if (hasDirectButtons.length > 0 && !hasDropdown) {
                            hasDirectButtons.forEach(function(btn) {
                                btn.remove();
                            });
                        }
                        
                        // إذا كانت الخلية فارغة بعد إزالة الأزرار، احذفها
                        if (cell.textContent.trim() === '' && !hasDropdown) {
                            cell.remove();
                        }
                    });
                });
                
                // إزالة header عمود الإجراءات الافتراضي إذا كان فارغاً
                var headers = table.querySelectorAll('thead th[data-action-column="true"]');
                headers.forEach(function(header) {
                    var headerText = header.textContent.trim();
                    // إذا كان header "أجراءات" أو "إجراءات" وكان هناك عمود actions مخصص
                    if ((headerText === 'أجراءات' || headerText === 'إجراءات') && header.getAttribute('data-column-name') !== 'actions') {
                        // تحقق من وجود عمود actions مخصص
                        var hasCustomActions = false;
                        var allHeaders = table.querySelectorAll('thead th');
                        allHeaders.forEach(function(h) {
                            if (h.getAttribute('data-column-name') === 'actions' && h !== header) {
                                hasCustomActions = true;
                            }
                        });
                        
                        if (hasCustomActions) {
                            var index = Array.from(header.parentElement.children).indexOf(header);
                            header.remove();
                            
                            // إزالة الخلايا المقابلة
                            var rows = table.querySelectorAll('tbody tr');
                            rows.forEach(function(row) {
                                if (row.cells[index]) {
                                    row.cells[index].remove();
                                }
                            });
                        }
                    }
                });
            }
            
            // إصلاح موضع dropdown menu لعنصر محدد
            function fixDropdownPositionForElement(dropdown) {
                if (!hasClass(dropdown, 'show')) return;
                
                var menu = dropdown.querySelector('.dropdown-menu');
                var button = dropdown.querySelector('.dropdown-toggle');
                var td = closest(dropdown, 'td');
                var tr = closest(dropdown, 'tr');
                
                if (!menu || !button || !td || !tr) return;
                
                // رفع z-index للصف والخلية
                tr.style.zIndex = '10000';
                tr.style.position = 'relative';
                td.style.overflow = 'visible';
                
                // إزالة overflow من العناصر المحيطة
                var parents = ['card', 'card-body', 'table-responsive', 'row', 'col-md-12'];
                var current = dropdown.parentElement;
                while (current && current !== document.body) {
                    parents.forEach(function(className) {
                        if (current.classList.contains(className)) {
                            current.style.overflow = 'visible';
                        }
                    });
                    current = current.parentElement;
                }
                
                // وضع dropdown menu على يمين الزر
                setTimeout(function() {
                    var buttonRect = button.getBoundingClientRect();
                    var menuWidth = menu.offsetWidth;
                    var windowWidth = window.innerWidth;
                    var scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
                    var newLeft = buttonRect.left + buttonRect.width + 8;
                    
                    menu.style.position = 'absolute';
                    menu.style.left = '100%';
                    menu.style.right = 'auto';
                    menu.style.top = '0';
                    menu.style.bottom = 'auto';
                    menu.style.marginLeft = '0.5rem';
                    menu.style.marginTop = '0';
                    menu.style.zIndex = '99999';
                    menu.style.transform = 'none';
                    menu.style.display = 'block';
                    
                    // إذا كانت القائمة ستخرج عن الشاشة من اليمين، نضعها على يسار الزر
                    if (newLeft + menuWidth > windowWidth + scrollLeft) {
                        menu.style.left = 'auto';
                        menu.style.right = '100%';
                        menu.style.marginLeft = '0';
                        menu.style.marginRight = '0.5rem';
                    }
                }, 10);
            }
            
            // دالة لإغلاق جميع dropdowns
            function closeAllDropdowns() {
                var allDropdowns = $$('.unified-actions-dropdown.dropdown');
                allDropdowns.forEach(function(dropdown) {
                    removeClass(dropdown, 'show');
                    var menu = dropdown.querySelector('.dropdown-menu');
                    if (menu) {
                        removeClass(menu, 'show');
                        menu.style.display = 'none';
                    }
                    var tr = closest(dropdown, 'tr');
                    if (tr) {
                        tr.style.zIndex = '1';
                        tr.style.position = 'relative';
                    }
                });
            }
            
            // تهيئة Bootstrap 5 dropdown يدوياً
            function initBootstrapDropdowns() {
                // إزالة event listeners القديمة
                var oldToggles = $$('.unified-actions-dropdown .dropdown-toggle');
                oldToggles.forEach(function(toggle) {
                    var newToggle = toggle.cloneNode(true);
                    toggle.parentNode.replaceChild(newToggle, toggle);
                });
                
                // تهيئة جميع dropdowns في unified-actions-dropdown
                var toggles = $$('.unified-actions-dropdown .dropdown-toggle');
                toggles.forEach(function(toggle) {
                    toggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        var dropdown = closest(toggle, '.dropdown');
                        if (!dropdown) return;
                        
                        var menu = dropdown.querySelector('.dropdown-menu');
                        if (!menu) return;
                        
                        var isOpen = hasClass(dropdown, 'show');
                        
                        // إغلاق جميع dropdowns الأخرى أولاً
                        closeAllDropdowns();
                        
                        // إذا كان dropdown مفتوحاً، أغلقه
                        if (isOpen) {
                            removeClass(dropdown, 'show');
                            removeClass(menu, 'show');
                            menu.style.display = 'none';
                            var tr = closest(dropdown, 'tr');
                            if (tr) {
                                tr.style.zIndex = '1';
                                tr.style.position = 'relative';
                            }
                        } else {
                            // إذا كان dropdown مغلقاً، افتحه
                            addClass(dropdown, 'show');
                            addClass(menu, 'show');
                            menu.style.display = 'block';
                            
                            // إصلاح الموضع
                            fixDropdownPositionForElement(dropdown);
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
                }, true); // استخدام capture phase لضمان التنفيذ أولاً
            }
            
            // تشغيل الكود بعد تحميل DOM
            function init() {
                hideDefaultButtons();
                initBootstrapDropdowns();
                
                // إعادة التشغيل بعد تحميل DataTables
                var table = $('#crudTable');
                if (table && typeof DataTable !== 'undefined') {
                    var dataTable = DataTable.api ? new DataTable.Api(table) : null;
                    if (dataTable) {
                        dataTable.on('draw', function() {
                            hideDefaultButtons();
                            initBootstrapDropdowns();
                        });
                    }
                }
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
            
            // إخفاء النقاط الثلاث (dtr-control) من DataTables responsive
            function hideDtrControl() {
                var dtrControls = document.querySelectorAll('.dtr-control, .dtr-details, .dtr-details-control, td.dtr-control, th.dtr-control');
                dtrControls.forEach(function(element) {
                    element.style.display = 'none';
                    element.style.visibility = 'hidden';
                });
            }
            
            // تشغيل إخفاء النقاط الثلاث بشكل دوري
            setInterval(hideDtrControl, 100);
            
            // تشغيل بعد تحميل DataTables
            if (typeof DataTable !== 'undefined') {
                var table = document.querySelector('#crudTable');
                if (table && table.DataTable) {
                    table.DataTable.on('draw', function() {
                        hideDtrControl();
                    });
                }
            }
        })();
        
    </script>
  @endif
  
@endsection
