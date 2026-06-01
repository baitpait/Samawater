@extends(backpack_view('blank'))

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    <style>
        .client-ledger-container { background: var(--bg-light); min-height: 100vh; padding: 2rem 0; }
        .ledger-header {
            background: linear-gradient(135deg, var(--primary-deep) 0%, #2d4a6b 100%);
            border-radius: 20px; padding: 2rem; margin-bottom: 2rem; box-shadow: var(--shadow-lg);
        }
        .ledger-header-title { color: #fff; font-size: 26px; font-weight: 900; margin: 0; }
        .ledger-header-subtitle { color: rgba(255,255,255,.85); margin: .5rem 0 0; font-size: 14px; }
        .filter-card-modern, .table-card-modern {
            background: #fff; border-radius: 20px; box-shadow: var(--shadow-md); margin-bottom: 1.5rem; overflow: hidden;
        }
        .filter-card-body { padding: 1.5rem 2rem; }
        .table-ledger thead th {
            background: var(--bg-light); color: var(--primary-deep); font-weight: 700; font-size: 13px;
            white-space: nowrap;
        }
        .table-ledger tbody td { font-size: 13px; vertical-align: middle; }
        .summary-pill {
            background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1rem;
        }
    </style>
@endsection

@section('header')
    <section class="ledger-header">
        <h1 class="ledger-header-title"><i class="la la-book"></i> كشف حساب مالي شامل</h1>
        <p class="ledger-header-subtitle">جميع الحركات مع أرصدة تراكمية (مسار الفواتير + مستحق التسليمات + الإجمالي)</p>
    </section>
@endsection

@section('content')
<div class="client-ledger-container">
    <div class="container-fluid pb-4">

        <div class="filter-card-modern">
            <div class="filter-card-body">
                <form method="GET" action="{{ route('reports.client-ledger') }}" class="row g-3 align-items-end">
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-bold">المشترك</label>
                        @include('admin.partials.client_select_searchable', [
                            'clients' => $clientsList ?? collect(),
                            'selectedId' => $selectParentId ?? request('client_id'),
                            'allowEmpty' => true,
                            'emptyLabel' => '— اختر مشترك —',
                            'required' => true,
                            'selectClass' => 'form-select',
                            'placeholder' => 'ابحث عن اسم المشترك…',
                        ])
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label fw-bold">من تاريخ</label>
                        <input type="date" name="from" class="form-control" value="{{ $from ?? '' }}">
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label fw-bold">إلى تاريخ</label>
                        <input type="date" name="to" class="form-control" value="{{ $to ?? '' }}">
                    </div>
                    <div class="col-6 col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="la la-search"></i> عرض</button>
                    </div>
                    <div class="col-6 col-md-2">
                        <a href="{{ route('reports.client-ledger') }}" class="btn btn-secondary w-100">إعادة</a>
                    </div>
                </form>
            </div>
        </div>

        @if($ledger !== null)
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <div class="summary-pill">
                        <div class="fw-bold fs-5 mb-1" style="color: var(--primary-deep);">{{ $ledger['display_name'] ?? '—' }}</div>
                        <div class="small text-muted">
                            @if(!empty($ledger['period']['from']) || !empty($ledger['period']['to']))
                                الفترة:
                                {{ $ledger['period']['from'] ?? '—' }}
                                →
                                {{ $ledger['period']['to'] ?? '—' }}
                            @else
                                الفترة: كل التاريخ
                            @endif
                        </div>
                    </div>
                </div>
                @php $s = $ledger['summary'] ?? []; @endphp
                <div class="col-6 col-md-4">
                    <div class="summary-pill text-center">
                        <div class="small text-muted">رصيد مسار الفواتير (نهائي)</div>
                        <div class="fw-bold fs-5">{{ number_format((float)($s['final_invoice_path_balance'] ?? 0), 2) }} ₪</div>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="summary-pill text-center">
                        <div class="small text-muted">مستحق التسليمات (نهائي)</div>
                        <div class="fw-bold fs-5">{{ number_format((float)($s['final_delivery_outstanding'] ?? 0), 2) }} ₪</div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="summary-pill text-center">
                        <div class="small text-muted">إجمالي المستحق (مطابق الفلاتر)</div>
                        <div class="fw-bold fs-5 text-danger">{{ number_format((float)($s['final_combined_debt'] ?? 0), 2) }} ₪</div>
                    </div>
                </div>
            </div>

            <div class="table-card-modern">
                <div class="table-responsive">
                    <table class="table table-ledger table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th>التاريخ</th>
                                <th>نوع الحركة</th>
                                <th>البيان</th>
                                <th class="text-end">مدين</th>
                                <th class="text-end">دائن</th>
                                <th class="text-end">رصيد فواتير تراكمي</th>
                                <th class="text-end">مستحق تسليمات</th>
                                <th class="text-end">إجمالي مستحق</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ledger['rows'] ?? [] as $row)
                                <tr>
                                    <td class="fw-bold">{{ $row['date'] }}</td>
                                    <td>{{ $row['label'] }}</td>
                                    <td class="text-muted">{{ $row['reference'] }}</td>
                                    <td class="text-end">{{ (float)$row['debit'] > 0 ? number_format((float)$row['debit'], 2).' ₪' : '—' }}</td>
                                    <td class="text-end">{{ (float)$row['credit'] > 0 ? number_format((float)$row['credit'], 2).' ₪' : '—' }}</td>
                                    <td class="text-end fw-bold">{{ number_format((float)$row['invoice_balance_running'], 2) }} ₪</td>
                                    <td class="text-end">{{ number_format((float)$row['delivery_outstanding_running'], 2) }} ₪</td>
                                    <td class="text-end fw-bold @if((float)$row['combined_balance_running'] > 0) text-danger @elseif((float)$row['combined_balance_running'] < 0) text-success @endif">
                                        {{ number_format((float)$row['combined_balance_running'], 2) }} ₪
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">لا توجد حركات في هذه الفترة</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <p class="small text-muted mt-3">
                مدفوعات التسليم تُسجَّل ضمن سطر التسليم ولا تُكرَّر كدفعة على مسار الفواتير (ADR-003).
            </p>

            @if(!empty($ledger['billing_parent_id']))
                <div class="d-flex flex-wrap gap-2 mt-2">
                    <a href="{{ route('reports.client-balance', ['client_id' => $ledger['display_client_id']]) }}" class="btn btn-sm btn-outline-warning">
                        <i class="la la-file-invoice-dollar"></i> ملخص الرصيد
                    </a>
                    <a href="{{ backpack_url('client/'.$ledger['billing_parent_id'].'/show') }}" class="btn btn-sm btn-outline-primary">
                        <i class="la la-eye"></i> ملف المشترك
                    </a>
                </div>
            @endif
        @else
            <div class="alert alert-info text-center py-4" style="border-radius: 16px;">
                اختر مشتركاً واضغط «عرض» لكشف الحساب التراكمي.
            </div>
        @endif
    </div>
</div>
@endsection
