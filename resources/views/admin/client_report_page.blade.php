@extends(backpack_view('blank'))

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}?v={{ time() }}">
    <style>
        .badge-success-custom { background: var(--success-gradient) !important; color: #fff !important; }
        .badge-warning-custom { background: var(--warning-color) !important; color: #fff !important; }
        .badge-info-custom { background: var(--primary-deep) !important; color: #fff !important; }
        .btn-edit-delivery {
            background: var(--warning-color);
            border: none;
            color: #fff;
            padding: 8px 12px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-edit-delivery:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); color: #fff; }
        .client-report-table th { white-space: nowrap; font-size: 13px; }
        .client-report-table td { font-size: 13px; }
    </style>
@endsection

@section('header')
    @php
        $amountDue = (float) ($accountSnapshot['amount_due'] ?? ($client->combined_subscriber_debt ?? 0));
    @endphp
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header" style="background: var(--primary-deep) !important; border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 2rem; box-shadow: var(--shadow-md) !important; width: 100%; display: flex; align-items: center; justify-content: space-between; position: relative; overflow: visible;">
        <div style="display: flex; align-items: center; gap: 1rem; position: relative; z-index: 1;">
            <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.1); border-radius: 16px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                <i class="la la-chart-bar" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
            </div>
            <div>
                <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 800; margin: 0; font-family: 'Cairo', sans-serif;">تسليمات المشترك</h1>
                @if(isset($client))
                <div class="mt-1" style="color: rgba(255, 255, 255, 0.9); font-size: 15px; font-weight: 700;">
                    <span style="color: rgba(255, 255, 255, 0.7);">المبلغ المستحق (إجمالي):</span>
                    <span style="{{ $amountDue > 0 ? 'color: #fca5a5;' : ($amountDue < 0 ? 'color: #86efac;' : 'color: #fff;') }}">₪ {{ number_format($amountDue, 2) }}</span>
                </div>
                @endif
            </div>
        </div>
        <div class="header-actions" style="position: relative; z-index: 10;">
            <a href="{{ route('reports.filters') }}" class="btn btn-light" style="color: var(--primary-deep); font-weight: 700; border-radius: 12px;">
                <i class="la la-arrow-right"></i> العودة للمشتركين
            </a>
            @if($client)
            @php
                $pdfQuery = array_filter([
                    'client_id' => $client->id,
                    'from' => request('from'),
                    'to' => request('to'),
                ], static fn ($v) => $v !== null && $v !== '');
            @endphp
            <a href="{{ route('client.report.pdf', $pdfQuery) }}" class="btn btn-light" style="color: var(--primary-deep); font-weight: 700; border-radius: 12px; margin-right: 10px;">
                <i class="la la-file-pdf"></i> PDF
            </a>
            @endif
        </div>
    </section>
@endsection

@section('content')
<div class="container-fluid pb-4">
    @if(!$client)
        <div class="alert alert-info text-center" style="border-radius: 16px; padding: 20px; font-weight: 600;">
            👆 الرجاء اختيار مشترك من القائمة لعرض التقرير
        </div>
    @else
        <div class="row g-4 mb-4">
            <div class="col-12 {{ !empty($bottleSnapshot) ? 'col-lg-8' : '' }}">
                <div class="dashboard-stat-card h-100" style="background: var(--primary-deep) !important; border-radius: 20px; padding: 28px; box-shadow: var(--shadow-md); border: 1px solid rgba(255, 255, 255, 0.05); position: relative; overflow: hidden;">
                    <div class="stat-card-content" style="display: flex; align-items: flex-start; gap: 24px; position: relative; z-index: 2;">
                        <div class="stat-icon-box" style="width: 72px; height: 72px; min-width: 72px; background: rgba(255, 255, 255, 0.1); border-radius: 16px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);">
                            <i class="la la-user" style="font-size: 32px; color: #fff; font-weight: 900;"></i>
                        </div>
                        <div class="stat-info flex-grow-1">
                            <h6 class="stat-label" style="color: rgba(255, 255, 255, 0.7); font-size: 14px; font-weight: 600; margin-bottom: 8px;">اسم المشترك</h6>
                            <h3 class="stat-value" style="color: #fff; font-size: 28px; font-weight: 800; margin: 0 0 12px 0;">{{ $client->name }}</h3>
                            <div class="mt-2 d-flex flex-wrap gap-2 align-items-center">
                                @if(!empty($client->contract_no))
                                <span class="badge" style="background: rgba(255, 255, 255, 0.1); color: #fff; border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 8px; padding: 6px 14px; font-weight: 600;">
                                    <i class="la la-file-contract"></i> عقد: {{ $client->contract_no }}
                                </span>
                                @endif
                                <span class="badge" style="background: rgba(255, 255, 255, 0.1); color: #fff; border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 8px; padding: 6px 14px; font-weight: 600;">
                                    <i class="la la-map-marker"></i> {{ $client->city->city_name ?? '-' }}
                                </span>
                                @if(!empty($client->phone_one) || !empty($client->phone_two))
                                <span class="badge" style="background: rgba(255, 255, 255, 0.1); color: #fff; border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 8px; padding: 6px 14px; font-weight: 600;">
                                    <i class="la la-phone"></i>
                                    {{ $client->phone_one ?: '-' }}
                                    @if(!empty($client->phone_two))
                                        / {{ $client->phone_two }}
                                    @endif
                                </span>
                                @endif
                                @if($client->distributor)
                                <span class="badge" style="background: rgba(255, 255, 255, 0.1); color: #fff; border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 8px; padding: 6px 14px; font-weight: 600;">
                                    <i class="la la-truck"></i> موزع المشترك: {{ $client->distributor->name }}
                                </span>
                                @endif
                            </div>
                            <div class="mt-3 pt-3" style="border-top: 1px solid rgba(255, 255, 255, 0.15);">
                                <h6 class="stat-label" style="color: rgba(255, 255, 255, 0.7); font-size: 13px; font-weight: 600; margin-bottom: 6px;">عنوان الزبون</h6>
                                <p class="mb-0" style="color: #fff; font-size: 16px; font-weight: 600; line-height: 1.5;">{{ $client->address ?? '-' }}</p>
                            </div>
                            @if(!empty(trim((string) ($client->notes ?? ''))))
                            <div class="mt-3 pt-3" style="border-top: 1px solid rgba(255, 255, 255, 0.15);">
                                <h6 class="stat-label" style="color: rgba(255, 255, 255, 0.7); font-size: 13px; font-weight: 600; margin-bottom: 6px;">ملاحظات المشترك</h6>
                                <p class="mb-0" style="color: #fff; font-size: 15px; font-weight: 500; line-height: 1.6;">{{ $client->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if(!empty($bottleSnapshot))
            <div class="col-12 col-lg-4">
                <div class="dashboard-stat-card bottle-balance-box h-100" style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%) !important; border-radius: 20px; padding: 28px; box-shadow: var(--shadow-md); border: 1px solid rgba(255, 255, 255, 0.12); position: relative; overflow: hidden;">
                    <div style="display: flex; flex-direction: column; align-items: center; text-align: center; position: relative; z-index: 2;">
                        <div style="width: 64px; height: 64px; background: rgba(255, 255, 255, 0.15); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                            <i class="la la-wine-bottle" style="font-size: 32px; color: #fff;"></i>
                        </div>
                        <h6 style="color: rgba(255, 255, 255, 0.85); font-size: 14px; font-weight: 600; margin-bottom: 8px;">رصيد القوارير عنده</h6>
                        <p class="mb-2" style="color: #fff; font-size: 40px; font-weight: 900; line-height: 1;">
                            {{ (int) ($bottleSnapshot['bottle_balance'] ?? 0) }}
                        </p>
                        <p class="mb-0" style="color: rgba(255, 255, 255, 0.9); font-size: 15px; font-weight: 700; padding: 10px 14px; background: rgba(0,0,0,0.12); border-radius: 12px; width: 100%;">
                            {{ (int) ($bottleSnapshot['total_bottle_received'] ?? 0) }}
                            <span style="opacity: 0.8;">−</span>
                            {{ (int) ($bottleSnapshot['total_bottle_empty'] ?? 0) }}
                            <span style="opacity: 0.8;">=</span>
                            {{ (int) ($bottleSnapshot['bottle_balance'] ?? 0) }}
                        </p>
                        <p class="mb-0 mt-2 small" style="color: rgba(255, 255, 255, 0.75);">ممتلئة − فارغة (كل التسليمات)</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="card filter-card mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('client.report') }}" class="row g-3 align-items-end">
                    <input type="hidden" name="client_id" value="{{ request('client_id') }}">
                    <div class="col-md-5">
                        <label class="form-label">من تاريخ</label>
                        <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">إلى تاريخ</label>
                        <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100" style="height: 48px;">
                            <i class="la la-search"></i> تصفية
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @php
            $periodRequired = (float) $client->deliveries->sum('required_amount');
            $periodPaid = (float) $client->deliveries->sum('paymant');
            $periodDebt = round($periodRequired - $periodPaid, 2);
        @endphp

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-clean align-middle mb-0 client-report-table">
                        <thead>
                            <tr>
                                <th>التاريخ</th>
                                <th>الموزع</th>
                                <th>ممتلئة</th>
                                <th>فارغة</th>
                                <th>فرق اليوم</th>
                                <th>المبلغ المطلوب</th>
                                <th>المبلغ المدفوع</th>
                                <th>الدين المتبقي</th>
                                <th style="width: 110px;">إجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($client->deliveries as $row)
                            @php
                                $required = (float) ($row->required_amount ?? 0);
                                $paid = (float) ($row->paymant ?? 0);
                                $remaining = round($required - $paid, 2);
                                $dayDelta = (int) $row->bottle_received - (int) $row->bottle_empty;
                            @endphp
                            <tr>
                                <td class="ps-4 fw-bold">{{ $row->delivery_date ? \Carbon\Carbon::parse($row->delivery_date)->format('Y-m-d') : '-' }}</td>
                                <td>{{ $row->distributor->name ?? '-' }}</td>
                                <td><span class="badge badge-success-custom">{{ $row->bottle_received }}</span></td>
                                <td><span class="badge badge-warning-custom">{{ $row->bottle_empty }}</span></td>
                                <td class="fw-semibold">{{ $dayDelta }}</td>
                                <td>₪ {{ number_format($required, 2) }}</td>
                                <td class="fw-bold" style="color: var(--primary-deep);">₪ {{ number_format($paid, 2) }}</td>
                                <td class="fw-bold {{ $remaining > 0 ? 'text-danger' : ($remaining < 0 ? 'text-success' : 'text-muted') }}">
                                    ₪ {{ number_format($remaining, 2) }}
                                </td>
                                <td class="pe-4">
                                    <div class="d-flex gap-1">
                                        <button type="button" class="btn btn-sm btn-primary" onclick="editDelivery({{ $row->id }})" title="تعديل سريع">
                                            <i class="la la-pen"></i>
                                        </button>
                                        <a href="{{ backpack_url('delivery/'.$row->id.'/edit') }}" class="btn btn-sm btn-outline-secondary" title="فتح نموذج التسليم">
                                            <i class="la la-external-link-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="text-center py-5 text-muted">لا توجد عمليات مسجلة في الفترة المحددة</td></tr>
                        @endforelse
                        </tbody>
                        @if($client->deliveries->isNotEmpty())
                        <tfoot>
                            <tr style="background: #f8fafc; font-weight: 700;">
                                <td colspan="5" class="ps-4 text-end">إجمالي الفترة المعروضة:</td>
                                <td>₪ {{ number_format($periodRequired, 2) }}</td>
                                <td>₪ {{ number_format($periodPaid, 2) }}</td>
                                <td class="{{ $periodDebt > 0 ? 'text-danger' : ($periodDebt < 0 ? 'text-success' : 'text-muted') }}">
                                    ₪ {{ number_format($periodDebt, 2) }}
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

@include('admin.reports.inc.edit_delivery_modal')

@endsection
