@extends(backpack_view('blank'))

@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">
    
    <style>
        /* ============================================
           Account Page - تطبيق الهوية البصرية
        ============================================ */
        
        /* Page Header */
        section.content-header,
        section.header-operation,
        section.header-operation.container-fluid {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%) !important;
            border-radius: 20px !important;
            padding: 1.5rem 2rem !important;
            margin-bottom: 2rem !important;
            box-shadow: var(--shadow-lg) !important;
            position: relative !important;
            overflow: hidden !important;
        }

        section.content-header::before,
        section.header-operation::before {
            content: '' !important;
            position: absolute !important;
            top: -50% !important;
            right: -10% !important;
            width: 300px !important;
            height: 300px !important;
            background: rgba(255, 255, 255, 0.05) !important;
            border-radius: 50% !important;
            z-index: 0 !important;
        }

        section.content-header::after,
        section.header-operation::after {
            content: '' !important;
            position: absolute !important;
            bottom: -30% !important;
            left: -5% !important;
            width: 200px !important;
            height: 200px !important;
            background: rgba(255, 255, 255, 0.03) !important;
            border-radius: 50% !important;
            z-index: 0 !important;
        }

        section.content-header h1,
        section.header-operation h1 {
            color: #fff !important;
            font-size: 28px !important;
            font-weight: 900 !important;
            margin: 0 !important;
            font-family: 'Cairo', sans-serif !important;
            position: relative !important;
            z-index: 1 !important;
            display: flex !important;
            align-items: center !important;
            gap: 1rem !important;
        }

        .header-icon-wrapper {
            width: 64px !important;
            height: 64px !important;
            background: rgba(255, 255, 255, 0.15) !important;
            border-radius: 18px !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .header-icon-wrapper i {
            font-size: 28px !important;
            color: #fff !important;
            font-weight: 900 !important;
        }

        /* إخفاء breadcrumbs */
        .breadcrumb,
        .breadcrumb-item,
        nav[aria-label="breadcrumb"],
        ol.breadcrumb {
            display: none !important;
        }

        /* Account Cards */
        .account-card,
        .card.padding-10 {
            background: #fff !important;
            border-radius: 20px !important;
            border: none !important;
            box-shadow: var(--shadow-md) !important;
            margin-bottom: 2rem !important;
            overflow: hidden !important;
            transition: all 0.3s ease !important;
        }

        .account-card:hover,
        .card.padding-10:hover {
            box-shadow: var(--shadow-lg) !important;
            transform: translateY(-2px) !important;
        }

        .account-card .card-header,
        .card.padding-10 .card-header {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%) !important;
            color: #fff !important;
            font-size: 20px !important;
            font-weight: 800 !important;
            padding: 1.5rem 2rem !important;
            border: none !important;
            font-family: 'Cairo', sans-serif !important;
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
        }

        .account-card .card-header i,
        .card.padding-10 .card-header i {
            font-size: 24px !important;
        }

        .account-card .card-body,
        .card.padding-10 .card-body {
            padding: 2rem !important;
        }

        .account-card .card-footer,
        .card.padding-10 .card-footer {
            background: var(--bg-light) !important;
            border-top: 2px solid #e2e8f0 !important;
            padding: 1.5rem 2rem !important;
            display: flex !important;
            gap: 12px !important;
            flex-wrap: wrap !important;
        }

        /* Form Labels */
        .account-card label,
        .card.padding-10 label,
        .backpack-profile-form label {
            font-size: 14px !important;
            font-weight: 700 !important;
            color: var(--primary-deep) !important;
            margin-bottom: 0.75rem !important;
            font-family: 'Cairo', sans-serif !important;
        }

        .account-card label.required::after,
        .card.padding-10 label.required::after,
        .backpack-profile-form label.required::after {
            content: ' *' !important;
            color: var(--danger-color) !important;
        }

        /* Form Inputs */
        .account-card .form-control,
        .card.padding-10 .form-control,
        .backpack-profile-form .form-control,
        .modern-input {
            height: 52px !important;
            font-size: 15px !important;
            padding: 14px 20px !important;
            border-radius: 12px !important;
            border: 2px solid #e2e8f0 !important;
            font-family: 'Cairo', sans-serif !important;
            transition: all 0.3s ease !important;
            background: #fff !important;
        }

        .account-card .form-control:focus,
        .card.padding-10 .form-control:focus,
        .backpack-profile-form .form-control:focus,
        .modern-input:focus {
            border-color: var(--primary-deep) !important;
            box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.1) !important;
            outline: none !important;
        }

        .account-card .form-control::placeholder,
        .modern-input::placeholder {
            color: #94a3b8 !important;
            font-size: 14px !important;
        }

        /* Unified Buttons */
        .btn-save-unified,
        .btn.btn-success {
            background: linear-gradient(135deg, var(--success-gradient) 0%, #10b981 100%) !important;
            color: #fff !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 0.875rem 2rem !important;
            font-weight: 700 !important;
            font-size: 15px !important;
            font-family: 'Cairo', sans-serif !important;
            transition: all 0.3s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3) !important;
        }

        .btn-save-unified:hover,
        .btn.btn-success:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4) !important;
            color: #fff !important;
        }

        .btn-close-unified,
        .btn-cancel-unified {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%) !important;
            color: #fff !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 0.875rem 2rem !important;
            font-weight: 700 !important;
            font-size: 15px !important;
            font-family: 'Cairo', sans-serif !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
            box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3) !important;
        }

        .btn-close-unified:hover,
        .btn-cancel-unified:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(100, 116, 139, 0.4) !important;
            color: #fff !important;
        }

        /* Alert Messages */
        .alert {
            border-radius: 16px !important;
            padding: 1.25rem 1.5rem !important;
            margin-bottom: 1.5rem !important;
            font-family: 'Cairo', sans-serif !important;
            border: none !important;
            box-shadow: var(--shadow-sm) !important;
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%) !important;
            color: #065f46 !important;
            border-right: 4px solid var(--success-gradient) !important;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%) !important;
            color: #991b1b !important;
            border-right: 4px solid var(--danger-color) !important;
        }

        .alert i {
            font-size: 20px !important;
            margin-left: 0.5rem !important;
        }

        .alert ul {
            margin: 0.75rem 0 0 0 !important;
            padding-right: 1.5rem !important;
        }

        .alert ul li {
            margin-bottom: 0.5rem !important;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 1.5rem !important;
        }

        .row.g-3 {
            margin: 0 !important;
        }

        .row.g-3 > * {
            padding: 0.75rem !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            section.content-header,
            section.header-operation {
                padding: 1.25rem 1.5rem !important;
            }

            .account-card .card-body,
            .card.padding-10 .card-body {
                padding: 1.5rem !important;
            }

            .account-card .card-footer,
            .card.padding-10 .card-footer {
                padding: 1.25rem 1.5rem !important;
                flex-direction: column !important;
            }

            .btn-save-unified,
            .btn-close-unified {
                width: 100% !important;
                justify-content: center !important;
            }

            .header-icon-wrapper {
                width: 48px !important;
                height: 48px !important;
            }

            .header-icon-wrapper i {
                font-size: 20px !important;
            }

            section.content-header h1,
            section.header-operation h1 {
                font-size: 22px !important;
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
    <section class="content-header">
        <div class="container-fluid mb-3" style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div class="header-icon-wrapper">
                    <i class="la la-user"></i>
                </div>
                <h1>{{ trans('backpack::base.my_account') }}</h1>
            </div>
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
        <div class="col-12">
            <form class="form" action="{{ route('backpack.account.info.store') }}" method="post">
                {!! csrf_field() !!}

                <div class="card account-card padding-10">
                    <div class="card-header">
                        <i class="la la-user-edit"></i>
                        {{ trans('backpack::base.update_account_info') }}
                    </div>

                    <div class="card-body backpack-profile-form bold-labels">
                        <div class="row g-3">
                            <div class="col-12 col-md-6 form-group">
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

                            <div class="col-12 col-md-6 form-group">
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
                        <button type="submit" class="btn btn-success btn-save-unified">
                            <i class="la la-save"></i> {{ trans('backpack::base.save') }}
                        </button>
                        <a href="{{ backpack_url() }}" class="btn btn-close-unified">
                            <i class="la la-times"></i> إغلاق
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- CHANGE PASSWORD FORM --}}
        <div class="col-12">
            <form class="form" action="{{ route('backpack.account.password') }}" method="post">
                {!! csrf_field() !!}

                <div class="card account-card padding-10">
                    <div class="card-header">
                        <i class="la la-key"></i>
                        {{ trans('backpack::base.change_password') }}
                    </div>

                    <div class="card-body backpack-profile-form bold-labels">
                        <div class="row g-3">
                            <div class="col-12 col-md-4 form-group">
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

                            <div class="col-12 col-md-4 form-group">
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

                            <div class="col-12 col-md-4 form-group">
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
                        <button type="submit" class="btn btn-success btn-save-unified">
                            <i class="la la-key"></i> {{ trans('backpack::base.change_password') }}
                        </button>
                        <a href="{{ backpack_url() }}" class="btn btn-close-unified">
                            <i class="la la-times"></i> إغلاق
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
