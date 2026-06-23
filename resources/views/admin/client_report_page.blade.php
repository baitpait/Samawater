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
        .btn-delete-delivery {
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
        .btn-delete-delivery:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); color: #fff; }
        .client-report-table th { white-space: nowrap; font-size: 13px; }
        .client-report-table td { font-size: 13px; }
        @media (max-width: 767.98px) {
            .client-report-bottle-panel {
                max-width: none !important;
                width: 100%;
                margin-inline-start: 0 !important;
            }
        }
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
            <div class="col-12">
                @php
                    $bottleSnapshot = $bottleSnapshot ?? [
                        'total_bottle_received' => 0,
                        'total_bottle_empty' => 0,
                        'bottle_balance' => 0,
                    ];
                @endphp
                <div class="dashboard-stat-card h-100" style="background: var(--primary-deep) !important; border-radius: 20px; padding: 28px; box-shadow: var(--shadow-md); border: 1px solid rgba(255, 255, 255, 0.05); position: relative; overflow: hidden;">
                    <div class="stat-card-content" style="display: flex; align-items: stretch; gap: 24px; position: relative; z-index: 2; flex-wrap: wrap;">
                        <div class="stat-icon-box d-none d-md-flex" style="width: 72px; height: 72px; min-width: 72px; background: rgba(255, 255, 255, 0.1); border-radius: 16px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);">
                            <i class="la la-user" style="font-size: 32px; color: #fff; font-weight: 900;"></i>
                        </div>
                        <div class="stat-info flex-grow-1" style="min-width: 220px;">
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
                        <div class="client-report-bottle-panel text-center" style="min-width: 220px; max-width: 280px; margin-inline-start: auto; padding: 20px; background: rgba(255, 255, 255, 0.08); border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.15); align-self: center;">
                            <div style="width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.2);">
                                <i class="la la-wine-bottle" style="font-size: 24px; color: #fff;"></i>
                            </div>
                            <div style="color: rgba(255, 255, 255, 0.75); font-size: 14px; font-weight: 600; margin-bottom: 0.5rem;">رصيد القوارير عنده</div>
                            <p class="mb-2" style="color: #fff; font-size: 2rem; font-weight: 800; line-height: 1.2;">{{ (int) ($bottleSnapshot['bottle_balance'] ?? 0) }}</p>
                            <p class="mb-0 small fw-bold px-2 py-2" style="background: rgba(255, 255, 255, 0.1); border-radius: 12px; color: #fff;">
                                {{ (int) ($bottleSnapshot['total_bottle_received'] ?? 0) }}
                                <span style="opacity: 0.75;">−</span>
                                {{ (int) ($bottleSnapshot['total_bottle_empty'] ?? 0) }}
                                <span style="opacity: 0.75;">=</span>
                                {{ (int) ($bottleSnapshot['bottle_balance'] ?? 0) }}
                            </p>
                            <p class="small mb-0 mt-2" style="color: rgba(255, 255, 255, 0.65);">ممتلئة − فارغة (كل التسليمات)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
            $filterFrom = $filterMeta['from'] ?? request('from');
            $filterTo = $filterMeta['to'] ?? request('to');
            $currentMonthStart = now()->startOfMonth()->format('Y-m-d');
            $currentMonthEnd = now()->endOfMonth()->format('Y-m-d');
            $quickMonthQuery = static fn (string $from, string $to): string => http_build_query(array_filter([
                'client_id' => $client->id,
                'from' => $from,
                'to' => $to,
            ]));
        @endphp
        <div class="card filter-card mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('client.report') }}" class="row g-3 align-items-end">
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                    <div class="col-md-4">
                        <label class="form-label">من تاريخ</label>
                        <input type="date" name="from" class="form-control" value="{{ $filterFrom }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">إلى تاريخ</label>
                        <input type="date" name="to" class="form-control" value="{{ $filterTo }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100" style="height: 48px;">
                            <i class="la la-search"></i> تصفية
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('client.report', ['client_id' => $client->id]) }}" class="btn btn-outline-secondary w-100" style="height: 48px;">
                            <i class="la la-times"></i> الكل
                        </a>
                    </div>
                </form>
                <div class="d-flex flex-wrap gap-2 mt-3 align-items-center">
                    <span class="text-muted small fw-semibold">اختصارات:</span>
                    <a href="{{ route('client.report') }}?{{ $quickMonthQuery($currentMonthStart, $currentMonthEnd) }}" class="btn btn-sm btn-outline-primary">
                        هذا الشهر ({{ now()->format('Y-m') }})
                    </a>
                    @if(isset($filterMeta) && ($filterMeta['total_count'] ?? 0) > 0)
                    <span class="badge bg-light text-dark border">
                        إجمالي التسليمات: {{ $filterMeta['total_count'] }}
                        @if(!empty($filterMeta['earliest_delivery_date']) && !empty($filterMeta['latest_delivery_date']))
                            ({{ $filterMeta['earliest_delivery_date'] }} — {{ $filterMeta['latest_delivery_date'] }})
                        @endif
                    </span>
                    @endif
                    @if(isset($filterMeta) && ($filterFrom || $filterTo))
                    <span class="badge bg-primary">
                        في الفترة: {{ $filterMeta['filtered_count'] ?? 0 }} تسليم
                    </span>
                    @endif
                </div>
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
                                <th style="width: 150px;">إجراء</th>
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
                                        <button type="button" class="btn btn-sm btn-danger btn-delete-delivery" onclick="deleteDelivery({{ $row->id }})" title="حذف التسليم">
                                            <i class="la la-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <div class="fw-semibold mb-2">لا توجد تسليمات في الفترة المحددة</div>
                                    @if(isset($filterMeta) && ($filterMeta['total_count'] ?? 0) > 0)
                                        <div class="small">
                                            يوجد {{ $filterMeta['total_count'] }} تسليم مسجّل لهذا المشترك
                                            @if(!empty($filterMeta['earliest_delivery_date']) && !empty($filterMeta['latest_delivery_date']))
                                                بين {{ $filterMeta['earliest_delivery_date'] }} و {{ $filterMeta['latest_delivery_date'] }}.
                                            @endif
                                            تأكد من <strong>السنة</strong> في الفلتر (مثلاً {{ now()->format('Y') }}).
                                        </div>
                                        <a href="{{ route('client.report') }}?{{ $quickMonthQuery($currentMonthStart, $currentMonthEnd) }}" class="btn btn-sm btn-primary mt-3">
                                            عرض تسليمات {{ now()->format('Y-m') }}
                                        </a>
                                    @else
                                        <div class="small">لا توجد أي تسليمات مسجّلة لهذا المشترك بعد.</div>
                                    @endif
                                </td>
                            </tr>
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

<script>
(function () {
    var deliveryBaseUrl = @json(backpack_url('delivery'));
    var reportPageUrl = @json(request()->fullUrl());
    var csrfToken = @json(csrf_token());

    window.deleteDelivery = function (deliveryId) {
        if (!confirm('هل تريد حذف هذا التسليم؟ سيتم حذف الدفعة المرتبطة وإرجاع أثر العبوات للمخزون.')) {
            return;
        }

        fetch(deliveryBaseUrl + '/' + deliveryId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(function (res) {
            if (res.ok || res.redirected) {
                window.location.href = reportPageUrl;
                return;
            }

            res.json().then(function (data) {
                alert(data.message || 'تعذّر حذف التسليم.');
            }).catch(function () {
                alert('تعذّر حذف التسليم.');
            });
        }).catch(function () {
            alert('تعذّر حذف التسليم.');
        });
    };
})();
</script>

@endsection
