@extends(backpack_view('blank'))

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">معاينة أمانة</span>
            <small id="datatable_info_stack"> {{ $entry->client->name ?? '' }}</small>
        </h2>
    </section>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">بيانات الأمانة</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>المشترك:</strong> {{ $entry->client->name ?? '-' }}
                    </div>
                    <div class="col-md-6">
                        <strong>تاريخ الإعارة:</strong> {{ $entry->date_given ? $entry->date_given->format('Y-m-d') : '-' }}
                    </div>
                    <div class="col-md-6">
                        <strong>الحالة:</strong> 
                        @if($entry->is_withdrawn)
                            <span class="badge bg-success">مسحوبة</span>
                            @if($entry->withdrawn_at)
                                <small class="text-muted">({{ $entry->withdrawn_at->format('Y-m-d H:i') }})</small>
                            @endif
                        @else
                            <span class="badge bg-warning">معارة</span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <strong>أنشأ بواسطة:</strong> {{ $entry->creator->name ?? '-' }}
                    </div>
                    @if($entry->notes)
                    <div class="col-md-12 mt-2">
                        <strong>ملاحظات:</strong> {{ $entry->notes }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">الأصناف</h3>
                @if(!$entry->is_withdrawn && $entry->items->count() > 0)
                    <form method="POST" action="{{ route('client-deposit.withdraw', ['id' => $entry->id]) }}" style="display: inline-block;" onsubmit="return confirm('هل تريد سحب جميع الأصناف وإرجاعها للمخزون؟');">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="la la-undo"></i> سحب جميع الأصناف
                        </button>
                    </form>
                @endif
            </div>
            <div class="card-body">
                @if($entry->items->count() > 0)
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم الصنف</th>
                                <th>الكمية</th>
                                @if(!$entry->is_withdrawn)
                                <th>الإجراءات</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($entry->items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->item_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    @if(!$entry->is_withdrawn)
                                    <td>
                                        <form method="POST" action="{{ route('client-deposit.withdraw-item', ['id' => $entry->id, 'itemId' => $item->id]) }}" style="display: inline-block;" onsubmit="return confirm('هل تريد سحب هذا الصنف وإرجاعه للمخزون؟');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning">
                                                <i class="la la-undo"></i> سحب
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-right"><strong>المجموع:</strong></td>
                                <td><strong>{{ $entry->items->sum('quantity') }}</strong></td>
                                @if(!$entry->is_withdrawn)
                                <td></td>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <div class="alert alert-info">لا توجد أصناف في هذه الأمانة.</div>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <a href="{{ url($crud->route) }}" class="btn btn-default">
                    <i class="la la-arrow-right"></i> رجوع
                </a>
                @if(!$entry->is_withdrawn)
                <a href="{{ url($crud->route . '/' . $entry->id . '/edit') }}" class="btn btn-primary">
                    <i class="la la-edit"></i> تعديل
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
