<div class="card filter-card mb-4" id="client-deposit-filters-card">
    <div class="card-header bg-light py-3">
        <h6 class="mb-0 fw-bold"><i class="la la-filter"></i> فلاتر البحث</h6>
    </div>
    <div class="card-body p-4">
        <form method="GET" action="{{ url(config('backpack.base.route_prefix') . '/client-deposit') }}" id="client-deposit-filters-form" class="client-deposit-filters-form">
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
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold mb-1">الحالة</label>
                    <select name="status" class="form-select form-control">
                        <option value="">الكل</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>معارة</option>
                        <option value="withdrawn" {{ request('status') === 'withdrawn' ? 'selected' : '' }}>مسحوبة</option>
                    </select>
                </div>
                <div class="col-12 col-md-4 text-start">
                    <button type="submit" class="btn btn-primary btn-search-deposit" title="عرض النتائج" aria-label="عرض النتائج">
                        <i class="la la-search la-lg"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    #client-deposit-filters-card .client-deposit-filters-form .row { display: flex; flex-wrap: wrap; }
    #client-deposit-filters-card .client-deposit-filters-form .row > [class*="col-"] { margin-bottom: 0.5rem; }
    #client-deposit-filters-card .btn-search-deposit { min-width: 48px; min-height: 48px; padding: 0.75rem; }
    #client-deposit-filters-card .btn-search-deposit .la { font-size: 1.25rem; }
</style>
