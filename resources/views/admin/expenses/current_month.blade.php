@extends(backpack_view('blank'))

@section('header')
    <section class="container-fluid animated fadeIn">
        <h2>
            <span class="text-capitalize">المصروفات الشهرية</span>
            <small id="datatable_info_stack">عرض المصروفات لشهر معين</small>
        </h2>
    </section>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        {{-- فلتر الشهر --}}
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">اختر الشهر والسنة</h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('expenses.current-month') }}" class="form-inline">
                    <div class="form-group mr-3">
                        <label for="year" class="mr-2">السنة:</label>
                        <select name="year" id="year" class="form-control" onchange="this.form.submit()" required>
                            @php
                                $currentYear = (int)\Carbon\Carbon::now()->format('Y');
                                $years = [];
                                for ($i = $currentYear - 2; $i <= $currentYear + 2; $i++) {
                                    $years[] = $i;
                                }
                            @endphp
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mr-3">
                        <label for="month" class="mr-2">الشهر:</label>
                        <select name="month_num" id="month_num" class="form-control" onchange="this.form.submit()" required>
                            @php
                                $months = [
                                    1 => '01 - يناير', 2 => '02 - فبراير', 3 => '03 - مارس',
                                    4 => '04 - أبريل', 5 => '05 - مايو', 6 => '06 - يونيو',
                                    7 => '07 - يوليو', 8 => '08 - أغسطس', 9 => '09 - سبتمبر',
                                    10 => '10 - أكتوبر', 11 => '11 - نوفمبر', 12 => '12 - ديسمبر'
                                ];
                            @endphp
                            @foreach($months as $num => $label)
                                <option value="{{ $num }}" {{ $selectedMonthNum == $num ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>

        {{-- ملخص المصروفات --}}
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">المجموع الكلي</h5>
                        <h3>{{ number_format($totalAmount, 2) }} شيكل</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- جدول المصروفات --}}
        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    مصروفات {{ $selectedYear }}-{{ str_pad($selectedMonthNum, 2, '0', STR_PAD_LEFT) }}
                    @php
                        $monthNum = (int)$selectedMonthNum; // التأكد من أنه integer
                        $monthNames = [
                            1 => 'يناير', 2 => 'فبراير', 3 => 'مارس',
                            4 => 'أبريل', 5 => 'مايو', 6 => 'يونيو',
                            7 => 'يوليو', 8 => 'أغسطس', 9 => 'سبتمبر',
                            10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر'
                        ];
                        $monthName = $monthNames[$monthNum] ?? 'غير محدد';
                    @endphp
                    ({{ $monthName }} {{ $selectedYear }})
                </h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if($allocations->isEmpty())
                    <div class="alert alert-info">
                        لا توجد مصروفات لهذا الشهر.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>الفئة</th>
                                    <th>المبلغ</th>
                                    <th>المصروف الأصلي</th>
                                    <th>تاريخ الدفع</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allocations as $allocation)
                                    <tr>
                                        <td>
                                            <span class="badge bg-info">{{ $allocation->expense->category->name ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <strong class="text-primary">{{ number_format($allocation->amount, 2) }} شيكل</strong>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ number_format($allocation->expense->total_amount, 2) }} شيكل
                                                <br>
                                                ({{ $allocation->expense->number_of_months }} شهر)
                                            </small>
                                        </td>
                                        <td>
                                            @php
                                                $paymentDate = \Carbon\Carbon::parse($allocation->expense->payment_date);
                                            @endphp
                                            {{ $paymentDate->format('Y-m-d') }}
                                        </td>
                                        <td>
                                            <a href="{{ backpack_url('expense/' . $allocation->expense->id . '/edit') }}" 
                                               class="btn btn-sm btn-primary" 
                                               title="تعديل المصروف">
                                                <i class="la la-edit"></i> تعديل
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-light">
                                    <th colspan="1" class="text-right">المجموع:</th>
                                    <th class="text-primary">{{ number_format($totalAmount, 2) }} شيكل</th>
                                    <th colspan="3"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">
@endsection
