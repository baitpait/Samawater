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

@extends(backpack_view('blank'))

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
            <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 800; margin: 0; font-family: 'Cairo', sans-serif;">قائمة التسليم</h1>
        </div>
        <div class="page-header-actions" style="display: flex; gap: 0.75rem; position: relative; z-index: 10;">
            @if(request()->has('search') && $clients->count() > 0)
            <a href="{{ route('reports.clients_due_advanced.export.excel', request()->all()) }}" class="btn btn-light" style="color: var(--primary-deep); font-weight: 700; border-radius: 12px;">
                <i class="la la-file-excel"></i> Excel
            </a>
            <a href="{{ route('reports.clients_due_advanced.export.pdf', request()->all()) }}" class="btn btn-light" style="color: var(--primary-deep); font-weight: 700; border-radius: 12px;">
                <i class="la la-file-pdf"></i> PDF
            </a>
            @endif
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
                    <label class="form-label">بحث</label>
                    <input type="text" name="q" class="form-control" placeholder="اسم / هاتف / عقد" value="{{ request('q') }}">
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
                    <label class="form-label">نوع الاشتراك</label>
                    <select name="subscription_type_name" class="form-select">
                        <option value="">الكل</option>
                        @foreach($subscriptionTypes as $type)
                            <option value="{{ $type }}" @selected(request('subscription_type_name') == $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">حالة الاشتراك</label>
                    <select name="subscription_status_name" class="form-select">
                        <option value="">الكل</option>
                        @foreach($subscriptionStatuses as $status)
                            <option value="{{ $status }}" @selected(request('subscription_status_name') == $status)>{{ $status }}</option>
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
                                <th>الرصيد</th>
                                <th>الدفعة</th>
                                <th>الموزع</th>
                                <th style="width: 80px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $c)
                            <tr>
                                <td class="ps-4 fw-bold text-primary-deep">{{ $c->client_name }}</td>
                                <td>{{ $c->city_name ?? '-' }}</td>
                                <td>{{ $c->phone_one ?? '-' }}</td>
                                <td class="fw-semibold text-primary-deep">{{ $c->last_delivery_date_formatted ?? $c->last_delivery_date ?? '-' }}</td>
                                <td><span class="badge badge-success-custom">{{ number_format($c->total_bottle_received ?? 0) }}</span></td>
                                <td><span class="badge badge-warning-custom">{{ number_format($c->total_bottle_empty ?? 0) }}</span></td>
                                <td>
                                    @php
                                        $balance = ($c->total_bottle_received ?? 0) - ($c->total_bottle_empty ?? 0);
                                        $class = $balance > 0 ? 'badge-balance-positive' : ($balance < 0 ? 'badge-balance-negative' : 'badge-balance-zero');
                                    @endphp
                                    <span class="badge {{ $class }}">{{ number_format($balance) }}</span>
                                </td>
                                <td class="fw-bold text-primary-deep">₪ {{ number_format($c->last_delivery_payment ?? 0) }}</td>
                                <td>{{ $c->last_delivery_distributor ?? '-' }}</td>
                                <td class="pe-4">
                                    <div class="btn-group unified-actions-dropdown dropdown">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                                            <i class="la la-cog"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ backpack_url('client/' . $c->client_id . '/show') }}"><i class="la la-eye"></i> معاينة</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-success" href="{{ url('admin/delivery/create?client_id=' . $c->client_id) }}"><i class="la la-truck"></i> تسليم</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-top">
                    {{ $clients->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
