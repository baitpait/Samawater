{{-- Business Purpose: أصول Select2 الموحّدة لقوائم اختيار المشترك (مرة واحدة لكل صفحة). --}}
@once
    @push('after_styles')
        <style>
            .client-select-searchable + .select2-container {
                width: 100% !important;
            }
            .client-select-searchable + .select2-container .select2-selection {
                min-height: 48px;
                border: 2px solid #e2e8f0;
                border-radius: 12px;
                padding: 6px 10px;
            }
            .select2-container--bootstrap .select2-search--dropdown .select2-search__field {
                border-radius: 8px;
            }
        </style>
    @endpush
    @push('after_scripts')
        <script src="{{ asset('js/client-select-search.js') }}?v=1"></script>
    @endpush
@endonce
