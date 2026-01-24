{{-- Financial Report Modal --}}
<div class="modal fade"
     id="financialReportModal-{{ $entry->id }}"
     tabindex="-1"
     role="dialog"
     aria-labelledby="financialReportLabel-{{ $entry->id }}"
     aria-hidden="true"
     data-backdrop="true"
     data-keyboard="true">

    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable"
         role="document">

        <div class="modal-content shadow-lg border-0">

            {{-- ================= Header ================= --}}
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="financialReportLabel-{{ $entry->id }}">
                    📊 التقرير المالي – {{ $entry->name }}
                </h5>

                <button type="button"
                        class="close text-white"
                        data-dismiss="modal"
                        aria-label="Close"
                        style="font-size: 26px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- ================= Body ================= --}}
            <div class="modal-body bg-light">

                {{-- Summary --}}
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm text-center">
                            <div class="card-body py-3">
                                <div class="text-muted mb-1">الرصيد الحالي</div>
                                <h4 class="fw-bold mb-0">
                                    {{ number_format($entry->balance, 2) }} ₪
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Withdraws --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h6 class="mb-0">
                            📤 سجل السحوبات
                        </h6>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover mb-0">
                                <thead class="thead-light">
                                <tr class="text-center">
                                    <th style="width: 60px">#</th>
                                    <th>المبلغ</th>
                                    <th>ملاحظات</th>
                                    <th style="width: 130px">التاريخ</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($entry->cashWithdraws as $w)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold">
                                            {{ number_format($w->total_amount, 2) }} ₪
                                        </td>
                                        <td>{{ $w->notes ?? '-' }}</td>
                                        <td>{{ $w->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="text-center text-muted py-4">
                                            لا توجد سحوبات مسجّلة
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>

                                {{-- Footer Sum --}}
                                @if($entry->cashWithdraws->count())
                                    <tfoot class="bg-light">
                                    <tr class="text-center fw-bold">
                                        <td colspan="3">إجمالي السحوبات</td>
                                        <td>
                                            {{ number_format($entry->cashWithdraws->sum('total_amount'), 2) }} ₪
                                        </td>
                                    </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ================= Footer ================= --}}
            <div class="modal-footer bg-white">
                <button type="button"
                        class="btn btn-outline-secondary"
                        data-dismiss="modal">
                    إغلاق
                </button>
            </div>

        </div>
    </div>
</div>

{{-- Safety Fix (z-index) --}}
<style>
    .modal {
        z-index: 1050;
    }
    .modal-backdrop {
        z-index: 1040;
    }
</style>