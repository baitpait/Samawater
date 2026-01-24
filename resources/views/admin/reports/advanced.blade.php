@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
@endsection

@extends(backpack_view('blank'))

@section('content')
<div class="container-fluid pb-4">

    {{-- ===============================
        Header - Unified Design
    =============================== --}}
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header" style="background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%); border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 2rem; box-shadow: 0 10px 30px rgba(111, 106, 248, 0.3); width: 100%; display: flex; align-items: center; justify-content: space-between; position: relative; overflow: visible;">
        <div style="display: flex; align-items: center; gap: 1rem; position: relative; z-index: 1;">
            <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.2); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15); display: flex; align-items: center; justify-content: center;">
                <i class="la la-chart-bar" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
            </div>
            <div>
                <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 700; margin: 0; font-family: 'Cairo', sans-serif;">التقارير الإحصائية</h1>
            </div>
        </div>
            <div style="display: flex; gap: 12px; align-items: center; position: relative; z-index: 10;">
                <a href="{{ route('reports.advanced.export.excel', request()->all()) }}" style="background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.3); color: #fff; padding: 10px 20px; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; font-family: 'Cairo', sans-serif;">
                    <i class="la la-file-excel"></i>
                    تصدير Excel
                </a>
                <a href="{{ route('reports.advanced.export.pdf', request()->all()) }}" style="background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.3); color: #fff; padding: 10px 20px; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; font-family: 'Cairo', sans-serif;">
                    <i class="la la-file-pdf"></i>
                    تصدير PDF
                </a>
            </div>
        </div>
    </section>

    {{-- Unified Header CSS --}}
    <style>
        section.header-operation a:hover {
            background: rgba(255, 255, 255, 0.3) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.2) !important;
        }
    </style>

    {{-- ======================= فلاتر الفترة الزمنية ======================= --}}
    <div class="card filter-card mb-4" style="background: #ffffff; border-radius: 20px; padding: 28px; box-shadow: 0 6px 20px rgba(0,0,0,0.05); border: none;">
        <div class="card-body" style="padding: 0;">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-12 col-md-2">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">الفترة</label>
                    <select name="period" class="form-select modern-select">
                        <option value="day" @selected($period == 'day')>يومي</option>
                        <option value="week" @selected($period == 'week')>أسبوعي</option>
                        <option value="month" @selected($period == 'month')>شهري</option>
                        <option value="year" @selected($period == 'year')>سنوي</option>
                        <option value="custom" @selected($period == 'custom' || ($dateFrom && $dateTo))>مخصص</option>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">من تاريخ</label>
                    <input type="date" name="date_from" class="form-control modern-input" value="{{ $dateFrom ?? $startDate->format('Y-m-d') }}">
                </div>
                <div class="col-12 col-md-2">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">إلى تاريخ</label>
                    <input type="date" name="date_to" class="form-control modern-input" value="{{ $dateTo ?? $endDate->format('Y-m-d') }}">
                </div>
                <div class="col-12 col-md-2">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">المدينة</label>
                    <select name="city_id" class="form-select modern-select">
                        <option value="">الكل</option>
                        @foreach($cities as $city)
                        <option value="{{ $city->id }}" @selected($cityId == $city->id)>{{ $city->city_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 10px; display: block;">الموزع</label>
                    <select name="distributor_id" class="form-select modern-select">
                        <option value="">الكل</option>
                        @foreach($distributors as $distributor)
                        <option value="{{ $distributor->id }}" @selected($distributorId == $distributor->id)>{{ $distributor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-show-results w-100" title="عرض النتائج" style="height: 46px; display: flex; align-items: center; justify-content: center;">
                        <i class="la la-search" style="font-size: 20px;"></i>
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
        {{-- التسليمات اليومية --}}
        <div class="col-md-6">
            <div class="dashboard-chart-card">
                <div class="chart-card-header">
                    <div class="chart-card-icon">
                        <i class="la la-chart-line"></i>
                    </div>
                    <h5 class="chart-card-title">التسليمات اليومية</h5>
                </div>
                <div class="chart-card-body">
                    <canvas id="dailyDeliveriesChart" height="200"></canvas>
                </div>
            </div>
        </div>

        {{-- التسليمات الشهرية --}}
        <div class="col-md-6">
            <div class="dashboard-chart-card">
                <div class="chart-card-header">
                    <div class="chart-card-icon">
                        <i class="la la-chart-bar"></i>
                    </div>
                    <h5 class="chart-card-title">التسليمات الشهرية (آخر 12 شهر)</h5>
                </div>
                <div class="chart-card-body">
                    <canvas id="monthlyDeliveriesChart" height="200"></canvas>
                </div>
            </div>
        </div>

        {{-- المشتركين حسب حالة الالتزام --}}
        <div class="col-md-6">
            <div class="dashboard-chart-card">
                <div class="chart-card-header">
                    <div class="chart-card-icon">
                        <i class="la la-chart-pie"></i>
                    </div>
                    <h5 class="chart-card-title">المشتركين حسب حالة الالتزام</h5>
                </div>
                <div class="chart-card-body">
                    <canvas id="clientsByCommitmentChart" height="200"></canvas>
                </div>
            </div>
        </div>

        {{-- المشتركين حسب حالة الاشتراك --}}
        <div class="col-md-6">
            <div class="dashboard-chart-card">
                <div class="chart-card-header">
                    <div class="chart-card-icon">
                        <i class="la la-chart-pie"></i>
                    </div>
                    <h5 class="chart-card-title">المشتركين حسب حالة الاشتراك</h5>
                </div>
                <div class="chart-card-body">
                    <canvas id="clientsBySubscriptionStatusChart" height="200"></canvas>
                </div>
            </div>
        </div>

        {{-- نمو المشتركين (الشهري) --}}
        <div class="col-md-6">
            <div class="dashboard-chart-card">
                <div class="chart-card-header">
                    <div class="chart-card-icon">
                        <i class="la la-chart-line"></i>
                    </div>
                    <h5 class="chart-card-title">نمو المشتركين (آخر 12 شهر)</h5>
                </div>
                <div class="chart-card-body">
                    <canvas id="clientGrowthChart" height="200"></canvas>
                </div>
            </div>
        </div>

        {{-- مقارنة الموزعين (رسم بياني) --}}
        <div class="col-md-6">
            <div class="dashboard-chart-card">
                <div class="chart-card-header">
                    <div class="chart-card-icon">
                        <i class="la la-chart-bar"></i>
                    </div>
                    <h5 class="chart-card-title">مقارنة أداء الموزعين</h5>
                </div>
                <div class="chart-card-body">
                    <canvas id="distributorComparisonChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================= تقرير أداء الموزعين ======================= --}}
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="dashboard-table-card">
                <div class="table-card-header">
                    <div class="table-card-title-wrapper">
                        <div class="table-card-icon">
                            <i class="la la-user-tie"></i>
                        </div>
                        <h5 class="table-card-title">أداء الموزعين</h5>
                    </div>
                </div>
                <div class="table-card-body">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-clean align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">اسم الموزع</th>
                                    <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">عدد التسليمات</th>
                                    <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">القوارير المستلمة</th>
                                    <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">القوارير الفارغة</th>
                                    <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">إجمالي الدفعات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($distributorPerformance as $distributor)
                                <tr style="background: #fcfdff; box-shadow: 0 4px 12px rgba(0,0,0,.06); border-radius: 12px; margin-bottom: 8px;">
                                    <td style="padding: 12px; color: #374151; font-weight: 600;">{{ $distributor->name }}</td>
                                    <td style="padding: 12px;"><span class="badge badge-soft-purple">{{ number_format($distributor->deliveries_count) }}</span></td>
                                    <td style="padding: 12px;"><span class="badge badge-success-custom">{{ number_format($distributor->total_bottles_received) }}</span></td>
                                    <td style="padding: 12px;"><span class="badge badge-warning-custom">{{ number_format($distributor->total_bottles_empty) }}</span></td>
                                    <td style="padding: 12px;"><span class="badge badge-soft-purple">{{ number_format($distributor->total_payment ?? 0) }} ₪</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">لا توجد بيانات في هذه الفترة</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================= توزيع المشتركين حسب المدن ======================= --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="dashboard-table-card">
                <div class="table-card-header">
                    <div class="table-card-title-wrapper">
                        <div class="table-card-icon">
                            <i class="la la-map-marker"></i>
                        </div>
                        <h5 class="table-card-title">توزيع المشتركين حسب المدن (أول 20 مدينة)</h5>
                    </div>
                </div>
                <div class="table-card-body">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-clean align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">المدينة</th>
                                    <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">عدد المشتركين</th>
                                    <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">النسبة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clientsByCity as $city)
                                <tr style="background: #fcfdff; box-shadow: 0 4px 12px rgba(0,0,0,.06); border-radius: 12px; margin-bottom: 8px;">
                                    <td style="padding: 12px; color: #374151; font-weight: 600;">{{ $city->city_name }}</td>
                                    <td style="padding: 12px;"><span class="badge badge-soft-purple">{{ number_format($city->clients_count) }}</span></td>
                                    <td style="padding: 12px;">
                                        <div class="progress" style="height: 20px; border-radius: 10px;">
                                            <div class="progress-bar" role="progressbar" 
                                                 style="width: {{ ($city->clients_count / max($generalStats['total_clients'], 1)) * 100 }}%; background: linear-gradient(135deg, #6f6af8, #7c7cff); border-radius: 10px;">
                                                {{ number_format(($city->clients_count / max($generalStats['total_clients'], 1)) * 100, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- معدل الالتزام حسب المدينة --}}
        <div class="col-md-6">
            <div class="dashboard-table-card">
                <div class="table-card-header">
                    <div class="table-card-title-wrapper">
                        <div class="table-card-icon">
                            <i class="la la-chart-bar"></i>
                        </div>
                        <h5 class="table-card-title">معدل الالتزام حسب المدينة (أول 15 مدينة)</h5>
                    </div>
                </div>
                <div class="table-card-body">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-clean align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">المدينة</th>
                                    <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">عدد المشتركين</th>
                                    <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">متوسط الالتزام</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($commitmentByCity as $city)
                                <tr style="background: #fcfdff; box-shadow: 0 4px 12px rgba(0,0,0,.06); border-radius: 12px; margin-bottom: 8px;">
                                    <td style="padding: 12px; color: #374151; font-weight: 600;">{{ $city['city_name'] }}</td>
                                    <td style="padding: 12px;"><span class="badge badge-soft-purple">{{ number_format($city['total_clients']) }}</span></td>
                                    <td style="padding: 12px;">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress flex-grow-1" style="height: 20px; border-radius: 10px;">
                                                <div class="progress-bar 
                                                    @if($city['avg_commitment'] >= 90) badge-success-custom
                                                    @elseif($city['avg_commitment'] >= 75) badge-soft-purple
                                                    @elseif($city['avg_commitment'] >= 50) badge-warning-custom
                                                    @else badge-danger-custom
                                                    @endif" 
                                                    role="progressbar" 
                                                    style="width: {{ $city['avg_commitment'] }}%; border-radius: 10px; background: @if($city['avg_commitment'] >= 90) linear-gradient(135deg, #22c55e, #16a34a) @elseif($city['avg_commitment'] >= 75) linear-gradient(135deg, #6f6af8, #7c7cff) @elseif($city['avg_commitment'] >= 50) linear-gradient(135deg, #f59e0b, #d97706) @else linear-gradient(135deg, #ef4444, #dc2626) @endif;">
                                                    {{ number_format($city['avg_commitment'], 1) }}%
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted" style="padding: 20px;">لا توجد بيانات</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ======================= المشتركين حسب نوع الاشتراك ======================= --}}
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="dashboard-table-card">
                <div class="table-card-header">
                    <div class="table-card-title-wrapper">
                        <div class="table-card-icon">
                            <i class="la la-calendar"></i>
                        </div>
                        <h5 class="table-card-title">المشتركين حسب نوع الاشتراك</h5>
                    </div>
                </div>
                <div class="table-card-body">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-clean align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">نوع الاشتراك</th>
                                    <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">عدد الأيام</th>
                                    <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">عدد المشتركين</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clientsBySubscriptionType as $type)
                                <tr style="background: #fcfdff; box-shadow: 0 4px 12px rgba(0,0,0,.06); border-radius: 12px; margin-bottom: 8px;">
                                    <td style="padding: 12px; color: #374151; font-weight: 600;">{{ $type['type'] }}</td>
                                    <td style="padding: 12px;"><span class="badge badge-soft-purple">{{ $type['distribution_days'] }} يوم</span></td>
                                    <td style="padding: 12px;"><span class="badge badge-success-custom">{{ number_format($type['count']) }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================= الموزعين المسوقين ======================= --}}
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="dashboard-table-card">
                <div class="table-card-header">
                    <div class="table-card-title-wrapper">
                        <div class="table-card-icon">
                            <i class="la la-users"></i>
                        </div>
                        <div>
                            <h5 class="table-card-title">الموزعين المسوقين</h5>
                            <p class="text-muted small mb-0" style="color: #6b7280; font-size: 13px; margin-top: 4px;">عدد المشتركين الذين اشتركوا من خلال كل موزع (الموزع المسوق)</p>
                        </div>
                    </div>
                </div>
                <div class="table-card-body">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-clean align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">اسم الموزع</th>
                                    <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">إجمالي المشتركين</th>
                                    <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">المشتركين النشطين</th>
                                    <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">النسبة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($marketingDistributors as $distributor)
                                <tr style="background: #fcfdff; box-shadow: 0 4px 12px rgba(0,0,0,.06); border-radius: 12px; margin-bottom: 8px;">
                                    <td style="padding: 12px;">
                                        <a href="{{ backpack_url('distributor/' . $distributor['id']) }}" class="text-decoration-none fw-bold" style="color: #6f6af8;">
                                            {{ $distributor['name'] }}
                                        </a>
                                    </td>
                                    <td style="padding: 12px;"><span class="badge badge-soft-purple">{{ number_format($distributor['total_clients']) }}</span></td>
                                    <td style="padding: 12px;"><span class="badge badge-success-custom">{{ number_format($distributor['active_clients']) }}</span></td>
                                    <td style="padding: 12px;">
                                        <div class="progress" style="height: 20px; border-radius: 10px;">
                                            <div class="progress-bar" role="progressbar" 
                                                 style="width: {{ ($distributor['total_clients'] / max($generalStats['total_clients'], 1)) * 100 }}%; background: linear-gradient(135deg, #6f6af8, #7c7cff); border-radius: 10px;">
                                                {{ number_format(($distributor['total_clients'] / max($generalStats['total_clients'], 1)) * 100, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted" style="padding: 20px;">لا توجد بيانات للموزعين المسوقين</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================= إحصائيات القوارير ======================= --}}
    <div class="row g-4">
        <div class="col-12">
            <div class="dashboard-table-card">
                <div class="table-card-header">
                    <div class="table-card-title-wrapper">
                        <div class="table-card-icon">
                            <i class="la la-box"></i>
                        </div>
                        <h5 class="table-card-title">إحصائيات القوارير</h5>
                    </div>
                </div>
                <div class="table-card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="dashboard-stat-card stat-card-danger">
                                <div class="stat-card-content">
                                    <div class="stat-icon-box icon-box-danger">
                                        <i class="la la-warehouse"></i>
                                    </div>
                                    <div class="stat-info">
                                        <h6 class="stat-label">مخزون المستودع</h6>
                                        <h3 class="stat-value">{{ number_format($bottlesStats['warehouse']) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dashboard-stat-card stat-card-green">
                                <div class="stat-card-content">
                                    <div class="stat-icon-box icon-box-green">
                                        <i class="la la-users"></i>
                                    </div>
                                    <div class="stat-info">
                                        <h6 class="stat-label">لدى الزبائن</h6>
                                        <h3 class="stat-value">{{ number_format($bottlesStats['with_customers']) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dashboard-stat-card stat-card-purple">
                                <div class="stat-card-content">
                                    <div class="stat-icon-box icon-box-purple">
                                        <i class="la la-calculator"></i>
                                    </div>
                                    <div class="stat-info">
                                        <h6 class="stat-label">الإجمالي</h6>
                                        <h3 class="stat-value">{{ number_format($bottlesStats['total']) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

{{-- ======================= CSS ======================= --}}
@push('after_styles')
<style>
    /* ===============================
       Unified Design System Styles
    =============================== */
    .filter-card {
        background: #ffffff !important;
        border-radius: 20px !important;
        border: none !important;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05) !important;
    }

    .dashboard-card-purple {
        background: linear-gradient(135deg, #f5f3ff, #ede9fe) !important;
        border-radius: 20px !important;
        border: none !important;
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.06) !important;
        transition: all 0.3s ease !important;
    }

    .dashboard-card-purple:hover {
        transform: translateY(-4px) !important;
        box-shadow: 0 12px 30px rgba(111, 106, 248, 0.15) !important;
    }

    .dashboard-card-green {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7) !important;
        border-radius: 20px !important;
        border: none !important;
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.06) !important;
        transition: all 0.3s ease !important;
    }

    .dashboard-card-green:hover {
        transform: translateY(-4px) !important;
        box-shadow: 0 12px 30px rgba(34, 197, 94, 0.15) !important;
    }

    .icon-box-purple {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-left: 15px;
        box-shadow: 0 8px 20px rgba(111, 106, 248, 0.3);
        background: linear-gradient(135deg, #6f6af8, #7c7cff);
    }

    .icon-box-green {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-left: 15px;
        box-shadow: 0 8px 20px rgba(34, 197, 94, 0.3);
        background: linear-gradient(135deg, #22c55e, #16a34a);
    }

    .table-clean {
        border-collapse: separate;
        border-spacing: 0 8px;
    }

    .table-clean thead th {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9) !important;
        border: none !important;
        font-weight: 700;
        color: #374151;
        padding: 12px;
        text-align: right;
    }

    .table-clean tbody tr {
        background: #fcfdff;
        box-shadow: 0 4px 12px rgba(0,0,0,.06);
        border-radius: 12px;
        margin-bottom: 8px;
    }

    .table-clean tbody td {
        border: none;
        padding: 12px;
        vertical-align: middle;
    }

    .table-clean tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,.1);
        transition: all 0.2s ease;
    }

    .table-responsive {
        border-radius: 12px;
    }

    .table-responsive::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .progress {
        border-radius: 10px;
        min-width: 60px;
        background: #e5e7eb;
    }

    .progress-bar {
        border-radius: 10px;
        font-size: 11px;
        line-height: 20px;
        font-weight: 600;
    }

    /* تحسين ارتفاع الرسوم البيانية */
    .filter-card canvas {
        max-height: 200px !important;
    }

    /* ============================================
       Dashboard Stat Cards - Unified Design
       ============================================ */
    .dashboard-stat-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 28px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        overflow: hidden;
        position: relative;
    }

    .dashboard-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%);
        transition: width 0.3s ease;
    }

    .stat-card-green::before {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .stat-card-danger::before {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .stat-card-danger:hover {
        box-shadow: 0 12px 30px rgba(239, 68, 68, 0.2);
    }

    .icon-box-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.25);
    }

    .dashboard-stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(111, 106, 248, 0.2);
    }

    .stat-card-green:hover {
        box-shadow: 0 12px 30px rgba(16, 185, 129, 0.2);
    }

    .stat-card-content {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .stat-icon-box {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(111, 106, 248, 0.25);
        flex-shrink: 0;
    }

    .icon-box-purple {
        background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%);
    }

    .icon-box-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);
    }

    .stat-icon-box i {
        font-size: 28px;
        color: #fff;
        font-weight: 900;
    }

    .stat-info {
        flex: 1;
    }

    .stat-label {
        font-size: 14px;
        font-weight: 600;
        color: #6b7280;
        margin: 0 0 8px 0;
        font-family: 'Cairo', sans-serif;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
        font-family: 'Cairo', sans-serif;
    }

    /* ============================================
       Dashboard Chart Cards
       ============================================ */
    .dashboard-chart-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 28px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 24px;
        height: 100%;
    }
    
    .row.g-4 > [class*="col-"] {
        margin-bottom: 24px;
    }
    
    .row.g-4 > [class*="col-"]:last-child {
        margin-bottom: 0;
    }

    .chart-card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e5e7eb;
    }

    .chart-card-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(111, 106, 248, 0.25);
    }

    .chart-card-icon i {
        font-size: 20px;
        color: #fff;
        font-weight: 900;
    }

    .chart-card-title {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
        font-family: 'Cairo', sans-serif;
    }

    .chart-card-body {
        position: relative;
        height: 200px;
    }

    .chart-card-body canvas {
        max-height: 200px;
    }

    /* ============================================
       Dashboard Table Card
       ============================================ */
    .dashboard-table-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 28px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .table-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e5e7eb;
    }

    .table-card-title-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .table-card-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(111, 106, 248, 0.25);
    }

    .table-card-icon i {
        font-size: 20px;
        color: #fff;
        font-weight: 900;
    }

    .table-card-title {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
        font-family: 'Cairo', sans-serif;
    }

    .table-card-body {
        overflow-x: auto;
    }
</style>
@endpush

{{-- ======================= JS ======================= --}}
@push('after_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// ===== التسليمات اليومية =====
@php
    $dailyLabels = $dailyDeliveries->map(function($item) {
        return \Carbon\Carbon::parse($item->date)->format('Y-m-d');
    })->values();
@endphp
new Chart(document.getElementById('dailyDeliveriesChart'), {
    type: 'line',
    data: {
        labels: @json($dailyLabels),
        datasets: [{
            label: 'عدد التسليمات',
            data: @json($dailyDeliveries->pluck('count')),
            borderColor: '#7c7cff',
            backgroundColor: 'rgba(124,124,255,0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// ===== التسليمات الشهرية =====
new Chart(document.getElementById('monthlyDeliveriesChart'), {
    type: 'bar',
    data: {
        labels: @json($monthlyDeliveries->pluck('month')),
        datasets: [{
            label: 'عدد التسليمات',
            data: @json($monthlyDeliveries->pluck('count')),
            backgroundColor: '#22c55e',
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// ===== المشتركين حسب حالة الالتزام =====
new Chart(document.getElementById('clientsByCommitmentChart'), {
    type: 'doughnut',
    data: {
        labels: @json(array_column($clientsByCommitment->toArray(), 'status')),
        datasets: [{
            data: @json(array_column($clientsByCommitment->toArray(), 'count')),
            backgroundColor: ['#22c55e', '#34d399', '#fbbf24', '#ef4444']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// ===== المشتركين حسب حالة الاشتراك =====
new Chart(document.getElementById('clientsBySubscriptionStatusChart'), {
    type: 'pie',
    data: {
        labels: @json(array_column($clientsBySubscriptionStatus->toArray(), 'status')),
        datasets: [{
            data: @json(array_column($clientsBySubscriptionStatus->toArray(), 'count')),
            backgroundColor: ['#7c7cff', '#34d399', '#fbbf24', '#ef4444', '#8b5cf6']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// ===== نمو المشتركين (الشهري) =====
new Chart(document.getElementById('clientGrowthChart'), {
    type: 'line',
    data: {
        labels: @json($clientGrowth->pluck('month')),
        datasets: [{
            label: 'عدد المشتركين الجدد',
            data: @json($clientGrowth->pluck('count')),
            borderColor: '#7c7cff',
            backgroundColor: 'rgba(124,124,255,0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// ===== مقارنة الموزعين =====
@php
    $distributorLabels = $distributorPerformance->pluck('name')->take(10);
    $distributorDeliveries = $distributorPerformance->pluck('deliveries_count')->take(10);
    $distributorPayments = $distributorPerformance->map(function($d) {
        return $d->total_payment ?? 0;
    })->take(10);
@endphp
new Chart(document.getElementById('distributorComparisonChart'), {
    type: 'bar',
    data: {
        labels: @json($distributorLabels),
        datasets: [{
            label: 'عدد التسليمات',
            data: @json($distributorDeliveries),
            backgroundColor: '#7c7cff',
            borderRadius: 8
        }, {
            label: 'إجمالي الدفعات (بالآلاف)',
            data: @json($distributorPayments->map(function($p) { return round($p / 1000, 1); })),
            backgroundColor: '#22c55e',
            borderRadius: 8,
            yAxisID: 'y1'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                position: 'left',
                title: {
                    display: true,
                    text: 'عدد التسليمات'
                }
            },
            y1: {
                beginAtZero: true,
                position: 'right',
                title: {
                    display: true,
                    text: 'إجمالي الدفعات (بالآلاف)'
                },
                grid: {
                    drawOnChartArea: false
                }
            }
        }
    }
});
</script>
@endpush

