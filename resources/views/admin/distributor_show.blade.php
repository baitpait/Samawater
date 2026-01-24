@extends(backpack_view('blank'))

@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">
    
    {{-- Unified Header Styles --}}
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
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
            position: relative !important;
            z-index: 1 !important;
            display: flex !important;
            align-items: center !important;
            gap: 1rem !important;
        }

        section.header-operation p {
            color: rgba(255, 255, 255, 0.9) !important;
            font-size: 14px !important;
            margin: 0 !important;
            position: relative !important;
            z-index: 1 !important;
        }

        section.header-operation a {
            color: rgba(255, 255, 255, 0.9) !important;
            text-decoration: none !important;
        }

        section.header-operation a:hover {
            color: #fff !important;
        }

        /* إخفاء header الافتراضي */
        div.container-fluid.d-flex.justify-content-between.my-3 {
            display: none !important;
        }

        /* Unified Card Design */
        .card {
            background: #fcfdff !important;
            border-radius: 20px !important;
            border: none !important;
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.06) !important;
            margin-bottom: 1.5rem !important;
        }

        .card-body {
            padding: 1.5rem !important;
        }

        /* Unified Table Design */
        table.table {
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            background: #fff !important;
            border-radius: 20px !important;
            overflow: hidden !important;
        }

        table.table thead th {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
            color: #fff !important;
            font-weight: 600 !important;
            padding: 1rem !important;
            border: none !important;
            font-family: 'Cairo', sans-serif !important;
            font-size: 14px !important;
        }

        table.table tbody td {
            padding: 1rem !important;
            color: #1f2937 !important;
            font-family: 'Cairo', sans-serif !important;
            font-size: 14px !important;
            border-bottom: 1px solid #e5e7eb !important;
        }

        table.table tbody tr:last-child td {
            border-bottom: none !important;
        }

        table.table tbody tr:hover {
            background: #f7f9ff !important;
        }

        /* إخفاء عمود الإجراءات من الجدول */
        table.table tbody tr td:contains('أجراءات'),
        table.table tbody tr td:contains('إجراءات'),
        table.table tbody tr:has(td:contains('أجراءات')),
        table.table tbody tr:has(td:contains('إجراءات')) {
            display: none !important;
        }

        /* Unified Buttons */
        .btn {
            border-radius: 12px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            padding: 0.5rem 1rem !important;
            transition: all 0.2s ease !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
            border: none !important;
            color: #fff !important;
        }

        .btn-primary:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(111, 106, 248, 0.4) !important;
        }

        .btn-success {
            background: linear-gradient(135deg, #34d399 0%, #22c55e 100%) !important;
            border: none !important;
            color: #fff !important;
        }

        .btn-success:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(34, 211, 153, 0.4) !important;
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            border: none !important;
            color: #fff !important;
        }

        .btn-danger:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4) !important;
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
            border: none !important;
            color: #fff !important;
        }

        .btn-warning:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4) !important;
        }

        .btn-info {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
            border: none !important;
            color: #fff !important;
        }

        .btn-info:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4) !important;
        }

        /* Unified Actions Buttons Section */
        .unified-actions-section {
            background: #fcfdff !important;
            border-radius: 20px !important;
            border: none !important;
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.06) !important;
            padding: 1.5rem !important;
            margin-top: 1.5rem !important;
        }

        .unified-actions-section h3 {
            color: #1f2937 !important;
            font-size: 18px !important;
            font-weight: 700 !important;
            margin-bottom: 1rem !important;
            font-family: 'Cairo', sans-serif !important;
        }

        .unified-actions-buttons {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 0.75rem !important;
        }

        .btn-back-unified {
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

        .btn-back-unified:hover {
            background: rgba(255, 255, 255, 0.3) !important;
            transform: translateY(-2px) !important;
            color: #fff !important;
        }

        /* مربع احترافي لأيقونة header */
        .header-icon-wrapper {
            width: 56px !important;
            height: 56px !important;
            background: rgba(255, 255, 255, 0.2) !important;
            border-radius: 16px !important;
            backdrop-filter: blur(10px) !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            position: relative !important;
        }

        .header-icon-wrapper i {
            font-size: 24px !important;
            color: #fff !important;
            font-weight: 900 !important;
            z-index: 2 !important;
        }
    </style>
@endsection

@section('header')
    {{-- Unified Header Design - الهوية البصرية الموحدة --}}
    <section class="header-operation-unified" style="background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%); border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 2rem; box-shadow: 0 10px 30px rgba(111, 106, 248, 0.3); position: relative; overflow: hidden;">
        {{-- Background Animation Effect --}}
        <div style="content: ''; position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite; pointer-events: none;"></div>
        
        {{-- Header Content --}}
        <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                <div class="header-icon-wrapper">
                    <i class="la la-user-tie"></i>
                </div>
                <h1 style="color: #fff; font-size: 24px; font-weight: 700; margin: 0; font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                    الموزعين
                </h1>
            </div>
            @if ($crud->hasAccess('list'))
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <a href="{{ backpack_url('distributor') }}" class="btn btn-back-unified no-print">
                        <i class="la la-angle-double-right"></i> العودة إلى قائمة الموزعين
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('content')
<div class="row" bp-section="crud-operation-show">
    <div class="{{ $crud->getShowContentClass() }}">
        {{-- Default box --}}
        <div class="">
            {{-- Unified Actions Buttons Section - في الأعلى --}}
            <div class="unified-actions-section" style="margin-bottom: 2rem;">
                <div class="unified-actions-buttons">
                    @if ($crud->hasAccess('update'))
                        <a href="{{ backpack_url('distributor/'.$entry->getKey().'/edit') }}" class="btn btn-primary">
                            <i class="la la-edit"></i> تعديل
                        </a>
                    @endif
                    
                    @if ($crud->hasAccess('delete'))
                        <a href="{{ backpack_url('distributor/'.$entry->getKey()) }}" 
                           class="btn btn-danger"
                           onclick="event.preventDefault(); if(confirm('هل أنت متأكد من حذف هذا الموزع؟')) { document.getElementById('delete-form-{{ $entry->getKey() }}').submit(); }">
                            <i class="la la-trash"></i> حذف
                        </a>
                        <form id="delete-form-{{ $entry->getKey() }}" action="{{ backpack_url('distributor/'.$entry->getKey()) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif

                    <button type="button" class="btn btn-warning open-withdraw-modal" 
                            data-id="{{ $entry->getKey() }}" 
                            data-balance="{{ $entry->balance ?? 0 }}">
                        <i class="la la-money-bill"></i> سحب
                    </button>

                    <a href="{{ backpack_url('distributor/'.$entry->getKey().'/financial-report') }}" class="btn btn-info">
                        <i class="la la-file-invoice-dollar"></i> التقرير المالي
                    </a>

                    <a href="{{ backpack_url('distributor/'.$entry->getKey().'/clients') }}" class="btn btn-success">
                        <i class="la la-users"></i> المشتركين
                    </a>
                </div>
            </div>

            @if ($crud->model->translationEnabled())
                <div class="row">
                    <div class="col-md-12 mb-2" bp-section="show-operation-language-dropdown">
                        {{-- Change translation button group --}}
                        <div class="btn-group float-right">
                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[request()->input('_locale')?request()->input('_locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                @foreach ($crud->model->getAvailableLocales() as $key => $locale)
                                    <a class="dropdown-item" href="{{ backpack_url('distributor/'.$entry->getKey().'/show') }}?_locale={{ $key }}">{{ $locale }}</a>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            
            @if($crud->tabsEnabled() && count($crud->getUniqueTabNames('columns')))
                @include('crud::inc.show_tabbed_table')
            @else
                <div class="card no-padding no-border mb-0">
                    @include('crud::inc.show_table', ['columns' => $crud->columns(), 'displayActionsColumn' => false])
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('after_scripts')
<script>
    // إخفاء عمود الإجراءات من الجدول باستخدام JavaScript
    (function() {
        function hideActionsColumn() {
            var table = document.querySelector('table.table');
            if (!table) return;
            
            var rows = table.querySelectorAll('tbody tr');
            rows.forEach(function(row) {
                var cells = row.querySelectorAll('td');
                cells.forEach(function(cell) {
                    var cellText = cell.textContent.trim();
                    if (cellText === 'أجراءات' || cellText === 'إجراءات' || cellText === 'Actions') {
                        // إخفاء الصف كاملاً إذا كان يحتوي على عمود الإجراءات
                        var prevCell = cell.previousElementSibling;
                        if (prevCell && (prevCell.textContent.trim() === 'أجراءات' || prevCell.textContent.trim() === 'إجراءات' || prevCell.textContent.trim() === 'Actions')) {
                            row.style.display = 'none';
                        } else {
                            cell.style.display = 'none';
                        }
                    }
                });
            });
        }
        
        // تشغيل عند تحميل الصفحة
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(hideActionsColumn, 100);
                setTimeout(hideActionsColumn, 500);
            });
        } else {
            setTimeout(hideActionsColumn, 100);
            setTimeout(hideActionsColumn, 500);
        }
    })();
</script>
@include('admin.distributor_withdraw_modal')
@endsection

