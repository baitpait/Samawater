@php
    $categories = \App\Models\ExpenseCategory::where('is_active', true)->orderBy('name')->get();
    $beneficiariesQuery = \App\Models\ExpenseBeneficiary::where('is_active', true)->orderBy('name');
    if (request()->filled('expense_category_id')) {
        $beneficiariesQuery->where('expense_category_id', (int) request('expense_category_id'));
    }
    $beneficiaries = $beneficiariesQuery->get();
    $exportQuery = request()->query();
@endphp
<div class="card filter-card mb-4" id="expense-filters-card">
    <div class="card-header bg-light py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h6 class="mb-0 fw-bold"><i class="la la-filter"></i> فلاتر البحث</h6>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('expense.export.excel', $exportQuery) }}" class="btn btn-sm btn-success" style="border-radius: 10px; font-weight: 700;">
                <i class="la la-file-excel"></i> Excel
            </a>
            <a href="{{ route('expense.export.pdf', $exportQuery) }}" class="btn btn-sm btn-danger" style="border-radius: 10px; font-weight: 700;">
                <i class="la la-file-pdf"></i> PDF
            </a>
        </div>
    </div>
    <div class="card-body p-4">
        <form method="GET" action="{{ url(config('backpack.base.route_prefix') . '/expense') }}" id="expense-filters-form" class="expense-filters-form">
            <div class="row g-3 align-items-end mb-3">
                <div class="col-12 col-md-3">
                    <label class="form-label fw-semibold mb-1">الفئة</label>
                    <select name="expense_category_id" class="form-select form-control">
                        <option value="">الكل</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('expense_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label fw-semibold mb-1">صاحب المصروف</label>
                    <select name="expense_beneficiary_id" class="form-select form-control">
                        <option value="">الكل</option>
                        @foreach($beneficiaries as $beneficiary)
                            <option value="{{ $beneficiary->id }}" {{ request('expense_beneficiary_id') == $beneficiary->id ? 'selected' : '' }}>{{ $beneficiary->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label fw-semibold mb-1">حالة الدفع</label>
                    <select name="payment_status" class="form-select form-control">
                        <option value="">الكل</option>
                        <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>مدفوع</option>
                        <option value="partial" {{ request('payment_status') === 'partial' ? 'selected' : '' }}>جزئي</option>
                        <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>غير مدفوع</option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label fw-semibold mb-1">من تاريخ الدفع</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
            </div>
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold mb-1">إلى تاريخ الدفع</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-12 col-md-4 text-start">
                    <button type="submit" class="btn btn-primary btn-search-expense" title="عرض النتائج" aria-label="عرض النتائج">
                        <i class="la la-search la-lg"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    #expense-filters-card .expense-filters-form .row { display: flex; flex-wrap: wrap; }
    #expense-filters-card .expense-filters-form .row > [class*="col-"] { margin-bottom: 0.5rem; }
    #expense-filters-card .btn-search-expense { min-width: 48px; min-height: 48px; padding: 0.75rem; }
    #expense-filters-card .btn-search-expense .la { font-size: 1.25rem; }
</style>
