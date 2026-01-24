@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      $crud->entity_name_plural => url($crud->route),
      trans('backpack::crud.preview') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('after_styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Cairo', sans-serif;
        }
        
        /* ============================================
           تصميم صفحة عرض العميل - Unified Design
           ============================================ */
        
        .client-info-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 24px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: none;
            box-sizing: border-box;
            position: relative;
            z-index: 10;
            margin-top: 0;
        }
        
        /* على الشاشات الكبيرة، نفس عرض header-operation */
        @media (min-width: 768px) {
            .main .client-info-card {
                width: 100%;
                max-width: 100%;
                margin-left: 20px;
                margin-right: 20px;
            }
        }
        
        /* على الشاشات الصغيرة */
        @media (max-width: 767px) {
            .main .client-info-card {
                margin-left: 15px;
                margin-right: 15px;
                width: calc(100% - 30px);
                max-width: calc(100% - 30px);
            }
        }
        
        .client-info-card .card-title {
            font-size: 22px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 32px;
            padding-bottom: 20px;
            border-bottom: 3px solid #e5e7eb;
            font-family: 'Cairo', sans-serif;
        }
        
        .info-row {
            display: flex;
            align-items: flex-start;
            padding: 20px 0;
            border-bottom: 1px solid #f3f4f6;
            min-height: 50px;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-size: 16px;
            font-weight: 700;
            color: #374151;
            min-width: 200px;
            margin-left: 24px;
            line-height: 1.6;
            font-family: 'Cairo', sans-serif;
        }
        
        .info-value {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            flex: 1;
            line-height: 1.6;
            font-family: 'Cairo', sans-serif;
            word-break: break-word;
        }
        
        .info-value strong,
        .info-value b {
            font-weight: 700;
            color: #1f2937;
        }
        
        .info-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            font-family: 'Cairo', sans-serif;
            line-height: 1.4;
        }
        
        .info-value a {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            font-family: 'Cairo', sans-serif;
            margin-bottom: 8px;
            transition: all 0.2s ease;
        }
        
        .info-value a:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2) !important;
            opacity: 0.9;
        }
        
        .badge-primary {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%);
            color: #fff;
            box-shadow: 0 2px 8px rgba(111, 106, 248, 0.25);
        }
        
        .badge-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
        }
        
        .badge-secondary {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #e5e7eb;
        }
        
        .badge-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #fff;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.25);
        }
        
        .badge-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #fff;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.25);
        }
        
        .empty-value {
            color: #9ca3af;
            font-style: italic;
            font-size: 15px;
            font-weight: 500;
        }
        
        /* تصميم صورة العميل */
        .client-info-card img {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .client-info-card img:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15) !important;
        }
        
        @media (max-width: 768px) {
            .client-info-card {
                padding: 24px;
            }
            
            .info-row {
                flex-direction: column;
                align-items: flex-start;
                padding: 16px 0;
            }
            
            .info-label {
                min-width: auto;
                margin-left: 0;
                margin-bottom: 12px;
                font-size: 15px;
            }
            
            .info-value {
                font-size: 15px;
                width: 100%;
            }
            
            .col-md-6 {
                margin-bottom: 8px;
            }
        }
    </style>
@endsection

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header" style="background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%); border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 2rem; box-shadow: 0 10px 30px rgba(111, 106, 248, 0.3); width: 100%; display: flex; align-items: center; justify-content: space-between; position: relative; overflow: visible;">
        <div style="display: flex; align-items: center; gap: 1rem; position: relative; z-index: 1;">
            <div>
                <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 700; margin: 0; font-family: 'Cairo', sans-serif;">ملف العميل</h1>
            </div>
        </div>
        <div style="display: flex; gap: 12px; align-items: center; position: relative; z-index: 10;">
            @if ($crud->hasAccess('list'))
                <a href="{{ url($crud->route) }}" style="background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.3); color: #fff; padding: 10px 20px; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; font-family: 'Cairo', sans-serif;">
                    <div style="width: 32px; height: 32px; background: rgba(255, 255, 255, 0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255, 255, 255, 0.3);">
                        <i class="la la-arrow-right" style="font-size: 16px; color: #fff;"></i>
                    </div>
                    {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span>
                </a>
            @endif
        </div>
    </section>
    
    <style>
        /* إخفاء breadcrumbs */
        .breadcrumb,
        .breadcrumb-item,
        nav[aria-label="breadcrumb"],
        ol.breadcrumb {
            display: none !important;
        }
        
        /* إخفاء header-operation الافتراضي من Backpack إن وجد */
        section.header-operation p[bp-section="page-subheading-back-button"],
        section.header-operation small,
        section.header-operation a.font-sm {
            display: none !important;
        }
    </style>
@endsection

@section('content')
  {{-- Default box --}}
  <div class="row" bp-section="crud-operation-show">
    {{-- THE ACTUAL CONTENT --}}
    <div class="{{ $crud->getListContentClass() }}">
        @if ($crud->model->translationEnabled())
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="btn-group float-right">
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[request()->input('_locale')?request()->input('_locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            @foreach ($crud->model->getAvailableLocales() as $key => $locale)
                                <a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/show') }}?_locale={{ $key }}">{{ $locale }}</a>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if($crud->tabsEnabled() && count($crud->getUniqueTabNames('columns')))
            @include('crud::inc.show_tabbed_table')
        @else
            <div class="client-info-card">
                @if($entry->name)
                    <h3 class="card-title" style="font-size: 22px; font-weight: 700; color: #1f2937; margin-bottom: 32px; padding-bottom: 20px; border-bottom: 3px solid #e5e7eb; font-family: 'Cairo', sans-serif;">{{ $entry->name }}</h3>
                @else
                    <h3 class="card-title">معلومات العميل</h3>
                @endif
                
                <div class="row">
                    {{-- قسم الأجراءات في الأعلى --}}
                    <div class="col-12">
                        <div class="info-row" style="border-bottom: 2px solid #e5e7eb; margin-bottom: 16px; padding-bottom: 24px;">
                            <span class="info-value" style="width: 100%;">
                                @php
                                    $clientId = $entry->id;
                                    $clientName = $entry->name ?? '';
                                    $editUrl = backpack_url('client/' . $clientId . '/edit');
                                    $reportUrl = route('client.report', ['client_id' => $clientId]);
                                    $deliveryUrl = backpack_url('delivery/create?client_id=' . $clientId);
                                    $deleteUrl = backpack_url('client/' . $clientId);
                                @endphp
                                <div style="display: flex; flex-direction: row; gap: 12px; align-items: stretch; width: 100%;">
                                    {{-- تعديل --}}
                                    <a href="{{ $editUrl }}" style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 14px 20px; border-radius: 10px; font-weight: 700; font-size: 15px; background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%); color: #fff; box-shadow: 0 2px 8px rgba(111, 106, 248, 0.25); text-decoration: none; transition: all 0.2s ease; min-height: 48px;">
                                        تعديل
                                    </a>
                                    
                                    {{-- التسليمات --}}
                                    <a href="{{ $reportUrl }}" style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 14px 20px; border-radius: 10px; font-weight: 700; font-size: 15px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: #fff; box-shadow: 0 2px 8px rgba(59, 130, 246, 0.25); text-decoration: none; transition: all 0.2s ease; min-height: 48px;">
                                        التسليمات
                                    </a>
                                    
                                    {{-- تسليم --}}
                                    <a href="{{ $deliveryUrl }}" style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 14px 20px; border-radius: 10px; font-weight: 700; font-size: 15px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25); text-decoration: none; transition: all 0.2s ease; min-height: 48px;">
                                        تسليم
                                    </a>
                                    
                                    {{-- حذف --}}
                                    <a href="#" 
                                       data-client-id="{{ $clientId }}"
                                       data-client-name="{{ htmlspecialchars($clientName, ENT_QUOTES, 'UTF-8') }}"
                                       class="delete-client-btn"
                                       style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 14px 20px; border-radius: 10px; font-weight: 700; font-size: 15px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: #fff; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.25); text-decoration: none; transition: all 0.2s ease; cursor: pointer; min-height: 48px;">
                                        حذف
                                    </a>
                                    
                                    <form id="delete-form-{{ $clientId }}" action="{{ $deleteUrl }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </span>
                        </div>
                    </div>
                    
                    @php
                        // ترتيب الأعمدة حسب المطلوب
                        $orderedColumns = [];
                        $notesColumn = null;
                        $contractNoColumn = null;
                        $distributorColumn = null;
                        
                        foreach($crud->columns() as $column) {
                            if ($column['name'] === 'notes') {
                                $notesColumn = $column;
                            } elseif ($column['name'] === 'contract_no') {
                                $contractNoColumn = $column;
                            } elseif ($column['name'] === 'distributor_id') {
                                $distributorColumn = $column;
                            } else {
                                $orderedColumns[] = $column;
                            }
                        }
                    @endphp
                    
                    {{-- رقم العقد واسم الموزع في نفس الصف --}}
                    <div class="row" style="width: 100%; margin: 0;">
                        @if($contractNoColumn)
                            <div class="col-md-6">
                                <div class="info-row">
                                    <span class="info-label">{{ $contractNoColumn['label'] ?? $contractNoColumn['name'] }}</span>
                                    <span class="info-value">
                                        @php
                                            $columnPaths = array_map(function($item) use ($contractNoColumn) {
                                                return $item.'.'.$contractNoColumn['type'];
                                            }, \Backpack\CRUD\ViewNamespaces::getFor('columns'));
                                            
                                            if (!in_array('crud::columns.text', $columnPaths)) {
                                                $columnPaths[] = 'crud::columns.text';
                                            }
                                        @endphp
                                        @includeFirst($columnPaths, ['entry' => $entry, 'column' => $contractNoColumn])
                                    </span>
                                </div>
                            </div>
                        @endif
                        
                        @if($distributorColumn)
                            <div class="col-md-6">
                                <div class="info-row">
                                    <span class="info-label">{{ $distributorColumn['label'] ?? $distributorColumn['name'] }}</span>
                                    <span class="info-value">
                                        @php
                                            $columnPaths = array_map(function($item) use ($distributorColumn) {
                                                return $item.'.'.$distributorColumn['type'];
                                            }, \Backpack\CRUD\ViewNamespaces::getFor('columns'));
                                            
                                            if (!in_array('crud::columns.text', $columnPaths)) {
                                                $columnPaths[] = 'crud::columns.text';
                                            }
                                        @endphp
                                        @includeFirst($columnPaths, ['entry' => $entry, 'column' => $distributorColumn])
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    @foreach($orderedColumns as $column)
                        @php
                            // تحديد نوع badge
                            $badgeClass = '';
                            $useBadge = false;
                            
                            if ($column['name'] === 'subscription_type_id') {
                                $useBadge = true;
                                $badgeClass = 'badge-primary';
                            } elseif ($column['name'] === 'subscription_status_id') {
                                $useBadge = true;
                                $badgeClass = 'badge-success';
                            } elseif ($column['name'] === 'client_type') {
                                $useBadge = true;
                                $badgeClass = 'badge-secondary';
                            } elseif ($column['name'] === 'days_since_last_delivery' || $column['name'] === 'last_delivery_date') {
                                $useBadge = false; // لا نريد badge لهذه
                            } elseif ($column['type'] === 'custom_html' && $column['name'] !== 'location') {
                                $useBadge = false;
                            }
                            
                            // تحديد حجم العمود
                            $colSize = 'col-md-6';
                            if ($column['name'] === 'location') {
                                $colSize = 'col-12'; // الموقع في عمود كامل
                            }
                        @endphp
                        
                        <div class="{{ $colSize }}">
                            <div class="info-row">
                                <span class="info-label">{{ $column['label'] ?? $column['name'] }}</span>
                                <span class="info-value">
                                    @if($useBadge)
                                        <span class="info-badge {{ $badgeClass }}">
                                            @php
                                                $columnPaths = array_map(function($item) use ($column) {
                                                    return $item.'.'.$column['type'];
                                                }, \Backpack\CRUD\ViewNamespaces::getFor('columns'));
                                                
                                                if (!in_array('crud::columns.text', $columnPaths)) {
                                                    $columnPaths[] = 'crud::columns.text';
                                                }
                                            @endphp
                                            @includeFirst($columnPaths, ['entry' => $entry, 'column' => $column])
                                        </span>
                                    @else
                                        @php
                                            $columnPaths = array_map(function($item) use ($column) {
                                                return $item.'.'.$column['type'];
                                            }, \Backpack\CRUD\ViewNamespaces::getFor('columns'));
                                            
                                            if (!in_array('crud::columns.text', $columnPaths)) {
                                                $columnPaths[] = 'crud::columns.text';
                                            }
                                        @endphp
                                        @includeFirst($columnPaths, ['entry' => $entry, 'column' => $column])
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endforeach
                    
                    {{-- الملاحظات في عمود منفصل --}}
                    @if($notesColumn)
                        <div class="col-12">
                            <div class="info-row" style="border-top: 2px solid #e5e7eb; margin-top: 16px; padding-top: 24px;">
                                <span class="info-label">{{ $notesColumn['label'] ?? $notesColumn['name'] }}</span>
                                <span class="info-value" style="width: 100%;">
                                    @php
                                        $columnPaths = array_map(function($item) use ($notesColumn) {
                                            return $item.'.'.$notesColumn['type'];
                                        }, \Backpack\CRUD\ViewNamespaces::getFor('columns'));
                                        
                                        if (!in_array('crud::columns.text', $columnPaths)) {
                                            $columnPaths[] = 'crud::columns.text';
                                        }
                                    @endphp
                                    @includeFirst($columnPaths, ['entry' => $entry, 'column' => $notesColumn])
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
  </div>

@section('after_scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // نقل client-info-card إلى نفس مستوى header-operation داخل main
    var clientInfoCard = document.querySelector('.client-info-card');
    var headerOperation = document.querySelector('section.header-operation');
    var mainElement = document.querySelector('.app-body .main');
    
    if (clientInfoCard && headerOperation && mainElement) {
        // نقل الكارد إلى بعد الـ Header مباشرة داخل main
        if (clientInfoCard.parentNode !== mainElement) {
            // إزالة الكارد من موضعه الحالي
            clientInfoCard.remove();
            
            // إدراجه بعد الـ Header مباشرة داخل main
            if (headerOperation.nextSibling) {
                mainElement.insertBefore(clientInfoCard, headerOperation.nextSibling);
            } else {
                mainElement.appendChild(clientInfoCard);
            }
        }
        
        // تطبيق العرض الصحيح - نفس عرض header-operation
        function updateCardWidth() {
            var headerOperation = document.querySelector('section.header-operation');
            if (headerOperation && clientInfoCard) {
                if (window.innerWidth >= 768) {
                    // الحصول على عرض الـ Header
                    var headerWidth = headerOperation.offsetWidth;
                    var headerLeft = headerOperation.offsetLeft;
                    
                    // تطبيق نفس العرض والموضع على الكارد
                    clientInfoCard.style.width = headerWidth + 'px';
                    clientInfoCard.style.maxWidth = headerWidth + 'px';
                    clientInfoCard.style.marginLeft = headerLeft + 'px';
                    clientInfoCard.style.marginRight = 'auto';
                } else {
                    clientInfoCard.style.width = 'calc(100% - 30px)';
                    clientInfoCard.style.maxWidth = 'calc(100% - 30px)';
                    clientInfoCard.style.marginLeft = '15px';
                    clientInfoCard.style.marginRight = '15px';
                }
            }
        }
        
        // تطبيق العرض عند تحميل الصفحة
        setTimeout(updateCardWidth, 100);
        
        // تحديث العرض عند تغيير حجم النافذة
        window.addEventListener('resize', function() {
            setTimeout(updateCardWidth, 100);
        });
        
        // مراقبة تغييرات الـ Header
        if (window.MutationObserver) {
            var observer = new MutationObserver(function(mutations) {
                updateCardWidth();
            });
            
            var headerOperation = document.querySelector('section.header-operation');
            if (headerOperation) {
                observer.observe(headerOperation, {
                    attributes: true,
                    attributeFilter: ['style', 'class']
                });
            }
        }
    }
    
    // إضافة event listeners لأزرار الحذف
    document.querySelectorAll('.delete-client-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var clientId = this.getAttribute('data-client-id');
            var clientName = this.getAttribute('data-client-name');
            
            var confirmed = confirm('هل أنت متأكد من حذف العميل "' + clientName + '"؟');
            
            if (confirmed) {
                var form = document.getElementById('delete-form-' + clientId);
                if (form) {
                    form.submit();
                } else {
                    alert('خطأ: لم يتم العثور على نموذج الحذف');
                }
            }
            
            return false;
        });
    });
});
</script>
@endsection
