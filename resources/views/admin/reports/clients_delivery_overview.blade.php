@extends(backpack_view('blank'))

@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    <style>
        .badge-success-custom { background: var(--success-gradient) !important; color: #fff !important; }
        .badge-warning-custom { background: var(--warning-color) !important; color: #fff !important; }
        .badge-balance-positive { background: var(--primary-deep) !important; color: #fff !important; }
        .badge-balance-negative { background: var(--danger-color) !important; color: #fff !important; }
        .badge-balance-zero { background: #64748b !important; color: #fff !important; }
        .badge-soft-purple { background: var(--primary-deep) !important; color: #fff !important; }
    </style>
@endsection

@section('content')
<div class="container-fluid pb-4">

    {{-- ===============================
        Header - Unified Design
    =============================== --}}
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header" style="background: var(--primary-deep) !important; border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 2rem; box-shadow: var(--shadow-md) !important; width: 100%; display: flex; align-items: center; justify-content: space-between; position: relative; overflow: visible;">
        <div style="display: flex; align-items: center; gap: 1rem; position: relative; z-index: 1;">
            <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.1); border-radius: 16px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                <i class="la la-truck" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
            </div>
            <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 800; margin: 0; font-family: 'Cairo', sans-serif;">تقرير التسليمات</h1>
        </div>
        <div class="page-header-actions" style="display: flex; gap: 0.75rem; position: relative; z-index: 10;">
            @if(request('search'))
            <a href="{{ route('reports.clients_delivery_overview.export.excel', request()->all()) }}" class="btn btn-light" style="color: var(--primary-deep); font-weight: 700; border-radius: 12px;">
                <i class="la la-file-excel"></i> Excel
            </a>
            <a href="{{ route('reports.clients_delivery_overview.export.pdf', request()->all()) }}" class="btn btn-light" style="color: var(--primary-deep); font-weight: 700; border-radius: 12px;">
                <i class="la la-file-pdf"></i> PDF
            </a>
            @endif
            <a href="{{ backpack_url('delivery/create') }}" class="btn btn-light" style="color: var(--primary-deep); font-weight: 700; border-radius: 12px;">
                <i class="la la-plus"></i> إضافة تسليم
            </a>
        </div>
    </section>

    {{-- ===============================
        Filters
    =============================== --}}
    <div class="card filter-card mb-4">
        <div class="card-body p-4">
            <form method="GET" class="row g-3 align-items-end">
                <input type="hidden" name="search" value="1">
                
                <div class="col-md-3">
                    <label class="form-label">من تاريخ</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">إلى تاريخ</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">المدينة</label>
                    <select name="city_id" class="form-select">
                        <option value="">الكل</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" @selected(request('city_id') == $city->id)>{{ $city->city_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">الموزع</label>
                    <select name="distributor_id" class="form-select">
                        <option value="">الكل</option>
                        @foreach($distributors as $distributor)
                            <option value="{{ $distributor->id }}" @selected(request('distributor_id') == $distributor->id)>{{ $distributor->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12 text-end mt-3">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="la la-search"></i> عرض النتائج
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===============================
        Results
    =============================== --}}
    @if(request()->has('search'))
        <div class="card filter-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-clean align-middle mb-0" style="min-width: 1200px;">
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
                                <th style="width: 80px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rows as $r)
                            <tr>
                                <td class="ps-4 fw-bold text-primary-deep">{{ $r->client_name }}</td>
                                <td>{{ $r->city_name ?? '-' }}</td>
                                <td>{{ $r->phone_one ?? '-' }}</td>
                                <td class="fw-semibold text-primary-deep">
                                    {{ $r->last_delivery_date_actual ? \Carbon\Carbon::parse($r->last_delivery_date_actual)->format('Y-m-d') : '-' }}
                                </td>
                                <td><span class="badge badge-success-custom">{{ number_format($r->last_bottle_received ?? 0) }}</span></td>
                                <td><span class="badge badge-warning-custom">{{ number_format($r->last_bottle_empty ?? 0) }}</span></td>
                                <td>
                                    @php
                                        $balance = ($r->last_bottle_received ?? 0) - ($r->last_bottle_empty ?? 0);
                                        $class = $balance > 0 ? 'badge-balance-positive' : ($balance < 0 ? 'badge-balance-negative' : 'badge-balance-zero');
                                    @endphp
                                    <span class="badge {{ $class }}">{{ number_format($balance) }}</span>
                                </td>
                                <td class="fw-bold text-primary-deep">₪ {{ number_format($r->last_paymant ?? 0) }}</td>
                                <td>{{ $r->distributor_name ?? '-' }}</td>
                                <td class="pe-4">
                                    @if($r->last_delivery_id)
                                    <button type="button" class="btn btn-sm btn-primary" onclick="editDelivery({{ $r->last_delivery_id }})">
                                        <i class="la la-edit"></i>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-5 text-muted">لا توجد نتائج مطابقة</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-top">
                    {{ $rows->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

@include('admin.reports.inc.edit_delivery_modal')

@endsection
