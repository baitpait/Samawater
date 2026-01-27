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
            overflow: hidden !important;
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

        {{-- إضافة فلاتر موحدة لصفحة العملاء --}}
        @if(request()->is('*/client') && !request()->is('*/client-type*') && !request()->is('*/client/*/show') && !request()->is('*/client/*/edit') && !request()->is('*/client/*/create'))
            @include('admin.client_filters')
            
            {{-- جدول العملاء - عرض مباشر من قاعدة البيانات --}}
            @php
                $perPage = request('per_page', 10);
                $perPage = in_array($perPage, [10, 50, 100, 'all']) ? $perPage : 10;
                
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
                                <th>الهاتف</th>
                                <th>معلومات الاشتراك</th>
                                <th>نسبة الالتزام</th>
                                <th class="pe-4">إجراءات</th>
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
                                    <td>{{ $client->phone_one }}</td>
                                    <td>
                                        <span class="badge bg-primary-deep text-white">{{ $client->subscriptionType ? $client->subscriptionType->type_name : '-' }}</span>
                                        <span class="badge bg-success text-white">{{ $client->subscriptionStatus ? $client->subscriptionStatus->status_name : '-' }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $percentage = 0;
                                            if ($client->subscription_start_date && $client->subscriptionType && $client->subscriptionType->distribution_days > 0) {
                                                $days = \Carbon\Carbon::parse($client->subscription_start_date)->diffInDays(now());
                                                $expected = floor($days / $client->subscriptionType->distribution_days);
                                                if ($expected > 0) $percentage = round(($client->deliveries->count() / $expected) * 100, 1);
                                            }
                                        @endphp
                                        <span class="badge bg-{{ $percentage >= 80 ? 'success' : ($percentage >= 50 ? 'warning' : 'danger') }} text-white">{{ $percentage }}%</span>
                                    </td>
                                    <td class="pe-4">
                                        <a href="{{ backpack_url('client/' . $client->id . '/show') }}" class="btn btn-sm btn-primary"><i class="la la-eye"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center py-5 text-muted">لا توجد بيانات</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                    @if($perPage !== 'all' && $clients->hasPages())
                        <div class="mt-4">{{ $clients->appends(request()->query())->links() }}</div>
                    @endif
                </div>
            </div>
        @endif

        @if(!request()->is('*/delivery') || request()->is('*/delivery/*'))
            <div class="{{ backpack_theme_config('classes.tableWrapper') }}">
                <table id="crudTable" class="table table-clean align-middle mb-0" cellspacing="0">
                <thead>
                  <tr>
                    @foreach ($crud->columns() as $column)
                      <th data-column-name="{{ $column['name'] }}">{!! $column['label'] !!}</th>
                    @endforeach
                    @if ( $crud->buttons()->where('stack', 'line')->count() )
                      <th data-action-column="true">{{ trans('backpack::crud.actions') }}</th>
                    @endif
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
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
  </script>
@endsection
