@extends(backpack_view('blank'))

@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">
    
    <style>
        /* ============================================
           Page Header - Unified Design
           ============================================ */
        section.header-operation-unified {
            background: var(--primary-deep) !important;
            border-radius: 20px !important;
            padding: 1.5rem 2rem !important;
            margin-bottom: 2rem !important;
            box-shadow: var(--shadow-md) !important;
            position: relative !important;
            overflow: visible !important;
            width: 100% !important;
            display: block !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
        }
        
        .header-icon-wrapper {
            width: 56px !important;
            height: 56px !important;
            background: rgba(255, 255, 255, 0.1) !important;
            border-radius: 16px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
        }

        .header-icon-wrapper i {
            font-size: 24px !important;
            color: #fff !important;
        }
        
        .btn-back-unified {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 700 !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
        }
        
        .btn-back-unified:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            transform: translateY(-2px) !important;
            color: #fff !important;
            text-decoration: none;
        }

        /* Unified Card Design */
        .card {
            background: #ffffff !important;
            border-radius: 20px !important;
            border: 1px solid #f1f5f9 !important;
            box-shadow: var(--shadow-sm) !important;
            margin-bottom: 1.5rem !important;
        }

        /* Unified Table Design */
        table.table {
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            background: #fff !important;
            border-radius: 20px !important;
            overflow: visible !important;
        }

        table.table thead th {
            background: var(--primary-deep) !important;
            color: #fff !important;
            font-weight: 700 !important;
            padding: 1rem !important;
            border: none !important;
            font-size: 15px !important;
        }

        table.table tbody td {
            padding: 1rem !important;
            color: #334155 !important;
            font-weight: 600 !important;
            border-bottom: 1px solid #f1f5f9 !important;
        }

        /* Unified Actions Buttons Section */
        .unified-actions-section {
            background: #ffffff !important;
            border-radius: 20px !important;
            border: 1px solid #f1f5f9 !important;
            box-shadow: var(--shadow-sm) !important;
            padding: 1.5rem !important;
            margin-bottom: 1.5rem !important;
        }

        .unified-actions-buttons {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 0.75rem !important;
        }
    </style>
@endsection

@section('header')
    <section class="header-operation-unified">
        <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                <div class="header-icon-wrapper">
                    <i class="la la-user-tie"></i>
                </div>
                <h1 style="color: #fff; font-size: 24px; font-weight: 800; margin: 0; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);">
                    ملف الموزع
                </h1>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <a href="{{ backpack_url('distributor') }}" class="btn btn-back-unified no-print">
                    <i class="la la-angle-double-right"></i> العودة إلى القائمة
                </a>
            </div>
        </div>
    </section>
@endsection

@section('content')
<div class="row" bp-section="crud-operation-show">
    <div class="{{ $crud->getShowContentClass() }}">
        {{-- Actions Buttons --}}
        <div class="unified-actions-section">
            <div class="unified-actions-buttons">
                @if ($crud->hasAccess('update'))
                    <a href="{{ backpack_url('distributor/'.$entry->getKey().'/edit') }}" class="btn btn-primary">
                        <i class="la la-edit"></i> تعديل البيانات
                    </a>
                @endif

                <button type="button" class="btn btn-warning text-white" style="background: var(--warning-color); border: none;" onclick="openWithdrawModal({{ $entry->getKey() }}, {{ $entry->balance ?? 0 }})">
                    <i class="la la-money-bill"></i> سحب مالي
                </button>

                <a href="{{ backpack_url('distributor/'.$entry->getKey().'/financial-report') }}" class="btn btn-info text-white" style="background: var(--primary-deep); border: none;">
                    <i class="la la-file-invoice-dollar"></i> التقرير المالي
                </a>

                <a href="{{ backpack_url('distributor/'.$entry->getKey().'/clients') }}" class="btn btn-success">
                    <i class="la la-users"></i> عرض المشتركين
                </a>
            </div>
        </div>

        {{-- Data Table --}}
        <div class="card">
            <div class="card-body p-0">
                @if($crud->tabsEnabled() && count($crud->getUniqueTabNames('columns')))
                    @include('crud::inc.show_tabbed_table')
                @else
                    @include('crud::inc.show_table', ['columns' => $crud->columns(), 'displayActionsColumn' => false])
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('after_scripts')
<script>
    function openWithdrawModal(id, balance) {
        // This function will be handled by the included modal
        if (typeof window.jQuery !== 'undefined' && window.jQuery('.open-withdraw-modal').length) {
            const btn = window.jQuery('.open-withdraw-modal').first();
            btn.data('id', id);
            btn.data('balance', balance);
            btn.click();
        }
    }

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
                        cell.style.display = 'none';
                    }
                });
            });
        }
        setTimeout(hideActionsColumn, 100);
    })();
</script>
@include('admin.distributor_withdraw_modal')
@endsection
