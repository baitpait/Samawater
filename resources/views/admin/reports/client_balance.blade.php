@extends(backpack_view('blank'))

@section('header')
    <section class="container-fluid animated fadeIn">
        <h2>
            <span class="text-capitalize">تقرير رصيد المشتركين (المستحقات)</span>
            <small id="datatable_info_stack">عرض الفواتير والمدفوعات والرصيد المستحق لكل مشترك</small>
        </h2>
    </section>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        {{-- فلتر البحث --}}
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">فلترة البحث</h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('reports.client-balance') }}" class="form-inline">
                    <div class="form-group mr-3">
                        <label for="search" class="mr-2">اسم المشترك:</label>
                        <input type="text" name="search" id="search" class="form-control" 
                               value="{{ request('search') }}" placeholder="ابحث عن مشترك...">
                    </div>
                    <div class="form-group mr-3">
                        <small class="text-muted">
                            <i class="la la-info-circle"></i> يتم عرض المشتركين الذين لديهم مستحقات فقط (الرصيد > 0)
                        </small>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="la la-search"></i> بحث
                    </button>
                    <a href="{{ route('reports.client-balance') }}" class="btn btn-secondary">
                        <i class="la la-refresh"></i> إعادة تعيين
                    </a>
                </form>
            </div>
        </div>

        {{-- الإحصائيات --}}
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">إجمالي الفواتير</h5>
                        <h3>{{ number_format($totalInvoices, 2) }} شيكل</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">إجمالي المدفوعات</h5>
                        <h3>{{ number_format($totalPayments, 2) }} شيكل</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">الرصيد المستحق</h5>
                        <h3>{{ number_format($totalBalance, 2) }} شيكل</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- جدول المشتركين --}}
        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title mb-0">قائمة المشتركين</h4>
            </div>
            <div class="card-body">
                @if($clients->isEmpty())
                    <div class="alert alert-info">
                        لا يوجد مشتركين.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>اسم المشترك</th>
                                    <th>الهاتف</th>
                                    <th>إجمالي الفواتير</th>
                                    <th>إجمالي المدفوعات</th>
                                    <th>الرصيد المستحق</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clients as $client)
                                    <tr>
                                        <td>
                                            <strong>{{ $client->name }}</strong>
                                        </td>
                                        <td>
                                            {{ $client->phone_one ?? '-' }}
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ number_format($client->total_invoices_amount, 2) }} شيكل
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                {{ number_format($client->total_paid_amount, 2) }} شيكل
                                            </span>
                                        </td>
                                        <td>
                                            @if($client->balance > 0)
                                                <span class="badge bg-danger">
                                                    {{ number_format($client->balance, 2) }} شيكل
                                                </span>
                                            @elseif($client->balance < 0)
                                                <span class="badge bg-warning">
                                                    {{ number_format(abs($client->balance), 2) }} شيكل (مدفوع زائد)
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    0.00 شيكل
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ backpack_url('client/' . $client->id . '/show') }}" 
                                               class="btn btn-sm btn-primary" title="عرض المشترك">
                                                <i class="la la-eye"></i>
                                            </a>
                                            <a href="{{ backpack_url('invoice/create?client_id=' . $client->id) }}" 
                                               class="btn btn-sm btn-success" title="إضافة فاتورة">
                                                <i class="la la-file-invoice"></i>
                                            </a>
                                            <a href="{{ backpack_url('client-payment/create?client_id=' . $client->id) }}" 
                                               class="btn btn-sm btn-info" title="تسجيل دفعة">
                                                <i class="la la-money-bill"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
