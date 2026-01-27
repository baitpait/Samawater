@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    <style>
        /* تثبيت الجدول داخل البطاقة مع شريط أفقي */
        .filter-card .card-body {
            overflow-x: auto !important;
        }
        .filter-card .table-responsive {
            overflow-x: auto !important;
        }
        .filter-card .table-clean {
            min-width: 1400px;
        }
        
        /* تحسين المسافات في الفلاتر */
        .days-filter-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .days-operator-select {
            width: 160px !important;
        }
        
        /* تجميل أزرار الإجراءات */
        .btn-group.unified-actions-dropdown .btn-primary {
            background: var(--primary-deep) !important;
            border: none !important;
            box-shadow: var(--shadow-sm) !important;
        }
        
        .btn-group.unified-actions-dropdown .btn-primary:hover {
            background: #254a7a !important;
            box-shadow: var(--shadow-md) !important;
        }
    </style>
@endsection

@extends(backpack_view('blank'))

@section('content')
<div class="container-fluid pb-4">

    {{-- ===============================
        Header - Unified Design
    =============================== --}}
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header">
        <div class="header-content-wrapper" style="display: flex; align-items: center; gap: 1rem; width: 100%; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div class="icon-box" style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255, 255, 255, 0.2);">
                    <i class="la la-truck" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
                </div>
                <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 700; margin: 0; font-family: 'Cairo', sans-serif;">قائمة التسليم</h1>
            </div>
            <div>
                @php
                    $bulkEntryUrl = route('delivery.bulk-entry', request()->query());
                @endphp
                <a href="{{ $bulkEntryUrl }}" class="btn btn-light" style="color: var(--primary-deep); font-weight: 700; border-radius: 12px; padding: 10px 20px;">
                    <i class="la la-table"></i> إدخال جماعي
                </a>
            </div>
        </div>
    </section>

    {{-- ===============================
        Filters
    =============================== --}}
    <div class="card filter-card mb-4">
        <div class="card-body p-4">
            <form method="GET" class="row g-3 align-items-end">
                {{-- صف مستقل للبحث --}}
                <div class="col-12">
                    <label class="form-label">بحث سريع</label>
                    <input type="text" name="q" class="form-control" placeholder="اسم المشترك / رقم الهاتف / رقم العقد / العنوان" value="{{ request('q') }}">
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
                    <select name="subscription_type_id" class="form-select">
                        <option value="">الكل</option>
                        @foreach($subscriptionTypes as $type)
                            <option value="{{ $type->id }}" @selected(request('subscription_type_id') == $type->id)>{{ $type->type_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">حالة الاشتراك</label>
                    <select name="subscription_status_name" class="form-select">
                        <option value="">الكل</option>
                        @foreach($subscriptionStatuses as $status)
                            <option value="{{ $status->status_name }}" @selected(request('subscription_status_name') == $status->status_name)>{{ $status->status_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <button type="submit" name="search" value="1" class="btn btn-primary w-100">
                        <i class="la la-search"></i> بحث وتصفية
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===============================
        Results Table
    =============================== --}}
    @if(request()->has('search') && $clients instanceof \Illuminate\Pagination\LengthAwarePaginator && $clients->count() > 0)
        <div class="card filter-card mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-clean align-middle mb-0" style="min-width: 1200px;">
                        <thead>
                            <tr>
                                <th>المشترك</th>
                                <th>المدينة / العنوان</th>
                                <th>الهاتف</th>
                                <th>معلومات الاشتراك</th>
                                <th>نسبة الالتزام</th>
                                <th>تاريخ آخر تسليم</th>
                                <th>أيام بدون تسليم</th>
                                <th>الموزع</th>
                                <th>إجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-primary-deep">{{ $client->client_name ?? '-' }}</div>
                                        <div class="text-muted small">{{ $client->contract_no ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $client->city_name ?? '-' }}</div>
                                        <div class="text-muted small">{{ $client->address ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div>{{ $client->phone_one ?? '-' }}</div>
                                        @if($client->phone_two) <div class="text-muted small">{{ $client->phone_two }}</div> @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-deep text-white">{{ $client->subscription_type_name ?? '-' }}</span>
                                        <span class="badge bg-success text-white">{{ $client->subscription_status_name ?? '-' }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $rate = $client->percentage_delivery_rate ?? 0;
                                            $color = $rate >= 80 ? 'success' : ($rate >= 50 ? 'warning' : 'danger');
                                        @endphp
                                        <span class="badge bg-{{ $color }} text-white">{{ number_format($rate, 1) }}%</span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-primary-deep">{{ $client->last_delivery_date ? \Carbon\Carbon::parse($client->last_delivery_date)->format('Y-m-d') : 'لم يتسلم' }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-danger">{{ $client->days_since_last_delivery ?? 0 }} يوم</span>
                                    </td>
                                    <td>{{ $client->distributor_name ?? '-' }}</td>
                                    <td class="pe-4">
                                        <div class="btn-group unified-actions-dropdown dropdown">
                                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                                                <i class="la la-cog"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="{{ url('admin/client/' . $client->client_id . '/show') }}"><i class="la la-eye"></i> معاينة</a>
                                                <a class="dropdown-item" href="{{ url('admin/client-report?client_id=' . $client->client_id) }}"><i class="la la-file-alt"></i> تقرير</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-success" href="{{ backpack_url('delivery/create?client_id=' . $client->client_id) }}"><i class="la la-truck"></i> تسليم</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                <div class="p-4 border-top">
                    {{ $clients->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @elseif(request()->has('search'))
        <div class="alert alert-warning text-center" style="border-radius: 16px;">
            <i class="la la-exclamation-circle"></i> لا توجد نتائج تطابق معايير البحث.
        </div>
    @endif

</div>
@endsection
