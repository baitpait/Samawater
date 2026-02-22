@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    <style>
        /* ===============================
           Client Balance Report - تحسين صفحة تقرير رصيد المشتركين
        =============================== */
        
        .client-balance-container {
            background: var(--bg-light);
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        /* Header Section */
        .balance-header {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%) !important;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg) !important;
            position: relative;
            overflow: hidden;
        }
        
        .balance-header::before {
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
        
        .balance-header::after {
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
        
        .balance-header-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .balance-header-icon {
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
        
        .balance-header-icon i {
            font-size: 32px;
            color: #fff;
            font-weight: 900;
        }
        
        .balance-header-title {
            color: #fff;
            font-size: 28px;
            font-weight: 900;
            margin: 0;
            font-family: 'Cairo', sans-serif;
        }
        
        .balance-header-subtitle {
            color: rgba(255, 255, 255, 0.85);
            font-size: 15px;
            margin: 0.5rem 0 0 0;
            font-weight: 500;
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
        
        .form-control-modern {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #fff;
        }
        
        .form-control-modern:focus {
            border-color: var(--primary-deep);
            box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.1);
            outline: none;
        }
        
        .btn-filter-submit {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%) !important;
            color: #fff !important;
            font-weight: 700 !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            border: none !important;
            height: 48px;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 12px rgba(30, 58, 95, 0.3) !important;
        }
        
        .btn-filter-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 58, 95, 0.4) !important;
        }
        
        .btn-filter-reset {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%) !important;
            color: #fff !important;
            font-weight: 700 !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            border: none !important;
            height: 48px;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0.5rem !important;
        }
        
        .btn-filter-reset:hover {
            transform: translateY(-2px);
            color: #fff !important;
        }
        
        /* Statistics Cards */
        .stat-card-modern {
            background: #fff;
            border-radius: 18px;
            padding: 1.75rem;
            box-shadow: var(--shadow-md);
            border: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            height: 100%;
        }
        
        .stat-card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-deep);
        }
        
        .stat-card-modern.stat-card-success::before {
            background: var(--success-gradient);
        }
        
        .stat-card-modern.stat-card-danger::before {
            background: var(--danger-color);
        }
        
        .stat-card-modern:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }
        
        .stat-card-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%);
        }
        
        .stat-card-icon.stat-icon-success {
            background: linear-gradient(135deg, var(--success-gradient) 0%, #10b981 100%);
        }
        
        .stat-card-icon.stat-icon-danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, #dc2626 100%);
        }
        
        .stat-card-icon i {
            font-size: 24px;
            color: #fff;
        }
        
        .stat-card-label {
            font-size: 14px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .stat-card-value {
            font-size: 32px;
            font-weight: 900;
            color: var(--primary-deep);
            margin: 0;
            font-family: 'Cairo', sans-serif;
        }
        
        .stat-card-modern.stat-card-success .stat-card-value {
            color: var(--success-gradient);
        }
        
        .stat-card-modern.stat-card-danger .stat-card-value {
            color: var(--danger-color);
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
        
        .badge-primary-modern {
            background: var(--primary-deep) !important;
            color: #fff !important;
        }
        
        .badge-success-modern {
            background: var(--success-gradient) !important;
            color: #fff !important;
        }
        
        .badge-danger-modern {
            background: var(--danger-color) !important;
            color: #fff !important;
        }
        
        .badge-warning-modern {
            background: var(--warning-color) !important;
            color: #fff !important;
        }
        
        .badge-secondary-modern {
            background: #64748b !important;
            color: #fff !important;
        }
        
        .btn-action-modern {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            transition: all 0.3s ease;
            font-size: 16px;
        }
        
        .btn-action-primary {
            background: var(--primary-deep) !important;
            color: #fff !important;
        }
        
        .btn-action-primary:hover {
            background: #254a7a !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 58, 95, 0.3);
        }
        
        .btn-action-success {
            background: var(--success-gradient) !important;
            color: #fff !important;
        }
        
        .btn-action-success:hover {
            background: #10b981 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        }
        
        .btn-action-info {
            background: var(--primary-deep) !important;
            color: #fff !important;
        }
        
        .btn-action-info:hover {
            background: #254a7a !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 58, 95, 0.3);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .balance-header {
                padding: 1.5rem;
            }
            
            .balance-header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .filter-card-body {
                padding: 1.5rem;
            }
        }
    </style>
@endsection

@extends(backpack_view('blank'))

@section('header')
    <section class="balance-header">
        <div class="balance-header-content">
            <div class="balance-header-icon">
                <i class="la la-wallet"></i>
            </div>
            <div>
                <h1 class="balance-header-title">تقرير رصيد المشتركين</h1>
                <p class="balance-header-subtitle">عرض الفواتير والمدفوعات والرصيد المستحق</p>
            </div>
        </div>
    </section>
@endsection

@section('content')
<div class="client-balance-container">
    <div class="container-fluid pb-4">

        {{-- ======================= فلاتر البحث ======================= --}}
        <div class="filter-card-modern">
            <div class="filter-card-header">
                <i class="la la-filter"></i>
                <h6>فلاتر البحث</h6>
            </div>
            <div class="filter-card-body">
                <form method="GET" action="{{ route('reports.client-balance') }}" class="row g-3 g-md-4 filter-form-rtl">
                    <div class="col-12 col-md-8">
                        <label class="form-label-modern">اختر المشترك</label>
                        <select name="client_id" class="form-select form-control-modern" required>
                            <option value="">— اختر مشترك لعرض رصيده —</option>
                            @foreach($clientsList ?? [] as $c)
                                <option value="{{ $c->id }}" @selected(isset($selectedClientId) && (string)$selectedClientId === (string)$c->id)>
                                    {{ $c->name }} {{ $c->contract_no ? ' (' . $c->contract_no . ')' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-filter-submit w-100">
                            <i class="la la-search"></i> عرض الرصيد
                        </button>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 d-flex align-items-end">
                        <a href="{{ route('reports.client-balance') }}" class="btn btn-filter-reset w-100">
                            <i class="la la-refresh"></i> إعادة
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @if(!$clients->isEmpty())
        {{-- ======================= الإحصائيات ======================= --}}
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stat-card-modern">
                    <div class="stat-card-icon">
                        <i class="la la-file-invoice"></i>
                    </div>
                    <div class="stat-card-label">إجمالي الفواتير</div>
                    <h3 class="stat-card-value">{{ number_format($totalInvoices, 2) }} ₪</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card-modern stat-card-success">
                    <div class="stat-card-icon stat-icon-success">
                        <i class="la la-hand-holding-usd"></i>
                    </div>
                    <div class="stat-card-label">إجمالي المدفوعات</div>
                    <h3 class="stat-card-value">{{ number_format($totalPayments, 2) }} ₪</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card-modern stat-card-danger">
                    <div class="stat-card-icon stat-icon-danger">
                        <i class="la la-balance-scale"></i>
                    </div>
                    <div class="stat-card-label">الرصيد المستحق</div>
                    <h3 class="stat-card-value">{{ number_format($totalBalance, 2) }} ₪</h3>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-info text-center py-4 mb-4" style="border-radius: 16px; font-weight: 600;">
            <i class="la la-user-circle" style="font-size: 48px;"></i>
            <p class="mt-3 mb-0">اختر مشتركاً من القائمة أعلاه ثم اضغط «عرض الرصيد»</p>
        </div>
        @endif

        {{-- ======================= جدول المشترك (عند الاختيار) ======================= --}}
        @if(!$clients->isEmpty())
        <div class="table-card-modern">
            <div class="table-card-header-modern">
                <i class="la la-users"></i>
                <h5>قائمة المشتركين</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="min-width: 180px;">اسم المشترك</th>
                            <th>الهاتف</th>
                            <th>إجمالي الفواتير</th>
                            <th>إجمالي المدفوعات</th>
                            <th>الرصيد المستحق</th>
                            <th style="width: 180px;">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                            <tr>
                                <td class="fw-bold ps-4" style="color: var(--primary-deep); min-width: 180px;">{{ $client->name ?? $client->contract_no ?? '—' }}</td>
                                <td>{{ $client->phone_one ?? '-' }}</td>
                                <td><span class="badge badge-modern badge-primary-modern">{{ number_format($client->total_invoices_amount, 2) }} ₪</span></td>
                                <td><span class="badge badge-modern badge-success-modern">{{ number_format($client->total_paid_amount, 2) }} ₪</span></td>
                                <td>
                                    @if($client->balance > 0)
                                        <span class="badge badge-modern badge-danger-modern">{{ number_format($client->balance, 2) }} ₪</span>
                                    @elseif($client->balance < 0)
                                        <span class="badge badge-modern badge-warning-modern">{{ number_format(abs($client->balance), 2) }} ₪ (زائد)</span>
                                    @else
                                        <span class="badge badge-modern badge-secondary-modern">0.00 ₪</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ backpack_url('client/' . $client->id . '/show') }}" class="btn btn-action-modern btn-action-primary" title="عرض">
                                            <i class="la la-eye"></i>
                                        </a>
                                        <a href="{{ backpack_url('invoice/create?client_id=' . $client->id) }}" class="btn btn-action-modern btn-action-success" title="فاتورة">
                                            <i class="la la-file-invoice"></i>
                                        </a>
                                        <a href="{{ backpack_url('client-payment/create?client_id=' . $client->id) }}" class="btn btn-action-modern btn-action-info" title="دفع">
                                            <i class="la la-money-bill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="la la-inbox" style="font-size: 48px; opacity: 0.3;"></i>
                                    <p class="mt-3 mb-0">لا توجد بيانات متاحة</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
