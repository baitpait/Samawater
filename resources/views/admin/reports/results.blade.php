@extends(backpack_view('blank'))

@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
@endsection

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header" style="background: var(--primary-deep) !important; border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 2rem; box-shadow: var(--shadow-md) !important; width: 100%; display: flex; align-items: center; justify-content: space-between; position: relative; overflow: visible;">
        <div style="display: flex; align-items: center; gap: 1rem; position: relative; z-index: 1;">
            <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.1); border-radius: 16px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                <i class="la la-file-alt" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
            </div>
            <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 800; margin: 0; font-family: 'Cairo', sans-serif;">نتائج الفلترة</h1>
        </div>
    </section>
@endsection

@section('content')
<div class="container-fluid pb-4">
    <div class="card">
        <div class="card-body p-0">
            @if($clients->count())
            <div class="table-responsive">
                <table class="table table-clean align-middle mb-0">
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
                            <td class="ps-4 fw-bold text-primary-deep">{{ $client->name }}</td>
                            <td>{{ $client->city->city_name ?? '-' }}</td>
                            <td><span class="badge bg-primary-deep text-white">{{ $client->deliveries->count() }}</span></td>
                            <td class="fw-bold text-primary-deep">
                                {{ $client->deliveries->sum('bottle_received') - $client->deliveries->sum('bottle_empty') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div class="p-5 text-center text-muted">
                    <i class="la la-info-circle" style="font-size: 48px; color: var(--primary-deep); margin-bottom: 15px;"></i>
                    <h5 class="fw-bold">لا توجد نتائج مطابقة للفلترة</h5>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
