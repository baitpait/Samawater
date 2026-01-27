{{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
<link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">

<div class="card filter-card mb-4">
    <div class="card-body p-4">
        {{-- Results Header --}}
        @if(request()->has('city_id') || request()->has('client_type') || request()->has('client_status_id') || request()->has('subscription_type_id') || request()->has('subscription_status_id') || request()->has('search'))
        @php
            $query = \App\Models\Client::query();
            
            $cityId = request('city_id');
            if (!empty($cityId)) $query->where('city_id', $cityId);
            
            $clientType = request('client_type');
            if (!empty($clientType)) $query->where('client_type', $clientType);
            
            $clientStatusId = request('client_status_id');
            if (!empty($clientStatusId)) $query->where('client_status_id', $clientStatusId);
            
            $subscriptionTypeId = request('subscription_type_id');
            if (!empty($subscriptionTypeId)) $query->where('subscription_type_id', $subscriptionTypeId);
            
            $subscriptionStatusId = request('subscription_status_id');
            if (!empty($subscriptionStatusId)) $query->where('subscription_status_id', $subscriptionStatusId);
            
            $searchTerm = request('search');
            if (!empty($searchTerm)) {
                $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('phone_one', 'like', '%' . $searchTerm . '%')
                      ->orWhere('address', 'like', '%' . $searchTerm . '%');
                });
            }
            
            $totalClients = $query->count();
        @endphp
        <div class="results-header-modern mb-4" style="background: var(--primary-deep); border-radius: 16px; padding: 20px; color: #fff; display: flex; align-items: center; gap: 15px;">
            <i class="la la-users" style="font-size: 24px;"></i>
            <span style="font-size: 18px; font-weight: 700;">عدد المشتركين المطابقين: {{ number_format($totalClients) }}</span>
        </div>
        @endif

        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">المدينة</label>
                <select name="city_id" class="form-select">
                    <option value="">الكل</option>
                    @foreach(\App\Models\City::orderBy('city_name')->get() as $city)
                        <option value="{{ $city->id }}" @selected(request('city_id') == $city->id)>{{ $city->city_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">نوع المشترك</label>
                <select name="client_type" class="form-select">
                    <option value="">الكل</option>
                    <option value="1" @selected(request('client_type') == '1')>فردي</option>
                    <option value="2" @selected(request('client_type') == '2')>مؤسسة</option>
                    <option value="3" @selected(request('client_type') == '3')>تجاري</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">حالة المشترك</label>
                <select name="client_status_id" class="form-select">
                    <option value="">الكل</option>
                    @foreach(\App\Models\ClientStatus::orderBy('status_name')->get() as $status)
                        <option value="{{ $status->id }}" @selected(request('client_status_id') == $status->id)>{{ $status->status_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">نوع الاشتراك</label>
                <select name="subscription_type_id" class="form-select">
                    <option value="">الكل</option>
                    @foreach(\App\Models\SubscriptionType::orderBy('type_name')->get() as $type)
                        <option value="{{ $type->id }}" @selected(request('subscription_type_id') == $type->id)>{{ $type->type_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-9">
                <label class="form-label">بحث سريع</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="اسم المشترك، رقم الهاتف، أو العنوان">
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100" style="height: 48px;">
                    <i class="la la-search"></i> بحث
                </button>
            </div>
        </form>
    </div>
</div>
