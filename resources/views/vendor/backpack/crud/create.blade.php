@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    
    {{-- Unified Visual Identity - Create Page --}}
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
            font-family: 'Cairo', sans-serif !important;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
            position: relative !important;
            z-index: 1 !important;
        }

        /* إزالة أيقونات CSS القديمة (::before و ::after) */
        section.header-operation h1::before,
        section.header-operation h1::after {
            display: none !important;
            content: none !important;
        }

        /* مربع احترافي لأيقونة الموزع (يستخدم header-icon-box الآن) */
        .distributor-icon-wrapper {
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

        .distributor-icon-wrapper i {
            font-size: 24px !important;
            color: #fff !important;
            font-weight: 900 !important;
            z-index: 2 !important;
        }

        section.header-operation p,
        section.header-operation p.ms-2,
        section.header-operation p.ml-2,
        section.header-operation p.mb-0 {
            color: rgba(255, 255, 255, 0.9) !important;
            font-size: 14px !important;
            margin: 0 !important;
            margin-top: 4px !important;
            margin-right: 0 !important;
            margin-bottom: 0 !important;
            font-weight: 500 !important;
            position: relative !important;
            z-index: 1 !important;
            line-height: 1.4 !important;
        }

        .header-operation p:empty {
            display: none;
        }

        /* إزالة رابط العودة تماماً */
        section.header-operation p[bp-section="page-subheading-back-button"],
        section.header-operation p.mb-0.ms-2.ml-2:has(small),
        section.header-operation small,
        section.header-operation a.font-sm,
        section.header-operation a.d-print-none {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            height: 0 !important;
            width: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            font-size: 0 !important;
            line-height: 0 !important;
        }

        /* إزالة أي تعارضات */
        section.header-operation.container-fluid {
            padding-left: 2rem !important;
            padding-right: 2rem !important;
        }

        section.header-operation.d-flex {
            display: flex !important;
        }

        section.header-operation.align-items-baseline {
            align-items: center !important;
        }

        section.header-operation.mb-2 {
            margin-bottom: 2rem !important;
        }

        section.header-operation[style*="background"],
        section.header-operation[style*="background-color"] {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            section.header-operation {
                padding: 1.25rem 1.5rem !important;
                border-radius: 16px !important;
            }

            section.header-operation h1 {
                font-size: 20px !important;
            }

            .header-icon-box {
                width: 48px !important;
                height: 48px !important;
            }

            .header-icon-box i {
                font-size: 20px !important;
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

            .header-icon-box {
                width: 44px !important;
                height: 44px !important;
            }

            .header-icon-box i {
                font-size: 18px !important;
            }
        }
    </style>
@endsection

@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.add') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header" style="background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%); border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 2rem; box-shadow: 0 10px 30px rgba(111, 106, 248, 0.3); width: 100%; display: flex; align-items: center; justify-content: space-between; position: relative; overflow: visible;">
        <div style="display: flex; align-items: center; gap: 1rem; position: relative; z-index: 1;">
            @php
                $iconClass = '';
                if(request()->is('*/distributor/create') || request()->is('*/distributor/create/*')) {
                    $iconClass = 'la-user-tie';
                } elseif(request()->is('*/delivery/create') || request()->is('*/delivery/create/*')) {
                    $iconClass = 'la-truck';
                } elseif(request()->is('*/client/create') || request()->is('*/client/create/*')) {
                    $iconClass = 'la-user-friends';
                } elseif(request()->is('*/client-type*/create') || request()->is('*/client-type*/create/*')) {
                    $iconClass = 'la-tags';
                } elseif(request()->is('*/subscription-status*/create') || request()->is('*/subscription-status*/create/*')) {
                    $iconClass = 'la-check-circle';
                } elseif(request()->is('*/subscription-type*/create') || request()->is('*/subscription-type*/create/*')) {
                    $iconClass = 'la-calendar-check';
                } elseif(request()->is('*/client-status*/create') || request()->is('*/client-status*/create/*')) {
                    $iconClass = 'la-info-circle';
                } elseif(request()->is('*/city*/create') || request()->is('*/city*/create/*')) {
                    $iconClass = 'la-map-marker';
                } else {
                    $iconClass = 'la-plus-circle';
                }
            @endphp
            @if($iconClass)
            <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.2); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15); display: flex; align-items: center; justify-content: center;">
                <i class="la {{ $iconClass }}" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
            </div>
            @endif
            <div>
                <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 700; margin: 0; font-family: 'Cairo', sans-serif;">
                    @if(request()->is('*/distributor/create') || request()->is('*/distributor/create/*'))
                        إضافة موزع
                    @elseif(request()->is('*/delivery/create') || request()->is('*/delivery/create/*'))
                        إضافة تسليم
                    @else
                        {!! $crud->getHeading() ?? 'إضافة ' . $crud->entity_name !!}
                    @endif
                </h1>
            </div>
        </div>
    </section>
    {{-- إخفاء breadcrumbs --}}
    <style>
        .breadcrumb,
        .breadcrumb-item,
        nav[aria-label="breadcrumb"],
        ol.breadcrumb {
            display: none !important;
        }
    </style>
@endsection

@section('content')

<div class="row" bp-section="crud-operation-create">
	<div class="{{ $crud->getCreateContentClass() }}">
		{{-- Default box --}}

		@include('crud::inc.grouped_errors')

		  <form method="post"
		  		action="{{ url($crud->route) }}"
				@if ($crud->hasUploadFields('create'))
				enctype="multipart/form-data"
				@endif
		  		>
			  {!! csrf_field() !!}
		      {{-- load the view from the application if it exists, otherwise load the one in the package --}}
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', [ 'fields' => $crud->fields(), 'action' => 'create' ])
		      @else
		      	@include('crud::form_content', [ 'fields' => $crud->fields(), 'action' => 'create' ])
		      @endif
                {{-- This makes sure that all field assets are loaded. --}}
                <div class="d-none" id="parentLoadedAssets">{{ json_encode(Basset::loaded()) }}</div>
	          @include('crud::inc.form_save_buttons')
		  </form>
	</div>
</div>

@endsection

@push('after_scripts')
<script>
// تحويل حقل client_id إلى Select2 مع AJAX
jQuery(document).ready(function($) {
    console.log('Initializing Select2 for client_id field...');
    
    // تحميل Select2 CSS و JS إذا لم يكن محملاً
    function loadSelect2Assets() {
        return new Promise(function(resolve) {
            // التحقق من وجود Select2
            if (typeof $.fn.select2 !== 'undefined') {
                console.log('Select2 already loaded');
                resolve();
                return;
            }
            
            // تحميل CSS
            if (!$('link[href*="select2"]').length) {
                var cssLink = document.createElement('link');
                cssLink.rel = 'stylesheet';
                cssLink.href = 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css';
                document.head.appendChild(cssLink);
                console.log('Select2 CSS loaded');
            }
            
            // تحميل JS
            if (!$('script[src*="select2"]').length) {
                var script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js';
                script.onload = function() {
                    console.log('Select2 JS loaded');
                    // تحميل اللغة العربية
                    var langScript = document.createElement('script');
                    langScript.src = 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/ar.js';
                    langScript.onload = function() {
                        console.log('Select2 Arabic language loaded');
                        resolve();
                    };
                    document.head.appendChild(langScript);
                };
                script.onerror = function() {
                    console.error('Failed to load Select2');
                    resolve(); // نتابع حتى لو فشل التحميل
                };
                document.head.appendChild(script);
            } else {
                resolve();
            }
        });
    }
    
    function initClientSelect2() {
        var $clientSelect = $('select[name="client_id"], select.client-select-ajax');
        
        console.log('Looking for client select field:', $clientSelect.length);
        
        if ($clientSelect.length === 0) {
            console.warn('Client select field not found');
            return false;
        }
        
        if (typeof $.fn.select2 === 'undefined') {
            console.warn('Select2 not available');
            return false;
        }
        
        // إذا كان Select2 مُهيأ بالفعل، لا نعيد التهيئة
        if ($clientSelect.hasClass('select2-hidden-accessible')) {
            console.log('Select2 already initialized');
            return true;
        }
        
        var ajaxUrl = $clientSelect.data('ajax-url');
        var minimumInputLength = parseInt($clientSelect.data('minimum-input-length')) || 2;
        var placeholder = $clientSelect.data('placeholder') || 'ابحث عن العميل...';
        
        console.log('Initializing Select2 with AJAX URL:', ajaxUrl);
        
        if (ajaxUrl) {
            $clientSelect.select2({
                placeholder: placeholder,
                allowClear: true,
                language: 'ar',
                dir: 'rtl',
                ajax: {
                    url: ajaxUrl,
                    dataType: 'json',
                    delay: 300,
                    data: function(params) {
                        return {
                            q: params.term || '',
                            id: $clientSelect.val() || null
                        };
                    },
                    processResults: function(data) {
                        console.log('Processed results:', data);
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.text
                                };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: minimumInputLength
            });
            console.log('Select2 initialized successfully');
        } else {
            console.warn('No AJAX URL found, initializing Select2 without AJAX');
            $clientSelect.select2({
                placeholder: placeholder,
                allowClear: true,
                language: 'ar',
                dir: 'rtl'
            });
        }
        
        return true;
    }
    
    // تهيئة Select2 بعد تحميل الأصول
    function initialize() {
        loadSelect2Assets().then(function() {
            setTimeout(function() {
                if (!initClientSelect2()) {
                    // إعادة المحاولة
                    setTimeout(function() {
                        initClientSelect2();
                    }, 1000);
                }
            }, 500);
        });
    }
    
    // تهيئة Select2
    initialize();
    
    // إعادة المحاولة إذا لم يتم التحميل
    var retryCount = 0;
    var retryInterval = setInterval(function() {
        if (typeof $.fn.select2 !== 'undefined') {
            if (initClientSelect2()) {
                clearInterval(retryInterval);
            }
        }
        retryCount++;
        if (retryCount >= 20) {
            console.error('Failed to initialize Select2 after 20 attempts');
            clearInterval(retryInterval);
        }
    }, 500);
});
</script>
@endpush

@push('after_scripts')
<script>
(function() {
    // إزالة رابط العودة تماماً من DOM
    function removeBackLink() {
        // إزالة paragraph الذي يحتوي على رابط العودة
        var backLinkParagraph = document.querySelector('section.header-operation p[bp-section="page-subheading-back-button"]');
        if (backLinkParagraph) {
            backLinkParagraph.remove();
        }

        // إزالة جميع عناصر small في الهيدر
        var smallElements = document.querySelectorAll('section.header-operation small');
        smallElements.forEach(function(small) {
            small.remove();
        });

        // إزالة أي paragraph يحتوي على small
        var paragraphs = document.querySelectorAll('section.header-operation p');
        paragraphs.forEach(function(p) {
            var small = p.querySelector('small');
            if (small) {
                p.remove();
            }
        });

        // إزالة جميع الروابط التي تحتوي على "العودة"
        var allLinks = document.querySelectorAll('section.header-operation a');
        allLinks.forEach(function(link) {
            var text = link.textContent || '';
            var href = link.getAttribute('href') || '';
            
            if (text.includes('العودة') || 
                text.includes('back_to_all') ||
                text.includes('العودة إلى الكل') ||
                link.classList.contains('font-sm') ||
                link.classList.contains('d-print-none')) {
                var parent = link.parentElement;
                if (parent && (parent.tagName === 'SMALL' || parent.tagName === 'P')) {
                    parent.remove();
                } else {
                    link.remove();
                }
            }
        });

        // إزالة أي عنصر يحتوي على span مع نص "العودة"
        var spans = document.querySelectorAll('section.header-operation span');
        spans.forEach(function(span) {
            var text = span.textContent || '';
            if (text.includes('العودة') || text.includes('العودة إلى الكل')) {
                var parent = span.parentElement;
                if (parent) {
                    parent.remove();
                }
            }
        });
    }

    // تنفيذ فوري
    removeBackLink();

    // تنفيذ بعد تحميل DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(removeBackLink, 50);
            setTimeout(removeBackLink, 100);
            setTimeout(removeBackLink, 300);
            setTimeout(removeBackLink, 500);
            setTimeout(removeBackLink, 1000);
        });
    } else {
        setTimeout(removeBackLink, 50);
        setTimeout(removeBackLink, 100);
        setTimeout(removeBackLink, 300);
        setTimeout(removeBackLink, 500);
        setTimeout(removeBackLink, 1000);
    }

    // مراقبة تغييرات DOM بشكل مستمر
    if (typeof MutationObserver !== 'undefined') {
        var observer = new MutationObserver(function(mutations) {
            removeBackLink();
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true,
            attributes: false,
            characterData: false
        });

        var headerSection = document.querySelector('section.header-operation');
        if (headerSection) {
            var headerObserver = new MutationObserver(function(mutations) {
                removeBackLink();
            });

            headerObserver.observe(headerSection, {
                childList: true,
                subtree: true,
                attributes: false,
                characterData: false
            });
        }
    }

    // تنفيذ دوري كل ثانية لمدة 5 ثوان
    var intervalCount = 0;
    var interval = setInterval(function() {
        removeBackLink();
        intervalCount++;
        if (intervalCount >= 5) {
            clearInterval(interval);
        }
    }, 1000);

    // إزالة أيقونة السيارة من صفحة إضافة موزع
    if (window.location.href.indexOf('/distributor/create') !== -1) {
        var h1Element = document.querySelector('section.header-operation h1');
        if (h1Element) {
            h1Element.style.setProperty('padding-right', '0', 'important');
            var style = document.createElement('style');
            style.textContent = `
                section.header-operation h1::before,
                section.header-operation h1::after {
                    display: none !important;
                }
            `;
            document.head.appendChild(style);
        }
    }
})();
</script>
@endpush

