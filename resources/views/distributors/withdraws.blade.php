@extends('layouts.app')

@section('content')
<div class="container">

    <h4 class="mb-4">
        السحوبات الخاصة بالموزّع: {{ $distributor->name }}
    </h4>

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>المبلغ</th>
                <th>ملاحظات</th>
                <th>التاريخ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($withdraws as $index => $withdraw)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ number_format($withdraw->total_amount, 2) }}</td>
                    <td>{{ $withdraw->notes ?? '-' }}</td>
                    <td>{{ $withdraw->created_at->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">لا يوجد سحوبات</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection