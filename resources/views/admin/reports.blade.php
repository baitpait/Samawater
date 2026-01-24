@extends(backpack_view('layouts.top_left'))

@section('content')
<div class="container-fluid">

    <h2 class="mb-4">📊 صفحة التقارير</h2>

    <div class="row">

        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>إجمالي المشتركين</h5>
                <h3>{{ \App\Models\Client::count() }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>إجمالي التوزيعات اليوم</h5>
                <h3>{{ \App\Models\Delivery::whereDate('created_at', today())->count() }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>عدد الموزعين</h5>
                <h3>{{ \App\Models\Distributor::count() }}</h3>
            </div>
        </div>

    </div>

</div>
@endsection