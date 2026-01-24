@extends(backpack_view('blank'))

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">📑 نتائج الفلترة</h4>

    <div class="card">
        <div class="card-body">

            @if($clients->count())

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>المشترك</th>
                        <th>المدينة</th>
                        <th>عدد العمليات</th>
                        <th>الرصيد</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($clients as $client)
                    <tr>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->city->city_name ?? '-' }}</td>
                        <td>{{ $client->deliveries->count() }}</td>
                        <td class="fw-bold">
                            {{ 
                                $client->deliveries->sum('bottle_received')
                                - $client->deliveries->sum('bottle_empty')
                            }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            @else
                <div class="alert alert-info">
                    لا توجد نتائج مطابقة للفلترة
                </div>
            @endif

        </div>
    </div>

</div>
@endsection