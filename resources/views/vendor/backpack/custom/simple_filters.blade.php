<div class="mb-3 p-3 bg-white rounded shadow-sm">

    <form method="GET" class="row">

        {{-- فلتر المدينة --}}
        <div class="col-md-3 mb-2">
            <label>المدينة</label>
            <select name="city" class="form-control" onchange="this.form.submit()">
                <option value="">كل المدن</option>
                @foreach(\DB::table('v_clients_due_by_type_days_ids')->select('city_name')->distinct()->get() as $row)
                    <option value="{{ $row->city_name }}" {{ request('city') == $row->city_name ? 'selected' : '' }}>
                        {{ $row->city_name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- فلتر نوع الاشتراك --}}
        <div class="col-md-3 mb-2">
            <label>نوع الاشتراك</label>
            <select name="sub_type" class="form-control" onchange="this.form.submit()">
                <option value="">كل الأنواع</option>
                @foreach(\DB::table('v_clients_due_by_type_days_ids')->select('subscription_type_name')->distinct()->get() as $row)
                    <option value="{{ $row->subscription_type_name }}" {{ request('sub_type') == $row->subscription_type_name ? 'selected' : '' }}>
                        {{ $row->subscription_type_name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- فلتر حالة العميل --}}
        <div class="col-md-3 mb-2">
            <label>حالة العميل</label>
            <select name="status" class="form-control" onchange="this.form.submit()">
                <option value="">كل الحالات</option>
                @foreach(\DB::table('v_clients_due_by_type_days_ids')->select('client_status_name')->distinct()->get() as $row)
                    <option value="{{ $row->client_status_name }}" {{ request('status') == $row->client_status_name ? 'selected' : '' }}>
                        {{ $row->client_status_name }}
                    </option>
                @endforeach
            </select>
        </div>

    </form>

</div>