@extends(backpack_view('blank'))

@section('after_styles')
    {{-- Unified Forms Design System --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    <style>
        /* لا تمدّ الصفحة أفقياً؛ التمرير داخل الغلاف فقط */
        .bulk-delivery-entry-scope.container-fluid {
            max-width: 100%;
            min-width: 0;
            overflow-x: hidden;
            box-sizing: border-box;
        }

        .bulk-entry-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            font-size: 14px;
        }
        .bulk-entry-table th {
            background: var(--primary-deep) !important;
            color: white;
            padding: 12px 8px;
            text-align: center;
            font-weight: 700;
            border: 1px solid rgba(255,255,255,0.1);
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .bulk-entry-table td {
            padding: 12px 8px;
            border: 1px solid #f1f5f9;
            text-align: center;
            vertical-align: middle;
        }
        .bulk-entry-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .bulk-entry-table tr:hover {
            background-color: #f1f5f9;
        }
        .editable-cell {
            background: #fffbeb !important;
            cursor: pointer;
            min-width: 80px;
            transition: all 0.2s ease;
        }
        .editable-cell:hover {
            background: #fef3c7 !important;
        }
        .editable-cell.editing {
            background: white !important;
            border: 2px solid var(--primary-deep) !important;
        }
        .editable-cell input {
            width: 100%;
            border: none;
            padding: 4px;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            background: transparent;
        }
        .readonly-cell {
            background: #f8fafc;
            font-weight: 600;
            color: var(--primary-deep);
        }
        .debt-cell {
            font-weight: 700;
        }
        .debt-cell.positive {
            color: var(--danger-color);
        }
        .debt-cell.negative {
            color: var(--success-gradient);
        }
        .inventory-display {
            background: var(--success-gradient);
            color: white;
            padding: 15px 25px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 25px;
            text-align: center;
            box-shadow: var(--shadow-sm);
        }
        .save-row-btn {
            padding: 6px 16px;
            font-size: 13px;
            font-weight: 700;
            border-radius: 8px !important;
        }
        .table-wrapper {
            max-height: 70vh;
            overflow-y: auto;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            width: 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
        }

        .table-wrapper.bulk-entry-table-inner-scroll > .bulk-entry-table-responsive.table-responsive {
            overflow-x: auto;
            overflow-y: visible;
            width: 100%;
            max-width: 100%;
            min-width: 0;
            -webkit-overflow-scrolling: touch;
        }

        /* إبقاء التمرير داخل div.table-wrapper دون أن يخرج الجدول خارج العرض */
        .bulk-entry-table-inner-scroll .bulk-entry-table {
            min-width: 960px;
            width: 100%;
            table-layout: auto;
        }

        @media (max-width: 768px) {
            .table-wrapper {
                max-height: none !important;
                overflow-x: visible !important;
                overflow-y: visible !important;
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            
            .bulk-entry-table {
                display: block !important;
                width: 100% !important;
                min-width: 100% !important;
                max-width: 100% !important;
                table-layout: fixed !important;
            }
            
            /* Override min-width for mobile */
            @media (max-width: 768px) {
                .bulk-entry-table {
                    min-width: 100% !important;
                }
            }
            
            .bulk-entry-table thead {
                display: none !important;
            }
            
            .bulk-entry-table tbody {
                display: block !important;
                width: 100% !important;
            }
            
            .bulk-entry-table tr {
                display: block !important;
                margin-bottom: 20px !important;
                background: white !important;
                border: 1px solid #e2e8f0 !important;
                border-radius: 12px !important;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
                padding: 15px !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }
            
            .bulk-entry-table td {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                padding: 12px 0 !important;
                border: none !important;
                border-bottom: 1px solid #f1f5f9 !important;
                text-align: right !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }
            
            .bulk-entry-table td:last-child {
                border-bottom: none !important;
            }
            
            .bulk-entry-table td::before {
                content: attr(data-label) !important;
                font-weight: 700 !important;
                color: var(--primary-deep) !important;
                margin-left: 15px !important;
                flex-shrink: 0 !important;
                min-width: 120px !important;
            }
            
            .bulk-entry-table td[data-label=""]::before {
                display: none !important;
            }
            
            .bulk-entry-table td:has(.save-row-btn) {
                justify-content: center !important;
                padding-top: 15px !important;
            }
            
            .bulk-entry-table td:has(.save-row-btn)::before {
                display: none !important;
            }
            
            .readonly-cell {
                flex-direction: column !important;
                align-items: flex-start !important;
            }
            
            .readonly-cell .fw-bold {
                font-size: 16px !important;
                margin-bottom: 5px !important;
            }
            
            .readonly-cell small {
                font-size: 12px !important;
            }
            
            .editable-cell {
                min-width: auto !important;
            }
            
            .save-row-btn {
                width: 100% !important;
                padding: 12px !important;
                font-size: 14px !important;
            }
            
            .inventory-display {
                font-size: 16px !important;
                padding: 12px 20px !important;
                margin-bottom: 20px !important;
            }
            
            .mb-4.d-flex {
                flex-direction: column !important;
                gap: 15px !important;
                align-items: stretch !important;
            }
            
            #save-all-btn {
                width: 100% !important;
                padding: 15px !important;
            }
            
            .container-fluid.pb-4 {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }
        }
        
        /* Tablet - Medium Screens */
        @media (min-width: 769px) and (max-width: 1024px) {
            .table-wrapper {
                max-height: 60vh;
            }
            
            .bulk-entry-table th,
            .bulk-entry-table td {
                padding: 10px 6px;
                font-size: 13px;
            }
            
            .bulk-entry-table th {
                min-width: auto;
            }
        }
        
        /* Ensure container doesn't overflow */
        /* بطاقة فلاتر الإدخال الجماعي — ثلاث صفوف منفصلة */
        .bulk-entry-filters-card .bulk-entry-filter-form .bulk-entry-filter-row {
            margin-inline: 0;
        }

        .bulk-entry-filters-card .bulk-entry-filter-form .bulk-entry-filter-row + .bulk-entry-filter-row {
            padding-top: 1rem;
            margin-top: 0.125rem;
            border-top: 1px solid #e9eef5;
        }

        .bulk-entry-filters-card .bulk-entry-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 700;
            color: var(--primary-deep);
            margin-bottom: 0.4rem;
        }

        .bulk-entry-filters-card .bulk-entry-field-tall .form-select,
        .bulk-entry-filters-card .bulk-entry-field-tall .form-control {
            min-height: 42px;
        }

        .bulk-entry-filters-card .bulk-entry-actions-row {
            gap: 0.75rem;
        }

        .bulk-entry-filters-card .bulk-entry-actions-row .btn {
            padding: 0.55rem 1.25rem;
        }

        /* شريط تاريخ التسليم + الموزّع + الإجراءات — تسمية فوق الحقل */
        .bulk-entry-toolbar-row {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 1rem 1.25rem !important;
            box-shadow: var(--shadow-sm, 0 1px 3px rgba(0, 0, 0, 0.06));
            width: 100%;
        }

        .bulk-entry-toolbar-row .bulk-entry-toolbar-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 700;
            color: var(--primary-deep);
            margin-bottom: 0.4rem;
        }

        .bulk-entry-toolbar-row .bulk-entry-toolbar-field .form-control,
        .bulk-entry-toolbar-row .bulk-entry-toolbar-field .form-select {
            width: 100%;
            max-width: 100%;
        }

        .bulk-entry-toolbar-row .bulk-entry-toolbar-stat-box {
            min-height: 46px;
            display: inline-flex;
            align-items: center;
            padding: 0.45rem 0.95rem;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            background: #f8fafc;
            font-weight: 800;
            font-size: 1.05rem;
            color: var(--primary-deep);
        }

        @media (max-width: 768px) {
            .container-fluid.pb-4 {
                padding-left: 10px !important;
                padding-right: 10px !important;
                max-width: 100% !important;
                overflow-x: hidden !important;
            }
            
            .table-responsive {
                width: 100% !important;
                overflow-x: visible !important;
                overflow-y: visible !important;
            }
        }
        
    </style>
@endsection

@section('content')
<div class="container-fluid pb-4 bulk-delivery-entry-scope">
    {{-- Header --}}
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header" style="background: var(--primary-deep) !important; border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 2rem; box-shadow: var(--shadow-md) !important; width: 100%; display: flex; align-items: center; justify-content: space-between; position: relative; overflow: visible;">
        <div style="display: flex; align-items: center; gap: 1rem; position: relative; z-index: 1;">
            <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.1); border-radius: 16px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                <i class="la la-table" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
            </div>
            <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 800; margin: 0; font-family: 'Cairo', sans-serif;">إدخال جماعي للتسليمات</h1>
        </div>
        <div style="display: flex; align-items: center; gap: 0.75rem; position: relative; z-index: 10;">
            <a href="{{ route('delivery.list', request()->query()) }}" class="btn btn-light" style="color: var(--primary-deep); font-weight: 700; border-radius: 12px;">
                <i class="la la-angle-double-right"></i> العودة للقائمة
            </a>
        </div>
    </section>

    {{-- نفس معاملات GET في BulkDeliveryController — تصفية من الخادم دون أي جافاسكربت ثقيلة --}}
    <div class="filter-card mb-4 bulk-entry-filters-card" style="overflow: visible;">
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between gap-2 flex-wrap" style="background: linear-gradient(135deg, #f8fafc 0%, #fff 100%); border-radius: var(--card-radius, 16px) var(--card-radius, 16px) 0 0;">
            <div class="d-flex align-items-center gap-2">
                <i class="la la-filter" style="color: var(--primary-deep); font-size: 1.35rem;"></i>
                <h6 class="mb-0 fw-bold" style="color: var(--primary-deep);">فلاتر البحث</h6>
            </div>
            <span class="d-none d-md-inline small text-muted" style="font-size: 0.75rem;">ثلاث خطوات: نص ثم اشتراك ثم الأيام</span>
        </div>
        <div class="p-3 pt-4 pb-4">
            <form method="get" action="{{ route('delivery.bulk-entry') }}" class="bulk-entry-filter-form">

                {{-- الصف الأول: بحث نصّي شامل --}}
                <div class="row g-3 bulk-entry-filter-row align-items-end">
                    <div class="col-12 bulk-entry-field-tall">
                        <label class="bulk-entry-label" for="bulk-filter-q"><i class="la la-search me-1"></i> بحث سريع</label>
                        <input id="bulk-filter-q" type="text" name="q" class="form-control" placeholder="اسم المشترك، رقم هاتف، رقم العقد، أو عنوان" value="{{ request('q') }}" autocomplete="off" style="border-radius: 12px;">
                    </div>
                </div>

                {{-- الصف الثاني: الموقع وحالة ونوع الاشتراك (ثلاثة أعمدة متكافئة على الشاشات العريضة) --}}
                <div class="row g-3 bulk-entry-filter-row">
                    <div class="col-12 col-md-4 bulk-entry-field-tall">
                        <label class="bulk-entry-label" for="bulk-filter-city"><i class="la la-map-marker me-1"></i> المدينة</label>
                        <select id="bulk-filter-city" name="city_id" class="form-select" style="border-radius: 12px;">
                            <option value="">الكل</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" @selected(request('city_id') == $city->id)>{{ $city->city_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4 bulk-entry-field-tall">
                        <label class="bulk-entry-label" for="bulk-filter-sub-type"><i class="la la-layer-group me-1"></i> نوع الاشتراك</label>
                        <select id="bulk-filter-sub-type" name="subscription_type_id" class="form-select" style="border-radius: 12px;">
                            <option value="">الكل</option>
                            @foreach($subscriptionTypes as $type)
                                <option value="{{ $type->id }}" @selected(request('subscription_type_id') == $type->id)>{{ $type->type_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4 bulk-entry-field-tall">
                        <label class="bulk-entry-label" for="bulk-filter-sub-status"><i class="la la-tags me-1"></i> حالة الاشتراك</label>
                        <select id="bulk-filter-sub-status" name="subscription_status_id" class="form-select" style="border-radius: 12px;">
                            <option value="">الكل</option>
                            @foreach($subscriptionStatuses as $status)
                                <option value="{{ $status->id }}" @selected($subscriptionStatusFilterId !== null && (int) $status->id === $subscriptionStatusFilterId)>{{ $status->status_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- الصف الثالث: شروط الأيام + أزرار الإجراء --}}
                <div class="row g-3 bulk-entry-filter-row align-items-end">
                    <div class="col-12 col-sm-6 col-lg-3 bulk-entry-field-tall">
                        <label class="bulk-entry-label" for="bulk-filter-min-days"><i class="la la-clock me-1"></i> حد الأيام</label>
                        <input id="bulk-filter-min-days" type="number" name="min_days" min="0" step="1" class="form-control" placeholder="اتركه فارغاً مع «بحث» للافتراضي" value="{{ request('min_days') }}" style="border-radius: 12px;">
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 bulk-entry-field-tall">
                        <label class="bulk-entry-label" for="bulk-filter-days-op"><i class="la la-exchange me-1"></i> مقارنة الأيام</label>
                        <select id="bulk-filter-days-op" name="days_operator" class="form-select" style="border-radius: 12px;">
                            <option value=">=" @selected(request('days_operator', '>=') === '>=')>&ge; أكبر أو يساوي</option>
                            <option value="=" @selected(request('days_operator') === '=')>= يساوي</option>
                            <option value="<=" @selected(request('days_operator') === '<=')>&le; أصغر أو يساوي</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-5 d-flex flex-wrap bulk-entry-actions-row justify-content-lg-end align-items-end">
                        <button type="submit" name="search" value="1" class="btn btn-primary fw-bold flex-grow-1 flex-sm-grow-0" style="border-radius: 12px; min-width: 140px;">
                            <i class="la la-search"></i> بحث
                        </button>
                        <a href="{{ route('delivery.bulk-entry') }}" class="btn btn-outline-secondary fw-bold flex-grow-1 flex-sm-grow-0" style="border-radius: 12px;">مسح الفلاتر</a>
                    </div>
                </div>

            </form>
        </div>
    </div>

    {{-- عرض المخزون الحالي --}}
    <div class="inventory-display">
        <i class="la la-warehouse"></i> المخزون الحالي: <span id="current-inventory">{{ $currentInventory }}</span> عبوة
    </div>

    {{-- تاريخ التسليم + الموزّع — صف واحد شبكي: التسمية فوق الحقل لكل مجموعة --}}
    @if(count($allClients) > 0)
    <div class="mb-4 px-2 bulk-entry-toolbar-row">
        <div class="row g-3 g-lg-4 align-items-end">
            <div class="col-12 col-sm-6 col-lg-3 bulk-entry-toolbar-field">
                <label for="delivery-date-input" class="bulk-entry-toolbar-label mb-0">
                    <i class="la la-calendar"></i> تاريخ التسليم
                </label>
                <input type="date" id="delivery-date-input" class="form-control bulk-entry-toolbar-control" style="border-radius: 12px; border: 2px solid #e2e8f0; padding: 0.5rem 1rem; font-weight: 600;" value="{{ date('Y-m-d') }}" required>
            </div>
            @if(isset($distributors) && $distributors->isNotEmpty())
                @if(!empty($bulkEntryDistributorLocked))
                    <div class="col-12 col-sm-6 col-lg-4 bulk-entry-toolbar-field">
                        <span class="bulk-entry-toolbar-label"><i class="la la-truck"></i> الموزّع</span>
                        <input type="hidden" id="bulk-delivery-distributor-id" value="{{ $defaultBulkEntryDistributorId }}">
                        <div class="form-control fw-bold d-flex align-items-center bulk-entry-toolbar-control" style="border-radius: 12px; border: 2px solid #e2e8f0; padding: 0.5rem 1rem; background: #f8fafc; min-height: 46px;">
                            {{ $bulkEntryDistributorDisplayName ?? '—' }}
                        </div>
                    </div>
                @else
                    <div class="col-12 col-sm-6 col-lg-4 bulk-entry-toolbar-field">
                        <label for="bulk-delivery-distributor-id" class="bulk-entry-toolbar-label mb-0">
                            <i class="la la-truck"></i> الموزّع
                        </label>
                        <select id="bulk-delivery-distributor-id" name="bulk_distributor_id" class="form-select bulk-entry-toolbar-control" style="border-radius: 12px; border: 2px solid #e2e8f0; padding: 0.5rem 1rem; font-weight: 600;" required>
                            @foreach($distributors as $d)
                                <option value="{{ $d->id }}" @selected((int) $d->id === (int) $defaultBulkEntryDistributorId)>{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            @else
                <div class="col-12 col-sm-6 col-lg text-danger fw-bold small d-flex align-items-end">
                    <div><i class="la la-exclamation-triangle"></i> لا يوجد موزّعين — أضف موزّعاً قبل التسجيل.</div>
                </div>
            @endif

            <div class="col-12 col-sm-6 col-lg-2 bulk-entry-toolbar-field">
                <span class="bulk-entry-toolbar-label"><i class="la la-users"></i> عدد المشتركين</span>
                <div class="bulk-entry-toolbar-stat-box w-100 justify-content-center justify-content-sm-start">{{ count($allClients) }}</div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3 bulk-entry-toolbar-field d-flex align-items-end justify-content-stretch justify-content-sm-end">
                <button type="button"
                    class="btn btn-success fw-bold w-100 w-sm-auto"
                    id="save-all-btn"
                    title="حفظ جميع التغييرات"
                    aria-label="حفظ جميع التغييرات"
                    style="padding: 12px 14px; border-radius: 12px !important; min-height: 46px; min-width: 46px;">
                    <i class="la la-save" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- الجدول --}}
    @if(count($allClients) > 0)
    <div class="table-wrapper bulk-entry-table-inner-scroll">
        <div class="table-responsive bulk-entry-table-responsive">
        <table class="bulk-entry-table" id="bulk-entry-table">
            <thead>
                <tr>
                    <th style="min-width: 200px;">اسم المشترك</th>
                    <th style="min-width: 100px;">العبوات المستلمة</th>
                    <th style="min-width: 100px;">العبوات الفارغة</th>
                    <th style="min-width: 120px;">المبلغ المطلوب</th>
                    <th style="min-width: 120px;">المبلغ المدفوع</th>
                    <th style="min-width: 120px;">الدين المتبقي</th>
                    <th style="min-width: 100px;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allClients as $client)
                <tr data-client-id="{{ $client->client_id }}">
                    <td class="readonly-cell text-right ps-4" data-label="اسم المشترك">
                        <div class="fw-bold">{{ $client->client_name ?? $client->name ?? '-' }}</div>
                        <small class="text-muted">{{ $client->phone_one ?? '-' }}</small>
                    </td>
                    <td class="editable-cell" data-field="bottle_received" data-type="number" data-label="العبوات المستلمة">
                        <span class="display-value">0</span>
                        <input type="number" class="edit-input" value="0" min="0" style="display: none;">
                    </td>
                    <td class="editable-cell" data-field="bottle_empty" data-type="number" data-label="العبوات الفارغة">
                        <span class="display-value">0</span>
                        <input type="number" class="edit-input" value="0" min="0" style="display: none;">
                    </td>
                    <td class="editable-cell" data-field="required_amount" data-type="decimal" data-label="المبلغ المطلوب">
                        <span class="display-value">0.00</span>
                        <input type="number" class="edit-input" value="0.00" min="0" step="0.01" style="display: none;">
                    </td>
                    <td class="editable-cell" data-field="paymant" data-type="decimal" data-label="المبلغ المدفوع">
                        <span class="display-value">0.00</span>
                        <input type="number" class="edit-input" value="0.00" min="0" step="0.01" style="display: none;">
                    </td>
                    <td class="readonly-cell debt-cell" data-field="remaining_debt" data-label="الدين المتبقي">
                        <span class="debt-value">0.00</span>
                    </td>
                    <td data-label="">
                        <button type="button" class="btn btn-sm btn-primary save-row-btn" data-client-id="{{ $client->client_id }}">
                            <i class="la la-save"></i> حفظ
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
    @else
    <div class="card p-5 text-center" style="border-radius: 20px;">
        <i class="la la-info-circle" style="font-size: 48px; color: var(--primary-deep); margin-bottom: 15px;"></i>
        <h5 class="fw-bold">لا يوجد مشتركين للعرض</h5>
        <p class="text-muted mb-0">اضبط الفلاتر أعلاه ثم اضغط <strong>بحث</strong> (نفس منطق الصفحة دون تحميل إضافي على المتصفح).</p>
    </div>
    @endif
</div>
@endsection

@section('after_scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('bulk-entry-table');
    const deliveryDateInput = document.getElementById('delivery-date-input');
    const distributorInput = document.getElementById('bulk-delivery-distributor-id');
    let currentEditingCell = null;

    function getDeliveryDate() {
        if (deliveryDateInput && deliveryDateInput.value) return deliveryDateInput.value.trim();
        return new Date().toISOString().split('T')[0];
    }

    function getBulkDistributorId() {
        if (!distributorInput) return null;
        var v = distributorInput.value ? String(distributorInput.value).trim() : '';
        if (v === '') return null;
        var n = parseInt(v, 10);
        return Number.isNaN(n) ? null : n;
    }

    if (table) {
        table.addEventListener('click', function(e) {
            const cell = e.target.closest('.editable-cell');
            if (!cell || cell.classList.contains('editing')) return;
            if (currentEditingCell && currentEditingCell !== cell) finishEditing(currentEditingCell);
            startEditing(cell);
        });

        table.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && currentEditingCell) {
                e.preventDefault();
                const cellToFinish = currentEditingCell;
                finishEditing(cellToFinish);
                moveToNextCell(cellToFinish);
            }
            if (e.key === 'Escape' && currentEditingCell) {
                e.preventDefault();
                cancelEditing(currentEditingCell);
            }
        });

        table.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && e.target.classList.contains('save-row-btn')) {
                e.preventDefault();
                e.target.click();
            }
        });
    }

    function startEditing(cell) {
        const span = cell.querySelector('.display-value');
        const input = cell.querySelector('.edit-input');
        if (!span || !input) return;
        currentEditingCell = cell;
        cell.classList.add('editing');
        span.style.display = 'none';
        input.style.display = 'block';
        input.value = span.textContent.trim();
        input.focus();
        input.select();
    }

    function finishEditing(cell) {
        const span = cell.querySelector('.display-value');
        const input = cell.querySelector('.edit-input');
        if (!span || !input) return;
        let value = input.value.trim();
        const type = cell.dataset.type;
        if (type === 'number') value = Math.max(0, parseInt(value) || 0);
        else if (type === 'decimal') value = Math.max(0, parseFloat(value) || 0).toFixed(2);
        span.textContent = value;
        cell.classList.remove('editing');
        span.style.display = 'inline';
        input.style.display = 'none';
        updateRemainingDebt(cell.closest('tr'));
        currentEditingCell = null;
    }

    function cancelEditing(cell) {
        const span = cell.querySelector('.display-value');
        const input = cell.querySelector('.edit-input');
        if (!span || !input) return;
        cell.classList.remove('editing');
        span.style.display = 'inline';
        input.style.display = 'none';
        currentEditingCell = null;
    }

    function moveToNextCell(currentCell) {
        const row = currentCell.closest('tr');
        const cells = Array.from(row.querySelectorAll('.editable-cell'));
        const currentIndex = cells.indexOf(currentCell);
        if (currentIndex < cells.length - 1) {
            startEditing(cells[currentIndex + 1]);
        } else {
            const saveBtn = row.querySelector('.save-row-btn');
            if (saveBtn) saveBtn.focus();
        }
    }

    function updateRemainingDebt(row) {
        const requiredAmountCell = row.querySelector('[data-field="required_amount"]');
        const paymantCell = row.querySelector('[data-field="paymant"]');
        const debtCell = row.querySelector('[data-field="remaining_debt"]');
        if (!requiredAmountCell || !paymantCell || !debtCell) return;
        const requiredAmount = parseFloat(requiredAmountCell.querySelector('.display-value').textContent) || 0;
        const paymant = parseFloat(paymantCell.querySelector('.display-value').textContent) || 0;
        const remaining = requiredAmount - paymant;
        const debtValue = debtCell.querySelector('.debt-value');
        if (debtValue) {
            debtValue.textContent = Math.abs(remaining).toFixed(2);
            debtCell.classList.remove('positive', 'negative');
            if (remaining > 0) debtCell.classList.add('positive');
            else if (remaining < 0) debtCell.classList.add('negative');
        }
    }

    document.querySelectorAll('.save-row-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const clientId = this.dataset.clientId;
            const row = this.closest('tr');
            if (currentEditingCell) finishEditing(currentEditingCell);
            const deliveryDate = getDeliveryDate();
            if (!deliveryDate) {
                alert('يرجى اختيار تاريخ التسليم من التقويم.');
                return;
            }
            const distributorId = getBulkDistributorId();
            if (distributorId === null) {
                alert('يرجى ضبط الموزّع من القائمة أعلاه (لا يوجد موزّع محدد).');
                return;
            }
            const data = {
                client_id: clientId,
                delivery_date: deliveryDate,
                distributor_id: distributorId,
                bottle_received: parseInt(row.querySelector('[data-field="bottle_received"] .display-value').textContent) || 0,
                bottle_empty: parseInt(row.querySelector('[data-field="bottle_empty"] .display-value').textContent) || 0,
                required_amount: parseFloat(row.querySelector('[data-field="required_amount"] .display-value').textContent) || 0,
                paymant: parseFloat(row.querySelector('[data-field="paymant"] .display-value').textContent) || 0,
            };
            saveSingleDelivery(data, this);
        });
    });

    function saveSingleDelivery(data, button) {
        button.disabled = true;
        button.innerHTML = '<i class="la la-spinner la-spin"></i>';
        fetch('{{ route("delivery.bulk-store-single") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                if (result.inventory !== undefined) document.getElementById('current-inventory').textContent = result.inventory;
                const row = button.closest('tr');
                const nextRow = row.nextElementSibling;
                row.style.transition = 'all 0.4s ease';
                row.style.opacity = '0';
                row.style.transform = 'translateX(50px)';
                row.style.backgroundColor = '#d4edda';
                setTimeout(() => {
                    row.remove();
                    if (nextRow) {
                        const firstCell = nextRow.querySelector('.editable-cell');
                        if (firstCell) startEditing(firstCell);
                    }
                    const countStrong = document.querySelector('strong:contains("عدد المشتركين")') || document.querySelector('.mb-4 strong');
                    if (countStrong) countStrong.textContent = document.querySelectorAll('#bulk-entry-table tbody tr').length;
                    if (document.querySelectorAll('#bulk-entry-table tbody tr').length === 0) window.location.reload();
                }, 400);
                if (typeof Noty !== 'undefined') {
                    new Noty({ type: "success", text: "تم الحفظ بنجاح", timeout: 2000 }).show();
                }
            } else {
                alert('خطأ: ' + (result.message || 'فشل الحفظ'));
                button.disabled = false;
                button.innerHTML = '<i class="la la-save"></i> حفظ';
            }
        })
        .catch(error => {
            alert('حدث خطأ أثناء الحفظ');
            button.disabled = false;
            button.innerHTML = '<i class="la la-save"></i> حفظ';
        });
    }
});
</script>
@endsection
