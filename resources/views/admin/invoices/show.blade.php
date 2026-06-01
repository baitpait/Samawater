@extends(backpack_view('blank'))

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    <style>
        .invoice-show-header {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%);
            border-radius: 20px;
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            color: #fff;
        }
        .invoice-show-header h2 { margin: 0; font-weight: 800; font-size: 1.5rem; }
        .invoice-show-header .sub { opacity: 0.9; font-size: 0.95rem; margin-top: 0.35rem; }
        .invoice-detail-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            margin-bottom: 1.25rem;
            overflow: hidden;
        }
        .invoice-detail-card .card-head {
            background: #f8fafc;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 700;
            color: var(--primary-deep);
        }
        .invoice-detail-card .card-body { padding: 1.25rem 1.5rem; }
        .detail-row { margin-bottom: 0.75rem; }
        .detail-row strong { color: #64748b; font-weight: 600; display: inline-block; min-width: 140px; }
        .detail-row span { color: #1e293b; font-weight: 600; }
        .items-table thead th {
            background: var(--primary-deep);
            color: #fff;
            font-weight: 700;
            white-space: nowrap;
        }
        .summary-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 1rem 1.25rem;
        }
    </style>
@endsection

@section('content')
@php
    $statusLabels = [
        'draft' => 'مسودة',
        'confirmed' => 'مؤكدة',
        'cancelled' => 'ملغاة',
    ];
    $paymentStatusLabels = [
        'paid' => 'مدفوع كامل',
        'partial' => 'مدفوع جزئي',
        'unpaid' => 'دين',
    ];
    $paymentMethodLabels = [
        'cash' => 'نقدي',
        'bank_transfer' => 'تحويل بنكي',
        'check' => 'شيك',
        'credit_card' => 'بطاقة ائتمان',
        'other' => 'أخرى',
    ];
    $total = (float) ($entry->total_amount ?? 0);
    $paid = (float) ($entry->amount_paid ?? 0);
    $remaining = round(max(0, $total - $paid), 2);
    $statusClass = match ($entry->status) {
        'confirmed' => 'bg-success',
        'cancelled' => 'bg-secondary',
        default => 'bg-warning text-dark',
    };
@endphp

<div class="container-fluid pb-4">
    <div class="invoice-show-header d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2><i class="la la-file-invoice"></i> معاينة فاتورة مبيعات</h2>
            <div class="sub">{{ $entry->invoice_number }} — {{ $entry->client->name ?? '—' }}</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ url($crud->route) }}" class="btn btn-light btn-sm">
                <i class="la la-arrow-right"></i> قائمة الفواتير
            </a>
            <a href="{{ url($crud->route.'/'.$entry->id.'/edit') }}" class="btn btn-light btn-sm">
                <i class="la la-edit"></i> تعديل
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="invoice-detail-card h-100">
                <div class="card-head">بيانات الفاتورة</div>
                <div class="card-body">
                    <div class="detail-row"><strong>رقم الفاتورة:</strong> <span>{{ $entry->invoice_number }}</span></div>
                    <div class="detail-row"><strong>تاريخ الفاتورة:</strong>
                        <span>{{ $entry->invoice_date ? $entry->invoice_date->format('Y-m-d') : '—' }}</span>
                    </div>
                    <div class="detail-row"><strong>حالة الفاتورة:</strong>
                        <span class="badge {{ $statusClass }}">{{ $statusLabels[$entry->status] ?? $entry->status }}</span>
                    </div>
                    <div class="detail-row"><strong>أنشئت بواسطة:</strong>
                        <span>{{ $entry->creator->name ?? '—' }}</span>
                    </div>
                    <div class="detail-row"><strong>تاريخ الإنشاء:</strong>
                        <span>{{ $entry->created_at ? $entry->created_at->format('Y-m-d H:i') : '—' }}</span>
                    </div>
                    @if($entry->notes)
                    <div class="detail-row mt-3 pt-3 border-top"><strong>ملاحظات:</strong>
                        <span style="white-space: pre-wrap;">{{ $entry->notes }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="invoice-detail-card h-100">
                <div class="card-head">المشترك والدفع</div>
                <div class="card-body">
                    <div class="detail-row"><strong>المشترك:</strong>
                        @if($entry->client)
                        <a href="{{ backpack_url('client/'.$entry->client_id.'/show') }}">{{ $entry->client->name }}</a>
                        @else
                        <span>—</span>
                        @endif
                    </div>
                    <div class="detail-row"><strong>رقم العقد:</strong> <span>{{ $entry->client->contract_no ?? '—' }}</span></div>
                    <div class="detail-row"><strong>حالة الدفع:</strong>
                        <span>{{ $paymentStatusLabels[$entry->payment_status] ?? $entry->payment_status }}</span>
                    </div>
                    <div class="detail-row"><strong>المبلغ الإجمالي:</strong>
                        <span class="fs-5" style="color: var(--primary-deep);">₪ {{ number_format($total, 2) }}</span>
                    </div>
                    <div class="detail-row"><strong>المبلغ المدفوع:</strong>
                        <span class="text-success">₪ {{ number_format($paid, 2) }}</span>
                    </div>
                    <div class="detail-row"><strong>المتبقي (دين):</strong>
                        <span class="{{ $remaining > 0 ? 'text-danger' : 'text-muted' }} fw-bold">₪ {{ number_format($remaining, 2) }}</span>
                    </div>
                    @if($paid > 0)
                    <div class="detail-row"><strong>طريقة الدفع:</strong>
                        <span>{{ $paymentMethodLabels[$entry->payment_method] ?? ($entry->payment_method ?? '—') }}</span>
                    </div>
                    <div class="detail-row"><strong>تاريخ الدفع:</strong>
                        <span>{{ $entry->payment_date ? $entry->payment_date->format('Y-m-d') : '—' }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="invoice-detail-card">
        <div class="card-head d-flex justify-content-between align-items-center">
            <span><i class="la la-boxes"></i> أصناف الفاتورة</span>
            <span class="badge bg-primary">{{ $entry->items->count() }} صنف</span>
        </div>
        <div class="card-body p-0">
            @if($entry->items->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0 items-table">
                    <thead>
                        <tr>
                            <th class="ps-4">#</th>
                            <th>اسم الصنف</th>
                            <th class="text-center">الكمية</th>
                            <th class="text-end">سعر الوحدة</th>
                            <th class="text-end pe-4">الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entry->items as $index => $item)
                        <tr>
                            <td class="ps-4">{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $item->item_name }}</td>
                            <td class="text-center">{{ number_format((int) $item->quantity) }}</td>
                            <td class="text-end">₪ {{ number_format((float) $item->unit_price, 2) }}</td>
                            <td class="text-end pe-4 fw-bold">₪ {{ number_format((float) $item->total_price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background: #f8fafc;">
                            <td colspan="2" class="ps-4 text-end fw-bold">المجموع</td>
                            <td class="text-center fw-bold">{{ number_format($entry->items->sum('quantity')) }}</td>
                            <td></td>
                            <td class="text-end pe-4 fw-bold fs-5" style="color: var(--primary-deep);">
                                ₪ {{ number_format($total, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @else
            <div class="alert alert-warning m-3 mb-0">لا توجد أصناف مسجّلة على هذه الفاتورة.</div>
            @endif
        </div>
    </div>

    <div class="summary-box">
        <div class="row g-2">
            <div class="col-md-4"><strong>إجمالي الأصناف:</strong> ₪ {{ number_format($total, 2) }}</div>
            <div class="col-md-4"><strong>المدفوع:</strong> ₪ {{ number_format($paid, 2) }}</div>
            <div class="col-md-4"><strong>المتبقي على المشترك:</strong>
                <span class="{{ $remaining > 0 ? 'text-danger' : 'text-success' }}">₪ {{ number_format($remaining, 2) }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
