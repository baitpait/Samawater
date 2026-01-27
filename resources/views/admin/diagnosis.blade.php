@extends(backpack_view('blank'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">تشخيص النظام</div>
            <div class="card-body">
                <h3>حالة البيانات</h3>
                <ul>
                    <li>عدد الفواتير: {{ $data['invoices_count'] }}</li>
                    <li>عدد العملاء: {{ $data['clients_count'] }}</li>
                    <li>حالات الاشتراك: {{ $data['subscription_statuses_count'] }}</li>
                </ul>
                <hr>
                <h3>فحص JavaScript (سيتم التحديث تلقائياً)</h3>
                <div id="js-status">جاري الفحص...</div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('after_scripts')
<script>
    function checkLibraries() {
        var status = '<ul>';
        status += '<li>jQuery Loaded: ' + (typeof jQuery !== 'undefined' ? '<span class="text-success">Yes (' + jQuery.fn.jquery + ')</span>' : '<span class="text-danger">No</span>') + '</li>';
        
        if (typeof jQuery !== 'undefined') {
            status += '<li>DataTables Plugin: ' + (jQuery.fn.DataTable ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>') + '</li>';
            if (jQuery.fn.DataTable) {
                 status += '<li>DataTables Responsive: ' + (jQuery.fn.DataTable.Responsive ? '<span class="text-success">Yes</span>' : '<span class="text-warning">Missing (Mocked?)</span>') + '</li>';
            }
        }
        status += '<li>Global DataTable Object: ' + (typeof DataTable !== 'undefined' ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>') + '</li>';
        status += '</ul>';
        
        document.getElementById('js-status').innerHTML = status;
    }
    
    // Check immediately and periodically
    checkLibraries();
    setInterval(checkLibraries, 1000);
</script>
@endsection
