@extends(backpack_view('blank'))

@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">
    
    {{-- تحميل Noty CSS --}}
    @basset('https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css')
    
    {{-- تحميل jQuery و Noty مبكراً لضمان الترتيب --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/noty@3.2.0-beta-deprecated/lib/noty.min.js"></script>
    
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
        }

        .header-icon-wrapper i {
            font-size: 24px !important;
            color: #fff !important;
        }
        
        .btn-success-unified {
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
        
        .btn-success-unified:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            transform: translateY(-2px) !important;
            color: #fff !important;
            text-decoration: none;
        }

        /* Unified Table Styles */
        .table-clean {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        .table-clean thead th {
            background: var(--primary-deep) !important;
            color: #fff !important;
            font-weight: 700 !important;
            padding: 1.25rem 1rem !important;
            border: none !important;
            font-size: 15px !important;
        }

        .table-clean thead th a {
            color: #fff !important;
            text-decoration: none;
        }

        .table-clean tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s ease;
        }

        .table-clean tbody tr:hover {
            background: #f8fafc;
        }

        .table-clean tbody td {
            padding: 1rem;
            color: #334155;
            font-weight: 600;
            vertical-align: middle;
        }
        
        .btn-group.unified-actions-dropdown .btn-primary {
            background: var(--primary-deep) !important;
            border: none !important;
            border-radius: 10px !important;
        }
    </style>
@endsection

@section('header')
    <section class="header-operation-unified">
        <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div class="header-icon-wrapper">
                    <i class="la la-user-friends"></i>
                </div>
                <h1 style="color: #fff; font-size: 24px; font-weight: 800; margin: 0; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);">
                    الموزعين
                </h1>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <a href="{{ backpack_url('distributor/create') }}" class="btn btn-success-unified">
                    <i class="la la-plus"></i>
                    إضافة موزع
                </a>
            </div>
        </div>
    </section>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Search Card -->
        <div class="card filter-card mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ url(config('backpack.base.route_prefix') . '/distributors-list') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-10">
                            <label class="form-label">بحث عن موزع</label>
                            <input type="text" name="search" class="form-control" placeholder="اسم الموزع أو رقم الهاتف" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100" style="height: 48px;">
                                <i class="la la-search"></i> بحث
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Card -->
        <div class="card filter-card">
            <div class="card-body p-0">
                <div class="table-responsive" style="overflow: visible;">
                    <table class="table table-clean align-middle mb-0">
                        <thead>
                            <tr>
                                <th>اسم الموزع</th>
                                <th>رقم الهاتف</th>
                                <th>الرصيد الحالي</th>
                                <th style="width: 100px;">إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($distributors as $distributor)
                                <tr>
                                    <td class="ps-4">{{ $distributor->name }}</td>
                                    <td>{{ $distributor->phone }}</td>
                                    <td class="fw-bold text-primary-deep">₪ {{ number_format($distributor->balance, 2) }}</td>
                                    <td class="pe-4">
                                        <div class="btn-group unified-actions-dropdown dropdown">
                                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                                                <i class="la la-cog"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="{{ url(config('backpack.base.route_prefix') . '/distributor/' . $distributor->id . '/show') }}"><i class="la la-eye"></i> معاينة</a></li>
                                                <li><a class="dropdown-item" href="{{ url(config('backpack.base.route_prefix') . '/distributor/' . $distributor->id . '/edit') }}"><i class="la la-edit"></i> تعديل</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><button type="button" class="dropdown-item open-withdraw-modal" data-id="{{ $distributor->id }}" data-balance="{{ $distributor->balance }}"><i class="la la-money-bill"></i> سحب</button></li>
                                                <li><a class="dropdown-item" href="{{ url(config('backpack.base.route_prefix') . '/distributor/' . $distributor->id . '/financial-report') }}"><i class="la la-file-invoice-dollar"></i> التقرير المالي</a></li>
                                                <li><a class="dropdown-item" href="{{ url(config('backpack.base.route_prefix') . '/distributor/' . $distributor->id . '/clients') }}"><i class="la la-users"></i> المشتركين</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">لا توجد بيانات متاحة</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4 border-top">
                    {{ $distributors->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('after_scripts')
@include('admin.financial_report_modal')
@include('admin.distributor_withdraw_modal')
@endsection
