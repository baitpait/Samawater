@extends(backpack_view('blank'))

@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    <style>
        .badge-success { background: var(--success-gradient) !important; color: #fff !important; border: none !important; }
        .badge-warning { background: var(--warning-color) !important; color: #fff !important; border: none !important; }
        .badge-danger { background: var(--danger-color) !important; color: #fff !important; border: none !important; }
        .badge-info { background: var(--primary-deep) !important; color: #fff !important; border: none !important; }
        .badge-secondary { background: #64748b !important; color: #fff !important; border: none !important; }
        
        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: none;
            background: var(--bg-light);
            color: var(--primary-deep);
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .action-btn:hover {
            background: var(--primary-deep);
            color: #fff;
        }
        
        .action-menu {
            position: absolute;
            top: 42px;
            left: 0;
            min-width: 180px;
            background: #fff;
            border-radius: 14px;
            box-shadow: var(--shadow-lg);
            padding: 8px;
            display: none;
            z-index: 1000;
            border: 1px solid #f1f5f9;
        }
        
        .action-menu a, .action-menu button {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            color: #334155;
            transition: all 0.2s ease;
            background: none;
            border: none;
            text-align: right;
        }
        
        .action-menu a:hover, .action-menu button:hover {
            background: var(--bg-light);
            color: var(--primary-deep);
        }
    </style>
@endsection

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header" style="background: var(--primary-deep) !important; border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 2rem; box-shadow: var(--shadow-md) !important; width: 100%; display: flex; align-items: center; justify-content: space-between; position: relative; overflow: visible;">
        <div style="display: flex; align-items: center; gap: 1rem; position: relative; z-index: 1;">
            <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.1); border-radius: 16px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                <i class="la la-users" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
            </div>
            <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 800; margin: 0; font-family: 'Cairo', sans-serif;">تقرير المشتركين</h1>
        </div>
        <div class="page-header-actions" style="display: flex; gap: 0.75rem; position: relative; z-index: 10;">
            @if($clients->count() > 0)
            <a href="{{ route('reports.filters.export.excel', request()->all()) }}" class="btn btn-light" style="color: var(--primary-deep); font-weight: 700; border-radius: 12px;">
                <i class="la la-file-excel"></i> Excel
            </a>
            <a href="{{ route('reports.filters.export.pdf', request()->all()) }}" class="btn btn-light" style="color: var(--primary-deep); font-weight: 700; border-radius: 12px;">
                <i class="la la-file-pdf"></i> PDF
            </a>
            @endif
        </div>
    </section>
@endsection

@section('content')
<div class="container-fluid pb-5">

    {{-- Filter Panel --}}
    <div class="card filter-card mb-4">
        <div class="card-body p-4">
            <div class="results-header-modern mb-4" style="background: var(--primary-deep); border-radius: 16px; padding: 20px; color: #fff; display: flex; align-items: center; gap: 15px;">
                <i class="la la-filter" style="font-size: 24px;"></i>
                <span style="font-size: 18px; font-weight: 700;">عدد المشتركين المطابقين: {{ number_format($clients->total()) }}</span>
            </div>

            <form method="GET" action="{{ route('reports.filters') }}" class="row g-3 align-items-end">
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
                    <label class="form-label">نوع المشترك</label>
                    <select name="client_type_id" class="form-select">
                        <option value="">الكل</option>
                        @foreach($clientTypes as $id => $name)
                            <option value="{{ $id }}" @selected(request('client_type_id') == $id)>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">حالة المشترك</label>
                    <select name="status_id" class="form-select">
                        <option value="">الكل</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" @selected(request('status_id') == $status->id)>{{ $status->status_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">نوع الاشتراك</label>
                    <select name="subscription_type_id" class="form-select">
                        <option value="">الكل</option>
                        @foreach($subscriptions as $sub)
                            <option value="{{ $sub->id }}" @selected(request('subscription_type_id') == $sub->id)>{{ $sub->type_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">بحث سريع</label>
                    <input type="text" name="q" class="form-control" placeholder="اسم المشترك، رقم الهاتف، أو العنوان" value="{{ request('q') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100" style="height: 48px;">
                        <i class="la la-search"></i> عرض النتائج
                    </button>
                </div>
                <div class="col-md-3">
                    <a href="{{ url(config('backpack.base.route_prefix').'/client/create') }}" class="btn btn-success w-100" style="height: 48px; border-radius: 12px !important;">
                        <i class="la la-plus"></i> إضافة مشترك
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Results Table --}}
    @if($clients->count())
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-clean align-middle mb-0">
                    <thead>
                        <tr>
                            <th>المشترك</th>
                            <th>المدينة</th>
                            <th>حالة الاشتراك</th>
                            <th>الرصيد</th>
                            <th>آخر استلام</th>
                            <th>أيام بدون استلام</th>
                            <th style="width: 80px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-primary-deep">{{ $client->name }}</div>
                                <small class="text-muted">{{ $client->phone_one ?? '-' }}</small>
                            </td>
                            <td>{{ $client->city->city_name ?? '-' }}</td>
                            <td><span class="badge badge-info">{{ optional($client->subscriptionStatus)->status_name }}</span></td>
                            <td class="fw-bold text-primary-deep">{{ $client->bottle_balance }}</td>
                            <td class="fw-semibold">{{ $client->lastDelivery ? \Carbon\Carbon::parse($client->lastDelivery->delivery_date)->format('Y-m-d') : '-' }}</td>
                            <td>
                                @if($client->lastDelivery)
                                    @php
                                        $days = (int) \Carbon\Carbon::parse($client->lastDelivery->delivery_date)->startOfDay()->diffInDays(now()->startOfDay());
                                    @endphp
                                    <span class="badge @if($days <= 1) badge-success @elseif($days <= 10) badge-warning @else badge-danger @endif">
                                        @if($days === 0) اليوم @elseif($days === 1) أمس @else منذ {{ $days }} يوم @endif
                                    </span>
                                @else
                                    <span class="badge badge-secondary">لم يستلم</span>
                                @endif
                            </td>
                            <td class="pe-4">
                                <div class="btn-group dropdown" style="position: relative;">
                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                                        <i class="la la-cog"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ backpack_url('client/'.$client->id.'/show') }}"><i class="la la-eye"></i> معاينة</a>
                                        <a class="dropdown-item" href="{{ backpack_url('client/'.$client->id.'/edit') }}"><i class="la la-edit"></i> تعديل</a>
                                        <a class="dropdown-item" href="{{ url('admin/client-report?client_id='.$client->id) }}"><i class="la la-chart-bar"></i> تقرير</a>
                                        <a class="dropdown-item" href="{{ url('admin/delivery/create?client_id='.$client->id) }}"><i class="la la-truck"></i> تسليم</a>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item text-danger btn-delete" data-url="{{ backpack_url('client/'.$client->id) }}"><i class="la la-trash"></i> حذف</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-top">
                {{ $clients->withQueryString()->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Delete Action
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            if (confirm('هل أنت متأكد من الحذف؟')) {
                fetch(this.dataset.url, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                })
                .then(res => { if (res.ok) this.closest('tr').remove(); })
                .catch(() => alert('حدث خطأ أثناء الحذف'));
            }
        });
    });
});
</script>
@endsection
