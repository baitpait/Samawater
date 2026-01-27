@extends(backpack_view('blank'))

@section('after_styles')
    <style>
        /* Ensure CRUD list table uses full width like the custom design */
        #crudTable,
        #crudTable_wrapper,
        .dataTables_wrapper,
        .dataTables_scroll,
        .dataTables_scrollHead,
        .dataTables_scrollBody,
        .dataTables_scrollHeadInner,
        .table-responsive,
        .card,
        .card-body {
            width: 100% !important;
            max-width: 100% !important;
        }

        /* Remove unexpected centering or shrinking from DataTables rows */
        .dataTables_wrapper .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
            width: 100% !important;
        }

        .dataTables_wrapper .row > [class*="col-"] {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* Keep table layout consistent and aligned */
        #crudTable {
            table-layout: auto !important;
        }

        /* Prevent header pill from floating or shrinking */
        #crudTable thead,
        #crudTable thead tr,
        #crudTable thead th {
            width: auto !important;
            white-space: nowrap;
        }
    </style>
@endsection

@section('before_scripts')
    {{-- تحميل jQuery و Noty قبل أي سكربتات للقائمة --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/noty@3.2.0-beta-deprecated/lib/noty.min.js"></script>
@endsection

@section('content')
    @include('crud::list')
@endsection

@section('after_scripts')
    @include('admin.distributor_list_scripts')
@endsection