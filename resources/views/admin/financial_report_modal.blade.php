<div class="modal fade"
     id="financialReportModal"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable"
         role="document">

        <div class="modal-content" style="border-radius: 22px; border: none; overflow: visible; box-shadow: 0 25px 60px rgba(0,0,0,0.2);">

            <div class="modal-header" style="background: var(--primary-deep); border-bottom: none; padding: 20px 28px;">
                <h5 class="modal-title text-white fw-bold">
                    📊 التقرير المالي
                </h5>

                <button type="button"
                        class="btn-close-custom"
                        data-dismiss="modal"
                        style="background: rgba(255,255,255,0.1); border: none; color: #fff; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;">
                    <i class="la la-times"></i>
                </button>
            </div>

            <div class="modal-body p-4" id="financial-report-body">
                <div class="text-center text-muted py-5">
                    <i class="la la-spinner la-spin" style="font-size: 32px; color: var(--primary-deep);"></i>
                    <div class="mt-3 fw-bold">جاري التحميل...</div>
                </div>
            </div>

            <div class="modal-footer border-top-0 p-4">
                <button class="btn btn-secondary px-4"
                        data-dismiss="modal"
                        style="border-radius: 12px; font-weight: 700;">
                    إغلاق النافذة
                </button>
            </div>

        </div>
    </div>
</div>
