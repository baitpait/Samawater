<div class="card filter-card mb-4" id="client-payment-filters-card">
    <div class="card-header bg-light py-3">
        <h6 class="mb-0 fw-bold"><i class="la la-filter"></i> فلاتر البحث</h6>
    </div>
    <div class="card-body p-4">
        <form method="GET" action="{{ url(config('backpack.base.route_prefix') . '/client-payment') }}" id="client-payment-filters-form" class="client-payment-filters-form">
            {{-- الصف الأول: المشترك، من تاريخ، إلى تاريخ --}}
            <div class="row g-3 align-items-end mb-3">
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold mb-1">المشترك</label>
                    @include('admin.partials.client_select_searchable', [
                        'selectedId' => request('client_id'),
                    ])
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold mb-1">من تاريخ</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold mb-1">إلى تاريخ</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
            </div>
            {{-- الصف الثاني: طريقة الدفع، زر البحث --}}
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold mb-1">طريقة الدفع</label>
                    <select name="payment_method" class="form-select form-control">
                        <option value="">الكل</option>
                        <option value="cash" {{ request('payment_method') === 'cash' ? 'selected' : '' }}>نقدي</option>
                        <option value="bank_transfer" {{ request('payment_method') === 'bank_transfer' ? 'selected' : '' }}>تحويل بنكي</option>
                        <option value="check" {{ request('payment_method') === 'check' ? 'selected' : '' }}>شيك</option>
                        <option value="credit_card" {{ request('payment_method') === 'credit_card' ? 'selected' : '' }}>بطاقة ائتمان</option>
                        <option value="other" {{ request('payment_method') === 'other' ? 'selected' : '' }}>أخرى</option>
                    </select>
                </div>
                <div class="col-12 col-md-4 text-start">
                    <button type="submit" class="btn btn-primary btn-search-payment" title="عرض النتائج" aria-label="عرض النتائج">
                        <i class="la la-search la-lg"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    #client-payment-filters-card .client-payment-filters-form .row { display: flex; flex-wrap: wrap; }
    #client-payment-filters-card .client-payment-filters-form .row > [class*="col-"] { margin-bottom: 0.5rem; }
    #client-payment-filters-card .btn-search-payment { min-width: 48px; min-height: 48px; padding: 0.75rem; }
    #client-payment-filters-card .btn-search-payment .la { font-size: 1.25rem; }
</style>
