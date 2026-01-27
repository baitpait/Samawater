@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    <style>
        /* تحسين ارتفاع الرسوم البيانية */
        .dashboard-chart-card canvas {
            max-height: 250px !important;
        }
        
        .stat-card-purple::before { background: var(--primary-deep) !important; }
        .stat-card-green::before { background: var(--success-gradient) !important; }
        
        .icon-box-purple { background: var(--primary-deep) !important; }
        .icon-box-green { background: var(--success-gradient) !important; }
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
                <i class="la la-chart-bar" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
            </div>
            <div>
                <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 800; margin: 0; font-family: 'Cairo', sans-serif;">التقارير الإحصائية</h1>
            </div>
        </div>
        <div style="display: flex; gap: 12px; align-items: center; position: relative; z-index: 10;">
            <a href="{{ route('reports.advanced.export.excel', request()->all()) }}" class="btn btn-light" style="color: var(--primary-deep); font-weight: 700; border-radius: 12px;">
                <i class="la la-file-excel"></i> Excel
            </a>
            <a href="{{ route('reports.advanced.export.pdf', request()->all()) }}" class="btn btn-light" style="color: var(--primary-deep); font-weight: 700; border-radius: 12px;">
                <i class="la la-file-pdf"></i> PDF
            </a>
        </div>
    </section>

    {{-- ======================= فلاتر الفترة الزمنية ======================= --}}
    <div class="card filter-card mb-4">
        <div class="card-body p-4">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label">الفترة</label>
                    <select name="period" class="form-select">
                        <option value="day" @selected($period == 'day')>يومي</option>
                        <option value="week" @selected($period == 'week')>أسبوعي</option>
                        <option value="month" @selected($period == 'month')>شهري</option>
                        <option value="year" @selected($period == 'year')>سنوي</option>
                        <option value="custom" @selected($period == 'custom')>مخصص</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">من تاريخ</label>
                    <input type="date" name="date_from" class="form-control" value="{{ $dateFrom ?? $startDate->format('Y-m-d') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">إلى تاريخ</label>
                    <input type="date" name="date_to" class="form-control" value="{{ $dateTo ?? $endDate->format('Y-m-d') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">المدينة</label>
                    <select name="city_id" class="form-select">
                        <option value="">الكل</option>
                        @foreach($cities as $city)
                        <option value="{{ $city->id }}" @selected($cityId == $city->id)>{{ $city->city_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">الموزع</label>
                    <select name="distributor_id" class="form-select">
                        <option value="">الكل</option>
                        @foreach($distributors as $distributor)
                        <option value="{{ $distributor->id }}" @selected($distributorId == $distributor->id)>{{ $distributor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100" style="height: 48px;">
                        <i class="la la-search"></i> تحديث
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ======================= الإحصائيات العامة ======================= --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="dashboard-stat-card stat-card-purple">
                <div class="stat-card-content">
                    <div class="stat-icon-box icon-box-purple">
                        <i class="la la-users"></i>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">إجمالي المشتركين</h6>
                        <h3 class="stat-value">{{ number_format($generalStats['total_clients']) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-stat-card stat-card-green">
                <div class="stat-card-content">
                    <div class="stat-icon-box icon-box-green">
                        <i class="la la-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">المشتركين النشطين</h6>
                        <h3 class="stat-value">{{ number_format($generalStats['active_clients']) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-stat-card stat-card-purple">
                <div class="stat-card-content">
                    <div class="stat-icon-box icon-box-purple">
                        <i class="la la-truck"></i>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">التسليمات في الفترة</h6>
                        <h3 class="stat-value">{{ number_format($generalStats['deliveries_in_period']) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-stat-card stat-card-green">
                <div class="stat-card-content">
                    <div class="stat-icon-box icon-box-green">
                        <i class="la la-calendar-check"></i>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">المشتركين المستحقين</h6>
                        <h3 class="stat-value">{{ number_format($clientsDueCount) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================= الرسوم البيانية ======================= --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="dashboard-chart-card">
                <div class="chart-card-header">
                    <div class="chart-card-icon" style="background: var(--primary-deep);">
                        <i class="la la-chart-line"></i>
                    </div>
                    <h5 class="chart-card-title">التسليمات اليومية</h5>
                </div>
                <div class="chart-card-body">
                    <canvas id="dailyDeliveriesChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="dashboard-chart-card">
                <div class="chart-card-header">
                    <div class="chart-card-icon" style="background: var(--primary-deep);">
                        <i class="la la-chart-bar"></i>
                    </div>
                    <h5 class="chart-card-title">التسليمات الشهرية</h5>
                </div>
                <div class="chart-card-body">
                    <canvas id="monthlyDeliveriesChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================= أداء الموزعين ======================= --}}
    <div class="card filter-card mb-4">
        <div class="card-body p-0">
            <div class="p-4 border-bottom d-flex align-items-center gap-3">
                <div style="width: 40px; height: 40px; background: var(--primary-deep); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff;">
                    <i class="la la-user-tie" style="font-size: 20px;"></i>
                </div>
                <h5 class="mb-0 fw-bold">أداء الموزعين</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-clean align-middle mb-0">
                    <thead>
                        <tr>
                            <th>اسم الموزع</th>
                            <th>عدد التسليمات</th>
                            <th>القوارير المستلمة</th>
                            <th>القوارير الفارغة</th>
                            <th>إجمالي الدفعات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($distributorPerformance as $distributor)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $distributor->name }}</td>
                            <td><span class="badge bg-primary-deep text-white">{{ number_format($distributor->deliveries_count) }}</span></td>
                            <td><span class="badge bg-success text-white">{{ number_format($distributor->total_bottles_received) }}</span></td>
                            <td><span class="badge bg-warning text-white">{{ number_format($distributor->total_bottles_empty) }}</span></td>
                            <td class="fw-bold text-primary-deep">₪ {{ number_format($distributor->total_payment ?? 0) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">لا توجد بيانات متاحة</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('after_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Charts configuration with unified colors
const primaryColor = '#1e3a5f';
const successColor = '#059669';

// Daily Deliveries
new Chart(document.getElementById('dailyDeliveriesChart'), {
    type: 'line',
    data: {
        labels: @json($dailyDeliveries->pluck('date')),
        datasets: [{
            label: 'عدد التسليمات',
            data: @json($dailyDeliveries->pluck('count')),
            borderColor: primaryColor,
            backgroundColor: 'rgba(30, 58, 95, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: { responsive: true, maintainAspectRatio: false }
});

// Monthly Deliveries
new Chart(document.getElementById('monthlyDeliveriesChart'), {
    type: 'bar',
    data: {
        labels: @json($monthlyDeliveries->pluck('month')),
        datasets: [{
            label: 'عدد التسليمات',
            data: @json($monthlyDeliveries->pluck('count')),
            backgroundColor: successColor,
            borderRadius: 8
        }]
    },
    options: { responsive: true, maintainAspectRatio: false }
});
</script>
@endpush
