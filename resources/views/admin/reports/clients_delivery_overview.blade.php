@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    <style>
        /* ===============================
           Clients Delivery Overview - تحسين صفحة تقرير التسليمات
        =============================== */
        
        .delivery-overview-container {
            background: var(--bg-light);
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        /* Header Section */
        .delivery-overview-header {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%) !important;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg) !important;
            position: relative;
            overflow: hidden;
        }
        
        .delivery-overview-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            z-index: 0;
        }
        
        .delivery-overview-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            z-index: 0;
        }
        
        .delivery-overview-header-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .delivery-overview-header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .delivery-overview-header-icon {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 18px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .delivery-overview-header-icon i {
            font-size: 32px;
            color: #fff;
            font-weight: 900;
        }
        
        .delivery-overview-header-title {
            color: #fff;
            font-size: 28px;
            font-weight: 900;
            margin: 0;
            font-family: 'Cairo', sans-serif;
        }
        
        .delivery-overview-header-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        
        .btn-export {
            background: rgba(255, 255, 255, 0.95) !important;
            color: var(--primary-deep) !important;
            font-weight: 700 !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            border: none !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
        }
        
        .btn-export:hover {
            background: #fff !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15) !important;
        }
        
        .btn-add-delivery {
            background: linear-gradient(135deg, var(--success-gradient) 0%, #10b981 100%) !important;
            color: #fff !important;
            font-weight: 700 !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            border: none !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3) !important;
        }
        
        .btn-add-delivery:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4) !important;
            color: #fff !important;
        }
        
        /* Filter Card */
        .filter-card-modern {
            background: #fff;
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            border: none;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        .filter-card-header {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%);
            padding: 1.25rem 2rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .filter-card-header i {
            font-size: 22px;
            color: #fff;
        }
        
        .filter-card-header h6 {
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }
        
        .filter-card-body {
            padding: 2rem;
        }
        
        .form-label-modern {
            font-weight: 700;
            color: var(--primary-deep);
            margin-bottom: 0.75rem;
            font-size: 14px;
        }
        
        .form-control-modern,
        .form-select-modern {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #fff;
        }
        
        .form-control-modern:focus,
        .form-select-modern:focus {
            border-color: var(--primary-deep);
            box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.1);
            outline: none;
        }
        
        .btn-filter-submit {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%) !important;
            color: #fff !important;
            font-weight: 700 !important;
            border-radius: 12px !important;
            padding: 0.75rem 2rem !important;
            border: none !important;
            height: 48px;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 12px rgba(30, 58, 95, 0.3) !important;
        }
        
        .btn-filter-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 58, 95, 0.4) !important;
        }
        
        /* Table Card */
        .table-card-modern {
            background: #fff;
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            border: none;
            overflow: hidden;
        }
        
        .table-card-header-modern {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .table-card-header-modern i {
            font-size: 22px;
            color: #fff;
        }
        
        .table-card-header-modern h5 {
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }
        
        .table-modern {
            margin: 0;
            min-width: 1200px;
        }
        
        .table-modern thead {
            background: var(--bg-light);
        }
        
        .table-modern thead th {
            font-weight: 700;
            color: var(--primary-deep);
            padding: 1rem;
            border-bottom: 2px solid #e2e8f0;
            font-size: 14px;
        }
        
        .table-modern tbody td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }
        
        .table-modern tbody tr:hover {
            background: var(--bg-light);
        }
        
        .badge-modern {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
        }
        
        .badge-success-modern {
            background: var(--success-gradient) !important;
            color: #fff !important;
        }
        
        .badge-warning-modern {
            background: var(--warning-color) !important;
            color: #fff !important;
        }
        
        .badge-primary-modern {
            background: var(--primary-deep) !important;
            color: #fff !important;
        }
        
        .badge-danger-modern {
            background: var(--danger-color) !important;
            color: #fff !important;
        }
        
        .badge-secondary-modern {
            background: #64748b !important;
            color: #fff !important;
        }
        
        .btn-action-modern {
            background: var(--primary-deep) !important;
            color: #fff !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease !important;
            font-size: 14px !important;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-action-modern:hover {
            background: #254a7a !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 58, 95, 0.3);
        }
        
        .pagination-modern {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .pagination-modern .page-link {
            border-radius: 10px !important;
            border: 2px solid #e2e8f0 !important;
            color: var(--primary-deep) !important;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease !important;
        }
        
        .pagination-modern .page-link:hover {
            background: var(--primary-deep) !important;
            color: #fff !important;
            border-color: var(--primary-deep) !important;
        }
        
        .pagination-modern .page-item.active .page-link {
            background: var(--primary-deep) !important;
            border-color: var(--primary-deep) !important;
            color: #fff !important;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .delivery-overview-header {
                padding: 1.5rem;
            }
            
            .delivery-overview-header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .delivery-overview-header-actions {
                width: 100%;
                justify-content: flex-start;
            }
            
            .filter-card-body {
                padding: 1.5rem;
            }
        }
    </style>
@endsection

@extends(backpack_view('blank'))

@section('content')
<div class="delivery-overview-container">
    <div class="container-fluid pb-4">

        {{-- ===============================
            Header - Modern Design
        =============================== --}}
        <section class="delivery-overview-header">
            <div class="delivery-overview-header-content">
                <div class="delivery-overview-header-left">
                    <div class="delivery-overview-header-icon">
                        <i class="la la-truck"></i>
                    </div>
                    <h1 class="delivery-overview-header-title">تقرير التسليمات</h1>
                </div>
                <div class="delivery-overview-header-actions">
                    @if(request('search'))
                    <a href="{{ route('reports.clients_delivery_overview.export.excel', request()->all()) }}" class="btn-export">
                        <i class="la la-file-excel"></i> Excel
                    </a>
                    <a href="{{ route('reports.clients_delivery_overview.export.pdf', request()->all()) }}" class="btn-export">
                        <i class="la la-file-pdf"></i> PDF
                    </a>
                    @endif
                    <a href="{{ backpack_url('delivery/create') }}" class="btn-add-delivery">
                        <i class="la la-plus"></i> إضافة تسليم
                    </a>
                </div>
            </div>
        </section>

        {{-- ======================= فلاتر البحث ======================= --}}
        <div class="filter-card-modern">
            <div class="filter-card-header">
                <i class="la la-filter"></i>
                <h6>فلاتر البحث</h6>
            </div>
            <div class="filter-card-body">
                <form method="GET" class="row g-4">
                    <input type="hidden" name="search" value="1">
                    
                    <div class="col-md-3">
                        <label class="form-label-modern">من تاريخ</label>
                        <input type="date" name="from" class="form-control form-control-modern" value="{{ request('from') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label-modern">إلى تاريخ</label>
                        <input type="date" name="to" class="form-control form-control-modern" value="{{ request('to') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label-modern">المدينة</label>
                        <select name="city_id" class="form-select form-select-modern">
                            <option value="">الكل</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" @selected(request('city_id') == $city->id)>{{ $city->city_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label-modern">الموزع</label>
                        <select name="distributor_id" class="form-select form-select-modern">
                            <option value="">الكل</option>
                            @foreach($distributors as $distributor)
                                <option value="{{ $distributor->id }}" @selected(request('distributor_id') == $distributor->id)>{{ $distributor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 text-end mt-2">
                        <button type="submit" class="btn btn-filter-submit">
                            <i class="la la-search"></i> عرض النتائج
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ======================= جدول النتائج ======================= --}}
        @if(request()->has('search'))
            <div class="table-card-modern">
                <div class="table-card-header-modern">
                    <i class="la la-list"></i>
                    <h5>نتائج البحث</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-modern align-middle mb-0">
                        <thead>
                            <tr>
                                <th>المشترك</th>
                                <th>المدينة</th>
                                <th>الهاتف</th>
                                <th>تاريخ الاستلام</th>
                                <th>العبوات المستلمة</th>
                                <th>العبوات الفارغة</th>
                                <th>رصيد</th>
                                <th>الدفعة</th>
                                <th>الموزع</th>
                                <th style="width: 80px;">إجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rows as $r)
                            <tr>
                                <td class="ps-4 fw-bold" style="color: var(--primary-deep);">{{ $r->client_name }}</td>
                                <td>{{ $r->city_name ?? '-' }}</td>
                                <td>{{ $r->phone_one ?? '-' }}</td>
                                <td class="fw-semibold" style="color: var(--primary-deep);">
                                    {{ $r->last_delivery_date_actual ? \Carbon\Carbon::parse($r->last_delivery_date_actual)->format('Y-m-d') : '-' }}
                                </td>
                                <td><span class="badge badge-modern badge-success-modern">{{ number_format($r->last_bottle_received ?? 0) }}</span></td>
                                <td><span class="badge badge-modern badge-warning-modern">{{ number_format($r->last_bottle_empty ?? 0) }}</span></td>
                                <td>
                                    @php
                                        $balance = ($r->last_bottle_received ?? 0) - ($r->last_bottle_empty ?? 0);
                                        $class = $balance > 0 ? 'badge-primary-modern' : ($balance < 0 ? 'badge-danger-modern' : 'badge-secondary-modern');
                                    @endphp
                                    <span class="badge badge-modern {{ $class }}">{{ number_format($balance) }}</span>
                                </td>
                                <td class="fw-bold" style="color: var(--primary-deep); font-size: 16px;">₪ {{ number_format($r->last_paymant ?? 0) }}</td>
                                <td>{{ $r->distributor_name ?? '-' }}</td>
                                <td class="pe-4">
                                    @if($r->last_delivery_id)
                                    <button type="button" class="btn btn-action-modern" onclick="editDelivery({{ $r->last_delivery_id }})" title="تعديل">
                                        <i class="la la-edit"></i>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-5 text-muted">
                                    <i class="la la-inbox" style="font-size: 48px; opacity: 0.3;"></i>
                                    <p class="mt-3 mb-0">لا توجد نتائج مطابقة</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-top">
                    <div class="pagination-modern">
                        {{ $rows->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

@include('admin.reports.inc.edit_delivery_modal')

@endsection
