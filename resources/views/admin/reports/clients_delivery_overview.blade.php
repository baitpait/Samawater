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
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .filter-card-header-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .overview-total-paymant {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 12px;
            padding: 0.5rem 1rem;
            color: #fff;
            font-weight: 700;
            font-size: 15px;
            white-space: nowrap;
        }

        .overview-total-paymant .amount {
            font-size: 18px;
            margin-right: 6px;
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
        
        /* غلاف التمرير الأفقي للجدول - شريط يمين/شمال (إجباري) */
        .delivery-overview-container .table-card-modern .table-scroll-wrapper,
        .table-card-modern .table-responsive.table-scroll-wrapper {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            overflow-x: auto !important;
            overflow-y: visible !important;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: var(--primary-deep) var(--bg-light);
        }
        .table-card-modern .table-scroll-wrapper::-webkit-scrollbar {
            height: 10px;
        }
        .table-card-modern .table-scroll-wrapper::-webkit-scrollbar-track {
            background: var(--bg-light);
            border-radius: 10px;
        }
        .table-card-modern .table-scroll-wrapper::-webkit-scrollbar-thumb {
            background: var(--primary-deep);
            border-radius: 10px;
        }
        .table-card-modern .table-scroll-wrapper::-webkit-scrollbar-thumb:hover {
            background: #254a7a;
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
            min-width: 1200px; /* يجبر التمرير الأفقي عند ضيق العرض */
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
        
        .btn-action-danger {
            background: var(--danger-color) !important;
            color: #fff !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 0.5rem !important;
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease !important;
        }
        .btn-action-danger:hover {
            background: #dc2626 !important;
            color: #fff !important;
            transform: translateY(-2px);
        }
        .actions-cell .btn { flex-shrink: 0; }
        .actions-cell.actions-icons-only { gap: 0.5rem; }
        .btn-icon-only {
            padding: 0 !important;
            min-width: 36px !important;
            width: 36px !important;
            height: 36px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        .pagination-modern {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            direction: rtl;
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
                <div class="filter-card-header-title">
                    <i class="la la-filter"></i>
                    <h6>فلاتر البحث</h6>
                </div>
                @if(request()->has('search') && !empty($overviewTotals))
                @php
                    $isClientDeliveryMode = ($reportMode ?? 'overview') === 'client_deliveries';
                    $totalsTitle = $isClientDeliveryMode
                        ? 'مجموع المبلغ المدفوع لـ '.(int) ($overviewTotals['row_count'] ?? 0).' تسليم'
                        : 'مجموع عمود «المبلغ المدفوع» لآخر تسليم لكل مشترك في النتائج ('.(int) ($overviewTotals['row_count'] ?? 0).' مشترك)';
                @endphp
                <div class="overview-total-paymant" title="{{ $totalsTitle }}">
                    <span>مجموع المبلغ المدفوع:</span>
                    <span class="amount">₪ {{ number_format((float) ($overviewTotals['total_paymant'] ?? 0), 2) }}</span>
                </div>
                @endif
            </div>
            <div class="filter-card-body">
                <form method="GET" action="{{ route('reports.clients_delivery_overview') }}" class="row g-3 g-md-4 filter-form-rtl">
                    <input type="hidden" name="search" value="1">
                    <div class="col-12">
                        <label class="form-label-modern">المشترك</label>
                        @include('admin.partials.client_select_searchable', [
                            'clients' => $clients ?? collect(),
                            'selectedId' => request('client_id'),
                            'selectId' => 'delivery-overview-client-select',
                            'selectClass' => 'form-select form-select-modern w-100',
                            'placeholder' => 'ابحث عن اسم المشترك…',
                        ])
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label-modern">من تاريخ</label>
                        <input type="date" name="from" class="form-control form-control-modern w-100" value="{{ request('from') }}">
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label-modern">إلى تاريخ</label>
                        <input type="date" name="to" class="form-control form-control-modern w-100" value="{{ request('to') }}">
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label-modern">المدينة</label>
                        <select name="city_id" class="form-select form-select-modern w-100">
                            <option value="">الكل</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" @selected(request('city_id') == $city->id)>{{ $city->city_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label-modern">الموزع</label>
                        <select name="distributor_id" class="form-select form-select-modern w-100">
                            <option value="">الكل</option>
                            @foreach($distributors as $distributor)
                                <option value="{{ $distributor->id }}" @selected(request('distributor_id') == $distributor->id)>{{ $distributor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-12 d-flex align-items-end justify-content-end mt-2">
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
                    @if(($reportMode ?? 'overview') === 'client_deliveries')
                    <h5>تسليمات المشترك ({{ (int) ($overviewTotals['row_count'] ?? $rows->total()) }})</h5>
                    @else
                    <h5>نتائج البحث — آخر تسليم لكل مشترك</h5>
                    @endif
                </div>
                <div class="table-responsive table-scroll-wrapper">
                    <table class="table table-modern align-middle mb-0">
                        <thead>
                            <tr>
                                <th>المشترك</th>
                                <th>المدينة</th>
                                <th>الهاتف</th>
                                <th>تاريخ الاستلام</th>
                                <th>العبوات المستلمة</th>
                                <th>العبوات الفارغة</th>
                                <th>رصيد العبوات</th>
                                <th>المبلغ المطلوب</th>
                                <th>المبلغ المدفوع</th>
                                <th>الدين المتبقي</th>
                                <th>الموزع</th>
                                <th style="width: 100px;">إجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rows as $r)
                            @php
                                $required = (float) ($r->last_required_amount ?? 0);
                                $paymant = (float) ($r->last_paymant ?? 0);
                                $remainingDebt = $required - $paymant;
                            @endphp
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
                                <td>₪ {{ number_format($required, 2) }}</td>
                                <td class="fw-bold" style="color: var(--primary-deep);">₪ {{ number_format($paymant, 2) }}</td>
                                <td class="fw-bold {{ $remainingDebt > 0 ? 'text-danger' : ($remainingDebt < 0 ? 'text-success' : 'text-muted') }}">₪ {{ number_format($remainingDebt, 2) }}</td>
                                <td>{{ $r->distributor_name ?? '-' }}</td>
                                <td class="pe-4">
                                    <div class="d-flex gap-1 justify-content-center align-items-center actions-cell actions-icons-only">
                                        @if(!empty($r->last_delivery_id))
                                        <a href="{{ backpack_url('delivery').'/'.(int)$r->last_delivery_id.'/edit' }}?return_to_report=clients_delivery_overview" class="btn btn-action-modern btn-sm btn-icon-only" title="تعديل التسليم">
                                            <i class="la la-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-action-danger btn-sm btn-icon-only" onclick="deleteDelivery({{ (int)$r->last_delivery_id }}, '{{ addslashes($r->client_name ?? '') }}')" title="حذف التسليم">
                                            <i class="la la-trash"></i>
                                        </button>
                                        @else
                                        <a href="{{ backpack_url('delivery/create').'?client_id='.($r->client_id ?? '') }}" class="btn btn-action-modern btn-sm btn-icon-only" title="إضافة تسليم">
                                            <i class="la la-plus"></i>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="12" class="text-center py-5 text-muted">
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
                        {{ $rows->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

@push('after_scripts')
<script>
(function() {
    var deliveryBaseUrl = '{{ backpack_url("delivery") }}';
    var reportPageUrl = '{{ request()->fullUrl() }}';
    var csrfToken = '{{ csrf_token() }}';

    window.deleteDelivery = function(deliveryId, clientName) {
        var msg = clientName
            ? 'هل تريد حذف آخر تسليم للمشترك «' + clientName + '»؟'
            : 'هل تريد حذف هذا التسليم؟';
        if (!confirm(msg)) return;

        fetch(deliveryBaseUrl + '/' + deliveryId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(function(res) {
            if (res.redirected) {
                window.location.href = reportPageUrl;
            } else if (res.ok) {
                window.location.href = reportPageUrl;
            } else {
                res.json().then(function(d) { alert(d.message || 'حدث خطأ'); }).catch(function() { window.location.href = reportPageUrl; });
            }
        }).catch(function() {
            window.location.href = reportPageUrl;
        });
    };
})();
</script>
@endpush

@endsection
