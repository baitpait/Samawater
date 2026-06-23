@extends(backpack_view('blank'))

@php
    $isDistributor = backpack_user()?->isDistributor() ?? false;
@endphp

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header" style="background: var(--primary-deep); border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 2rem; box-shadow: var(--shadow-md); width: 100%; display: flex; align-items: center; justify-content: space-between; position: relative; overflow: visible;">
        <div style="display: flex; align-items: center; gap: 1rem; position: relative; z-index: 1;">
            <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.1); border-radius: 16px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                <i class="la la-home" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
            </div>
            <div>
                <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 700; margin: 0; font-family: 'Cairo', sans-serif;">لوحة التحكم</h1>
                <p style="color: rgba(255,255,255,0.7); margin: 0; font-size: 14px;">مرحباً بك في نظام مياه سما 💧</p>
            </div>
        </div>
    </section>
@endsection

@section('content')
<div class="container-fluid py-4">

@if ($isDistributor)
    <div class="row g-4">
        <div class="col-md-4">
            <a href="{{ route('reports.filters') }}" class="text-decoration-none">
                <div class="dashboard-stat-card stat-card-purple">
                    <div class="stat-card-content">
                        <div class="stat-icon-box icon-box-purple">
                            <i class="la la-users"></i>
                        </div>
                        <div class="stat-info">
                            <h6 class="stat-label">المشتركين</h6>
                            <h3 class="stat-value">عرض القائمة</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('delivery.list') }}" class="text-decoration-none">
                <div class="dashboard-stat-card stat-card-green">
                    <div class="stat-card-content">
                        <div class="stat-icon-box icon-box-green">
                            <i class="la la-truck"></i>
                        </div>
                        <div class="stat-info">
                            <h6 class="stat-label">قائمة التسليم</h6>
                            <h3 class="stat-value">عرض القائمة</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('reports.clients_delivery_overview') }}" class="text-decoration-none">
                <div class="dashboard-stat-card stat-card-purple">
                    <div class="stat-card-content">
                        <div class="stat-icon-box icon-box-purple">
                            <i class="la la-list"></i>
                        </div>
                        <div class="stat-info">
                            <h6 class="stat-label">التسليمات</h6>
                            <h3 class="stat-value">عرض القائمة</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
@else

    @php
        $dash = $ownerDashboard ?? [];
        $hero = $dash['hero'] ?? [];
        $totals = $dash['totals'] ?? [];
        $bottles = $dash['bottles'] ?? [];
        $alerts = $dash['alerts'] ?? [];
        $clientStatusStats = $dash['client_status_stats'] ?? [];
        $subscriptionStatusStats = $dash['subscription_status_stats'] ?? [];
        $cityChart = $dash['city_chart'] ?? ['labels' => [], 'values' => []];
        $labelsCities = $cityChart['labels'] ?? [];
        $valuesCities = $cityChart['values'] ?? [];
        $clientsReceivedToday = $dash['deliveries_today_rows'] ?? collect();
        $deliveriesThisMonth = (int) ($totals['deliveries_this_month'] ?? 0);
        $deliveriesLastMonth = (int) ($totals['deliveries_last_month'] ?? 0);
        $totalClients = (int) ($totals['total_clients'] ?? 0);
        $activeClients = (int) ($totals['active_clients'] ?? 0);
        $overallEmpty = (int) ($totals['warehouse_inventory'] ?? 0);
        $todayStr = today()->format('Y-m-d');
    @endphp

    {{-- ======================= مؤشرات المالك الرئيسية ======================= --}}
    <div class="row g-4 mb-2">
        <div class="col-md-3">
            <a href="{{ route('reports.clients_delivery_overview') }}?search=1&from={{ $todayStr }}&to={{ $todayStr }}" class="text-decoration-none">
                <div class="dashboard-stat-card stat-card-purple dashboard-hero-card">
                    <div class="stat-card-content">
                        <div class="stat-icon-box icon-box-purple"><i class="la la-truck"></i></div>
                        <div class="stat-info">
                            <h6 class="stat-label">التسليمات اليوم</h6>
                            <h3 class="stat-value">{{ number_format((int) ($hero['deliveries_today'] ?? 0)) }}</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ backpack_url('client-payment?date_from='.$todayStr.'&date_to='.$todayStr) }}" class="text-decoration-none">
                <div class="dashboard-stat-card stat-card-green dashboard-hero-card">
                    <div class="stat-card-content">
                        <div class="stat-icon-box icon-box-green"><i class="la la-money-bill-wave"></i></div>
                        <div class="stat-info">
                            <h6 class="stat-label">الكاش اليوم</h6>
                            <h3 class="stat-value">₪ {{ number_format((float) ($hero['cash_today'] ?? 0), 0) }}</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('reports.treasury-custody') }}" class="text-decoration-none">
                <div class="dashboard-stat-card stat-card-purple dashboard-hero-card">
                    <div class="stat-card-content">
                        <div class="stat-icon-box icon-box-purple"><i class="la la-hand-holding-usd"></i></div>
                        <div class="stat-info">
                            <h6 class="stat-label">العهدة لدى الموزعين</h6>
                            <h3 class="stat-value">₪ {{ number_format((float) ($hero['custody_now'] ?? 0), 0) }}</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ backpack_url('clients-due') }}" class="text-decoration-none">
                <div class="dashboard-stat-card stat-card-green dashboard-hero-card">
                    <div class="stat-card-content">
                        <div class="stat-icon-box icon-box-green"><i class="la la-calendar-check"></i></div>
                        <div class="stat-info">
                            <h6 class="stat-label">المستحقون للتوزيع</h6>
                            <h3 class="stat-value">{{ number_format((int) ($hero['dues_count'] ?? 0)) }}</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    @if((int) ($alerts['unpaid_expenses_count'] ?? 0) > 0)
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="alert alert-warning border-0 mb-0" style="border-radius: 16px;">
                <div class="fw-bold mb-2"><i class="la la-exclamation-triangle"></i> تنبيهات</div>
                <ul class="mb-0 ps-3">
                    <li>
                        {{ number_format((int) $alerts['unpaid_expenses_count']) }} مصروف غير مدفوع
                        — <a href="{{ backpack_url('expense?payment_status=unpaid') }}">عرض</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @endif

    {{-- ======================= الكــروت ======================= --}}
    <div class="row g-4">

        <div class="col-md-3">
            <div class="dashboard-stat-card stat-card-purple">
                <div class="stat-card-content">
                    <div class="stat-icon-box icon-box-purple">
                        <i class="la la-users"></i>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">إجمالي العملاء</h6>
                        <h3 class="stat-value">{{ number_format($totalClients) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-stat-card stat-card-green">
                <div class="stat-card-content">
                    <div class="stat-icon-box icon-box-green">
                        <i class="la la-truck"></i>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">تسليمات الشهر</h6>
                        <h3 class="stat-value">{{ number_format($deliveriesThisMonth) }}</h3>
                        @if($deliveriesLastMonth > 0)
                            <div class="stat-trend">
                                @if($deliveriesThisMonth > $deliveriesLastMonth)
                                    <span class="trend-up">↑ {{ round((($deliveriesThisMonth - $deliveriesLastMonth) / $deliveriesLastMonth) * 100) }}%</span>
                                @else
                                    <span class="trend-down">↓ {{ round((($deliveriesLastMonth - $deliveriesThisMonth) / $deliveriesLastMonth) * 100) }}%</span>
                                @endif
                            </div>
                        @endif
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
                        <h6 class="stat-label">العملاء النشطين</h6>
                        <h3 class="stat-value">{{ number_format($activeClients) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-stat-card stat-card-purple">
                <div class="stat-card-content">
                    <div class="stat-icon-box icon-box-purple">
                        <i class="la la-warehouse"></i>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">كمية المخزون</h6>
                        <h3 class="stat-value">{{ number_format($overallEmpty) }}</h3>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ======================= العملاء الذين استلموا اليوم ======================= --}}
    @if($clientsReceivedToday->count() > 0)
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="dashboard-table-card">
                <div class="table-card-header">
                    <div class="table-card-title-wrapper">
                        <div class="table-card-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                            <i class="la la-check-circle"></i>
                        </div>
                        <h5 class="table-card-title">تسليمات اليوم</h5>
                    </div>
                    <a href="{{ route('reports.clients_delivery_overview') }}?from={{ today()->format('Y-m-d') }}&to={{ today()->format('Y-m-d') }}" class="btn-view-all">
                        <i class="la la-list"></i>
                        <span>عرض الكل</span>
                    </a>
                </div>
                <div class="table-card-body">
                    <div class="table-responsive">
                        <table class="dashboard-table">
                            <thead>
                                <tr>
                                    <th>اسم العميل</th>
                                    <th>الهاتف</th>
                                    <th>المدينة</th>
                                    <th>تاريخ التسليم</th>
                                    <th>الموزع</th>
                                    <th>قوارير مستلمة</th>
                                    <th>قوارير فارغة</th>
                                    <th>رصيد العائلة</th>
                                    <th>إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clientsReceivedToday as $delivery)
                                <tr>
                                    <td>{{ $delivery->client->name ?? '-' }}</td>
                                    <td>{{ $delivery->client->phone_one ?? '-' }}</td>
                                    <td>{{ $delivery->client->city->city_name ?? '-' }}</td>
                                    <td>
                                        <span class="badge-success-custom">{{ \Carbon\Carbon::parse($delivery->delivery_date)->format('Y-m-d') }}</span>
                                    </td>
                                    <td>{{ $delivery->distributor->name ?? '-' }}</td>
                                    <td>
                                        <span class="badge-success-custom">{{ number_format($delivery->bottle_received ?? 0) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge-warning-custom">{{ number_format($delivery->bottle_empty ?? 0) }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $clientModel = $delivery->client;
                                            $balance = $clientModel
                                                ? (int) ($clientModel->familyBottleBalanceFromDeliveries()['bottle_balance'] ?? 0)
                                                : 0;
                                            $balanceClass = $balance > 0 ? 'badge-balance-positive' : ($balance < 0 ? 'badge-balance-negative' : 'badge-balance-zero');
                                        @endphp
                                        <span class="{{ $balanceClass }}">{{ number_format($balance) }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ backpack_url('client/' . $delivery->client_id . '/show') }}" class="btn-view-client" title="عرض ملف العميل">
                                            <i class="la la-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ======================= الرسوم البيانية ======================= --}}
    <div class="row mt-4 g-4">
        <div class="col-md-6">
            <div class="dashboard-chart-card">
                <div class="chart-card-header">
                    <div class="chart-card-icon">
                        <i class="la la-box"></i>
                    </div>
                    <h5 class="chart-card-title">القوارير</h5>
                </div>
                <div class="chart-card-body">
                    <canvas id="overallBottlesChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="dashboard-chart-card">
                <div class="chart-card-header">
                    <div class="chart-card-icon">
                        <i class="la la-map-marker"></i>
                    </div>
                    <h5 class="chart-card-title">توزيع العملاء حسب المدن</h5>
                </div>
                <div class="chart-card-body">
                    <canvas id="cityPieChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="dashboard-chart-card">
                <div class="chart-card-header">
                    <div class="chart-card-icon">
                        <i class="la la-chart-bar"></i>
                    </div>
                    <h5 class="chart-card-title">العملاء حسب حالة الالتزام</h5>
                </div>
                <div class="chart-card-body">
                    <canvas id="clientStatusChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="dashboard-chart-card">
                <div class="chart-card-header">
                    <div class="chart-card-icon">
                        <i class="la la-chart-line"></i>
                    </div>
                    <h5 class="chart-card-title">العملاء حسب حالة الاشتراك</h5>
                </div>
                <div class="chart-card-body">
                    <canvas id="subscriptionStatusChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

@endif

</div>
@endsection

@section('after_styles')
<link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">
<style>
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
        background: var(--primary-deep);
        transition: width 0.3s ease;
    }

    .stat-card-green::before {
        background: var(--success-gradient);
    }

    .dashboard-stat-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg) !important;
    }

    .dashboard-hero-card .stat-value {
        font-size: 2rem;
    }

    .stat-card-green:hover {
        box-shadow: var(--shadow-lg) !important;
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
        box-shadow: var(--shadow-sm);
        flex-shrink: 0;
    }

    .icon-box-purple {
        background: var(--primary-deep);
    }

    .icon-box-green {
        background: var(--success-gradient);
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

    .stat-trend {
        margin-top: 8px;
        font-size: 12px;
        font-weight: 600;
    }

    .trend-up {
        color: #10b981;
    }

    .trend-down {
        color: #ef4444;
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
        background: var(--primary-deep);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-sm);
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

    .btn-view-all {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        background: var(--primary-deep);
        color: #fff;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: var(--shadow-sm);
        font-family: 'Cairo', sans-serif;
    }

    .btn-view-all:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: #fff;
        text-decoration: none;
        background: #254a7a;
    }

    .table-card-body {
        overflow-x: auto;
    }

    .dashboard-table {
        width: 100%;
        border-collapse: collapse;
    }

    .dashboard-table thead th {
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        padding: 16px 20px;
        text-align: right;
        font-weight: 700;
        font-size: 14px;
        color: #374151;
        border-bottom: 2px solid #e5e7eb;
        font-family: 'Cairo', sans-serif;
    }

    .dashboard-table tbody tr {
        border-bottom: 1px solid #e5e7eb;
        transition: background 0.2s ease;
    }

    .dashboard-table tbody tr:hover {
        background: #f9fafb;
    }

    .dashboard-table tbody td {
        padding: 16px 20px;
        font-size: 14px;
        color: #1f2937;
        font-family: 'Cairo', sans-serif;
    }

    .badge-danger-custom {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 12px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.25);
    }

    .badge-warning-custom {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 12px;
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: #fff;
        box-shadow: 0 2px 8px rgba(251, 191, 36, 0.25);
    }

    .badge-success-custom {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 12px;
        background: var(--success-gradient);
        color: #fff;
        box-shadow: var(--shadow-sm);
    }

    .badge-info-custom {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 12px;
        background: var(--primary-deep);
        color: #fff;
        box-shadow: var(--shadow-sm);
    }

    .badge-balance-positive {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 12px;
        background: var(--primary-deep);
        color: #fff;
        box-shadow: var(--shadow-sm);
    }

    .badge-balance-negative {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 12px;
        background: var(--danger-color);
        color: #fff;
        box-shadow: var(--shadow-sm);
    }

    .badge-balance-zero {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 12px;
        background: #64748b;
        color: #fff;
        box-shadow: var(--shadow-sm);
    }

    .btn-view-client {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        background: var(--primary-deep);
        color: #fff;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: var(--shadow-sm);
        font-family: 'Cairo', sans-serif;
    }
    
    .btn-view-client i {
        font-size: 17px;
        font-weight: 700;
    }

    .btn-view-client:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: #fff;
        text-decoration: none;
        background: #254a7a;
    }

    .badge-success-custom {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 12px;
        background: var(--success-gradient);
        color: #fff;
        box-shadow: var(--shadow-sm);
    }

    .badge-info-custom {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 12px;
        background: var(--primary-deep);
        color: #fff;
        box-shadow: var(--shadow-sm);
    }

    .badge-balance-positive {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 12px;
        background: var(--primary-deep);
        color: #fff;
        box-shadow: var(--shadow-sm);
    }

    .badge-balance-negative {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 12px;
        background: var(--danger-color);
        color: #fff;
        box-shadow: var(--shadow-sm);
    }

    .badge-balance-zero {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 12px;
        background: #64748b;
        color: #fff;
        box-shadow: var(--shadow-sm);
    }

    .btn-view-client {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        background: var(--primary-deep);
        color: #fff;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: var(--shadow-sm);
        font-family: 'Cairo', sans-serif;
    }
    
    .btn-view-client i {
        font-size: 17px;
        font-weight: 700;
    }

    .btn-view-client:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: #fff;
        text-decoration: none;
        background: #254a7a;
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
        background: var(--primary-deep);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-sm);
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
        height: 250px;
    }

    .chart-card-body canvas {
        max-height: 250px;
    }

    /* ============================================
       Responsive
       ============================================ */
    @media (max-width: 768px) {
        .dashboard-stat-card {
            padding: 20px;
        }

        .stat-icon-box {
            width: 56px;
            height: 56px;
        }

        .stat-icon-box i {
            font-size: 24px;
        }

        .stat-value {
            font-size: 28px;
        }

        .dashboard-table-card,
        .dashboard-chart-card {
            padding: 20px;
        }

        .table-card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }
    }
</style>
@endsection

@section('after_scripts')
@if (! $isDistributor)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// ===== رسم بياني للقوارير =====
new Chart(document.getElementById('overallBottlesChart'), {
    type: 'bar',
    data: {
        labels: ['مخزون الأصناف', 'قوارير عند الزبائن', 'أمانات عند الزبائن'],
        datasets: [{
            label: 'العدد',
            data: [{{ (int) ($bottles['warehouse'] ?? 0) }}, {{ (int) ($bottles['at_customers'] ?? 0) }}, {{ (int) ($bottles['on_loan'] ?? 0) }}],
            backgroundColor: ['#ef4444', '#059669', '#1e3a5f'],
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

// ===== رسم بياني لتوزيع العملاء حسب المدن =====
new Chart(document.getElementById('cityPieChart'), {
    type: 'pie',
    data: {
        labels: @json($labelsCities),
        datasets: [{
            data: @json($valuesCities),
            backgroundColor: ['#1e3a5f', '#059669', '#34d399', '#fbbf24', '#ef4444', '#64748b']
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

// ===== رسم بياني للعملاء حسب حالة الالتزام =====
new Chart(document.getElementById('clientStatusChart'), {
    type: 'doughnut',
    data: {
        labels: @json(array_column($clientStatusStats, 'name')),
        datasets: [{
            data: @json(array_column($clientStatusStats, 'count')),
            backgroundColor: @json(array_column($clientStatusStats, 'color'))
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

// ===== رسم بياني للعملاء حسب حالة الاشتراك =====
new Chart(document.getElementById('subscriptionStatusChart'), {
    type: 'bar',
    data: {
        labels: @json(array_column($subscriptionStatusStats, 'name')),
        datasets: [{
            label: 'عدد العملاء',
            data: @json(array_column($subscriptionStatusStats, 'count')),
            backgroundColor: '#1e3a5f',
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
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endif
@endsection
