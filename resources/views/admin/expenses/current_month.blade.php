@extends(backpack_view('blank'))

@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">
    <style>
        .stat-card-purple::before { background: var(--primary-deep) !important; }
    </style>
@endsection

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header" style="background: var(--primary-deep) !important; border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 2rem; box-shadow: var(--shadow-md) !important; width: 100%; display: flex; align-items: center; justify-content: space-between; position: relative; overflow: visible;">
        <div style="display: flex; align-items: center; gap: 1rem; position: relative; z-index: 1;">
            <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.1); border-radius: 16px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                <i class="la la-money-bill" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
            </div>
            <div>
                <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 800; margin: 0; font-family: 'Cairo', sans-serif;">المصروفات الشهرية</h1>
                <p style="color: rgba(255,255,255,0.7); margin: 0; font-size: 14px;">توزيع المصروفات حسب الأشهر</p>
            </div>
        </div>
    </section>
@endsection

@section('content')
<div class="container-fluid pb-4">
    {{-- فلتر الشهر --}}
    <div class="card filter-card mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('expenses.current-month') }}" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label">السنة</label>
                    <select name="year" class="form-select" onchange="this.form.submit()">
                        @php
                            $currentYear = (int)\Carbon\Carbon::now()->format('Y');
                            for ($i = $currentYear - 2; $i <= $currentYear + 2; $i++) {
                                $years[] = $i;
                            }
                        @endphp
                        @foreach($years as $year)
                            <option value="{{ $year }}" @selected($selectedYear == $year)>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label">الشهر</label>
                    <select name="month_num" class="form-select" onchange="this.form.submit()">
                        @php
                            $months = [
                                1 => '01 - يناير', 2 => '02 - فبراير', 3 => '03 - مارس',
                                4 => '04 - أبريل', 5 => '05 - مايو', 6 => '06 - يونيو',
                                7 => '07 - يوليو', 8 => '08 - أغسطس', 9 => '09 - سبتمبر',
                                10 => '10 - أكتوبر', 11 => '11 - نوفمبر', 12 => '12 - ديسمبر'
                            ];
                        @endphp
                        @foreach($months as $num => $label)
                            <option value="{{ $num }}" @selected($selectedMonthNum == $num)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100" style="height: 48px;">
                        <i class="la la-refresh"></i> تحديث
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ملخص المصروفات --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="dashboard-stat-card stat-card-purple">
                <div class="stat-card-content">
                    <div class="stat-icon-box" style="background: var(--primary-deep);">
                        <i class="la la-calculator"></i>
                    </div>
                    <div class="stat-info">
                        <h6 class="stat-label">المجموع الكلي لمصروفات الشهر</h6>
                        <h3 class="stat-value">{{ number_format($totalAmount, 2) }} ₪</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- جدول المصروفات --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="p-4 border-bottom">
                <h5 class="fw-bold mb-0 text-primary-deep">
                    <i class="la la-list"></i> تفاصيل المصروفات
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table table-clean align-middle mb-0">
                    <thead>
                        <tr>
                            <th>الفئة</th>
                            <th>المبلغ</th>
                            <th>المصروف الأصلي</th>
                            <th>تاريخ الدفع</th>
                            <th style="width: 100px;">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allocations as $allocation)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-primary-deep text-white">{{ $allocation->expense->category->name ?? '-' }}</span>
                                </td>
                                <td class="fw-bold text-primary-deep">{{ number_format($allocation->amount, 2) }} ₪</td>
                                <td>
                                    <div class="small fw-bold">{{ number_format($allocation->expense->total_amount, 2) }} ₪</div>
                                    <div class="text-muted small">({{ $allocation->expense->number_of_months }} شهر)</div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($allocation->expense->payment_date)->format('Y-m-d') }}</td>
                                <td class="pe-4">
                                    <a href="{{ backpack_url('expense/' . $allocation->expense->id . '/edit') }}" class="btn btn-sm btn-primary">
                                        <i class="la la-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">لا توجد مصروفات مسجلة لهذا الشهر</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if(!$allocations->isEmpty())
                    <tfoot>
                        <tr>
                            <td class="ps-4 fw-bold">المجموع:</td>
                            <td class="fw-bold text-primary-deep" style="font-size: 18px;">{{ number_format($totalAmount, 2) }} ₪</td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
