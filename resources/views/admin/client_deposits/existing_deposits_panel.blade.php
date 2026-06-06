@php
    /** @var \App\Models\Client|null $client */
    /** @var \Illuminate\Support\Collection<int, \App\Models\ClientDeposit> $activeDeposits */
    /** @var \Illuminate\Support\Collection<string, int> $totalsByItem */
    $activeDeposits = $activeDeposits ?? collect();
    $totalsByItem = $totalsByItem ?? collect();
@endphp

@if ($client)
<div class="form-group col-md-12 client-existing-deposits-panel mb-4">
    <label class="d-block mb-2">أمانات المشترك الحالية (معارة)</label>

    @if ($activeDeposits->isEmpty())
        <div class="alert alert-success border mb-0" style="border-radius: 12px;">
            <i class="la la-check-circle"></i>
            لا توجد أمانات معارة حالياً لـ <strong>{{ $client->name }}</strong>.
        </div>
    @else
        <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
            <div class="card-header py-3" style="background: var(--primary-deep, #1e3a5f); color: #fff;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <span>
                        <i class="la la-hand-holding"></i>
                        <strong>{{ $client->name }}</strong>
                        — {{ $activeDeposits->count() }} سجل أمانة نشط
                    </span>
                    <a href="{{ backpack_url('client-deposit?client_id=' . $client->id) }}" class="btn btn-sm btn-light">
                        <i class="la la-list"></i> كل الأمانات
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>تاريخ الإعارة</th>
                                <th>الأصناف</th>
                                <th class="text-center">إجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activeDeposits as $deposit)
                                <tr>
                                    <td class="text-nowrap">
                                        {{ $deposit->date_given?->format('Y-m-d') ?? '—' }}
                                    </td>
                                    <td>
                                        @if ($deposit->items->isEmpty())
                                            <span class="text-muted">—</span>
                                        @else
                                            <ul class="mb-0 ps-3">
                                                @foreach ($deposit->items as $item)
                                                    <li>
                                                        {{ trim($item->item_name) }}
                                                        <span class="badge bg-secondary">× {{ $item->quantity }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <a href="{{ backpack_url('client-deposit/' . $deposit->id . '/show') }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="معاينة">
                                            <i class="la la-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($totalsByItem->isNotEmpty())
                    <div class="p-3 border-top bg-light">
                        <strong class="d-block mb-2">المجموع المعار حالياً (كل السجلات):</strong>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($totalsByItem as $itemName => $qty)
                                <span class="badge rounded-pill text-bg-primary px-3 py-2">
                                    {{ $itemName }}: {{ $qty }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    const clientSelect = document.querySelector('select[name="client_id"]');
    if (!clientSelect) {
        return;
    }
    clientSelect.addEventListener('change', function () {
        const id = this.value;
        const base = @json(url(config('backpack.base.route_prefix') . '/client-deposit/create'));
        if (id) {
            window.location.href = base + '?client_id=' + encodeURIComponent(id);
        } else {
            window.location.href = base;
        }
    });
});
</script>
