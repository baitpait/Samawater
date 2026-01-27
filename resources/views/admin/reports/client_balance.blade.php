@extends(backpack_view('blank'))

@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    <style>
        .stat-card-purple::before { background: var(--primary-deep) !important; }
        .stat-card-green::before { background: var(--success-gradient) !important; }
        .stat-card-danger::before { background: var(--danger-color) !important; }
    </style>
@endsection

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header" style="background: var(--primary-deep) !important; border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 2rem; box-shadow: var(--shadow-md) !important; width: 100%; display: flex; align-items: center; justify-content: space-between; position: relative; overflow: visible;">
        <div style="display: flex; align-items: center; gap: 1rem; position: relative; z-index: 1;">
            <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.1); border-radius: 16px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                <i class="la la-wallet" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
            </div>
            <div>
                <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 800; margin: 0; font-family: 'Cairo', sans-serif;">تقرير رصيد المشتركين</h1>
                <p style="color: rgba(255,255,255,0.7); margin: 0; font-size: 14px;">عرض الفواتير والمدفوعات والرصيد المستحق</p>
            </div>
        </div>
    </section>
@endsection

@section('content')
<div class="container-fluid pb-4">
    {{-- فلتر البحث --}}
    <div class="card filter-card mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('reports.client-balance') }}" class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label class="form-label">بحث عن مشترك</label>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="ابحث عن مشترك...">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100" style="height: 48px;">
                        <i class="la la-search"></i> بحث
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('reports.client-balance') }}" class="btn btn-secondary w-100" style="height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="la la-refresh"></i> إعادة
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- الإحصائيات --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="dashboard-stat-card stat-card-purple">
                <div class="stat-card-content">
                    <div class="stat-icon-box" style="background: var(--primary-deep);">
                        <i class="la la-file-invoice"></i>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">إجمالي الفواتير</h6>
                        <h3 class="stat-value">{{ number_format($totalInvoices, 2) }} ₪</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-stat-card stat-card-green">
                <div class="stat-card-content">
                    <div class="stat-icon-box" style="background: var(--success-gradient);">
                        <i class="la la-hand-holding-usd"></i>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">إجمالي المدفوعات</h6>
                        <h3 class="stat-value">{{ number_format($totalPayments, 2) }} ₪</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-stat-card stat-card-danger">
                <div class="stat-card-content">
                    <div class="stat-icon-box" style="background: var(--danger-color);">
                        <i class="la la-balance-scale"></i>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">الرصيد المستحق</h6>
                        <h3 class="stat-value">{{ number_format($totalBalance, 2) }} ₪</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- جدول المشتركين --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-clean align-middle mb-0">
                    <thead>
                        <tr>
                            <th>اسم المشترك</th>
                            <th>الهاتف</th>
                            <th>إجمالي الفواتير</th>
                            <th>إجمالي المدفوعات</th>
                            <th>الرصيد المستحق</th>
                            <th style="width: 150px;">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                            <tr>
                                <td class="ps-4 fw-bold text-primary-deep">{{ $client->name }}</td>
                                <td>{{ $client->phone_one ?? '-' }}</td>
                                <td><span class="badge bg-primary-deep text-white">{{ number_format($client->total_invoices_amount, 2) }} ₪</span></td>
                                <td><span class="badge bg-success text-white">{{ number_format($client->total_paid_amount, 2) }} ₪</span></td>
                                <td>
                                    @if($client->balance > 0)
                                        <span class="badge bg-danger text-white">{{ number_format($client->balance, 2) }} ₪</span>
                                    @elseif($client->balance < 0)
                                        <span class="badge bg-warning text-white">{{ number_format(abs($client->balance), 2) }} ₪ (زائد)</span>
                                    @else
                                        <span class="badge bg-secondary text-white">0.00 ₪</span>
                                    @endif
                                </td>
                                <td class="pe-4">
                                    <div class="d-flex gap-2">
                                        <a href="{{ backpack_url('client/' . $client->id . '/show') }}" class="btn btn-sm btn-primary" title="عرض"><i class="la la-eye"></i></a>
                                        <a href="{{ backpack_url('invoice/create?client_id=' . $client->id) }}" class="btn btn-sm btn-success" title="فاتورة"><i class="la la-file-invoice"></i></a>
                                        <a href="{{ backpack_url('client-payment/create?client_id=' . $client->id) }}" class="btn btn-sm btn-info text-white" style="background: #1e3a5f; border: none;" title="دفع"><i class="la la-money-bill"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">لا توجد بيانات متاحة</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
