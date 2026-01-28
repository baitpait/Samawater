@extends(backpack_view('blank'))

@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">
    
    <style>
        /* ============================================
           Page Header - Unified Design
           ============================================ */
        section.header-operation {
            background: var(--primary-deep) !important;
            border-radius: 20px !important;
            padding: 1.5rem 2rem !important;
            margin-bottom: 2rem !important;
            box-shadow: var(--shadow-md) !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
        }

        section.header-operation h1 {
            color: #fff !important;
            font-weight: 800 !important;
            font-family: 'Cairo', sans-serif !important;
        }

        /* Show Table Styling */
        .card {
            border-radius: 20px !important;
            border: 1px solid #f1f5f9 !important;
            box-shadow: var(--shadow-sm) !important;
            overflow: visible !important;
        }

        table.table {
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
        }

        table.table thead th {
            background: var(--primary-deep) !important;
            color: #fff !important;
            font-weight: 700 !important;
            padding: 1rem !important;
            border: none !important;
        }

        table.table tbody td {
            padding: 1rem !important;
            color: #334155 !important;
            font-weight: 600 !important;
            border-bottom: 1px solid #f1f5f9 !important;
        }
    </style>
@endsection

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header">
        <div style="display: flex; align-items: center; gap: 1rem; position: relative; z-index: 1;">
            <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.1); border-radius: 16px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                <i class="la la-eye" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
            </div>
            <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 800; margin: 0;">
                {!! $crud->getHeading() ?? 'عرض ' . $crud->entity_name !!}
            </h1>
        </div>
        <div class="page-header-actions" style="position: relative; z-index: 10;">
            <a href="{{ url($crud->route) }}" class="btn btn-light" style="color: var(--primary-deep); font-weight: 700; border-radius: 12px;">
                <i class="la la-arrow-right"></i> العودة للقائمة
            </a>
        </div>
    </section>
@endsection

@section('content')
<div class="row" bp-section="crud-operation-show">
	<div class="{{ $crud->getShowContentClass() }}">

        {{-- أزرار الإجراءات المخصصة للمشتركين --}}
        @if(request()->is('*/client/*/show'))
            @php
                $clientId = $entry->id;
                $clientName = $entry->name ?? '';
                $editUrl = backpack_url('client/' . $clientId . '/edit');
                $reportUrl = route('client.report', ['client_id' => $clientId]);
                $deliveryUrl = backpack_url('delivery/create?client_id=' . $clientId);
                $deleteUrl = backpack_url('client/' . $clientId);
            @endphp
            <div class="card mb-4" style="border-radius: 20px; border: none; box-shadow: var(--shadow-sm); overflow: visible;">
                <div class="card-body p-3">
                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                        {{-- تعديل --}}
                        <a href="{{ $editUrl }}" class="btn btn-primary" style="flex: 1; min-width: 120px; background: #7c7cff !important; border: none; border-radius: 12px; font-weight: 700; padding: 12px;">
                            <i class="la la-edit"></i> تعديل
                        </a>
                        
                        {{-- التسليمات --}}
                        <a href="{{ $reportUrl }}" class="btn btn-info text-white" style="flex: 1; min-width: 120px; background: #3b82f6 !important; border: none; border-radius: 12px; font-weight: 700; padding: 12px;">
                            <i class="la la-list"></i> التسليمات
                        </a>
                        
                        {{-- تسليم --}}
                        <a href="{{ $deliveryUrl }}" class="btn btn-success" style="flex: 1; min-width: 120px; background: #10b981 !important; border: none; border-radius: 12px; font-weight: 700; padding: 12px;">
                            <i class="la la-truck"></i> تسليم
                        </a>
                        
                        {{-- حذف --}}
                        <a href="#" 
                           onclick="event.preventDefault(); if(confirm('هل أنت متأكد من حذف العميل؟')) { document.getElementById('delete-client-form').submit(); }"
                           class="btn btn-danger" style="flex: 1; min-width: 120px; background: #ef4444 !important; border: none; border-radius: 12px; font-weight: 700; padding: 12px;">
                            <i class="la la-trash"></i> حذف
                        </a>
                        
                        <form id="delete-client-form" action="{{ $deleteUrl }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <div class="card">
            <div class="card-body p-0">
                @if($crud->tabsEnabled() && count($crud->getUniqueTabNames('columns')))
                    @include('crud::inc.show_tabbed_table')
                @else
                    @include('crud::inc.show_table', ['columns' => $crud->columns()])
                @endif
            </div>
        </div>
	</div>
</div>
@endsection
