@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
@endsection

@extends(backpack_view('blank'))

@section('content')
<div class="container-fluid pb-4">

    {{-- ===============================
        Header - Unified Design
    =============================== --}}
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header">
        <div class="header-content-wrapper" style="display: flex; align-items: center; gap: 1rem; width: 100%; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <h1 class="text-capitalize mb-0" bp-section="page-heading">قائمة التسليم</h1>
            </div>
            @if(request()->has('search') && $clients->count() > 0)
            <div class="page-header-actions">
                <a href="{{ route('reports.clients_due_advanced.export.excel', request()->all()) }}" class="btn btn-success">
                    <i class="la la-file-excel"></i>
                    تصدير Excel
                </a>
                <a href="{{ route('reports.clients_due_advanced.export.pdf', request()->all()) }}" class="btn btn-danger">
                    <i class="la la-file-pdf"></i>
                    تصدير PDF
                </a>
            </div>
            @endif
        </div>
    </section>

    {{-- Unified Header CSS --}}
    <style>
        section.header-operation {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
            border-radius: 20px !important;
            padding: 1.5rem 2rem !important;
            margin-bottom: 2rem !important;
            box-shadow: 0 10px 30px rgba(111, 106, 248, 0.3) !important;
            position: relative !important;
            overflow: hidden !important;
        }

        section.header-operation::before {
            content: '' !important;
            position: absolute !important;
            top: -50% !important;
            right: -50% !important;
            width: 200% !important;
            height: 200% !important;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%) !important;
            animation: pulse 3s ease-in-out infinite !important;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 0.8; }
        }

        section.header-operation h1 {
            color: #fff !important;
            font-size: 24px !important;
            font-weight: 700 !important;
            margin: 0 !important;
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
            position: relative !important;
            z-index: 1 !important;
            display: flex !important;
            align-items: center !important;
            gap: 1rem !important;
            padding-right: 70px !important;
        }

        section.header-operation h1::before {
            content: '' !important;
            width: 56px !important;
            height: 56px !important;
            background: rgba(255, 255, 255, 0.2) !important;
            border-radius: 16px !important;
            backdrop-filter: blur(10px) !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
            position: absolute !important;
            right: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        section.header-operation h1::after {
            content: '\f1b9' !important; /* truck icon - Line Awesome */
            font-family: 'Line Awesome Free' !important;
            font-weight: 900 !important;
            font-size: 24px !important;
            color: #fff !important;
            position: absolute !important;
            right: 16px !important;
            z-index: 2 !important;
        }

        section.header-operation p {
            color: rgba(255, 255, 255, 0.9) !important;
            font-size: 14px !important;
            margin: 0 !important;
            margin-top: 4px !important;
            margin-right: 0 !important;
            font-weight: 500 !important;
            position: relative !important;
            z-index: 1 !important;
        }

        section.header-operation .page-header-actions .btn {
            height: 42px !important;
            border-radius: 12px !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            padding: 0 18px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            transition: all 0.2s ease !important;
            border: none !important;
            position: relative !important;
            z-index: 1 !important;
        }

        section.header-operation .btn-success {
            background: rgba(34, 197, 94, 0.2) !important;
            color: #fff !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
        }

        section.header-operation .btn-success:hover {
            background: rgba(34, 197, 94, 0.3) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 20px rgba(34, 197, 94, 0.3) !important;
        }

        section.header-operation .btn-danger {
            background: rgba(239, 68, 68, 0.2) !important;
            color: #fff !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
        }

        section.header-operation .btn-danger:hover {
            background: rgba(239, 68, 68, 0.3) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3) !important;
        }

        @media (max-width: 768px) {
            section.header-operation {
                padding: 1.25rem 1.5rem !important;
                border-radius: 16px !important;
            }

            section.header-operation h1 {
                font-size: 20px !important;
            }

            section.header-operation h1::before {
                width: 48px !important;
                height: 48px !important;
            }

            section.header-operation h1::after {
                font-size: 20px !important;
                right: 14px !important;
            }
        }

        @media (max-width: 576px) {
            section.header-operation {
                padding: 1rem !important;
            }

            section.header-operation h1 {
                font-size: 18px !important;
                padding-right: 0 !important;
            }

            section.header-operation h1::before,
            section.header-operation h1::after {
                display: none !important;
            }
        }
    </style>

    {{-- ===============================
        Filters
    =============================== --}}
    <div class="card filter-card mb-4">
        <div class="card-body">
@if(request()->has('search'))
    @if($clients instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="row mb-4">
        <div class="col-12">
            <div class="results-header-modern">
                <div class="results-header-item results-count-item">
                    <div class="results-count-wrapper">
                        <span class="results-label">عدد المشتركين:</span>
                        <strong class="results-value">{{ number_format($clients->total()) }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    {{-- إحصائيات القوارير --}}
    @php
        // التأكد من أن القيم موجودة وليست null
        $totalReceived = isset($totalBottleReceived) && $totalBottleReceived !== null ? (float)$totalBottleReceived : 0;
        $totalEmpty = isset($totalBottleEmpty) && $totalBottleEmpty !== null ? (float)$totalBottleEmpty : 0;
        $bottleBalance = $totalReceived - $totalEmpty;
    @endphp
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="bottles-stats-modern" style="display: flex !important; visibility: visible !important; opacity: 1 !important;">
                <div class="bottles-stat-item">
                    <div class="bottles-stat-label">العبوات المستلمة</div>
                    <div class="bottles-stat-value bottles-stat-green">{{ number_format($totalReceived, 0) }}</div>
                </div>
                <div class="bottles-stat-item">
                    <div class="bottles-stat-label">العبوات الفارغة</div>
                    <div class="bottles-stat-value bottles-stat-red">{{ number_format($totalEmpty, 0) }}</div>
                </div>
                <div class="bottles-stat-item">
                    <div class="bottles-stat-label">رصيد القوارير</div>
                    <div class="bottles-stat-value bottles-stat-purple">{{ number_format($bottleBalance, 0) }}</div>
                </div>
            </div>
        </div>
    </div>
@endif

<form method="GET">
    {{-- مهم: هذا السطر --}}
    <input type="hidden" name="search" value="1">

    {{-- الصف الأول --}}
    <div class="row g-4 align-items-end mb-4">

        {{-- Search --}}
        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 12px; display: block; font-size: 14px;">بحث</label>
            <input type="text"
                   name="q"
                   class="form-control modern-input"
                   placeholder="اسم / هاتف / عقد"
                   value="{{ request('q') }}"
                   style="font-size: 15px; padding: 14px 20px; height: 56px;">
        </div>

        {{-- City --}}
        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 12px; display: block; font-size: 14px;">المدينة</label>
            <select name="city_id" class="form-select modern-select" style="font-size: 15px; padding: 14px 20px; height: 56px;">
                <option value="">الكل</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}"
                        @selected(request('city_id') == $city->id)>
                        {{ $city->city_name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Subscription Type --}}
        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 12px; display: block; font-size: 14px;">نوع الاشتراك</label>
            <select name="subscription_type_name" class="form-select modern-select" style="font-size: 15px; padding: 14px 20px; height: 56px;">
                <option value="">الكل</option>
                @foreach($subscriptionTypes as $type)
                    <option value="{{ $type }}"
                        @selected(request('subscription_type_name') == $type)>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Client Status (حالة الالتزام) --}}
        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 12px; display: block; font-size: 14px;">حالة الالتزام</label>
            <select name="client_status_name" class="form-select modern-select" style="font-size: 15px; padding: 14px 20px; height: 56px;">
                <option value="">الكل</option>
                @foreach($clientStatuses ?? [] as $status)
                    <option value="{{ $status }}"
                        @selected(request('client_status_name') == $status)>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>

    </div>

    {{-- الصف الثاني --}}
    <div class="row g-4 align-items-end">

        {{-- Subscription Status (حالة الاشتراك) --}}
        <div class="col-12 col-sm-6 col-md-3">
            <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 12px; display: block; font-size: 14px;">حالة الاشتراك</label>
            <select name="subscription_status_name" class="form-select modern-select" style="font-size: 15px; padding: 14px 20px; height: 56px;">
                <option value="">الكل</option>
                @foreach($subscriptionStatuses ?? [] as $status)
                    <option value="{{ $status }}"
                        @selected(request('subscription_status_name') == $status)>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Days Without Delivery (أيام بدون تسليم) - مع خيار المقارنة --}}
        <div class="col-12 col-sm-6 col-md-5">
            <label class="form-label" style="font-weight: 700; color: #374151; margin-bottom: 12px; display: block; font-size: 14px;">أيام بدون تسليم</label>
            <div class="d-flex gap-3 align-items-center">
                <select name="days_operator" class="form-select modern-select" style="width: 180px; flex-shrink: 0; font-size: 15px; padding: 14px 20px; height: 56px;">
                    <option value=">=" @selected(request('days_operator', '>=') == '>=')>أكبر أو يساوي</option>
                    <option value="<=" @selected(request('days_operator') == '<=')>أصغر أو يساوي</option>
                    <option value="=" @selected(request('days_operator') == '=')>يساوي</option>
                </select>
                <input type="number"
                       name="min_days"
                       class="form-control modern-input flex-grow-1"
                       placeholder="عدد الأيام"
                       min="0"
                       value="{{ request('min_days') }}"
                       style="font-size: 16px; padding: 14px 20px; height: 56px;">
            </div>
        </div>

        {{-- Button --}}
        <div class="col-12 col-sm-6 col-md-2">
            <button type="submit" class="btn btn-show-results w-100" title="عرض النتائج" style="height: 56px; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                <i class="la la-search"></i>
            </button>
        </div>

    </div>
</form>

        </div>
    </div>

    {{-- ===============================
        Results
    =============================== --}}
    @if(request()->has('search'))

        {{-- Table --}}
        <div class="card filter-card mb-4">
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-clean align-middle mb-0">

                    <thead>
                    <tr>
                        <th>المشترك</th>
                        <th>المدينة</th>
                        <th>الهاتف</th>
                        <th>تاريخ الاستلام</th>
                        <th>العبوات المستلمة</th>
                        <th>العبوات الفارغة</th>
                        <th>الرصيد</th>
                        <th>الدفعة</th>
                        <th>الموزع</th>
                        <th>تعديل</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($clients as $c)
                    
                        <tr>

                            <td>
                                <div class="fw-bold">{{ $c->client_name }}</div>
                                <div class="text-muted small">{{ $c->contract_no }}</div>
                            </td>

                            <td>{{ $c->city_name ?? '-' }}</td>

                            <td>
                                @php
                                    $phones = [];
                                    if (!empty($c->phone_one)) {
                                        $phones[] = $c->phone_one;
                                    }
                                    if (!empty($c->phone_two)) {
                                        $phones[] = $c->phone_two;
                                    }
                                    $phonesDisplay = !empty($phones) ? implode(' / ', $phones) : '-';
                                @endphp
                                <div class="d-flex flex-column gap-1">
                                    @if(!empty($c->phone_one))
                                        <div>{{ $c->phone_one }}</div>
                                    @endif
                                    @if(!empty($c->phone_two))
                                        <div class="text-muted small">{{ $c->phone_two }}</div>
                                    @endif
                                    @if(empty($c->phone_one) && empty($c->phone_two))
                                        <div>-</div>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <span class="fw-bold" style="color: #6f6af8;">
                                    {{ $c->last_delivery_date_formatted ?? $c->last_delivery_date ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <span class="badge-success-custom" style="font-size: 14px; font-weight: 600;">
                                    {{ number_format($c->total_bottle_received ?? 0) }}
                                </span>
                            </td>

                            <td>
                                <span class="badge-warning-custom" style="font-size: 14px; font-weight: 600;">
                                    {{ number_format($c->total_bottle_empty ?? 0) }}
                                </span>
                            </td>

                            <td>
                                @php
                                    $balance = ($c->total_bottle_received ?? 0) - ($c->total_bottle_empty ?? 0);
                                    $balanceClass = $balance > 0 ? 'badge-balance-positive' : ($balance < 0 ? 'badge-balance-negative' : 'badge-balance-zero');
                                @endphp
                                <span class="{{ $balanceClass }}" style="font-size: 14px; font-weight: 600;">
                                    {{ number_format($balance) }}
                                </span>
                            </td>

                            <td>
                                <span class="badge badge-soft-purple" style="font-size: 14px; font-weight: 600;">
                                    {{ number_format($c->last_delivery_payment ?? 0) }} ₪
                                </span>
                            </td>

                            <td>
                                {{ $c->last_delivery_distributor ?? '-' }}
                            </td>

                            <td>
                                <div class="btn-group" style="position: relative; direction: rtl;">
                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="la la-cog"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" style="right: 0 !important; left: auto !important; direction: rtl !important; position: absolute !important;">
                                        <a class="dropdown-item" href="{{ backpack_url('client/' . $c->client_id . '/show') }}">
                                            <i class="la la-eye"></i> معاينة
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ url(config('backpack.base.route_prefix') . '/delivery/create?client_id=' . $c->client_id) }}">
                                            <i class="la la-truck"></i> تسليم
                                        </a>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">
                                لا توجد نتائج مطابقة
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                    </table>

                </div>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $clients->withQueryString()->links('pagination::bootstrap-5') }}
        </div>

    @else
        {{-- Empty State --}}
        <div class="card p-5 text-center text-muted">
            <i class="la la-search fs-1 mb-3"></i>
            <div class="fw-bold mb-1">لم يتم عرض أي نتائج بعد</div>
            <div>اختر الفلاتر ثم اضغط على زر <strong>عرض النتائج</strong></div>
        </div>
    @endif

</div>
@endsection

@push('after_scripts')
<script>
jQuery(document).ready(function($) {
    function fixDropdownPosition() {
        $('.table-clean .dropdown-menu').each(function() {
            var $dropdown = $(this);
            var $btnGroup = $dropdown.closest('.btn-group');
            var $td = $btnGroup.closest('td');
            
            // إزالة overflow من العناصر المحيطة
            $td.css('overflow', 'visible');
            $td.parent().css('overflow', 'visible');
            $('.table-responsive').css('overflow', 'visible');
            $('.table-card').css('overflow', 'visible');
            $('.card.filter-card').css('overflow', 'visible');
            $('.card-body').css('overflow', 'visible');
            
            // إزالة أي positioning خاطئ
            $dropdown.css({
                'right': '0',
                'left': 'auto',
                'transform': 'none',
                'position': 'absolute',
                'direction': 'rtl',
                'text-align': 'right',
                'margin-right': '0',
                'margin-left': 'auto',
                'top': '100%',
                'bottom': 'auto',
                'z-index': '9999'
            });
            
            // التأكد من أن الـ btn-group له position relative
            $btnGroup.css({
                'position': 'relative',
                'direction': 'rtl',
                'z-index': '1000'
            });
        });
    }
    
    // إصلاح موضع dropdown menu عند الفتح
    $('.table-clean .btn-group').on('show.bs.dropdown', function(e) {
        var $dropdown = $(this).find('.dropdown-menu');
        var $td = $(this).closest('td');
        var $tr = $(this).closest('tr');
        var $btnGroup = $(this);
        
        // رفع z-index للصف عند فتح dropdown
        $tr.css({
            'z-index': '10000',
            'position': 'relative'
        });
        
        $btnGroup.css('z-index', '10000');
        
        // إزالة overflow
        $td.css('overflow', 'visible');
        $('.table-responsive').css('overflow', 'visible');
        $('.table-card').css('overflow', 'visible');
        $('.card.filter-card').css('overflow', 'visible');
        $('.card-body').css('overflow', 'visible');
        
        setTimeout(function() {
            $dropdown.css({
                'right': '0',
                'left': 'auto',
                'transform': 'none',
                'position': 'absolute',
                'direction': 'rtl',
                'text-align': 'right',
                'margin-right': '0',
                'margin-left': 'auto',
                'top': '100%',
                'bottom': 'auto',
                'z-index': '10001'
            });
        }, 0);
    });
    
    // إعادة z-index عند إغلاق dropdown
    $('.table-clean .btn-group').on('hide.bs.dropdown', function(e) {
        var $tr = $(this).closest('tr');
        var $btnGroup = $(this);
        
        setTimeout(function() {
            $tr.css({
                'z-index': '1',
                'position': 'relative'
            });
            $btnGroup.css('z-index', '1');
        }, 300);
    });
    
    // إصلاح عند النقر على dropdown toggle
    $(document).on('click', '.table-clean .dropdown-toggle', function(e) {
        var $dropdown = $(this).next('.dropdown-menu');
        var $btnGroup = $(this).closest('.btn-group');
        var $td = $btnGroup.closest('td');
        
        // إزالة overflow
        $td.css('overflow', 'visible');
        $('.table-responsive').css('overflow', 'visible');
        $('.table-card').css('overflow', 'visible');
        $('.card.filter-card').css('overflow', 'visible');
        $('.card-body').css('overflow', 'visible');
        
        setTimeout(function() {
            $btnGroup.css({
                'position': 'relative',
                'direction': 'rtl',
                'z-index': '1000'
            });
            
            $dropdown.css({
                'right': '0',
                'left': 'auto',
                'transform': 'none',
                'direction': 'rtl',
                'position': 'absolute',
                'top': '100%',
                'bottom': 'auto',
                'margin-top': '8px',
                'margin-right': '0',
                'margin-left': 'auto',
                'z-index': '9999'
            });
        }, 10);
    });
    
    // إصلاح فوري
    fixDropdownPosition();
    
    // إصلاح بعد تحميل الصفحة
    setTimeout(fixDropdownPosition, 100);
    setTimeout(fixDropdownPosition, 500);
    setTimeout(fixDropdownPosition, 1000);
    
    // مراقبة تغييرات DOM
    if (typeof MutationObserver !== 'undefined') {
        var observer = new MutationObserver(function(mutations) {
            fixDropdownPosition();
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true,
            attributes: true,
            attributeFilter: ['class', 'style']
        });
    }
    
    // إصلاح عند scroll
    $(window).on('scroll', function() {
        fixDropdownPosition();
    });
    
    // إصلاح عند resize
    $(window).on('resize', function() {
        fixDropdownPosition();
    });
});
</script>
@endpush

@section('after_styles')
<style>

/* ===============================
   Layout
=============================== */
.container-fluid {
    max-width: 1200px;
}

/* ===============================
   Modern Stat Card Design
=============================== */
.stat-card-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 24px;
    padding: 0;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(102, 126, 234, 0.4);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.stat-card-modern:hover {
    transform: translateY(-8px);
    box-shadow: 0 30px 80px rgba(102, 126, 234, 0.5);
}

.stat-card-content {
    padding: 2rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    position: relative;
    z-index: 2;
}

.stat-card-icon-wrapper {
    position: relative;
    flex-shrink: 0;
}

.stat-card-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    position: relative;
    z-index: 2;
}

.stat-card-icon i {
    font-size: 36px;
    color: #fff;
    font-weight: 900;
}

.stat-card-icon-bg {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100px;
    height: 100px;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
    border-radius: 50%;
    animation: pulse-ring 2s ease-in-out infinite;
    z-index: 1;
}

@keyframes pulse-ring {
    0% {
        transform: translate(-50%, -50%) scale(0.8);
        opacity: 1;
    }
    50% {
        transform: translate(-50%, -50%) scale(1.2);
        opacity: 0.5;
    }
    100% {
        transform: translate(-50%, -50%) scale(0.8);
        opacity: 1;
    }
}

.stat-card-info {
    flex: 1;
    color: #fff;
}

.stat-card-label {
    font-size: 14px;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-card-value {
    font-size: 42px;
    font-weight: 800;
    color: #fff;
    line-height: 1;
    margin-bottom: 4px;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    font-family: 'Cairo', sans-serif;
}

.stat-card-subtitle {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.8);
    font-weight: 500;
}

.stat-card-decoration {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    overflow: hidden;
    z-index: 1;
}

.stat-card-wave {
    position: absolute;
    bottom: -50px;
    right: -50px;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    50% {
        transform: translate(-20px, -20px) scale(1.1);
    }
}

.stat-card-modern::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    animation: rotate 20s linear infinite;
    z-index: 1;
}

@keyframes rotate {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

/* ===============================
   Results Header Modern - Alert Style
=============================== */
.results-header-modern {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
    border-radius: 20px !important;
    padding: 2.5rem 3rem !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    box-shadow: 0 10px 30px rgba(239, 68, 68, 0.4) !important;
    border: none !important;
    position: relative !important;
    overflow: hidden !important;
    min-height: 100px !important;
}

.results-header-modern::before {
    content: '' !important;
    position: absolute !important;
    top: -50% !important;
    right: -50% !important;
    width: 200% !important;
    height: 200% !important;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%) !important;
    animation: pulse 3s ease-in-out infinite !important;
}

.results-header-item {
    display: flex !important;
    align-items: center !important;
    gap: 20px !important;
    font-family: 'Cairo', sans-serif !important;
    position: relative !important;
    z-index: 1 !important;
}

.results-icon-box {
    width: 64px !important;
    height: 64px !important;
    background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
    border-radius: 16px !important;
    box-shadow: 0 8px 20px rgba(111, 106, 248, 0.3) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex-shrink: 0 !important;
}

.results-icon-box i {
    font-size: 28px !important;
    color: #fff !important;
    font-weight: 900 !important;
}

.results-count-item {
    background: transparent !important;
    padding: 0 !important;
    border-radius: 0 !important;
    backdrop-filter: none !important;
    box-shadow: none !important;
}

.results-count-wrapper {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 16px !important;
    position: relative !important;
    z-index: 1 !important;
}

.results-label {
    font-size: 56px !important;
    font-weight: 800 !important;
    color: #ffffff !important;
    text-transform: none !important;
    letter-spacing: 0 !important;
    font-family: 'Cairo', sans-serif !important;
    margin: 0 !important;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3) !important;
}

.results-value {
    font-size: 56px !important;
    font-weight: 800 !important;
    color: #ffffff !important;
    line-height: 1 !important;
    font-family: 'Cairo', sans-serif !important;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3) !important;
    margin: 0 !important;
}

@media (max-width: 768px) {
    .results-header-modern {
        flex-direction: column;
        align-items: stretch;
        gap: 1.5rem;
        padding: 1.5rem 1.5rem;
    }
    
    .results-header-item {
        width: 100%;
        justify-content: flex-start;
    }
    
    .results-count-item {
        width: 100%;
        justify-content: center;
    }
    
    .results-header-item i {
        font-size: 24px;
    }
    
    .results-header-item strong {
        font-size: 28px;
    }
}

/* ===============================
   Dashboard Cards
=============================== */
.dashboard-card {
    border-radius: 20px;
    border: none;
    transition: all 0.3s ease;
}

.dashboard-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.12) !important;
}

.dashboard-card-purple {
    background: linear-gradient(135deg, #f5f3ff, #ede9fe);
    border-left: 4px solid #7c7cff;
}

.dashboard-card-green {
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border-left: 4px solid #22c55e;
}

.icon-box {
    width: 64px;
    height: 64px;
    border-radius: 18px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.icon-box-purple {
    background: linear-gradient(135deg, #6f6af8, #7c7cff);
}

.icon-box-green {
    background: linear-gradient(135deg, #34d399, #22c55e);
}

/* ===============================
   Cards
=============================== */
.card {
    border-radius: 20px;
    border: none;
    background: #fcfdff;
    box-shadow: 0 14px 34px rgba(0,0,0,.07);
}

.filter-card {
    background: #fcfdff;
    box-shadow: 0 10px 28px rgba(0,0,0,.06);
}

/* ===============================
   Inputs
=============================== */
.form-label {
    font-size: 12px;
    font-weight: 700;
    color: #6b7280;
}

.form-control,
.form-select {
    height: 46px;
    border-radius: 14px;
    font-size: 13px;
    border: 1px solid #e5e7eb;
}

.form-control:focus,
.form-select:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,.15);
}

/* ===============================
   Table Card - استخدام نفس خصائص filter-card
=============================== */
.card.filter-card .card-body {
    background: #fcfdff;
    padding: 1.5rem;
}

/* ===============================
   Table
=============================== */
.table-clean {
    border-collapse: separate;
    border-spacing: 0 12px;
    margin-bottom: 0;
    width: 100%;
}

.table-clean thead th {
    font-size: 13px;
    font-weight: 700;
    color: #55607b;
    background: linear-gradient(135deg, #f7f9ff 0%, #f1f5f9 100%);
    border: none;
    padding: 18px 20px;
    text-align: right;
    white-space: nowrap;
    position: relative;
}

.table-clean thead th:first-child {
    border-top-right-radius: 16px;
    border-bottom-right-radius: 16px;
}

.table-clean thead th:last-child {
    border-top-left-radius: 16px;
    border-bottom-left-radius: 16px;
}

.table-clean tbody tr {
    background: #fcfdff;
    box-shadow: 0 4px 16px rgba(0,0,0,.08);
    border-radius: 16px;
    transition: all 0.3s ease;
    border: 1px solid rgba(111, 106, 248, 0.1);
}

.table-clean tbody tr:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(111, 106, 248, 0.2);
    border-color: rgba(111, 106, 248, 0.3);
}

.table-clean td {
    padding: 18px 20px;
    font-size: 13px;
    border: none;
    vertical-align: middle;
    color: #374151;
    font-weight: 500;
}

.table-clean td:first-child {
    border-top-right-radius: 16px;
    border-bottom-right-radius: 16px;
}

.table-clean td:last-child {
    border-top-left-radius: 16px;
    border-bottom-left-radius: 16px;
}

.table-clean tbody tr td:first-child {
    font-weight: 600;
    color: #1f2937;
}

/* ===============================
   Badges
=============================== */
.badge {
    border-radius: 12px;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

.badge-soft-purple {
    background: linear-gradient(135deg, #f5f3ff, #ede9fe);
    color: #6f6af8;
    border: 1px solid rgba(111, 106, 248, 0.2);
}

.badge-success-custom {
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    color: #22c55e;
    border: 1px solid rgba(34, 197, 94, 0.2);
}

.badge-warning-custom {
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    color: #f59e0b;
    border: 1px solid rgba(245, 158, 11, 0.2);
}

.badge-danger-custom {
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    color: #ef4444;
    border: 1px solid rgba(239, 68, 68, 0.2);
}

/* ===============================
   Buttons
=============================== */
.btn-show-results i {
    font-size: 20px !important;
}

/* Action Dropdown Button */
.btn-group .btn-primary.dropdown-toggle {
    background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
    border: none !important;
    border-radius: 12px !important;
    padding: 8px 14px !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    color: #fff !important;
    box-shadow: 0 4px 15px rgba(111, 106, 248, 0.3) !important;
    transition: all 0.2s ease !important;
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
    height: 36px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 6px !important;
}

.btn-group .btn-primary.dropdown-toggle:hover,
.btn-group .btn-primary.dropdown-toggle:focus {
    background: linear-gradient(135deg, #7c7cff 0%, #8b8cff 100%) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 6px 20px rgba(111, 106, 248, 0.4) !important;
}

.btn-group .btn-primary.dropdown-toggle:active {
    transform: translateY(0) !important;
    box-shadow: 0 2px 10px rgba(111, 106, 248, 0.3) !important;
}

/* Dropdown Menu */
.dropdown-menu {
    border: none !important;
    border-radius: 16px !important;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15) !important;
    padding: 8px !important;
    margin-top: 8px !important;
    background: #fff !important;
    min-width: 180px !important;
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
    direction: rtl !important;
}

/* إصلاح موضع Dropdown في الجدول - يظهر على اليمين */
.table-clean td {
    position: relative;
    overflow: visible !important;
}

.table-clean tbody tr {
    position: relative;
    z-index: 1;
}

.table-clean tbody tr:hover {
    z-index: 10;
}

.table-clean tbody tr .btn-group.show {
    z-index: 10000 !important;
}

.table-clean td .btn-group {
    position: relative !important;
    direction: rtl !important;
    display: inline-block !important;
    z-index: 1 !important;
}

.table-clean td .btn-group.show {
    z-index: 10000 !important;
}

.table-clean td .btn-group .dropdown-menu,
.table-clean td .dropdown-menu,
.table-clean td .dropdown-menu-right {
    position: absolute !important;
    right: 0 !important;
    left: auto !important;
    transform: none !important;
    margin-top: 8px !important;
    margin-right: 0 !important;
    margin-left: auto !important;
    direction: rtl !important;
    text-align: right !important;
    top: 100% !important;
    bottom: auto !important;
    z-index: 10001 !important;
}

.table-clean td .btn-group.show .dropdown-menu {
    z-index: 10001 !important;
}

/* إزالة overflow من العناصر المحيطة */
.table-responsive {
    overflow: visible !important;
}

.table-clean {
    overflow: visible !important;
}

.table-card,
.card.filter-card,
.card-body {
    overflow: visible !important;
}

/* Bootstrap override للـ dropdown */
.btn-group.show .dropdown-menu,
.dropdown.show .dropdown-menu {
    display: block !important;
    right: 0 !important;
    left: auto !important;
    transform: none !important;
    position: absolute !important;
    top: 100% !important;
    bottom: auto !important;
    z-index: 10001 !important;
}

/* إصلاح موضع Dropdown في جميع الحالات */
.dropdown-menu-right,
.dropdown-menu[data-popper-placement],
.dropdown-menu.show {
    right: 0 !important;
    left: auto !important;
    transform: none !important;
    direction: rtl !important;
    position: absolute !important;
    top: 100% !important;
    bottom: auto !important;
    z-index: 10001 !important;
}

/* منع Bootstrap من تغيير الموضع */
.table-clean .dropdown-menu[style*="left"],
.table-clean .dropdown-menu[style*="transform"],
.table-clean .dropdown-menu[style*="top: auto"],
.table-clean .dropdown-menu[style*="bottom:"] {
    left: auto !important;
    transform: none !important;
    right: 0 !important;
    top: 100% !important;
    bottom: auto !important;
    z-index: 10001 !important;
}

/* إصلاح z-index للصف عند فتح dropdown */
.table-clean tbody tr:has(.btn-group.show) {
    z-index: 10000 !important;
    position: relative !important;
}

/* إصلاح overflow في الجدول */
.table-responsive {
    overflow: visible !important;
}

.table-clean {
    overflow: visible !important;
}

/* إزالة overflow من جميع العناصر المحيطة */
.card.filter-card,
.card.filter-card .card-body,
.table-card,
.table-card .table-responsive {
    overflow: visible !important;
}

/* التأكد من أن td لا يخفي الـ dropdown */
.table-clean td {
    overflow: visible !important;
}

.table-clean tr {
    overflow: visible !important;
}

/* Dropdown Items */
.dropdown-item {
    padding: 10px 16px !important;
    border-radius: 10px !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    color: #374151 !important;
    transition: all 0.2s ease !important;
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    margin-bottom: 4px !important;
}

.dropdown-item:last-child {
    margin-bottom: 0 !important;
}

.dropdown-item:hover {
    background: linear-gradient(135deg, rgba(111, 106, 248, 0.1) 0%, rgba(124, 124, 255, 0.1) 100%) !important;
    color: #6f6af8 !important;
    transform: translateX(-2px) !important;
}

.dropdown-item:active {
    background: linear-gradient(135deg, rgba(111, 106, 248, 0.15) 0%, rgba(124, 124, 255, 0.15) 100%) !important;
    color: #6f6af8 !important;
}

/* Dropdown Item Icons */
.dropdown-item i {
    font-size: 16px !important;
    width: 20px !important;
    text-align: center !important;
    color: inherit !important;
}

/* Dropdown Divider */
.dropdown-divider {
    margin: 8px 0 !important;
    border-top: 1px solid #e5e7eb !important;
    opacity: 0.5 !important;
}

/* Special Delivery Item */
.dropdown-item[href*="delivery/create"],
.dropdown-item[href*="delivery/create"] i {
    color: #22c55e !important;
}

.dropdown-item[href*="delivery/create"]:hover {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(34, 197, 94, 0.1) 100%) !important;
    color: #16a34a !important;
}

.dropdown-item[href*="delivery/create"]:hover i {
    color: #16a34a !important;
}

.pagination {
    direction: ltr;
}

/* ===============================
   Balance Badges
=============================== */
.badge-balance-positive {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 12px;
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    color: #fff;
    box-shadow: 0 2px 8px rgba(139, 92, 246, 0.25);
}

.badge-balance-negative {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 12px;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #fff;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.25);
}

.badge-balance-zero {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 12px;
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: #fff;
    box-shadow: 0 2px 8px rgba(107, 114, 128, 0.25);
}

/* ===============================
   Bottles Statistics - Unified Design
=============================== */
.bottles-stats-modern {
    background: #ffffff !important;
    border-radius: 20px !important;
    padding: 2rem 2.5rem !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 2rem !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
    border: 2px solid #e5e7eb !important;
    position: relative !important;
    overflow: hidden !important;
}

.bottles-stat-item {
    flex: 1 !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    gap: 12px !important;
    padding: 1.5rem !important;
    border-radius: 16px !important;
    background: #f8fafc !important;
    transition: all 0.3s ease !important;
    position: relative !important;
}

.bottles-stat-item:hover {
    transform: translateY(-4px) !important;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important;
}

.bottles-stat-item:not(:last-child)::after {
    content: '' !important;
    position: absolute !important;
    left: -1rem !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    width: 2px !important;
    height: 60% !important;
    background: #e5e7eb !important;
}

.bottles-stat-label {
    font-size: 16px !important;
    font-weight: 700 !important;
    color: #374151 !important;
    text-align: center !important;
    font-family: 'Cairo', sans-serif !important;
    margin: 0 !important;
}

.bottles-stat-value {
    font-size: 48px !important;
    font-weight: 800 !important;
    line-height: 1 !important;
    font-family: 'Cairo', sans-serif !important;
    margin: 0 !important;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
}

.bottles-stat-green {
    color: #22c55e !important;
}

.bottles-stat-red {
    color: #ef4444 !important;
}

.bottles-stat-purple {
    color: #6f6af8 !important;
}

@media (max-width: 768px) {
    .bottles-stats-modern {
        flex-direction: column !important;
        gap: 1.5rem !important;
        padding: 1.5rem !important;
    }
    
    .bottles-stat-item {
        width: 100% !important;
    }
    
    .bottles-stat-item:not(:last-child)::after {
        display: none !important;
    }
    
    .bottles-stat-value {
        font-size: 36px !important;
    }
}

</style>
@endsection