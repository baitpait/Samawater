@extends(backpack_view('blank'))
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.action-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.stopPropagation(); // منع إغلاق القائمة مباشرة

            let menu = this.nextElementSibling;

            // إغلاق أي قائمة أخرى مفتوحة
            document.querySelectorAll('.action-menu').forEach(m => {
                if (m !== menu) m.style.display = 'none';
            });

            // تبديل الظهور
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
        });
    });

    // إغلاق القائمة عند الضغط خارجها
    document.addEventListener('click', function () {
        document.querySelectorAll('.action-menu').forEach(menu => {
            menu.style.display = 'none';
        });
    });

});
</script>

@section('content')
<div class="container-fluid pb-5">

    {{-- ===== Title ===== --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center gap-2">
            <i class="fs-3 text-primary"></i>
            <h4 class="mb-0 fw-bold">المشتركين</h4>
        </div>
        @if($clients->count() > 0)
        <div class="d-flex gap-2">
            <a href="{{ route('reports.filters.export.excel', request()->all()) }}" class="btn btn-success">
                <i class="la la-file-excel"></i>
                تصدير Excel
            </a>
            <a href="{{ route('reports.filters.export.pdf', request()->all()) }}" class="btn btn-danger">
                <i class="la la-file-pdf"></i>
                تصدير PDF
            </a>
        </div>
        @endif
    </div>

    {{-- ===============================
        Filter Panel
    =============================== --}}
    <div class="filter-wrapper mx-auto mb-4">
        <div class="card filter-card">
            <div class="card-body">
<div class="card mb-3">
    <div class="card-body d-flex align-items-center gap-2">
        <i class="la la-users fs-4 text-primary"></i>
        <div class="fw-bold">
            عدد المشتركين المطابقين:
            <span class="text-primary">{{ $clients->total() }}</span>
        </div>
    </div>
</div>

                <form method="GET" action="{{ route('reports.filters') }}">

                    <div class="filter-grid">

                        {{-- المدينة --}}
                        <div class="filter-item">
                            <label>المدينة</label>
                            <select name="city_id" class="modern-select">
                                <option value="">الكل</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}"
                                        @selected(request('city_id') == $city->id)>
                                        {{ $city->city_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- نوع المشترك --}}
                        <div class="filter-item">
                            <label>نوع المشترك</label>
                            <select name="client_type_id" class="modern-select">
                                <option value="">الكل</option>
                                @foreach($clientTypes as $id => $name)
                                    <option value="{{ $id }}"
                                        @selected(request('client_type_id') == $id)>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- حالة المشترك --}}
                        <div class="filter-item">
                            <label>حالة المشترك</label>
                            <select name="status_id" class="modern-select">
                                <option value="">الكل</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}"
                                        @selected(request('status_id') == $status->id)>
                                        {{ $status->status_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- نوع الاشتراك --}}
                        <div class="filter-item">
                            <label>نوع الاشتراك</label>
                            <select name="subscription_type_id" class="modern-select">
                                <option value="">الكل</option>
                                @foreach($subscriptions as $sub)
                                    <option value="{{ $sub->id }}"
                                        @selected(request('subscription_type_id') == $sub->id)>
                                        {{ $sub->type_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- حالة الاشتراك --}}
                        <div class="filter-item">
                            <label>حالة الاشتراك</label>
                            <select name="subscription_status_id" class="modern-select">
                                <option value="">الكل</option>
                                @foreach($subscriptionStatuses as $sStatus)
                                    <option value="{{ $sStatus->id }}"
                                        @selected(request('subscription_status_id') == $sStatus->id)>
                                        {{ $sStatus->status_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- زر --}}
                        {{-- البحث --}}
<div class="filter-item">
    <label>بحث</label>
    <input
        type="text"
        name="q"
        class="modern-input"
        placeholder="اسم المشترك، رقم الهاتف، أو العنوان"
        value="{{ request('q') }}"
    >
</div>

                       {{-- الأزرار --}}
<div class="filter-item d-flex align-items-end">
    <div class="d-flex gap-2 w-100">

        {{-- زر عرض النتائج --}}
        <button class="btn btn-show-results flex-fill">
            <i class="la la-search"></i>
            عرض النتائج
        </button>

        {{-- زر إنشاء مشترك --}}
        <a href="{{ url(config('backpack.base.route_prefix').'/client/create') }}"
           class="btn btn-create flex-fill">
            <i class="la la-plus"></i>
            إضافة مشترك
        </a>

    </div>
</div>


                    </div>
                    <br>
                </form>

            </div>
        </div>
    </div>

    {{-- ===============================
        Results Table
    =============================== --}}
    @if($clients->count())
    <div class="results-wrapper mx-auto">

        <div class="card">
            <div class="card-body p-0 table-responsive">

                <table class="table table-hover mb-0 align-middle modern-table">
                    <thead>
                        <tr>
                            <th>المشترك</th>
                            <th>المدينة</th>
                            <th>حالة الاشتراك</th>
                            <th>الرصيد</th>
                            <th>آخر استلام</th>
                            <th>أيام بدون استلام</th>
                            <th>إجراء</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($clients as $client)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $client->name }}</div>
                                <div class="text-muted small">
                                    {{ $client->phone_one ?? '-' }}
                                </div>
                            </td>

                            <td>{{ $client->city->city_name ?? '-' }}</td>

                            <!--<td>-->
                            <!--    <span class="badge badge-soft">-->
                            <!--        {{ $clientTypes[$client->client_type] ?? '-' }}-->
                            <!--    </span>-->
                            <!--</td>-->

                            <td>
                                <span class="badge badge-status">
                                    {{ optional($client->subscriptionStatus)->status_name }}
                                </span>
                            </td>

                            <td class="fw-bold text-primary">
                                {{ $client->bottle_balance }}
                            </td>
                            
{{-- آخر تاريخ استلام --}}
<td>
    @if($client->lastDelivery)
        {{ \Carbon\Carbon::parse($client->lastDelivery->delivery_date)->format('Y-m-d') }}
    @else
        <span class="text-muted">—</span>
    @endif
</td>

{{-- عدد الأيام بدون استلام --}}
<td>
@if($client->lastDelivery)
    @php
        $days = (int) \Carbon\Carbon::parse(
            $client->lastDelivery->delivery_date
        )->startOfDay()->diffInDays(now()->startOfDay());
    @endphp

    @if($days === 0)
        <span class="badge badge-success">اليوم</span>
    @elseif($days === 1)
        <span class="badge badge-info">أمس</span>
    @elseif($days === 2)
        <span class="badge badge-info">منذ يومين</span>
    @elseif($days <= 10)
        <span class="badge badge-warning">منذ {{ $days }} أيام</span>
    @else
        <span class="badge badge-danger">منذ {{ $days }} يوم</span>
    @endif
@else
    <span class="badge badge-secondary">لم يستلم</span>
@endif
</td>




<td>
<div class="action-dropdown">

    <button class="action-btn">
        <i class="la la-ellipsis-v"></i>
    </button>

    <div class="action-menu">

        <a href="{{ url(config('backpack.base.route_prefix').'/client/'.$client->id.'/show') }}">
            <i class="la la-eye"></i> معاينة
        </a>

        <a href="{{ url(config('backpack.base.route_prefix').'/client/'.$client->id.'/edit') }}">
            <i class="la la-edit"></i> تعديل
        </a>

        <a href="{{ url(config('backpack.base.route_prefix').'/client-report?client_id='.$client->id) }}">
            <i class="la la-chart-bar"></i> تقرير
        </a>

        <a href="{{ url(config('backpack.base.route_prefix').'/delivery/create?client_id='.$client->id) }}">
            <i class="la la-truck"></i> تسليم
        </a>

<button class="danger btn-delete"
        data-url="{{ url(config('backpack.base.route_prefix').'/client/'.$client->id) }}">
    <i class="la la-trash"></i> حذف
</button>


    </div>
</div>
</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

       <div class="card-footer bg-white border-0">
    <div class="d-flex justify-content-center">
        {{ $clients->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>



    </div>
    @endif

</div>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function () {

            if (!confirm('هل أنت متأكد من الحذف؟')) return;

            fetch(this.dataset.url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('فشل الحذف');
                // حذف الصف مباشرة من الجدول
                this.closest('tr').remove();
            })
            .catch(() => alert('حدث خطأ أثناء الحذف'));

        });
    });

});
</script>


@section('after_styles')
<style>

/* ===== Layout Fix ===== */
html, body {
    overflow-x: hidden;
}
/* زر إنشاء */
.btn-create {
    margin-right:5px;
    height: 46px;
    border-radius: 23px;
    background: linear-gradient(135deg,#34d399,#22c55e);
    color: #fff;
    font-weight: 700;
    border: none;
    box-shadow: 0 12px 26px rgba(34,197,94,.35);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    text-decoration: none;
}

.btn-create:hover {
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 18px 36px rgba(34,197,94,.45);
}

/* ===============================
   FIX Pagination Footer Issue
   =============================== */
.action-dropdown {
    position: relative;
}
.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 12px;
    border: none;
    background: #f1f3f9;
    color: #555;
    cursor: pointer;
}

.action-btn:hover {
    background: #e6e8f5;
}

.action-menu {
    position: absolute;
    top: 42px;
    left: 0;
    min-width: 160px;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 12px 28px rgba(0,0,0,.12);
    padding: 6px;
    display: none;
    z-index: 20;
}

/*.action-dropdown:hover .action-menu {*/
/*    display: block;*/
/*}*/
.action-menu {
    display: none;
}
.action-menu a,
.action-menu button {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 10px;
    border-radius: 10px;
    font-size: 13px;
    border: none;
    text-decoration: none;
    background: none;
    text-align: right;
    color: #444;
    cursor: pointer;
}

.action-menu a:hover,
.action-menu button:hover {
    background: #f5f6fd;
    text-decoration: none;
}

.action-menu .danger {
    color: #e63946;
}

/* لا ارتفاع إضافي */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 18px;
    padding-bottom: 10px;
}
.card {
    border-radius: 22px;
    overflow: hidden; ✅✅✅
}

/* الغاء أي min-height أو margin غريب */
.pagination,
.page-item,
.page-link {
    min-height: unset !important;
    height: auto !important;
}

/* امنع Laravel من حجز مساحة فارغة */
nav[aria-label="Pagination Navigation"] {
    margin: 0 !important;
    padding: 0 !important;
}

/* النص السفلي (Showing 1 to X) */
.text-sm.text-gray-700.leading-5,
nav.d-flex.justify-items-center.justify-content-between > div.d-none.flex-sm-fill.d-sm-flex.align-items-sm-center.justify-content-sm-between > div:first-child,
nav[aria-label="Pagination Navigation"] .d-none.flex-sm-fill.d-sm-flex.align-items-sm-center.justify-content-sm-between > div:first-child {
    display: none !important; /* ✅ هذا السطر يحل 80% من المشكلة */
}

/* RTL fix */
.pagination {
    direction: ltr;
}

/* ===== Wrappers ===== */
.filter-wrapper,
.results-wrapper {
    max-width: 1100px;
}

/* ===== Card ===== */
.card {
    border-radius: 22px;
    border: none;
    background: #fff;
    box-shadow: 0 18px 40px rgba(0,0,0,.08);
}

.filter-card {
    background: #fcfdff;
}

/* ===== Grid ===== */
.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
    gap: 22px 26px;
}

/* ===== Labels ===== */
.filter-item label {
    font-size: 13px;
    font-weight: 600;
    color: #55607b;
    margin-bottom: 6px;
    display: block;
}

/* ===== Inputs ===== */
.modern-input,
.modern-select {
    width: 100%;
    height: 46px;
    border-radius: 20px;
    background: #f7f9ff;
    border: 1px solid #e2e8ff;
    padding: 0 18px;
    font-size: 13px;
}

.modern-input:focus,
.modern-select:focus {
    background: #fff;
    border-color: #7b7bff;
    box-shadow: 0 0 0 3px rgba(123,123,255,.15);
    outline: none;
}

/* ===== Button ===== */
.btn-show-results {
    height: 46px;
    border-radius: 23px;
    background: linear-gradient(135deg,#6f6af8,#7c7cff);
    color: #fff;
    border: none;
    font-weight: 700;
    box-shadow: 0 14px 30px rgba(124,124,255,.4);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-show-results:hover {
    transform: translateY(-1px);
    box-shadow: 0 20px 40px rgba(124,124,255,.5);
}

/* ===== Table ===== */
.modern-table thead th {
    font-size: 12px;
    font-weight: 700;
    color: #667085;
    background: #f8fafc;
    border-bottom: none;
}

.modern-table td {
    padding: 14px 16px;
    font-size: 13px;
}

.modern-table tbody tr:hover {
    background: #f6f8ff;
}

/* ===== Badges ===== */
.badge-soft {
    background: #eef2ff;
    color: #4f46e5;
    border-radius: 12px;
    padding: 5px 12px;
    font-weight: 600;
}

.badge-status {
    background: #e6f9f0;
    color: #12b76a;
    border-radius: 12px;
    padding: 5px 12px;
    font-weight: 600;
}

</style>
@endsection