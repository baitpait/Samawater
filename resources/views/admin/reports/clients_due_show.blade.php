@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    <style>
        .badge-success-custom { background: var(--success-gradient) !important; color: #fff !important; }
        .badge-warning-custom { background: var(--warning-color) !important; color: #fff !important; }
        .badge-danger-custom { background: var(--danger-color) !important; color: #fff !important; }
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
                <i class="la la-user" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
            </div>
            <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 800; margin: 0; font-family: 'Cairo', sans-serif;">تفاصيل المشترك</h1>
        </div>
        <div class="page-header-actions" style="position: relative; z-index: 10;">
            <a href="{{ url()->previous() }}" class="btn btn-light" style="color: var(--primary-deep); font-weight: 700; border-radius: 12px;">
                <i class="la la-arrow-right"></i> رجوع
            </a>
        </div>
    </section>

    {{-- ===============================
        Client Info Card
    =============================== --}}
    <div class="card mb-4">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-4">
                    <label class="form-label">اسم المشترك</label>
                    <div class="fw-bold text-primary-deep" style="font-size: 18px;">{{ $client->name ?? $row->client_name }}</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">رقم العقد</label>
                    <div class="fw-bold text-success">{{ $client->contract_no ?? $row->contract_no }}</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">المدينة</label>
                    <div class="fw-bold">{{ $client->city->city_name ?? $row->city_name ?? '-' }}</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">رقم الهاتف</label>
                    <div class="fw-bold">{{ $client->phone_one ?? $row->phone_one ?? '-' }}</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">نوع الاشتراك</label>
                    <div><span class="badge badge-soft-purple">{{ $client->subscriptionType->type_name ?? $row->subscription_type_name ?? '-' }}</span></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">حالة الاشتراك</label>
                    <div><span class="badge badge-success-custom">{{ $client->subscriptionStatus->status_name ?? $row->subscription_status_name ?? '-' }}</span></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===============================
        Delivery Info Card
    =============================== --}}
    <div class="card mb-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4 text-primary-deep"><i class="la la-info-circle"></i> ملخص التسليمات</h5>
            <div class="row g-4 text-center">
                <div class="col-md-3">
                    <label class="form-label">إجمالي التسليمات</label>
                    <div class="h3 fw-bold">{{ $row->total_deliveries ?? 0 }}</div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">أيام بدون تسليم</label>
                    <div class="h3 fw-bold text-danger">{{ $row->days_since_last_delivery ?? 0 }}</div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">نسبة الالتزام</label>
                    <div class="h3 fw-bold text-success">{{ number_format($row->percentage_delivery_rate ?? 0, 1) }}%</div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">تاريخ آخر تسليم</label>
                    <div class="h3 fw-bold text-primary-deep">{{ $row->last_delivery_date ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===============================
        Recent Deliveries Table
    =============================== --}}
    @if($recentDeliveries && $recentDeliveries->count() > 0)
    <div class="card">
        <div class="card-body p-0">
            <div class="p-4 border-bottom">
                <h5 class="fw-bold mb-0 text-primary-deep"><i class="la la-history"></i> سجل آخر التسليمات</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-clean align-middle mb-0">
                    <thead>
                        <tr>
                            <th>التاريخ</th>
                            <th>الموزع</th>
                            <th>العبوات المستلمة</th>
                            <th>العبوات الفارغة</th>
                            <th>المبلغ المدفوع</th>
                            <th style="width: 80px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentDeliveries as $delivery)
                        <tr>
                            <td class="ps-4 fw-bold">{{ \Carbon\Carbon::parse($delivery->delivery_date)->format('Y-m-d') }}</td>
                            <td>{{ $delivery->distributor->name ?? '-' }}</td>
                            <td><span class="badge badge-success-custom">{{ $delivery->bottle_received ?? 0 }}</span></td>
                            <td><span class="badge badge-warning-custom">{{ $delivery->bottle_empty ?? 0 }}</span></td>
                            <td class="fw-bold text-primary-deep">₪ {{ number_format($delivery->paymant ?? 0, 2) }}</td>
                            <td class="pe-4 text-center">
                                <a href="{{ url('admin/delivery/' . $delivery->id . '/edit') }}" class="btn btn-sm btn-primary">
                                    <i class="la la-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
