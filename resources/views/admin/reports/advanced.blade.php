@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    <style>
        /* ===============================
           Advanced Reports Page - تحسين صفحة التقارير المتقدمة
        =============================== */
        
        .advanced-reports-container {
            background: var(--bg-light);
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        /* Header Section */
        .reports-header {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%) !important;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg) !important;
            position: relative;
            overflow: hidden;
        }
        
        .reports-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            z-index: 0;
        }
        
        .reports-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            z-index: 0;
        }
        
        .reports-header-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .reports-header-icon {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 18px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 1rem;
        }
        
        .reports-header-icon i {
            font-size: 32px;
            color: #fff;
            font-weight: 900;
        }
        
        .reports-header-title {
            color: #fff;
            font-size: 28px;
            font-weight: 900;
            margin: 0;
            font-family: 'Cairo', sans-serif;
        }
        
        .reports-header-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        
        .btn-export {
            background: rgba(255, 255, 255, 0.95) !important;
            color: var(--primary-deep) !important;
            font-weight: 700 !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            border: none !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }
        
        .btn-export:hover {
            background: #fff !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15) !important;
        }
        
        /* Filter Card */
        .filter-card-modern {
            background: #fff;
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            border: none;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        .filter-card-header {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%);
            padding: 1.25rem 2rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .filter-card-header i {
            font-size: 22px;
            color: #fff;
        }
        
        .filter-card-header h6 {
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }
        
        .filter-card-body {
            padding: 2rem;
        }
        
        .form-label-modern {
            font-weight: 700;
            color: var(--primary-deep);
            margin-bottom: 0.75rem;
            font-size: 14px;
        }
        
        .form-control-modern,
        .form-select-modern {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #fff;
        }
        
        .form-control-modern:focus,
        .form-select-modern:focus {
            border-color: var(--primary-deep);
            box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.1);
            outline: none;
        }
        
        .btn-filter-submit {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%) !important;
            color: #fff !important;
            font-weight: 700 !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            border: none !important;
            height: 48px;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 12px rgba(30, 58, 95, 0.3) !important;
        }
        
        .btn-filter-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 58, 95, 0.4) !important;
        }
        
        /* Statistics Cards */
        .stat-card-modern {
            background: #fff;
            border-radius: 18px;
            padding: 1.75rem;
            box-shadow: var(--shadow-md);
            border: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            height: 100%;
        }
        
        .stat-card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-deep);
        }
        
        .stat-card-modern.stat-card-success::before {
            background: var(--success-gradient);
        }
        
        .stat-card-modern:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }
        
        .stat-card-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%);
        }
        
        .stat-card-icon.stat-icon-success {
            background: linear-gradient(135deg, var(--success-gradient) 0%, #10b981 100%);
        }
        
        .stat-card-icon i {
            font-size: 24px;
            color: #fff;
        }
        
        .stat-card-label {
            font-size: 14px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .stat-card-value {
            font-size: 32px;
            font-weight: 900;
            color: var(--primary-deep);
            margin: 0;
            font-family: 'Cairo', sans-serif;
        }
        
        .stat-card-modern.stat-card-success .stat-card-value {
            color: var(--success-gradient);
        }

        .bottle-balance-cell {
            min-width: 150px;
        }

        .bottle-balance-value {
            color: var(--primary-deep);
            font-size: 1.5rem;
            font-weight: 800;
            line-height: 1.2;
        }

        .bottle-balance-formula {
            margin-top: 0.35rem;
            padding: 0.35rem 0.5rem;
            background: #f1f5f9;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            color: #334155;
        }

        .bottle-balance-hint {
            margin-top: 0.35rem;
            font-size: 11px;
            color: #64748b;
        }

        .bottle-summary-panel .stat-card-value {
            font-size: 2.25rem;
        }
        
        /* Chart Cards */
        .chart-card-modern {
            background: #fff;
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            border: none;
            overflow: hidden;
            height: 100%;
        }
        
        .chart-card-header-modern {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .chart-card-icon-modern {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .chart-card-icon-modern i {
            font-size: 22px;
            color: #fff;
        }
        
        .chart-card-title-modern {
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }
        
        .chart-card-body-modern {
            padding: 1.5rem;
            min-height: 300px;
        }
        
        .chart-card-body-modern canvas {
            max-height: 300px !important;
        }
        
        /* Table Card */
        .table-card-modern {
            background: #fff;
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            border: none;
            overflow: hidden;
        }
        
        .table-card-header-modern {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .table-card-header-modern i {
            font-size: 22px;
            color: #fff;
        }
        
        .table-card-header-modern h5 {
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }
        
        .table-modern {
            margin: 0;
        }
        
        .table-modern thead {
            background: var(--bg-light);
        }
        
        .table-modern thead th {
            font-weight: 700;
            color: var(--primary-deep);
            padding: 1rem;
            border-bottom: 2px solid #e2e8f0;
            font-size: 14px;
        }
        
        .table-modern tbody td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }
        
        .table-modern tbody tr:hover {
            background: var(--bg-light);
        }
        
        .badge-modern {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
        }
        
        .badge-primary-modern {
            background: var(--primary-deep) !important;
            color: #fff !important;
        }
        
        .badge-success-modern {
            background: var(--success-gradient) !important;
            color: #fff !important;
        }
        
        .badge-warning-modern {
            background: var(--warning-color) !important;
            color: #fff !important;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .reports-header {
                padding: 1.5rem;
            }
            
            .reports-header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .reports-header-actions {
                width: 100%;
                justify-content: flex-start;
            }
            
            .filter-card-body {
                padding: 1.5rem;
            }
        }
    </style>
@endsection

@extends(backpack_view('blank'))

@section('content')
<div class="advanced-reports-container">
    <div class="container-fluid pb-4">

        {{-- ===============================
            Header - Modern Design
        =============================== --}}
        <section class="reports-header">
            <div class="reports-header-content">
                <div style="display: flex; align-items: center;">
                    <div class="reports-header-icon">
                        <i class="la la-chart-bar"></i>
                    </div>
                    <h1 class="reports-header-title">التقارير المتقدمة</h1>
                </div>
                <div class="reports-header-actions">
                    <a href="{{ route('reports.advanced.export.excel', request()->all()) }}" class="btn btn-export">
                        <i class="la la-file-excel"></i> Excel
                    </a>
                    <a href="{{ route('reports.advanced.export.pdf', request()->all()) }}" class="btn btn-export">
                        <i class="la la-file-pdf"></i> PDF
                    </a>
                </div>
            </div>
        </section>

        {{-- ======================= فلاتر الفترة الزمنية ======================= --}}
        <div class="filter-card-modern">
            <div class="filter-card-header">
                <i class="la la-filter"></i>
                <h6>فلاتر البحث</h6>
            </div>
            <div class="filter-card-body">
                <form method="GET" class="row g-3 g-md-4 filter-form-rtl">
                    <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <label class="form-label-modern">الفترة</label>
                        <select name="period" class="form-select form-select-modern w-100">
                            <option value="day" @selected($period == 'day')>يومي</option>
                            <option value="week" @selected($period == 'week')>أسبوعي</option>
                            <option value="month" @selected($period == 'month')>شهري</option>
                            <option value="year" @selected($period == 'year')>سنوي</option>
                            <option value="custom" @selected($period == 'custom')>مخصص</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <label class="form-label-modern">من تاريخ</label>
                        <input type="date" name="date_from" class="form-control form-control-modern w-100" value="{{ $dateFrom ?? $startDate->format('Y-m-d') }}">
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <label class="form-label-modern">إلى تاريخ</label>
                        <input type="date" name="date_to" class="form-control form-control-modern w-100" value="{{ $dateTo ?? $endDate->format('Y-m-d') }}">
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <label class="form-label-modern">المدينة</label>
                        <select name="city_id" class="form-select form-select-modern w-100">
                            <option value="">الكل</option>
                            @foreach($cities as $city)
                            <option value="{{ $city->id }}" @selected($cityId == $city->id)>{{ $city->city_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <label class="form-label-modern">الموزع</label>
                        <select name="distributor_id" class="form-select form-select-modern w-100">
                            <option value="">الكل</option>
                            @foreach($distributors as $distributor)
                            <option value="{{ $distributor->id }}" @selected($distributorId == $distributor->id)>{{ $distributor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-filter-submit w-100">
                            <i class="la la-search"></i> تحديث
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ======================= الإحصائيات العامة ======================= --}}
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stat-card-modern">
                    <div class="stat-card-icon">
                        <i class="la la-users"></i>
                    </div>
                    <div class="stat-card-label">إجمالي المشتركين</div>
                    <h3 class="stat-card-value">{{ number_format($generalStats['total_clients']) }}</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card-modern stat-card-success">
                    <div class="stat-card-icon stat-icon-success">
                        <i class="la la-check-circle"></i>
                    </div>
                    <div class="stat-card-label">المشتركين النشطين</div>
                    <h3 class="stat-card-value">{{ number_format($generalStats['active_clients']) }}</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card-modern">
                    <div class="stat-card-icon">
                        <i class="la la-truck"></i>
                    </div>
                    <div class="stat-card-label">التسليمات في الفترة</div>
                    <h3 class="stat-card-value">{{ number_format($generalStats['deliveries_in_period']) }}</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card-modern stat-card-success">
                    <div class="stat-card-icon stat-icon-success">
                        <i class="la la-calendar-check"></i>
                    </div>
                    <div class="stat-card-label">المشتركين المستحقين</div>
                    <h3 class="stat-card-value">{{ number_format($clientsDueCount) }}</h3>
                </div>
            </div>
        </div>

        {{-- ======================= ملخص رصيد القوارير (كل المشتركين المفلترين) ======================= --}}
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stat-card-modern h-100 text-center bottle-summary-panel">
                    <div class="stat-card-icon mx-auto"><i class="la la-wine-bottle"></i></div>
                    <div class="stat-card-label">إجمالي رصيد القوارير عند المشتركين</div>
                    <p class="stat-card-value mb-2">{{ (int) ($bottleBalanceSummary['bottle_balance'] ?? 0) }}</p>
                    <p class="mb-0 small fw-bold text-muted px-2 py-2" style="background: #f1f5f9; border-radius: 12px;">
                        {{ (int) ($bottleBalanceSummary['total_bottle_received'] ?? 0) }}
                        <span class="opacity-75">−</span>
                        {{ (int) ($bottleBalanceSummary['total_bottle_empty'] ?? 0) }}
                        <span class="opacity-75">=</span>
                        {{ (int) ($bottleBalanceSummary['bottle_balance'] ?? 0) }}
                    </p>
                    <p class="small text-muted mb-0 mt-2">
                        {{ (int) ($bottleBalanceSummary['family_count'] ?? 0) }} ملف عائلة
                        · {{ (int) ($bottleBalanceSummary['client_count'] ?? 0) }} مشترك
                    </p>
                    <p class="small text-muted mb-0 mt-1">ممتلئة − فارغة (كل التسليمات)</p>
                </div>
            </div>
        </div>

        {{-- ======================= رصيد القوارير لكل مشترك ======================= --}}
        <div class="table-card-modern mb-4">
            <div class="table-card-header-modern">
                <i class="la la-wine-bottle"></i>
                <h5>رصيد القوارير عند المشتركين</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th>اسم المشترك</th>
                            <th>المدينة</th>
                            <th>الموزع</th>
                            <th class="text-center">رصيد القوارير عنده</th>
                            <th class="text-center">إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientsWithBottleBalance as $clientRow)
                            @php
                                $snapshot = $bottleSnapshotsByClientId[$clientRow->id] ?? [
                                    'total_bottle_received' => 0,
                                    'total_bottle_empty' => 0,
                                    'bottle_balance' => 0,
                                ];
                            @endphp
                            <tr>
                                <td class="fw-bold" style="color: var(--primary-deep);">{{ $clientRow->name }}</td>
                                <td>{{ $clientRow->city->city_name ?? '—' }}</td>
                                <td>{{ $clientRow->distributor->name ?? '—' }}</td>
                                <td>
                                    @include('admin.reports.partials.bottle_balance_cell', ['snapshot' => $snapshot])
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('client.report', ['client_id' => $clientRow->id]) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 10px;">
                                        <i class="la la-list"></i> التسليمات
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="la la-inbox" style="font-size: 48px; opacity: 0.3;"></i>
                                    <p class="mt-3 mb-0">لا يوجد مشتركون مطابقون للفلاتر</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($clientsWithBottleBalance->hasPages())
                <div class="p-3 border-top">
                    {{ $clientsWithBottleBalance->links() }}
                </div>
            @endif
        </div>

        {{-- ======================= الرسوم البيانية ======================= --}}
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="chart-card-modern">
                    <div class="chart-card-header-modern">
                        <div class="chart-card-icon-modern">
                            <i class="la la-chart-line"></i>
                        </div>
                        <h5 class="chart-card-title-modern">التسليمات اليومية</h5>
                    </div>
                    <div class="chart-card-body-modern">
                        <canvas id="dailyDeliveriesChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="chart-card-modern">
                    <div class="chart-card-header-modern">
                        <div class="chart-card-icon-modern">
                            <i class="la la-chart-bar"></i>
                        </div>
                        <h5 class="chart-card-title-modern">التسليمات الشهرية</h5>
                    </div>
                    <div class="chart-card-body-modern">
                        <canvas id="monthlyDeliveriesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- ======================= أداء الموزعين ======================= --}}
        <div class="table-card-modern">
            <div class="table-card-header-modern">
                <i class="la la-user-tie"></i>
                <h5>أداء الموزعين</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
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
                            <td class="fw-bold" style="color: var(--primary-deep);">{{ $distributor->name }}</td>
                            <td><span class="badge badge-modern badge-primary-modern">{{ number_format($distributor->deliveries_count) }}</span></td>
                            <td><span class="badge badge-modern badge-success-modern">{{ number_format($distributor->total_bottles_received) }}</span></td>
                            <td><span class="badge badge-modern badge-warning-modern">{{ number_format($distributor->total_bottles_empty) }}</span></td>
                            <td class="fw-bold" style="color: var(--primary-deep); font-size: 16px;">₪ {{ number_format($distributor->total_payment ?? 0) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="la la-inbox" style="font-size: 48px; opacity: 0.3;"></i>
                                <p class="mt-3 mb-0">لا توجد بيانات متاحة</p>
                            </td>
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
const primaryGradient = 'linear-gradient(135deg, #1e3a5f 0%, #2d4a6b 100%)';

// Daily Deliveries Chart
const dailyCtx = document.getElementById('dailyDeliveriesChart');
new Chart(dailyCtx, {
    type: 'line',
    data: {
        labels: @json($dailyDeliveries->pluck('date')),
        datasets: [{
            label: 'عدد التسليمات',
            data: @json($dailyDeliveries->pluck('count')),
            borderColor: primaryColor,
            backgroundColor: 'rgba(30, 58, 95, 0.1)',
            borderWidth: 3,
            tension: 0.4,
            fill: true,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: primaryColor,
            pointBorderColor: '#fff',
            pointBorderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    font: {
                        family: 'Cairo',
                        size: 14,
                        weight: 'bold'
                    },
                    color: primaryColor
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    font: {
                        family: 'Cairo',
                        size: 12
                    }
                },
                grid: {
                    color: '#f1f5f9'
                }
            },
            x: {
                ticks: {
                    font: {
                        family: 'Cairo',
                        size: 12
                    }
                },
                grid: {
                    display: false
                }
            }
        }
    }
});

// Monthly Deliveries Chart
const monthlyCtx = document.getElementById('monthlyDeliveriesChart');
new Chart(monthlyCtx, {
    type: 'bar',
    data: {
        labels: @json($monthlyDeliveries->pluck('month')),
        datasets: [{
            label: 'عدد التسليمات',
            data: @json($monthlyDeliveries->pluck('count')),
            backgroundColor: successColor,
            borderRadius: 8,
            borderSkipped: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    font: {
                        family: 'Cairo',
                        size: 14,
                        weight: 'bold'
                    },
                    color: primaryColor
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    font: {
                        family: 'Cairo',
                        size: 12
                    }
                },
                grid: {
                    color: '#f1f5f9'
                }
            },
            x: {
                ticks: {
                    font: {
                        family: 'Cairo',
                        size: 12
                    }
                },
                grid: {
                    display: false
                }
            }
        }
    }
});
</script>
@endpush
