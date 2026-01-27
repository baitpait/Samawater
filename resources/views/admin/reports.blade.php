@extends(backpack_view('blank'))

@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
@endsection

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header" style="background: var(--primary-deep) !important; border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 2rem; box-shadow: var(--shadow-md) !important; width: 100%; display: flex; align-items: center; justify-content: space-between; position: relative; overflow: visible;">
        <div style="display: flex; align-items: center; gap: 1rem; position: relative; z-index: 1;">
            <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.1); border-radius: 16px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                <i class="la la-chart-pie" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
            </div>
            <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 800; margin: 0; font-family: 'Cairo', sans-serif;">مركز التقارير</h1>
        </div>
    </section>
@endsection

@section('content')
<div class="container-fluid pb-4">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="dashboard-stat-card stat-card-purple">
                <div class="stat-card-content">
                    <div class="stat-icon-box" style="background: var(--primary-deep);">
                        <i class="la la-users"></i>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">إجمالي المشتركين</h6>
                        <h3 class="stat-value">{{ number_format(\App\Models\Client::count()) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="dashboard-stat-card stat-card-green">
                <div class="stat-card-content">
                    <div class="stat-icon-box" style="background: var(--success-gradient);">
                        <i class="la la-truck"></i>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">توزيعات اليوم</h6>
                        <h3 class="stat-value">{{ number_format(\App\Models\Delivery::whereDate('created_at', today())->count()) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="dashboard-stat-card stat-card-purple">
                <div class="stat-card-content">
                    <div class="stat-icon-box" style="background: var(--primary-deep);">
                        <i class="la la-user-tie"></i>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">عدد الموزعين</h6>
                        <h3 class="stat-value">{{ number_format(\App\Models\Distributor::count()) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary-deep text-white fw-bold p-3">
                    <i class="la la-list"></i> روابط التقارير المتاحة
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('reports.advanced') }}" class="list-group-item list-group-item-action p-4 d-flex align-items-center gap-3">
                            <div style="width: 40px; height: 40px; background: var(--bg-light); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary-deep);">
                                <i class="la la-chart-bar" style="font-size: 20px;"></i>
                            </div>
                            <div>
                                <div class="fw-bold" style="font-size: 16px;">التقارير الإحصائية المتقدمة</div>
                                <small class="text-muted">تحليل شامل للتسليمات، نمو المشتركين، وأداء الموزعين</small>
                            </div>
                        </a>
                        <a href="{{ route('reports.client-balance') }}" class="list-group-item list-group-item-action p-4 d-flex align-items-center gap-3">
                            <div style="width: 40px; height: 40px; background: var(--bg-light); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary-deep);">
                                <i class="la la-wallet" style="font-size: 20px;"></i>
                            </div>
                            <div>
                                <div class="fw-bold" style="font-size: 16px;">تقرير أرصدة المشتركين</div>
                                <small class="text-muted">متابعة الفواتير والمدفوعات والمستحقات المالية</small>
                            </div>
                        </a>
                        <a href="{{ route('reports.clients_delivery_overview') }}" class="list-group-item list-group-item-action p-4 d-flex align-items-center gap-3">
                            <div style="width: 40px; height: 40px; background: var(--bg-light); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary-deep);">
                                <i class="la la-truck" style="font-size: 20px;"></i>
                            </div>
                            <div>
                                <div class="fw-bold" style="font-size: 16px;">تقرير التسليمات التفصيلي</div>
                                <small class="text-muted">عرض سجلات التسليم اليومية مع إمكانية التصفية المتقدمة</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
