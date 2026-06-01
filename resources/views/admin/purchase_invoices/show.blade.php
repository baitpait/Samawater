@extends(backpack_view('blank'))

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    <style>
        .purchase-show-header {
            background: linear-gradient(135deg, #0f766e 0%, #115e59 100%);
            border-radius: 20px;
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            color: #fff;
        }
        .purchase-show-header h2 { margin: 0; font-weight: 800; }
        .detail-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            margin-bottom: 1.25rem;
            overflow: hidden;
        }
        .detail-card .card-head {
            background: #f8fafc;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 700;
            color: #0f766e;
        }
        .detail-card .card-body { padding: 1.25rem 1.5rem; }
    </style>
@endsection

@section('content')
@php
    $statusLabels = ['draft' => 'مسودة', 'confirmed' => 'مؤكدة', 'cancelled' => 'ملغاة'];
    $paymentLabels = ['paid' => 'مدفوع كامل', 'partial' => 'جزئي', 'unpaid' => 'دين'];
    $methodLabels = [
        'cash' => 'نقدي', 'bank_transfer' => 'تحويل', 'check' => 'شيك',
        'credit_card' => 'بطاقة', 'other' => 'أخرى',
    ];
@endphp

<div class="container-fluid pb-4">
    <div class="purchase-show-header d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2><i class="la la-shopping-cart"></i> فاتورة مشتريات</h2>
            <div class="opacity-90">{{ $entry->invoice_number }} — {{ $entry->vendor->name ?? '—' }}</div>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ url($crud->route) }}" class="btn btn-light btn-sm"><i class="la la-arrow-right"></i> القائمة</a>
            <a href="{{ url($crud->route.'/'.$entry->id.'/edit') }}" class="btn btn-light btn-sm"><i class="la la-edit"></i> تعديل</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="detail-card h-100 text-center p-4">
                <div class="text-muted small">الإجمالي</div>
                <div class="fs-2 fw-bold text-success">₪ {{ number_format((float) $entry->total_amount, 2) }}</div>
                <span class="badge bg-secondary">{{ $statusLabels[$entry->status] ?? $entry->status }}</span>
            </div>
        </div>
        <div class="col-md-8">
            <div class="detail-card h-100">
                <div class="card-head">بيانات الفاتورة</div>
                <div class="card-body">
                    <p><strong>المورد:</strong> {{ $entry->vendor->name ?? '—' }}</p>
                    <p><strong>التاريخ:</strong> {{ $entry->invoice_date?->format('Y-m-d') }}</p>
                    <p><strong>الدفع:</strong> {{ $paymentLabels[$entry->payment_status] ?? $entry->payment_status }}
                        — مدفوع ₪ {{ number_format((float) $entry->amount_paid, 2) }}</p>
                    @if($entry->notes)
                    <p class="mb-0"><strong>ملاحظات:</strong> {{ $entry->notes }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="card-head">أصناف المشتريات</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>الصنف</th>
                        <th>الكمية</th>
                        <th>تكلفة الوحدة</th>
                        <th>الإجمالي</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entry->items as $item)
                    <tr>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₪ {{ number_format((float) $item->unit_cost, 2) }}</td>
                        <td>₪ {{ number_format((float) $item->total_cost, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted">لا توجد أصناف</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($entry->status === 'confirmed')
            <p class="text-success small mt-3 mb-0"><i class="la la-check-circle"></i> تمت إضافة الكميات إلى المخزون.</p>
            @elseif($entry->status === 'draft')
            <p class="text-warning small mt-3 mb-0"><i class="la la-info-circle"></i> مسودة — لم تُضف الكميات للمخزون بعد.</p>
            @endif
        </div>
    </div>
</div>
@endsection
