<div class="card filter-card mb-4">
    <div class="card-body p-4">
        <form method="GET" action="{{ backpack_url('distributor') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-10">
                    <label class="form-label">بحث عن موزع</label>
                    <input type="text" name="search" class="form-control" placeholder="اسم الموزع أو رقم الهاتف" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100" style="height: 48px;">
                        <i class="la la-search"></i> بحث
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
