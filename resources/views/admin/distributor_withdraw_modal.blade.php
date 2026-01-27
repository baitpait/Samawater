{{-- Withdraw Modal - Unified Design --}}
<div style="display:none" id="withdraw-view-loaded">LOADED</div>

<div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 22px; border: none; overflow: hidden; box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);">
            
            {{-- Unified Header --}}
            <div class="modal-header" style="background: var(--primary-deep); padding: 1.5rem 2rem; border: none; position: relative; overflow: hidden;">
                <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; position: relative; z-index: 1;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <i class="la la-money-bill" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
                        <h5 class="modal-title text-white fw-bold" id="withdrawModalLabel" style="margin: 0; font-family: 'Cairo', sans-serif;">
                            سحب أموال
                        </h5>
                    </div>
                    <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close" style="background: rgba(255, 255, 255, 0.1); border: none; color: #fff; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;">
                        <i class="la la-times"></i>
                    </button>
                </div>
            </div>

            <form id="withdrawForm" method="POST" action="{{ backpack_url('cash-withdraw') }}">
                @csrf
                <input type="hidden" name="distributor_id" id="withdraw_distributor_id">

                <div class="modal-body p-4" style="background: #fcfdff;">
                    
                    {{-- Current Balance Card --}}
                    <div class="balance-card mb-4" style="background: var(--success-gradient); border-radius: 16px; padding: 1.5rem; box-shadow: var(--shadow-sm);">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <p style="color: rgba(255, 255, 255, 0.9); font-size: 14px; font-weight: 600; margin: 0 0 0.5rem 0;">
                                    الرصيد الحالي
                                </p>
                                <h3 style="color: #fff; font-size: 28px; font-weight: 700; margin: 0;">
                                    <span id="currentBalance">0</span> <span style="font-size: 20px;">₪</span>
                                </h3>
                            </div>
                            <div style="width: 60px; height: 60px; background: rgba(255, 255, 255, 0.2); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                                <i class="la la-wallet" style="font-size: 32px; color: #fff;"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Amount Input --}}
                    <div class="form-group mb-4">
                        <label class="form-label">المبلغ المراد سحبه</label>
                        <input 
                            type="number" 
                            step="0.01" 
                            min="0"
                            name="total_amount"
                            id="withdrawAmount"
                            class="form-control"
                            placeholder="0.00"
                            required
                        >
                        <small class="text-danger d-none mt-2" id="balanceError">
                            <i class="la la-exclamation-circle"></i> المبلغ أكبر من الرصيد المتاح
                        </small>
                    </div>

                    {{-- Notes Input --}}
                    <div class="form-group mb-0">
                        <label class="form-label">ملاحظات (اختياري)</label>
                        <textarea 
                            name="notes" 
                            class="form-control"
                            placeholder="اكتب أي ملاحظات إضافية هنا..."
                            rows="3"
                            style="resize: vertical;"
                        ></textarea>
                    </div>

                </div>

                {{-- Unified Footer --}}
                <div class="modal-footer border-top-0 p-4" style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        إلغاء
                    </button>
                    <button type="submit" id="withdrawSubmit" class="btn btn-success px-4">
                        تأكيد السحب
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
(function() {
    'use strict';
    
    // Helper functions
    function $(selector) { return document.querySelector(selector); }
    function $$(selector) { return document.querySelectorAll(selector); }
    
    var withdrawModalInstance = null;
    var isSubmitting = false;
    
    function closeModal() {
        var modalElement = document.getElementById('withdrawModal');
        if (!modalElement) return;
        
        if (typeof jQuery !== 'undefined' && jQuery.fn.modal) {
            jQuery('#withdrawModal').modal('hide');
        } else if (withdrawModalInstance) {
            withdrawModalInstance.hide();
        } else {
            modalElement.classList.remove('show');
            modalElement.style.display = 'none';
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
            document.body.classList.remove('modal-open');
        }
    }
    
    function initModal() {
        var modalElement = document.getElementById('withdrawModal');
        if (!modalElement) return;
        
        if (typeof window.bootstrap !== 'undefined' && window.bootstrap.Modal && !withdrawModalInstance) {
            withdrawModalInstance = new window.bootstrap.Modal(modalElement);
        }
        
        // Open Modal Event
        document.addEventListener('click', function(e) {
            if (e.target.closest('.open-withdraw-modal')) {
                var button = e.target.closest('.open-withdraw-modal');
                var id = button.getAttribute('data-id');
                var balance = parseFloat(button.getAttribute('data-balance') || 0);
                
                document.getElementById('withdraw_distributor_id').value = id;
                document.getElementById('currentBalance').textContent = balance.toFixed(2);
                document.getElementById('withdrawAmount').value = '';
                document.getElementById('balanceError').classList.add('d-none');
                
                isSubmitting = false;
                const submitBtn = document.getElementById('withdrawSubmit');
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'تأكيد السحب';
                
                if (withdrawModalInstance) withdrawModalInstance.show();
                else if (typeof jQuery !== 'undefined') jQuery('#withdrawModal').modal('show');
            }
        });
        
        // Amount Validation
        const amountInput = document.getElementById('withdrawAmount');
        if (amountInput) {
            amountInput.addEventListener('input', function() {
                const balance = parseFloat(document.getElementById('currentBalance').textContent) || 0;
                const amount = parseFloat(this.value) || 0;
                const error = document.getElementById('balanceError');
                const submit = document.getElementById('withdrawSubmit');
                
                if (amount > balance) {
                    error.classList.remove('d-none');
                    submit.disabled = true;
                } else {
                    error.classList.add('d-none');
                    submit.disabled = false;
                }
            });
        }
        
        // Form Submit
        const form = document.getElementById('withdrawForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (isSubmitting) return;
                
                isSubmitting = true;
                const submitBtn = document.getElementById('withdrawSubmit');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="la la-spinner la-spin"></i> جاري المعالجة...';
                
                const formData = new FormData(this);
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        closeModal();
                        location.reload();
                    } else {
                        alert(data.message || 'حدث خطأ');
                        isSubmitting = false;
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'تأكيد السحب';
                    }
                })
                .catch(err => {
                    alert('حدث خطأ فني');
                    isSubmitting = false;
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'تأكيد السحب';
                });
            });
        }
    }
    
    document.addEventListener('DOMContentLoaded', initModal);
})();
</script>
