<div class="card filter-card mb-4" id="inventory-item-filters-card">
    <div class="card-header bg-light py-3">
        <h6 class="mb-0 fw-bold"><i class="la la-filter"></i> فلاتر البحث</h6>
    </div>
    <div class="card-body p-4">
        <form method="GET" action="{{ url(config('backpack.base.route_prefix') . '/inventory-item') }}" id="inventory-item-filters-form" class="inventory-item-filters-form">
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold mb-1">اسم الصنف</label>
                    <input type="text" name="item_name" class="form-control" value="{{ request('item_name') }}" placeholder="بحث بالاسم...">
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label fw-semibold mb-1">الكمية من</label>
                    <input type="number" name="quantity_min" class="form-control" value="{{ request('quantity_min') }}" min="0" placeholder="0">
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label fw-semibold mb-1">الكمية إلى</label>
                    <input type="number" name="quantity_max" class="form-control" value="{{ request('quantity_max') }}" min="0" placeholder="—">
                </div>
                <div class="col-12 col-md-2 text-start">
                    <button type="submit" class="btn btn-primary btn-search-inventory" title="عرض النتائج" aria-label="عرض النتائج">
                        <i class="la la-search la-lg"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    #inventory-item-filters-card .inventory-item-filters-form .row { display: flex; flex-wrap: wrap; }
    #inventory-item-filters-card .inventory-item-filters-form .row > [class*="col-"] { margin-bottom: 0.5rem; }
    #inventory-item-filters-card .btn-search-inventory { min-width: 48px; min-height: 48px; padding: 0.75rem; }
    #inventory-item-filters-card .btn-search-inventory .la { font-size: 1.25rem; }
</style>
