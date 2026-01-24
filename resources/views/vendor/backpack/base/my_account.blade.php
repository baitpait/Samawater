@extends(backpack_view('blank'))

@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">
    
    <style>
        /* ============================================
           Page Header - Unified Design
           ============================================ */
        section.header-operation,
        section.header-operation.container-fluid {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
            border-radius: 20px !important;
            padding: 1.5rem 2rem !important;
            margin-bottom: 2rem !important;
            box-shadow: 0 10px 30px rgba(111, 106, 248, 0.3) !important;
            position: relative !important;
            overflow: hidden !important;
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

        section.header-operation h1 {
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

        /* إخفاء breadcrumbs */
        .breadcrumb,
        .breadcrumb-item,
        nav[aria-label="breadcrumb"],
        ol.breadcrumb {
            display: none !important;
        }

        /* Unified Card Design */
        .account-card {
            background: #fcfdff !important;
            border-radius: 20px !important;
            border: none !important;
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.06) !important;
            margin-bottom: 2rem !important;
            overflow: hidden !important;
        }

        .account-card .card-header {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
            color: #fff !important;
            font-size: 18px !important;
            font-weight: 700 !important;
            padding: 1.25rem 1.5rem !important;
            border: none !important;
            font-family: 'Cairo', sans-serif !important;
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem !important;
        }

        .account-card .card-header i {
            font-size: 20px !important;
        }

        .account-card .card-body {
            padding: 2rem !important;
        }

        .account-card .card-footer {
            background: #f8f9fa !important;
            border-top: 1px solid #e9ecef !important;
            padding: 1.25rem 1.5rem !important;
            display: flex !important;
            gap: 0.75rem !important;
        }

        /* Form Labels */
        .account-card label {
            font-size: 14px !important;
            font-weight: 600 !important;
            color: #55607b !important;
            margin-bottom: 8px !important;
            font-family: 'Cairo', sans-serif !important;
        }

        .account-card label.required::after {
            content: ' *' !important;
            color: #ef4444 !important;
        }

        /* Form Inputs */
        .account-card .form-control {
            height: 50px !important;
            font-size: 15px !important;
            padding: 14px 20px !important;
            border-radius: 12px !important;
            border: 2px solid #e5e7eb !important;
            font-family: 'Cairo', sans-serif !important;
            transition: all 0.3s ease !important;
        }

        .account-card .form-control:focus {
            border-color: #6f6af8 !important;
            box-shadow: 0 0 0 3px rgba(111, 106, 248, 0.1) !important;
            outline: none !important;
        }

        /* Unified Buttons */
        .btn-save-unified {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            color: #fff !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 0.75rem 2rem !important;
            font-weight: 600 !important;
            font-size: 15px !important;
            font-family: 'Cairo', sans-serif !important;
            transition: all 0.3s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
        }

        .btn-save-unified:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3) !important;
            color: #fff !important;
        }

        .btn-cancel-unified {
            background: #f3f4f6 !important;
            color: #6b7280 !important;
            border: 2px solid #e5e7eb !important;
            border-radius: 12px !important;
            padding: 0.75rem 2rem !important;
            font-weight: 600 !important;
            font-size: 15px !important;
            font-family: 'Cairo', sans-serif !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
        }

        .btn-cancel-unified:hover {
            background: #e5e7eb !important;
            color: #374151 !important;
            transform: translateY(-2px) !important;
        }

        /* Alert Messages */
        .alert {
            border-radius: 12px !important;
            padding: 1rem 1.5rem !important;
            margin-bottom: 1.5rem !important;
            font-family: 'Cairo', sans-serif !important;
            border: none !important;
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%) !important;
            color: #065f46 !important;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%) !important;
            color: #991b1b !important;
        }

        .alert ul {
            margin: 0 !important;
            padding-right: 1.5rem !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .account-card .card-body {
                padding: 1.5rem !important;
            }

            section.header-operation {
                padding: 1.25rem 1.5rem !important;
            }
        }
    </style>
@endsection

@php
  $breadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      trans('backpack::base.my_account') => false,
  ];
@endphp

@section('header')
    <section class="header-operation container-fluid">
        <div style="display: flex; align-items: center; gap: 1rem; position: relative; z-index: 1;">
            <div class="header-icon-wrapper" style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.2); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15); display: flex; align-items: center; justify-content: center;">
                <i class="la la-user" style="font-size: 24px; color: #fff; font-weight: 900;"></i>
            </div>
            <h1>{{ trans('backpack::base.my_account') }}</h1>
        </div>
    </section>
@endsection

@section('content')
    <div class="row">
        {{-- Success Message --}}
        @if (session('success'))
        <div class="col-12">
            <div class="alert alert-success">
                <i class="la la-check-circle"></i> {{ session('success') }}
            </div>
        </div>
        @endif

        {{-- Error Messages --}}
        @if ($errors->count())
        <div class="col-12">
            <div class="alert alert-danger">
                <i class="la la-exclamation-circle"></i>
                <strong>حدث خطأ:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        {{-- UPDATE INFO FORM --}}
        <div class="col-12 col-lg-8">
            <form class="form" action="{{ route('backpack.account.info.store') }}" method="post">
                {!! csrf_field() !!}

                <div class="card account-card">
                    <div class="card-header">
                        <i class="la la-user-edit"></i>
                        {{ trans('backpack::base.update_account_info') }}
                    </div>

                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                @php
                                    $label = trans('backpack::base.name');
                                    $field = 'name';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input 
                                    required 
                                    class="form-control modern-input" 
                                    type="text" 
                                    name="{{ $field }}" 
                                    value="{{ old($field) ? old($field) : $user->$field }}"
                                    placeholder="أدخل الاسم"
                                >
                            </div>

                            <div class="col-12 col-md-6">
                                @php
                                    $label = config('backpack.base.authentication_column_name');
                                    $field = backpack_authentication_column();
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input 
                                    required 
                                    class="form-control modern-input" 
                                    type="{{ backpack_authentication_column()==backpack_email_column()?'email':'text' }}" 
                                    name="{{ $field }}" 
                                    value="{{ old($field) ? old($field) : $user->$field }}"
                                    placeholder="أدخل {{ $label }}"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-save-unified">
                            <i class="la la-save"></i> {{ trans('backpack::base.save') }}
                        </button>
                        <a href="{{ backpack_url() }}" class="btn btn-cancel-unified">
                            {{ trans('backpack::base.cancel') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- CHANGE PASSWORD FORM --}}
        <div class="col-12 col-lg-8">
            <form class="form" action="{{ route('backpack.account.password') }}" method="post">
                {!! csrf_field() !!}

                <div class="card account-card">
                    <div class="card-header">
                        <i class="la la-key"></i>
                        {{ trans('backpack::base.change_password') }}
                    </div>

                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                @php
                                    $label = trans('backpack::base.old_password');
                                    $field = 'old_password';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input 
                                    autocomplete="new-password" 
                                    required 
                                    class="form-control modern-input" 
                                    type="password" 
                                    name="{{ $field }}" 
                                    id="{{ $field }}" 
                                    value=""
                                    placeholder="أدخل كلمة المرور القديمة"
                                >
                            </div>

                            <div class="col-12 col-md-4">
                                @php
                                    $label = trans('backpack::base.new_password');
                                    $field = 'new_password';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input 
                                    autocomplete="new-password" 
                                    required 
                                    class="form-control modern-input" 
                                    type="password" 
                                    name="{{ $field }}" 
                                    id="{{ $field }}" 
                                    value=""
                                    placeholder="أدخل كلمة المرور الجديدة"
                                >
                            </div>

                            <div class="col-12 col-md-4">
                                @php
                                    $label = trans('backpack::base.confirm_password');
                                    $field = 'confirm_password';
                                @endphp
                                <label class="required">{{ $label }}</label>
                                <input 
                                    autocomplete="new-password" 
                                    required 
                                    class="form-control modern-input" 
                                    type="password" 
                                    name="{{ $field }}" 
                                    id="{{ $field }}" 
                                    value=""
                                    placeholder="أكد كلمة المرور الجديدة"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-save-unified">
                            <i class="la la-key"></i> {{ trans('backpack::base.change_password') }}
                        </button>
                        <a href="{{ backpack_url() }}" class="btn btn-cancel-unified">
                            {{ trans('backpack::base.cancel') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

