@extends(backpack_view('blank'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-4">
            <h1 class="h3 mb-0" style="color: #2c3e50; font-weight: 600;">مرحباً {{ $user->name ?? 'المسؤول' }}</h1>
            <p class="text-muted">لوحة تحكم الإدارة</p>
        </div>
    </div>

    <div class="alert alert-info">
        <h5><i class="la la-info-circle"></i> معلومة</h5>
        <p>تم إنشاء dashboard بسيط مؤقتاً لتجاوز مشكلة في الـ dashboard الأصلي. يمكن تطويره لاحقاً.</p>
    </div>

    <div class="row g-4">
        <!-- روابط سريعة -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6><i class="la la-tachometer-alt"></i> الإدارة</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="{{ backpack_url('client') }}" class="list-group-item list-group-item-action">
                            <i class="la la-users"></i> المشتركين
                        </a>
                        <a href="{{ route('delivery.list') }}" class="list-group-item list-group-item-action">
                            <i class="la la-list-alt"></i> قائمة التسليم
                        </a>
                        <a href="{{ backpack_url('delivery') }}" class="list-group-item list-group-item-action">
                            <i class="la la-truck"></i> التسليمات
                        </a>
                        <a href="{{ backpack_url('distributor') }}" class="list-group-item list-group-item-action">
                            <i class="la la-user-tie"></i> الموزعين
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6><i class="la la-chart-bar"></i> التقارير</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('reports.advanced') }}" class="list-group-item list-group-item-action">
                            <i class="la la-chart-line"></i> التقارير المتقدمة
                        </a>
                        <a href="{{ backpack_url('edit-account-info') }}" class="list-group-item list-group-item-action">
                            <i class="la la-user-edit"></i> تعديل معلومات الحساب
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection