{{-- Financial Report Modal --}}
<div class="modal fade"
     id="financialReportModal-{{ $entry->id }}"
     tabindex="-1"
     role="dialog"
     aria-labelledby="financialReportLabel-{{ $entry->id }}"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable"
         role="document">

        <div class="modal-content" style="border-radius: 22px; border: none; overflow: hidden; box-shadow: 0 25px 60px rgba(0,0,0,0.25);">

            {{-- ================= Header ================= --}}
            <div class="modal-header" style="background: var(--primary-deep); border-bottom: none; padding: 20px 28px;">
                <h5 class="modal-title text-white fw-bold" id="financialReportLabel-{{ $entry->id }}">
                    📊 التقرير المالي – {{ $entry->name }}
                </h5>

                <button type="button"
                        class="btn-close-custom"
                        data-dismiss="modal"
                        aria-label="Close"
                        style="background: rgba(255,255,255,0.1); border: none; color: #fff; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;">
                    <i class="la la-times"></i>
                </button>
            </div>

            {{-- ================= Body ================= --}}
            <div class="modal-body p-4" style="background: var(--bg-light);">

                {{-- Summary --}}
                <div class="card mb-4" style="background: var(--success-gradient); border-radius: 16px; padding: 1.5rem; box-shadow: var(--shadow-sm); border: none;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p style="color: rgba(255, 255, 255, 0.9); font-size: 14px; font-weight: 600; margin: 0 0 0.5rem 0;">الرصيد الحالي المستحق</p>
                            <h3 style="color: #fff; font-size: 28px; font-weight: 700; margin: 0;">
                                {{ number_format($entry->balance, 2) }} ₪
                            </h3>
                        </div>
                        <div style="width: 60px; height: 60px; background: rgba(255, 255, 255, 0.2); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                            <i class="la la-wallet" style="font-size: 32px; color: #fff;"></i>
                        </div>
                    </div>
                </div>

                {{-- Withdraws --}}
                <div class="card" style="border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: var(--shadow-sm);">
                    <div class="card-header bg-white p-3 border-bottom">
                        <h6 class="mb-0 fw-bold text-primary-deep">
                            <i class="la la-history"></i> سجل السحوبات المالية
                        </h6>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-clean align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 60px">#</th>
                                        <th>المبلغ</th>
                                        <th>ملاحظات</th>
                                        <th style="width: 130px">التاريخ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse ($entry->cashWithdraws as $w)
                                    <tr>
                                        <td class="text-center text-primary-deep fw-bold">{{ $loop->iteration }}</td>
                                        <td class="text-center fw-bold">₪ {{ number_format($w->total_amount, 2) }}</td>
                                        <td class="text-right">{{ $w->notes ?? '-' }}</td>
                                        <td class="text-center">{{ $w->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">لا توجد سحوبات مسجّلة</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                @if($entry->cashWithdraws->count())
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-start fw-bold">إجمالي السحوبات</td>
                                            <td class="text-center fw-bold text-primary-deep" style="font-size: 18px;">
                                                ₪ {{ number_format($entry->cashWithdraws->sum('total_amount'), 2) }}
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
            <div class="modal-footer border-top-0 p-4">
                <button type="button"
                        class="btn btn-secondary px-4"
                        data-dismiss="modal"
                        style="border-radius: 12px; font-weight: 700;">
                    إغلاق النافذة
                </button>
            </div>

        </div>
    </div>
</div>
