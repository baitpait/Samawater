@php
    $vendors = \App\Models\Vendor::where('is_active', true)->orderBy('name')->get();
@endphp
<div class="card filter-card mb-4" id="vendor-payment-filters-card">
    <div class="card-header bg-light py-3">
        <h6 class="mb-0 fw-bold"><i class="la la-filter"></i> فلاتر البحث</h6>
    </div>
    <div class="card-body p-4">
        <form method="GET" action="{{ url(config('backpack.base.route_prefix') . '/vendor-payment') }}" id="vendor-payment-filters-form" class="vendor-payment-filters-form">
            <div class="row g-3 align-items-end mb-3">
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold mb-1">المورد</label>
                    <select name="vendor_id" class="form-select form-control">
                        <option value="">الكل</option>
                        @foreach($vendors as $v)
                            <option value="{{ $v->id }}" {{ request('vendor_id') == $v->id ? 'selected' : '' }}>{{ $v->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold mb-1">طريقة الدفع</label>
                    <select name="method" class="form-select form-control">
                        <option value="">الكل</option>
                        <option value="cash" {{ request('method') === 'cash' ? 'selected' : '' }}>نقدي</option>
                        <option value="bank_transfer" {{ request('method') === 'bank_transfer' ? 'selected' : '' }}>تحويل بنكي</option>
                        <option value="check" {{ request('method') === 'check' ? 'selected' : '' }}>شيك</option>
                        <option value="credit_card" {{ request('method') === 'credit_card' ? 'selected' : '' }}>بطاقة ائتمان</option>
                        <option value="other" {{ request('method') === 'other' ? 'selected' : '' }}>أخرى</option>
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold mb-1">من تاريخ</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
            </div>
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold mb-1">إلى تاريخ</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-12 col-md-4 text-start">
                    <button type="submit" class="btn btn-primary btn-search-vendor-payment" title="عرض النتائج" aria-label="عرض النتائج">
                        <i class="la la-search la-lg"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    #vendor-payment-filters-card .vendor-payment-filters-form .row { display: flex; flex-wrap: wrap; }
    #vendor-payment-filters-card .vendor-payment-filters-form .row > [class*="col-"] { margin-bottom: 0.5rem; }
    #vendor-payment-filters-card .btn-search-vendor-payment { min-width: 48px; min-height: 48px; padding: 0.75rem; }
    #vendor-payment-filters-card .btn-search-vendor-payment .la { font-size: 1.25rem; }
</style>
