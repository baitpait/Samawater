@extends(backpack_view('blank'))

@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
@endsection

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header" style="background: var(--primary-deep) !important; border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 2rem; box-shadow: var(--shadow-md) !important; width: 100%; display: flex; align-items: center; justify-content: space-between; position: relative; overflow: visible;">
        <div style="display: flex; align-items: center; gap: 1rem; position: relative; z-index: 1;">
            <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.1); border-radius: 16px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                <i class="la la-tools" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
            </div>
            <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 800; margin: 0; font-family: 'Cairo', sans-serif;">تشخيص النظام</h1>
        </div>
    </section>
@endsection

@section('content')
<div class="container-fluid pb-4">
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-primary-deep text-white fw-bold p-3">
                    <i class="la la-database"></i> حالة البيانات
                </div>
                <div class="card-body p-4">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <span>عدد الفواتير</span>
                            <span class="badge bg-primary-deep text-white">{{ $data['invoices_count'] }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <span>عدد العملاء</span>
                            <span class="badge bg-primary-deep text-white">{{ $data['clients_count'] }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <span>حالات الاشتراك</span>
                            <span class="badge bg-primary-deep text-white">{{ $data['subscription_statuses_count'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-primary-deep text-white fw-bold p-3">
                    <i class="la la-code"></i> فحص JavaScript
                </div>
                <div class="card-body p-4" id="js-status">
                    <div class="text-center py-4">
                        <i class="la la-spinner la-spin" style="font-size: 32px; color: var(--primary-deep);"></i>
                        <div class="mt-2">جاري الفحص...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('after_scripts')
<script>
    function checkLibraries() {
        var html = '<div class="list-group list-group-flush">';
        
        // jQuery
        var jqueryStatus = typeof jQuery !== 'undefined';
        html += '<div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">' +
                '<span>jQuery Loaded</span>' +
                (jqueryStatus ? '<span class="badge bg-success text-white">Yes (' + jQuery.fn.jquery + ')</span>' : '<span class="badge bg-danger text-white">No</span>') +
                '</div>';
        
        // DataTables
        var dtStatus = typeof jQuery !== 'undefined' && !!jQuery.fn.DataTable;
        html += '<div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">' +
                '<span>DataTables Plugin</span>' +
                (dtStatus ? '<span class="badge bg-success text-white">Yes</span>' : '<span class="badge bg-danger text-white">No</span>') +
                '</div>';
        
        // Responsive
        var respStatus = dtStatus && !!jQuery.fn.DataTable.Responsive;
        html += '<div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">' +
                '<span>DataTables Responsive</span>' +
                (respStatus ? '<span class="badge bg-success text-white">Yes</span>' : '<span class="badge bg-warning text-white">Missing</span>') +
                '</div>';
        
        // Global DataTable
        var globalDt = typeof DataTable !== 'undefined';
        html += '<div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">' +
                '<span>Global DataTable Object</span>' +
                (globalDt ? '<span class="badge bg-success text-white">Yes</span>' : '<span class="badge bg-danger text-white">No</span>') +
                '</div>';
        
        html += '</div>';
        document.getElementById('js-status').innerHTML = html;
    }
    
    checkLibraries();
    setInterval(checkLibraries, 2000);
</script>
@endsection
