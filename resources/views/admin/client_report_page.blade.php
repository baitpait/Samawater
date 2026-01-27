@extends(backpack_view('blank'))

@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">
    
    <style>
        .badge-success-custom { background: var(--success-gradient) !important; color: #fff !important; }
        .badge-warning-custom { background: var(--warning-color) !important; color: #fff !important; }
        .badge-info-custom { background: var(--primary-deep) !important; color: #fff !important; }
        
        .btn-edit-delivery {
            background: var(--warning-color);
            border: none;
            color: #fff;
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .btn-edit-delivery:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: #fff;
        }
    </style>
@endsection

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header" style="background: var(--primary-deep) !important; border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 2rem; box-shadow: var(--shadow-md) !important; width: 100%; display: flex; align-items: center; justify-content: space-between; position: relative; overflow: visible;">
        <div style="display: flex; align-items: center; gap: 1rem; position: relative; z-index: 1;">
            <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.1); border-radius: 16px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                <i class="la la-chart-bar" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
            </div>
            <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 800; margin: 0; font-family: 'Cairo', sans-serif;">تسليمات المشترك</h1>
        </div>
        <div class="header-actions" style="position: relative; z-index: 10;">
            <a href="{{ backpack_url('client') }}" class="btn btn-light" style="color: var(--primary-deep); font-weight: 700; border-radius: 12px;">
                <i class="la la-arrow-right"></i> العودة للمشتركين
            </a>
            @if($client)
            <a href="{{ route('client.report.pdf',['client_id'=>$client->id]) }}" class="btn btn-light" style="color: var(--primary-deep); font-weight: 700; border-radius: 12px; margin-right: 10px;">
                <i class="la la-file-pdf"></i> PDF
            </a>
            @endif
        </div>
    </section>
@endsection

@section('content')
<div class="container-fluid pb-4">
    @if(!$client)
        <div class="alert alert-info text-center" style="border-radius: 16px; padding: 20px; font-weight: 600;">
            👆 الرجاء اختيار مشترك من القائمة لعرض التقرير
        </div>
    @else
        {{-- Summary Cards --}}
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="dashboard-stat-card stat-card-purple">
                    <div class="stat-card-content">
                        <div class="stat-icon-box" style="background: var(--primary-deep);">
                            <i class="la la-user"></i>
                        </div>
                        <div class="stat-info">
                            <h6 class="stat-label">اسم المشترك</h6>
                            <h3 class="stat-value" style="font-size: 24px;">{{ $client->name }}</h3>
                            <small class="text-muted">{{ $client->city->city_name ?? '-' }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="dashboard-stat-card stat-card-green">
                    <div class="stat-card-content">
                        <div class="stat-icon-box" style="background: var(--success-gradient);">
                            <i class="la la-truck"></i>
                        </div>
                        <div class="stat-info">
                            <h6 class="stat-label">إجمالي التسليمات</h6>
                            <h3 class="stat-value">{{ $client->deliveries->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Card --}}
        <div class="card filter-card mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('client.report') }}" class="row g-3 align-items-end">
                    <input type="hidden" name="client_id" value="{{ request('client_id') }}">
                    <div class="col-md-5">
                        <label class="form-label">من تاريخ</label>
                        <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">إلى تاريخ</label>
                        <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100" style="height: 48px;">
                            <i class="la la-search"></i> تصفية
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-clean align-middle mb-0">
                        <thead>
                            <tr>
                                <th>التاريخ</th>
                                <th>الموزع</th>
                                <th>قوارير ممتلئة</th>
                                <th>قوارير فارغة</th>
                                <th>رصيد القوارير</th>
                                <th>الدفع</th>
                                <th style="width: 100px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($client->deliveries as $row)
                            <tr>
                                <td class="ps-4 fw-bold">{{ $row->delivery_date ? \Carbon\Carbon::parse($row->delivery_date)->format('Y-m-d') : '-' }}</td>
                                <td>{{ $row->distributor->name ?? '-' }}</td>
                                <td><span class="badge badge-success-custom">{{ $row->bottle_received }}</span></td>
                                <td><span class="badge badge-warning-custom">{{ $row->bottle_empty }}</span></td>
                                <td class="fw-bold text-primary-deep">{{ $row->bottle_received - $row->bottle_empty }}</td>
                                <td class="fw-bold">₪ {{ number_format($row->paymant ?? 0, 0) }}</td>
                                <td class="pe-4">
                                    <button type="button" class="btn btn-sm btn-primary" onclick="editDelivery({{ $row->id }})">
                                        <i class="la la-pen"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-5 text-muted">لا توجد عمليات مسجلة</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

@include('admin.reports.inc.edit_delivery_modal')

@endsection
