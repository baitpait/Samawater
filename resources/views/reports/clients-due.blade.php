@extends(backpack_view('blank'))

@section('content')
<div class="container-fluid pb-5">

    <div class="d-flex align-items-center mb-3 gap-2">
        <h4 class="mb-0 fw-bold">المستحقون للتوزيع</h4>
    </div>

    {{-- ============= فلاتر ============= --}}
    <div class="filter-wrapper mx-auto mb-4">
        <div class="card filter-card">
            <div class="card-body">

<form method="GET" action="{{ url('admin/clients-due') }}">
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

    {{-- نوع الاشتراك --}}
    <div class="filter-item">
        <label>نوع الاشتراك</label>
        <select name="subscription_type_name" class="modern-select">
            <option value="">الكل</option>
            @foreach($subscriptionTypes as $type)
                <option value="{{ $type }}"
                    @selected(request('subscription_type_name') == $type)>
                    {{ $type }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- تصنيف المشترك --}}
    <div class="filter-item">
        <label>تصنيف المشترك</label>
        <select name="client_status_name" class="modern-select">
            <option value="">الكل</option>
            @foreach($statuses as $status)
                <option value="{{ $status }}"
                    @selected(request('client_status_name') == $status)>
                    {{ $status }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- أيام التوزيع --}}
    <div class="filter-item">
        <label>أيام التوزيع</label>
        <select name="distribution_days" class="modern-select">
            <option value="">الكل</option>
            @foreach($distributionDaysOptions as $day)
                <option value="{{ $day }}"
                    @selected(request('distribution_days') == $day)>
                    {{ $day }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- الأيام منذ آخر توزيع --}}
    <div class="filter-item">
        <label>أيام منذ آخر توزيع (من)</label>
        <input type="number" name="days_min" class="modern-input"
               value="{{ request('days_min') }}">
    </div>

    <div class="filter-item">
        <label>أيام منذ آخر توزيع (إلى)</label>
        <input type="number" name="days_max" class="modern-input"
               value="{{ request('days_max') }}">
    </div>

    {{-- نسبة الالتزام --}}
    <div class="filter-item">
        <label>نسبة الالتزام (من)</label>
        <input type="number" step="0.01" name="rate_min" class="modern-input"
               value="{{ request('rate_min') }}">
    </div>

    <div class="filter-item">
        <label>نسبة الالتزام (إلى)</label>
        <input type="number" step="0.01" name="rate_max" class="modern-input"
               value="{{ request('rate_max') }}">
    </div>

    {{-- رصيد القوارير --}}
    <div class="filter-item">
        <label>رصيد القوارير</label>
        <input type="number" name="bottle_balance" class="modern-input"
               value="{{ request('bottle_balance') }}">
    </div>

    {{-- آخر تاريخ توزيع --}}
    <div class="filter-item">
        <label>تاريخ آخر توزيع (من)</label>
        <input type="date" name="date_from" class="modern-input"
               value="{{ request('date_from') }}">
    </div>

    <div class="filter-item">
        <label>تاريخ آخر توزيع (إلى)</label>
        <input type="date" name="date_to" class="modern-input"
               value="{{ request('date_to') }}">
    </div>

    {{-- زر --}}
    <div class="filter-item">
        <button class="btn btn-show-results w-100">عرض النتائج</button>
    </div>
</div>
</form>

            </div>
        </div>
    </div>

    {{-- ============= جدول النتائج ============= --}}
    @if($clients->count())
    <div class="card">
        <div class="card-body p-0 table-responsive">

            <table class="table table-hover mb-0 align-middle modern-table">
                <thead>
                    <tr>
                        <th>المشترك</th>
                        <th>المدينة</th>
                        <th>نوع الاشتراك</th>
                        <th>آخر توزيع</th>
                        <th>الأيام</th>
                        <th>الرصيد</th>
                        <th>الالتزام %</th>
                        <th>التصنيف</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($clients as $c)
                    <tr>
                        <td>{{ $c->client_name }}</td>
                        <td>{{ $c->city_name }}</td>
                        <td>{{ $c->subscription_type_name }}</td>
                        <td>{{ $c->last_delivery_date }}</td>
                        <td>{{ $c->days_since_last_delivery }}</td>
                        <td>{{ $c->bottle_on_hand_calculated }}</td>
                        <td>{{ $c->percentage_delivery_rate }}%</td>
                        <td>{{ $c->client_status_name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <div class="card-footer bg-white border-0">
            {{ $clients->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif

</div>
@endsection