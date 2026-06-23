@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    
    {{-- Unified Visual Identity - All CRUD Form Pages --}}
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
            padding-right: 70px !important;
            padding-left: 0 !important;
            line-height: 1.2 !important;
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
        section.header-operation p.mb-0.ms-2.ml-2,
        section.header-operation p.mb-0.ms-2.ml-2 small,
        section.header-operation small,
        section.header-operation a[href*="/delivery"],
        section.header-operation a[href*="/client"],
        section.header-operation a[href*="/distributor"],
        section.header-operation a[href*="/city"],
        section.header-operation a[href*="/subscription"],
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

        /* إخفاء أي عنصر يحتوي على نص "العودة" */
        section.header-operation *:contains("العودة"),
        section.header-operation *:contains("back_to_all") {
            display: none !important;
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
    @include('admin.partials.client_select_search_assets')
@endsection

@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        $crud->entity_name_plural => url($crud->route),
        Str::of($crud->getCurrentOperation())->headline()->toString() => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
<section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header">
    <div class="header-content-wrapper" style="display: flex; align-items: center; gap: 1rem; width: 100%;">
        <h1 class="text-capitalize mb-0" bp-section="page-heading">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</h1>
        <p class="ms-2 ml-2 mb-0" bp-section="page-subheading">{!! $crud->getSubheading() ?? Str::of($operation)->headline() !!}</p>
    </div>
</section>
{{-- إخفاء breadcrumbs وروابط العودة --}}
<style>
    .breadcrumb,
    .breadcrumb-item,
    nav[aria-label="breadcrumb"],
    ol.breadcrumb {
        display: none !important;
    }

    /* إخفاء رابط العودة بقوة */
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
</style>
@endsection

@section('content')

<div class="row" bp-section="crud-operation-{{ Str::of($operation)->kebab() }}">
    <div class="{{ $crud->get($operation.'.contentClass') }}">
        {{-- Default box --}}

        @include('crud::inc.grouped_errors')

        <form
            method="{{ $formMethod ?? 'post' }}"
            action="{{ $formAction ?? url()->current() }}"
            @if ($crud->hasUploadFields())
            enctype="multipart/form-data"
            @endif
            >
            {!! csrf_field() !!}
            {!! method_field($formMethod ?? 'post') !!}

            {{-- load the view from the application if it exists, otherwise load the one in the package --}}
            @if(view()->exists('vendor.backpack.crud.form_content'))
                @include('vendor.backpack.crud.form_content', [ 'fields' => $crud->fields(), 'action' => $operation ])
            @else
                @include('crud::form_content', [ 'fields' => $crud->fields(), 'action' => $operation ])
            @endif
            {{-- This makes sure that all field assets are loaded. --}}
            <div class="d-none" id="parentLoadedAssets">{{ json_encode(Basset::loaded()) }}</div>
            @include('crud::inc.form_save_buttons')
        </form>
    </div>
</div>

@endsection

@section('after_scripts')
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
                href.includes('/delivery') && !href.includes('/create') ||
                link.classList.contains('font-sm') ||
                link.classList.contains('d-print-none')) {
                // إزالة العنصر الأب إذا كان paragraph أو small
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

        // مراقبة section.header-operation بشكل خاص
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
})();
</script>
@endsection

