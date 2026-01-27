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

        /* Form Card Styling */
        .card {
            border-radius: 20px !important;
            border: 1px solid #f1f5f9 !important;
            box-shadow: var(--shadow-sm) !important;
        }

        .card-body {
            padding: 2rem !important;
        }

        /* Fix for Select2 inside forms */
        .select2-container--bootstrap .select2-selection {
            border-radius: 12px !important;
            height: 46px !important;
            display: flex !important;
            align-items: center !important;
        }
    </style>
@endsection

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header">
        <div style="display: flex; align-items: center; gap: 1rem; position: relative; z-index: 1;">
            <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.1); border-radius: 16px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                <i class="la la-plus-circle" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
            </div>
            <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 800; margin: 0;">
                {!! $crud->getHeading() ?? 'إضافة ' . $crud->entity_name !!}
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
<div class="row" bp-section="crud-operation-create">
	<div class="{{ $crud->getCreateContentClass() }}">
		@include('crud::inc.grouped_errors')
		  <form method="post" action="{{ url($crud->route) }}" @if ($crud->hasUploadFields('create')) enctype="multipart/form-data" @endif>
			  {!! csrf_field() !!}
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', [ 'fields' => $crud->fields(), 'action' => 'create' ])
		      @else
		      	@include('crud::form_content', [ 'fields' => $crud->fields(), 'action' => 'create' ])
		      @endif
              <div class="d-none" id="parentLoadedAssets">{{ json_encode(Basset::loaded()) }}</div>
	          @include('crud::inc.form_save_buttons')
		  </form>
	</div>
</div>
@endsection
