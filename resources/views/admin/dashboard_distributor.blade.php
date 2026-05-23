@extends(backpack_view('blank'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-4">
            <h1 class="h3 mb-0" style="color: #2c3e50; font-weight: 600;">مرحباً {{ $user->name ?? 'الموزع' }}</h1>
            <p class="text-muted">لوحة تحكم الموزع</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- المشتركين -->
        <div class="col-md-4">
            <a href="{{ route('reports.filters') }}" class="text-decoration-none">
                <div class="card h-100" style="border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(52, 152, 219, 0.1); transition: all 0.3s ease;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="la la-users" style="font-size: 48px; color: #3498db;"></i>
                        </div>
                        <h5 class="card-title mb-2" style="color: #2c3e50; font-weight: 600;">المشتركين</h5>
                        <p class="card-text text-muted">عرض وإدارة قائمة المشتركين</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- قائمة التسليم -->
        <div class="col-md-4">
            <a href="{{ route('delivery.list') }}" class="text-decoration-none">
                <div class="card h-100" style="border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(46, 204, 113, 0.1); transition: all 0.3s ease;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="la la-list-alt" style="font-size: 48px; color: #2ecc71;"></i>
                        </div>
                        <h5 class="card-title mb-2" style="color: #2c3e50; font-weight: 600;">قائمة التسليم</h5>
                        <p class="card-text text-muted">عرض قائمة المشتركين المستحقين للتسليم</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- التسليمات -->
        <div class="col-md-4">
            <a href="{{ backpack_url('delivery') }}" class="text-decoration-none">
                <div class="card h-100" style="border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(155, 89, 182, 0.1); transition: all 0.3s ease;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="la la-truck" style="font-size: 48px; color: #9b59b6;"></i>
                        </div>
                        <h5 class="card-title mb-2" style="color: #2c3e50; font-weight: 600;">التسليمات</h5>
                        <p class="card-text text-muted">عرض وإدارة عمليات التسليم</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    
    <!-- تعديل معلومات الحساب -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card" style="border: none; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <div class="card-body p-4">
                    <h6 class="card-title mb-3" style="color: #2c3e50;">إعدادات الحساب</h6>
                    <a href="{{ backpack_url('edit-account-info') }}" class="btn btn-outline-primary btn-sm">
                        <i class="la la-user-edit"></i> تعديل معلومات الحساب
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('after_styles')
<style>
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}
</style>
@endpush