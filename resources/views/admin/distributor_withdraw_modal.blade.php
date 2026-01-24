{{-- Withdraw Modal - Unified Design --}}
<div style="display:none" id="withdraw-view-loaded">LOADED</div>

<div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);">
            
            {{-- Unified Header --}}
            <div class="modal-header-unified" style="background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%); padding: 1.5rem 2rem; border: none; position: relative; overflow: hidden;">
                {{-- Background Animation Effect --}}
                <div style="content: ''; position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite; pointer-events: none;"></div>
                
                <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; position: relative; z-index: 1;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <i class="la la-money-bill" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
                        <h5 class="modal-title" id="withdrawModalLabel" style="color: #fff; font-size: 20px; font-weight: 700; margin: 0; font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                            سحب أموال
                        </h5>
                    </div>
                    <button type="button" class="btn-close-unified" data-bs-dismiss="modal" aria-label="Close" style="background: rgba(255, 255, 255, 0.2); border: none; color: #fff; font-size: 24px; width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s ease;">
                        <i class="la la-times"></i>
                    </button>
                </div>
            </div>

            <form id="withdrawForm" method="POST" action="{{ backpack_url('cash-withdraw') }}">
                @csrf
                <input type="hidden" name="distributor_id" id="withdraw_distributor_id">

                <div class="modal-body" style="padding: 2rem; background: #fcfdff;">
                    
                    {{-- Current Balance Card --}}
                    <div class="balance-card" style="background: linear-gradient(135deg, #34d399 0%, #22c55e 100%); border-radius: 16px; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 8px 24px rgba(34, 211, 153, 0.2);">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <p style="color: rgba(255, 255, 255, 0.9); font-size: 14px; font-weight: 600; margin: 0 0 0.5rem 0; font-family: 'Cairo', sans-serif;">
                                    الرصيد الحالي
                                </p>
                                <h3 style="color: #fff; font-size: 28px; font-weight: 700; margin: 0; font-family: 'Cairo', sans-serif;">
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
                        <label class="form-label" style="font-size: 14px; font-weight: 600; color: #55607b; margin-bottom: 8px; display: block; font-family: 'Cairo', sans-serif;">
                            <i class="la la-money-bill-wave" style="margin-left: 6px; color: #6f6af8;"></i>
                            المبلغ
                        </label>
                        <input 
                            type="number" 
                            step="0.01" 
                            min="0"
                            name="total_amount"
                            id="withdrawAmount"
                            class="form-control modern-input"
                            placeholder="أدخل المبلغ المراد سحبه"
                            required
                            style="height: 50px; font-size: 15px; padding: 14px 20px; font-family: 'Cairo', sans-serif; border-radius: 12px; background: #f7f9ff; border: 1px solid #e2e8ff;"
                        >
                        <small class="text-danger d-none" id="balanceError" style="display: block; margin-top: 8px; font-size: 13px; color: #ef4444; font-family: 'Cairo', sans-serif;">
                            <i class="la la-exclamation-circle"></i> المبلغ أكبر من الرصيد المتاح
                        </small>
                    </div>

                    {{-- Notes Input --}}
                    <div class="form-group mb-4">
                        <label class="form-label" style="font-size: 14px; font-weight: 600; color: #55607b; margin-bottom: 8px; display: block; font-family: 'Cairo', sans-serif;">
                            <i class="la la-sticky-note" style="margin-left: 6px; color: #6f6af8;"></i>
                            ملاحظات
                        </label>
                        <textarea 
                            name="notes" 
                            class="form-control modern-input"
                            placeholder="أدخل ملاحظات (اختياري)"
                            rows="4"
                            style="font-size: 15px; padding: 14px 20px; font-family: 'Cairo', sans-serif; border-radius: 12px; background: #f7f9ff; border: 1px solid #e2e8ff; resize: vertical;"
                        ></textarea>
                    </div>

                </div>

                {{-- Unified Footer --}}
                <div class="modal-footer-unified" style="padding: 1.5rem 2rem; background: #fff; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 0.75rem;">
                    <button type="button" class="btn btn-cancel-unified" data-bs-dismiss="modal" style="background: #f3f4f6; color: #6b7280; border: none; border-radius: 12px; padding: 0.75rem 1.5rem; font-weight: 600; font-size: 14px; font-family: 'Cairo', sans-serif; transition: all 0.2s ease;">
                        <i class="la la-times"></i> إلغاء
                    </button>
                    <button type="submit" id="withdrawSubmit" class="btn btn-success-unified" style="background: linear-gradient(135deg, #34d399 0%, #22c55e 100%); color: #fff; border: none; border-radius: 12px; padding: 0.75rem 1.5rem; font-weight: 600; font-size: 14px; font-family: 'Cairo', sans-serif; transition: all 0.2s ease; box-shadow: 0 4px 12px rgba(34, 211, 153, 0.3);">
                        <i class="la la-check"></i> تأكيد السحب
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<style>
    @keyframes pulse {
        0%, 100% {
            opacity: 0.5;
        }
        50% {
            opacity: 0.8;
        }
    }

    /* Modal Overlay */
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5) !important;
        backdrop-filter: blur(4px);
    }

    /* Close Button Hover */
    .btn-close-unified:hover {
        background: rgba(255, 255, 255, 0.3) !important;
        transform: rotate(90deg);
    }

    /* Cancel Button Hover */
    .btn-cancel-unified:hover {
        background: #e5e7eb !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Success Button Hover */
    .btn-success-unified:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(34, 211, 153, 0.4) !important;
    }

    /* Input Focus */
    .modern-input:focus {
        background: #fff !important;
        border-color: #7b7bff !important;
        box-shadow: 0 0 0 3px rgba(123, 123, 255, 0.15) !important;
        outline: none !important;
    }

    /* Disabled Button */
    .btn-success-unified:disabled {
        opacity: 0.6 !important;
        cursor: not-allowed !important;
        transform: none !important;
    }
</style>

<script>
(function() {
    'use strict';
    
    // Helper functions
    function $(selector) {
        return document.querySelector(selector);
    }
    
    function $$(selector) {
        return document.querySelectorAll(selector);
    }
    
    // استخدام jQuery إذا كان متاحاً، وإلا استخدام vanilla JS
    var useJQuery = typeof jQuery !== 'undefined';
    var $j = useJQuery ? jQuery : null;
    
    // متغير عام للـ Modal
    var withdrawModalInstance = null;
    
    // متغير عام لمنع الإرسال المزدوج
    var isSubmitting = false;
    
    // دالة لإغلاق Modal
    function closeModal() {
        var modalElement = $('#withdrawModal');
        if (!modalElement) return;
        
        if (useJQuery && $j) {
            $j('#withdrawModal').modal('hide');
        } else if (typeof bootstrap !== 'undefined') {
            if (withdrawModalInstance) {
                withdrawModalInstance.hide();
            } else {
                var modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                } else {
                    modalElement.classList.remove('show');
                    modalElement.style.display = 'none';
                    modalElement.setAttribute('aria-hidden', 'true');
                    modalElement.removeAttribute('aria-modal');
                    var backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) {
                        backdrop.remove();
                    }
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                }
            }
        } else {
            // Fallback: إغلاق يدوي
            modalElement.classList.remove('show');
            modalElement.style.display = 'none';
            modalElement.setAttribute('aria-hidden', 'true');
            var backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
        }
    }
    
    // تهيئة Modal
    function initModal() {
        var modalElement = $('#withdrawModal');
        if (!modalElement) return;
        
        // تهيئة Bootstrap Modal
        if (typeof bootstrap !== 'undefined' && !withdrawModalInstance) {
            withdrawModalInstance = new bootstrap.Modal(modalElement, {
                backdrop: true,
                keyboard: true,
                focus: true
            });
        }
        
        // إضافة event listeners لأزرار الإغلاق
        var closeButtons = $$('.btn-close-unified, .btn-cancel-unified, [data-bs-dismiss="modal"], [data-dismiss="modal"]');
        closeButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeModal();
            });
        });
        
        // إغلاق عند النقر على backdrop
        modalElement.addEventListener('click', function(e) {
            if (e.target === modalElement) {
                closeModal();
            }
        });
        
        // فتح Modal عند النقر على زر السحب
        document.addEventListener('click', function(e) {
            if (e.target.closest('.open-withdraw-modal')) {
                var button = e.target.closest('.open-withdraw-modal');
                var id = button.getAttribute('data-id') || button.dataset.id;
                var balance = parseFloat(button.getAttribute('data-balance') || button.dataset.balance || 0);
                
                // تعبئة البيانات
                var distributorIdInput = $('#withdraw_distributor_id');
                var currentBalanceSpan = $('#currentBalance');
                var withdrawAmountInput = $('#withdrawAmount');
                var balanceError = $('#balanceError');
                var withdrawSubmit = $('#withdrawSubmit');
                
                // إعادة تعيين حالة الإرسال عند فتح modal جديد
                isSubmitting = false;
                
                if (distributorIdInput) distributorIdInput.value = id;
                if (currentBalanceSpan) currentBalanceSpan.textContent = balance.toFixed(2);
                if (withdrawAmountInput) withdrawAmountInput.value = '';
                if (balanceError) balanceError.classList.add('d-none');
                if (withdrawSubmit) {
                    withdrawSubmit.disabled = false;
                    withdrawSubmit.style.opacity = '1';
                    withdrawSubmit.innerHTML = '<i class="la la-check"></i> تأكيد السحب';
                }
                
                // فتح Modal
                if (useJQuery && $j) {
                    $j('#withdrawModal').modal('show');
                } else if (withdrawModalInstance) {
                    withdrawModalInstance.show();
                } else if (typeof bootstrap !== 'undefined') {
                    var modal = new bootstrap.Modal(modalElement);
                    modal.show();
                    withdrawModalInstance = modal;
                } else {
                    modalElement.classList.add('show');
                    modalElement.style.display = 'block';
                    modalElement.setAttribute('aria-modal', 'true');
                    modalElement.removeAttribute('aria-hidden');
                    document.body.classList.add('modal-open');
                    var backdrop = document.createElement('div');
                    backdrop.className = 'modal-backdrop fade show';
                    document.body.appendChild(backdrop);
                }
            }
        });
        
        // التحقق من المبلغ
        var withdrawAmountInput = $('#withdrawAmount');
        if (withdrawAmountInput) {
            withdrawAmountInput.addEventListener('input', function() {
                var currentBalanceText = $('#currentBalance') ? $('#currentBalance').textContent : '0';
                var balance = parseFloat(currentBalanceText) || 0;
                var amount = parseFloat(this.value) || 0;
                var balanceError = $('#balanceError');
                var withdrawSubmit = $('#withdrawSubmit');
                
                if (amount > balance) {
                    if (balanceError) balanceError.classList.remove('d-none');
                    if (withdrawSubmit) {
                        withdrawSubmit.disabled = true;
                        withdrawSubmit.style.opacity = '0.6';
                    }
                } else {
                    if (balanceError) balanceError.classList.add('d-none');
                    if (withdrawSubmit) {
                        withdrawSubmit.disabled = false;
                        withdrawSubmit.style.opacity = '1';
                    }
                }
            });
        }
        
        // إرسال النموذج
        var withdrawForm = $('#withdrawForm');
        
        if (withdrawForm) {
            // إزالة event listeners القديمة لمنع التكرار
            var newForm = withdrawForm.cloneNode(true);
            withdrawForm.parentNode.replaceChild(newForm, withdrawForm);
            withdrawForm = newForm;
            
            withdrawForm.addEventListener('submit', function(e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                
                // منع الإرسال المزدوج
                if (isSubmitting) {
                    console.log('⏸️ منع الإرسال المزدوج - النموذج قيد المعالجة');
                    return false;
                }
                
                var form = this;
                var formData = new FormData(form);
                var submitButton = $('#withdrawSubmit');
                
                // تعطيل الزر ووضع علامة الإرسال
                isSubmitting = true;
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.style.opacity = '0.6';
                    submitButton.innerHTML = '<i class="la la-spinner la-spin"></i> جاري المعالجة...';
                }
                
                if (useJQuery && $j) {
                    $j.ajax({
                        url: form.action,
                        method: 'POST',
                        data: $j(form).serialize(),
                        dataType: 'json',
                        success: function(response) {
                            // منع أي معالجة إضافية بعد النجاح
                            if (isSubmitting === false) {
                                return; // تم إرسال النموذج بالفعل
                            }
                            
                            if (response && response.status === 'success') {
                                // منع أي إرسال إضافي
                                isSubmitting = true;
                                
                                // إغلاق modal وإعادة تحميل الصفحة بدون رسالة
                                closeModal();
                                setTimeout(function() {
                                    location.reload();
                                }, 300);
                            } else {
                                // إظهار رسالة خطأ فقط
                                isSubmitting = false; // إعادة تفعيل الإرسال
                                alert(response && response.message ? response.message : 'حدث خطأ أثناء السحب');
                                if (submitButton) {
                                    submitButton.disabled = false;
                                    submitButton.style.opacity = '1';
                                    submitButton.innerHTML = '<i class="la la-check"></i> تأكيد السحب';
                                }
                            }
                        },
                        error: function(xhr) {
                            // إظهار رسالة خطأ فقط
                            isSubmitting = false; // إعادة تفعيل الإرسال
                            var errorMessage = 'حدث خطأ أثناء السحب';
                            try {
                                var response = xhr.responseJSON;
                                if (response && response.message) {
                                    errorMessage = response.message;
                                } else if (xhr.responseText) {
                                    try {
                                        var textResponse = JSON.parse(xhr.responseText);
                                        if (textResponse.message) {
                                            errorMessage = textResponse.message;
                                        }
                                    } catch (parseError) {
                                        // إذا فشل parsing، استخدم رسالة افتراضية
                                    }
                                }
                            } catch (e) {
                                console.error('Error parsing response:', e);
                            }
                            alert(errorMessage);
                            if (submitButton) {
                                submitButton.disabled = false;
                                submitButton.style.opacity = '1';
                                submitButton.innerHTML = '<i class="la la-check"></i> تأكيد السحب';
                            }
                        }
                    });
                } else {
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        // التحقق من status code
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw new Error(data.message || 'حدث خطأ أثناء السحب');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        // منع أي معالجة إضافية بعد النجاح
                        if (isSubmitting === false) {
                            return; // تم إرسال النموذج بالفعل
                        }
                        
                        if (data && data.status === 'success') {
                            // منع أي إرسال إضافي
                            isSubmitting = true;
                            
                            // إغلاق modal وإعادة تحميل الصفحة بدون رسالة
                            closeModal();
                            setTimeout(function() {
                                location.reload();
                            }, 300);
                        } else {
                            // إظهار رسالة خطأ فقط
                            isSubmitting = false; // إعادة تفعيل الإرسال
                            alert(data && data.message ? data.message : 'حدث خطأ أثناء السحب');
                            if (submitButton) {
                                submitButton.disabled = false;
                                submitButton.style.opacity = '1';
                                submitButton.innerHTML = '<i class="la la-check"></i> تأكيد السحب';
                            }
                        }
                    })
                    .catch(error => {
                        // إظهار رسالة خطأ فقط
                        isSubmitting = false; // إعادة تفعيل الإرسال
                        console.error('Error:', error);
                        alert(error.message || 'حدث خطأ أثناء السحب');
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.style.opacity = '1';
                            submitButton.innerHTML = '<i class="la la-check"></i> تأكيد السحب';
                        }
                    });
                }
            });
        }
    }
    
    // تشغيل عند تحميل الصفحة
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initModal, 100);
        });
    } else {
        setTimeout(initModal, 100);
    }
    
    // دعم jQuery إذا كان متاحاً
    if (useJQuery && $j) {
        $j(document).ready(function() {
            initModal();
        });
    }
})();
</script>

