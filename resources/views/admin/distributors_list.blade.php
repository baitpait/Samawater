@extends(backpack_view('blank'))

@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">
    
    {{-- Unified Header Styles --}}
    <style>
        /* ============================================
           Page Header - Unified Design
           ============================================ */
        section.header-operation,
        section.header-operation.container-fluid,
        section.header-operation.animated,
        section.header-operation.fadeIn {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
            border-radius: 20px !important;
            padding: 1.5rem 2rem !important;
            margin-bottom: 2rem !important;
            box-shadow: 0 10px 30px rgba(111, 106, 248, 0.3) !important;
            position: relative !important;
            overflow: hidden !important;
            height: auto !important;
            min-height: auto !important;
            max-height: none !important;
            width: 100% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-wrap: wrap !important;
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
            0%, 100% {
                opacity: 0.5;
            }
            50% {
                opacity: 0.8;
            }
        }

        section.header-operation h1,
        section.header-operation h1.text-capitalize,
        section.header-operation h1.mb-0 {
            color: #fff !important;
            font-size: 24px !important;
            font-weight: 700 !important;
            margin: 0 !important;
            margin-bottom: 0 !important;
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
            position: relative !important;
            z-index: 1 !important;
            display: flex !important;
            align-items: center !important;
            gap: 1rem !important;
            padding-right: 0 !important;
            padding-left: 0 !important;
            line-height: 1.2 !important;
        }

        section.header-operation i {
            font-size: 28px !important;
            color: #fff !important;
            font-weight: 900 !important;
            position: relative !important;
            z-index: 1 !important;
        }
        
        /* Unified Header Design - Header الجديد */
        section.header-operation-unified {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
            border-radius: 20px !important;
            padding: 1.5rem 2rem !important;
            margin-bottom: 2rem !important;
            box-shadow: 0 10px 30px rgba(111, 106, 248, 0.3) !important;
            position: relative !important;
            overflow: hidden !important;
            width: 100% !important;
            display: block !important;
        }
        
        section.header-operation-unified h1 {
            color: #fff !important;
            font-size: 24px !important;
            font-weight: 700 !important;
            margin: 0 !important;
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
            position: relative !important;
            z-index: 1 !important;
        }
        
        section.header-operation-unified i {
            font-size: 28px !important;
            color: #fff !important;
            font-weight: 900 !important;
            position: relative !important;
            z-index: 1 !important;
        }
        
        /* إخفاء جميع headers الافتراضية */
        div.container-fluid.d-flex.justify-content-between.my-3,
        div.container-fluid.d-flex.justify-content-between,
        section.header-operation:not(.header-operation-unified),
        section.header-operation.container-fluid:not(.header-operation-unified),
        section.header-operation.animated:not(.header-operation-unified),
        section.header-operation.fadeIn:not(.header-operation-unified) {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        /* إخفاء h1 الافتراضي */
        h1.text-capitalize.mb-0:not(section.header-operation-unified h1) {
            display: none !important;
        }

        /* إخفاء header الافتراضي من Backpack */
        div.container-fluid.d-flex.justify-content-between.my-3,
        div.container-fluid.d-flex.justify-content-between,
        section.header-operation:not(.header-operation) {
            display: none !important;
        }
        
        /* إخفاء widgets القديمة - فقط العناصر الفارغة */
        .col-sm-6.col-lg-3:empty,
        div[class*="col-sm"]:empty,
        div[class*="col-lg"]:empty {
            display: none !important;
        }
        
        /* التأكد من ظهور محتوى card-body */
        .filter-card .card-body {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            min-height: auto !important;
        }
        
        .filter-card .card-body form {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .filter-card .card-body .row {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .filter-card .card-body .col-12,
        .filter-card .card-body .col-md-6,
        .filter-card .card-body .col-lg-7,
        .filter-card .card-body .col-lg-5 {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* مربع احترافي لأيقونة header */
        .header-icon-wrapper {
            width: 56px !important;
            height: 56px !important;
            background: rgba(255, 255, 255, 0.2) !important;
            border-radius: 16px !important;
            backdrop-filter: blur(10px) !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            position: relative !important;
        }

        .header-icon-wrapper i {
            font-size: 24px !important;
            color: #fff !important;
            font-weight: 900 !important;
            z-index: 2 !important;
        }
        
        /* زر إضافة موزع في header */
        .btn-success-unified {
            background: rgba(255, 255, 255, 0.2) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            color: #fff !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            font-family: 'Cairo', sans-serif !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
        }
        
        .btn-success-unified:hover {
            background: rgba(255, 255, 255, 0.3) !important;
            transform: translateY(-2px) !important;
            color: #fff !important;
        }
    </style>
@endsection

@section('header')
    {{-- Unified Header Design - الهوية البصرية الموحدة --}}
    <section class="header-operation-unified" style="background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%); border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 2rem; box-shadow: 0 10px 30px rgba(111, 106, 248, 0.3); position: relative; overflow: hidden;">
        {{-- Background Animation Effect --}}
        <div style="content: ''; position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite; pointer-events: none;"></div>
        
        {{-- Header Content --}}
        <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div class="header-icon-wrapper">
                    <i class="la la-user-friends"></i>
                </div>
                <h1 style="color: #fff; font-size: 24px; font-weight: 700; margin: 0; font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                    الموزعين
                </h1>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <a href="{{ backpack_url('distributor/create') }}" class="btn btn-success-unified">
                    <i class="la la-plus"></i>
                    إضافة موزع
                </a>
            </div>
        </div>
    </section>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Search and Add Button - Unified Design -->
        <div class="card filter-card mb-4" style="background: #fcfdff; border-radius: 20px; border: none; box-shadow: 0 10px 28px rgba(0, 0, 0, 0.06); overflow: visible;">
            <div class="card-body" style="padding: 1.5rem; display: block !important; visibility: visible !important; opacity: 1 !important;">
                <form method="GET" action="{{ url(config('backpack.base.route_prefix') . '/distributors-list') }}" style="display: block !important; visibility: visible !important; opacity: 1 !important;">
                    <div class="row g-3 align-items-end" style="display: flex !important; visibility: visible !important; opacity: 1 !important; margin: 0;">
                        {{-- البحث --}}
                        <div class="col-12 col-md-10 col-lg-11" style="display: block !important; visibility: visible !important; opacity: 1 !important;">
                            <label class="form-label" style="font-size: 14px; font-weight: 600; color: #55607b; margin-bottom: 8px; display: block; visibility: visible !important; opacity: 1 !important;">
                                <i class="la la-search" style="margin-left: 6px; color: #6f6af8;"></i>
                                بحث
                            </label>
                            <input 
                                type="text" 
                                name="search" 
                                class="form-control modern-input" 
                                placeholder="اسم الموزع، رقم الهاتف، أو اسم المستخدم"
                                value="{{ request('search') }}"
                                style="height: 50px; font-size: 15px; padding: 14px 20px; font-family: 'Cairo', sans-serif; display: block !important; visibility: visible !important; opacity: 1 !important; width: 100%;"
                            >
                        </div>

                        {{-- الأزرار --}}
                        <div class="col-12 col-md-2 col-lg-1" style="display: block !important; visibility: visible !important; opacity: 1 !important;">
                            <button type="submit" class="btn btn-show-results w-100" title="عرض النتائج" style="height: 50px; display: flex !important; align-items: center; justify-content: center; font-size: 20px; min-width: 60px; visibility: visible !important; opacity: 1 !important;">
                                <i class="la la-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table - Unified Design -->
        <div class="card filter-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-clean align-middle mb-0" id="distributorsTable">
                        <thead>
                            <tr>
                                <th>
                                    <a href="{{ url(config('backpack.base.route_prefix') . '/distributors-list') }}?sort_by=name&sort_dir={{ request('sort_dir') == 'asc' ? 'desc' : 'asc' }}{{ request('search') ? '&search=' . request('search') : '' }}">
                                        اسم الموزع
                                        @if(request('sort_by') == 'name')
                                            <i class="la la-sort-{{ request('sort_dir') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ url(config('backpack.base.route_prefix') . '/distributors-list') }}?sort_by=phone&sort_dir={{ request('sort_dir') == 'asc' ? 'desc' : 'asc' }}{{ request('search') ? '&search=' . request('search') : '' }}">
                                        رقم الهاتف
                                        @if(request('sort_by') == 'phone')
                                            <i class="la la-sort-{{ request('sort_dir') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ url(config('backpack.base.route_prefix') . '/distributors-list') }}?sort_by=username&sort_dir={{ request('sort_dir') == 'asc' ? 'desc' : 'asc' }}{{ request('search') ? '&search=' . request('search') : '' }}">
                                        اسم المستخدم
                                        @if(request('sort_by') == 'username')
                                            <i class="la la-sort-{{ request('sort_dir') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ url(config('backpack.base.route_prefix') . '/distributors-list') }}?sort_by=balance&sort_dir={{ request('sort_dir') == 'asc' ? 'desc' : 'asc' }}{{ request('search') ? '&search=' . request('search') : '' }}">
                                        الرصيد الحالي
                                        @if(request('sort_by') == 'balance')
                                            <i class="la la-sort-{{ request('sort_dir') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($distributors as $distributor)
                                <tr>
                                    <td>{{ $distributor->name }}</td>
                                    <td>{{ $distributor->phone }}</td>
                                    <td>{{ $distributor->username }}</td>
                                    <td style="font-weight: 600; color: #1f2937;">₪ {{ number_format($distributor->balance, 2) }}</td>
                                    <td>
                                        <div class="btn-group unified-actions-dropdown dropdown" style="position: relative;">
                                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="la la-cog"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="{{ url(config('backpack.base.route_prefix') . '/distributor/' . $distributor->id . '/show') }}">
                                                    <i class="la la-eye"></i> معاينة
                                                </a></li>
                                                <li><a class="dropdown-item" href="{{ url(config('backpack.base.route_prefix') . '/distributor/' . $distributor->id . '/edit') }}">
                                                    <i class="la la-edit"></i> تعديل
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><button type="button" class="dropdown-item open-withdraw-modal" 
                                                        data-id="{{ $distributor->id }}" 
                                                        data-balance="{{ $distributor->balance }}">
                                                    <i class="la la-money-bill"></i> سحب
                                                </button></li>
                                                <li><a class="dropdown-item" href="{{ url(config('backpack.base.route_prefix') . '/distributor/' . $distributor->id . '/financial-report') }}">
                                                    <i class="la la-file-invoice-dollar"></i> التقرير المالي
                                                </a></li>
                                                <li><a class="dropdown-item" href="{{ url(config('backpack.base.route_prefix') . '/distributor/' . $distributor->id . '/clients') }}">
                                                    <i class="la la-users"></i> المشتركين
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#" 
                                                   onclick="event.preventDefault(); if(confirm('هل أنت متأكد من حذف هذا الموزع؟')) { document.getElementById('delete-form-{{ $distributor->id }}').submit(); }">
                                                    <i class="la la-trash"></i> حذف
                                                </a></li>
                                                <form id="delete-form-{{ $distributor->id }}" 
                                                      action="{{ url(config('backpack.base.route_prefix') . '/distributor/' . $distributor->id) }}" 
                                                      method="POST" 
                                                      style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">لا توجد بيانات</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2">
                            <span>عرض:</span>
                            <select class="form-control form-control-sm" style="width: auto;" onchange="window.location.href='{{ url(config('backpack.base.route_prefix') . '/distributors-list') }}?per_page=' + this.value + '{{ request('search') ? '&search=' . request('search') : '' }}'">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            {{ $distributors->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('after_styles')
<style>
    /* Unified Table Styles */
    .table-clean {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    .table-clean thead th {
        background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%);
        color: #fff;
        font-weight: 600;
        padding: 1rem;
        border: none;
        font-family: 'Cairo', sans-serif;
        font-size: 14px;
    }

    .table-clean tbody tr {
        border-bottom: 1px solid #e5e7eb;
        transition: all 0.2s ease;
    }

    .table-clean tbody tr:hover {
        background: #f7f9ff;
    }

    .table-clean tbody td {
        padding: 1rem;
        color: #1f2937;
        font-family: 'Cairo', sans-serif;
        font-size: 14px;
        vertical-align: middle;
    }

    .table-responsive {
        overflow-x: auto !important;
        overflow-y: visible !important;
    }
    
    table.table {
        min-width: 800px;
    }
    
    .card {
        overflow: visible !important;
    }
    
    .card-body {
        overflow: visible !important;
    }
    
    .filter-card {
        overflow: visible !important;
    }
    
    /* إصلاح overflow لجميع العناصر المحيطة */
    .container-fluid,
    .row,
    .col-md-12,
    .col-sm-12,
    div[class*="col-"] {
        overflow: visible !important;
    }
    
    table tbody tr {
        position: relative !important;
        z-index: 1 !important;
    }
    
    table tbody tr:hover {
        z-index: 2 !important;
    }
    
    table tbody tr td {
        position: relative !important;
        overflow: visible !important;
    }
    
    /* رفع z-index للصف الذي يحتوي على dropdown مفتوح */
    table tbody tr:has(.dropdown.show) {
        z-index: 1000 !important;
        position: relative !important;
    }
    
    .btn-group {
        position: relative !important;
        z-index: 1050 !important;
    }
    
    .unified-actions-dropdown {
        position: relative !important;
        z-index: 1051 !important;
    }
    
    .dropdown {
        position: relative !important;
    }
    
    .dropdown-menu {
        z-index: 99999 !important;
        position: fixed !important;
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        min-width: 10rem !important;
        background: #fff !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 8px !important;
    }
    
    .dropdown-menu.show {
        z-index: 99999 !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
    
    table tbody tr .dropdown-menu {
        z-index: 99999 !important;
    }
</style>
@endsection

@section('after_scripts')
@include('admin.financial_report_modal')
@include('admin.distributor_withdraw_modal')

<script>
(function() {
    'use strict';
    
    // Helper functions
    function $(selector) {
        return document.querySelector(selector);
    }
    
    function $$(selector) {
        return document.querySelectorAll(selector);
    }
    
    function hasClass(element, className) {
        return element.classList.contains(className);
    }
    
    function addClass(element, className) {
        element.classList.add(className);
    }
    
    function removeClass(element, className) {
        element.classList.remove(className);
    }
    
    function closest(element, selector) {
        while (element && element.nodeType === 1) {
            if (element.matches(selector)) {
                return element;
            }
            element = element.parentElement;
        }
        return null;
    }
    
    // دالة لإغلاق جميع dropdowns
    function closeAllDropdowns() {
        var allDropdowns = $$('.unified-actions-dropdown.dropdown');
        allDropdowns.forEach(function(dropdown) {
            removeClass(dropdown, 'show');
            var menu = dropdown.querySelector('.dropdown-menu');
            if (menu) {
                removeClass(menu, 'show');
                menu.style.display = 'none';
            }
        });
    }
    
    // تهيئة Bootstrap 5 dropdown يدوياً
    function initBootstrapDropdowns() {
        // إزالة event listeners القديمة
        var oldToggles = $$('.unified-actions-dropdown .dropdown-toggle');
        oldToggles.forEach(function(toggle) {
            var newToggle = toggle.cloneNode(true);
            toggle.parentNode.replaceChild(newToggle, toggle);
        });
        
        // تهيئة جميع dropdowns
        var toggles = $$('.unified-actions-dropdown .dropdown-toggle');
        toggles.forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var dropdown = closest(toggle, '.dropdown');
                if (!dropdown) return;
                
                var menu = dropdown.querySelector('.dropdown-menu');
                if (!menu) return;
                
                var isOpen = hasClass(dropdown, 'show');
                
                // إغلاق جميع dropdowns الأخرى أولاً
                closeAllDropdowns();
                
                // إذا كان dropdown مفتوحاً، أغلقه
                if (isOpen) {
                    removeClass(dropdown, 'show');
                    removeClass(menu, 'show');
                    menu.style.display = 'none';
                } else {
                    // إذا كان dropdown مغلقاً، افتحه
                    addClass(dropdown, 'show');
                    addClass(menu, 'show');
                    menu.style.display = 'block';
                    
                    // إصلاح الموضع باستخدام position: fixed
                    var buttonRect = toggle.getBoundingClientRect();
                    var menuWidth = menu.offsetWidth || 180;
                    var windowWidth = window.innerWidth;
                    var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    var scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
                    
                    // حساب الموضع المطلق للزر
                    var newLeft = buttonRect.left + buttonRect.width + 8;
                    var newTop = buttonRect.top;
                    
                    // استخدام position: fixed لتجنب مشاكل overflow
                    menu.style.position = 'fixed';
                    menu.style.left = newLeft + 'px';
                    menu.style.right = 'auto';
                    menu.style.top = newTop + 'px';
                    menu.style.bottom = 'auto';
                    menu.style.marginLeft = '0';
                    menu.style.marginTop = '0';
                    menu.style.zIndex = '99999';
                    menu.style.transform = 'none';
                    
                    // إذا كانت القائمة ستخرج عن الشاشة من اليمين، نضعها على يسار الزر
                    if (newLeft + menuWidth > windowWidth) {
                        menu.style.left = (buttonRect.left - menuWidth - 8) + 'px';
                        menu.style.right = 'auto';
                    }
                    
                    // رفع z-index للصف الذي يحتوي على dropdown
                    var tr = closest(toggle, 'tr');
                    if (tr) {
                        tr.style.zIndex = '1000';
                        tr.style.position = 'relative';
                    }
                }
            });
        });
        
        // إغلاق dropdown عند النقر خارجها
        document.addEventListener('click', function(e) {
            var clickedElement = e.target;
            var isInsideDropdown = closest(clickedElement, '.unified-actions-dropdown');
            
            if (!isInsideDropdown) {
                closeAllDropdowns();
            }
        }, true);
    }
    
    // تشغيل الكود بعد تحميل DOM
    function init() {
        initBootstrapDropdowns();
    }
    
    // تشغيل عند تحميل الصفحة
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(init, 100);
            setTimeout(init, 500);
            setTimeout(init, 1000);
        });
    } else {
        setTimeout(init, 100);
        setTimeout(init, 500);
        setTimeout(init, 1000);
    }
})();
</script>
@endsection

