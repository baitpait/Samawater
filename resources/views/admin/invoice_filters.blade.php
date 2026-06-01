@php
    $subscriptionStatuses = \App\Models\SubscriptionStatus::orderBy('status_name')->get();
@endphp
<div class="card filter-card mb-4" id="invoice-filters-card">
    <div class="card-header bg-light py-3">
        <h6 class="mb-0 fw-bold"><i class="la la-filter"></i> فلاتر البحث</h6>
    </div>
    <div class="card-body p-4">
        <form method="GET" action="{{ url(config('backpack.base.route_prefix') . '/invoice') }}" id="invoice-filters-form" class="invoice-filters-form">
            {{-- الصف الأول: المشترك، حالة المشترك، من تاريخ --}}
            <div class="row g-3 align-items-end mb-3">
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold mb-1">المشترك</label>
                    @include('admin.partials.client_select_searchable', [
                        'selectedId' => request('client_id'),
                    ])
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold mb-1">حالة المشترك</label>
                    <select name="subscription_status_id" class="form-select form-control">
                        <option value="">الكل</option>
                        @foreach($subscriptionStatuses as $s)
                            <option value="{{ $s->id }}" {{ request('subscription_status_id') == $s->id ? 'selected' : '' }}>{{ $s->status_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold mb-1">من تاريخ</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
            </div>
            {{-- الصف الثاني: إلى تاريخ، حالة الفاتورة، حالة الدفع، زر البحث --}}
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-3">
                    <label class="form-label fw-semibold mb-1">إلى تاريخ</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label fw-semibold mb-1">حالة الفاتورة</label>
                    <select name="status" class="form-select form-control">
                        <option value="">الكل</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>مسودة</option>
                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>مؤكدة</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>ملغاة</option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label fw-semibold mb-1">حالة الدفع</label>
                    <select name="payment_status" class="form-select form-control">
                        <option value="">الكل</option>
                        <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>مدفوع كامل</option>
                        <option value="partial" {{ request('payment_status') === 'partial' ? 'selected' : '' }}>مدفوع جزئي</option>
                        <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>دين</option>
                    </select>
                </div>
                <div class="col-12 col-md-3 text-start">
                    <button type="submit" class="btn btn-primary btn-search-invoice" title="عرض النتائج" aria-label="عرض النتائج">
                        <i class="la la-search la-lg"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    #invoice-filters-card .invoice-filters-form .row { display: flex; flex-wrap: wrap; }
    #invoice-filters-card .invoice-filters-form .row > [class*="col-"] { margin-bottom: 0.5rem; }
    #invoice-filters-card .btn-search-invoice { min-width: 48px; min-height: 48px; padding: 0.75rem; }
    #invoice-filters-card .btn-search-invoice .la { font-size: 1.25rem; }
</style>
