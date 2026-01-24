{{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
<link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">

<div class="card filter-card mb-4">
    <div class="card-body">
        {{-- Results Header - في بداية card-body --}}
        @if(request()->has('city_id') || request()->has('client_type') || request()->has('client_status_id') || request()->has('subscription_type_id') || request()->has('subscription_status_id') || request()->has('search'))
        @php
            $query = \App\Models\Client::query();
            $query->with(['city', 'subscriptionStatus', 'lastDelivery']);
            
            // تطبيق نفس منطق الفلاتر في Controller - بنفس الترتيب
            // 1. المدينة
            $cityId = request('city_id');
            if (!empty($cityId) && $cityId !== '') {
                $query->where('city_id', $cityId);
            }
            
            // 2. نوع المشترك
            $clientType = request('client_type');
            if (!empty($clientType) && $clientType !== '') {
                $query->where('client_type', $clientType);
            }
            
            // 3. حالة المشترك
            $clientStatusId = request('client_status_id');
            if (!empty($clientStatusId) && $clientStatusId !== '') {
                $query->where('client_status_id', $clientStatusId);
            }
            
            // 4. نوع الاشتراك
            $subscriptionTypeId = request('subscription_type_id');
            if (!empty($subscriptionTypeId) && $subscriptionTypeId !== '') {
                $query->where('subscription_type_id', $subscriptionTypeId);
            }
            
            // 5. حالة الاشتراك
            $subscriptionStatusId = request('subscription_status_id');
            if (!empty($subscriptionStatusId) && $subscriptionStatusId !== '') {
                $query->where('subscription_status_id', $subscriptionStatusId);
            }
            
            // 6. البحث (اسم، هاتف، عنوان) - في النهاية
            $searchTerm = request('search') ?: request('phone');
            if (is_array($searchTerm)) {
                $searchTerm = isset($searchTerm[0]) ? (string)$searchTerm[0] : '';
            } else {
                $searchTerm = $searchTerm ? (string)$searchTerm : '';
            }
            $searchTerm = trim($searchTerm);
            if (!empty($searchTerm)) {
                $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('phone_one', 'like', '%' . $searchTerm . '%')
                      ->orWhere('phone_two', 'like', '%' . $searchTerm . '%')
                      ->orWhere('address', 'like', '%' . $searchTerm . '%');
                });
            }
            
            $totalClients = $query->count();
        @endphp
        <div class="row mb-4">
            <div class="col-12">
                <div class="results-header-modern">
                    <div class="results-header-item">
                        <i class="la la-search"></i>
                        <span>نتائج البحث</span>
                    </div>
                    <div class="results-header-item">
                        <i class="la la-users"></i>
                        <span>عدد المشتركين المطابقين</span>
                        <strong>{{ number_format($totalClients) }}</strong>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <form method="GET">
            {{-- الصف الأول --}}
            <div class="row g-4 align-items-end mb-4">
                {{-- المدينة --}}
                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 12px; display: block; font-size: 15px; font-family: 'Cairo', sans-serif;">المدينة</label>
                    <select name="city_id" class="form-select modern-select" style="height: 50px; font-size: 15px; padding: 14px 20px; font-family: 'Cairo', sans-serif;">
                        <option value="">الكل</option>
                        @foreach(\App\Models\City::orderBy('city_name')->get() as $city)
                            <option value="{{ $city->id }}" {{ request('city_id')==$city->id?'selected':'' }}>
                                {{ $city->city_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- نوع المشترك --}}
                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 12px; display: block; font-size: 15px; font-family: 'Cairo', sans-serif;">نوع المشترك</label>
                    <select name="client_type" class="form-select modern-select" style="height: 50px; font-size: 15px; padding: 14px 20px; font-family: 'Cairo', sans-serif;">
                        <option value="">الكل</option>
                        <option value="1" {{ request('client_type')=='1'?'selected':'' }}>فردي</option>
                        <option value="2" {{ request('client_type')=='2'?'selected':'' }}>مؤسسة</option>
                        <option value="3" {{ request('client_type')=='3'?'selected':'' }}>تجاري</option>
                    </select>
                </div>

                {{-- حالة المشترك --}}
                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 12px; display: block; font-size: 15px; font-family: 'Cairo', sans-serif;">حالة المشترك</label>
                    <select name="client_status_id" class="form-select modern-select" style="height: 50px; font-size: 15px; padding: 14px 20px; font-family: 'Cairo', sans-serif;">
                        <option value="">الكل</option>
                        @foreach(\App\Models\ClientStatus::orderBy('status_name')->get() as $status)
                            <option value="{{ $status->id }}" {{ request('client_status_id')==$status->id?'selected':'' }}>
                                {{ $status->status_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- نوع الاشتراك --}}
                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 12px; display: block; font-size: 15px; font-family: 'Cairo', sans-serif;">نوع الاشتراك</label>
                    <select name="subscription_type_id" class="form-select modern-select" style="height: 50px; font-size: 15px; padding: 14px 20px; font-family: 'Cairo', sans-serif;">
                        <option value="">الكل</option>
                        @foreach(\App\Models\SubscriptionType::orderBy('type_name')->get() as $type)
                            <option value="{{ $type->id }}" {{ request('subscription_type_id')==$type->id?'selected':'' }}>
                                {{ $type->type_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- الصف الثاني --}}
            <div class="row g-4 align-items-end">
                {{-- حالة الاشتراك --}}
                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 12px; display: block; font-size: 15px; font-family: 'Cairo', sans-serif;">حالة الاشتراك</label>
                    <select name="subscription_status_id" class="form-select modern-select" style="height: 50px; font-size: 15px; padding: 14px 20px; font-family: 'Cairo', sans-serif;">
                        <option value="">الكل</option>
                        @foreach(\App\Models\SubscriptionStatus::orderBy('status_name')->get() as $status)
                            <option value="{{ $status->id }}" {{ request('subscription_status_id')==$status->id?'selected':'' }}>
                                {{ $status->status_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- البحث --}}
                <div class="col-12 col-sm-6 col-md-5">
                    <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 12px; display: block; font-size: 15px; font-family: 'Cairo', sans-serif;">بحث</label>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control modern-input"
                           placeholder="اسم المشترك، رقم الهاتف، أو العنوان"
                           style="height: 50px; font-size: 15px; padding: 14px 20px; font-family: 'Cairo', sans-serif;">
                </div>

                {{-- زر البحث --}}
                <div class="col-12 col-sm-6 col-md-4">
                    <button type="submit" class="btn btn-show-results w-100" title="عرض النتائج" style="height: 50px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                        <i class="la la-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('after_scripts')
<script>
    $(document).ready(function() {
        // الحصول على URL parameters
        var urlParams = new URLSearchParams(window.location.search);
        
        // إنشاء object يحتوي على جميع parameters
        var ajaxParams = {};
        urlParams.forEach(function(value, key) {
            // استثناء parameters الخاصة بـ DataTables
            if (!['draw', 'start', 'length', 'search', 'order', 'columns', '_', 'page', 'per_page'].includes(key)) {
                ajaxParams[key] = value;
            }
        });
        
        // البحث عن DataTable بعد تحميله
        function attachAjaxParams() {
            try {
                var table = $('#crudTable').DataTable();
                
                if (table && $.fn.DataTable.isDataTable('#crudTable')) {
                    // إزالة event listeners السابقة لتجنب التكرار
                    table.off('preXhr.dt');
                    
                    // إضافة parameters إلى AJAX requests
                    table.on('preXhr.dt', function(e, settings, data) {
                        // دمج URL parameters مع DataTables parameters
                        $.extend(data, ajaxParams);
                    });
                    
                    // إعادة تحميل الجدول عند تغيير URL parameters
                    if (Object.keys(ajaxParams).length > 0) {
                        table.ajax.reload(null, false);
                    }
                } else if (Object.keys(ajaxParams).length > 0) {
                    // إعادة المحاولة بعد 200ms إذا لم يتم تحميل DataTable بعد
                    setTimeout(attachAjaxParams, 200);
                }
            } catch (e) {
                // في حالة وجود خطأ، إعادة المحاولة
                if (Object.keys(ajaxParams).length > 0) {
                    setTimeout(attachAjaxParams, 200);
                }
            }
        }
        
        // محاولة إرفاق parameters بعد تحميل الصفحة
        // استخدام setTimeout للتأكد من تحميل DataTable
        setTimeout(function() {
            attachAjaxParams();
        }, 500);
        
        // أيضاً عند إعادة تحميل الجدول
        $(document).on('crudTableLoaded', function() {
            attachAjaxParams();
        });
    });
</script>
@endpush

{{-- CSS for Results Header - Unified Design --}}
<style>
.results-header-modern {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%) !important;
    border-radius: 20px !important;
    padding: 1.5rem 2rem !important;
    display: flex !important;
    align-items: center !important;
    justify-content: flex-start !important;
    gap: 3rem !important;
    box-shadow: 0 4px 20px rgba(239, 68, 68, 0.15) !important;
    border: 1px solid rgba(239, 68, 68, 0.2) !important;
    margin-bottom: 0 !important;
}

.results-header-item {
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
    font-family: 'Cairo', sans-serif !important;
    font-size: 28px !important;
    font-weight: 700 !important;
    color: #ef4444 !important;
}

.results-header-item i {
    font-size: 32px !important;
    color: #ef4444 !important;
    font-weight: 900 !important;
}

.results-header-item strong {
    font-size: 42px !important;
    font-weight: 800 !important;
    color: #dc2626 !important;
    margin-right: 8px !important;
    font-family: 'Cairo', sans-serif !important;
}

.results-header-item span {
    color: #ef4444 !important;
    font-weight: 700 !important;
    font-size: 28px !important;
}
</style>
