{{-- Modal for editing delivery --}}
<div class="modal fade" id="editDeliveryModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 22px; border: none; overflow: visible; box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25);">
      <form id="editDeliveryForm">
        <div class="modal-header" style="background: var(--primary-deep); border-bottom: none; padding: 20px 28px;">
          <h5 class="modal-title text-white fw-bold">تعديل التسليم</h5>
          <button type="button" class="btn-close-custom" onclick="closeEditModal()" aria-label="Close" style="background: rgba(255, 255, 255, 0.1); border: none; color: #fff; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;">
            <i class="la la-times"></i>
          </button>
        </div>
        <div class="modal-body p-4">
          <input type="hidden" name="delivery_id" id="delivery_id">
          <input type="hidden" name="client_id" id="edit_delivery_client_id" value="">
          <input type="hidden" name="inventory_item_id" id="inventory_item_id" value="1">

          <div class="mb-3">
            <label for="required_amount" class="form-label fw-bold">المبلغ المطلوب <span class="text-danger">*</span></label>
            <input type="number" name="required_amount" id="required_amount" class="form-control" min="0" step="0.01" required>
          </div>

          <div class="mb-3">
            <label for="bottle_received" class="form-label fw-bold">عدد العبوات المستلمة <span class="text-danger">*</span></label>
            <input type="number" name="bottle_received" id="bottle_received" class="form-control" min="0" required>
          </div>

          <div class="mb-3">
            <label for="bottle_empty" class="form-label fw-bold">عدد القوارير الفارغة <span class="text-danger">*</span></label>
            <input type="number" name="bottle_empty" id="bottle_empty" class="form-control" min="0" required>
          </div>

          <div class="mb-3">
            <label for="paymant" class="form-label fw-bold">الدفعة المالية <span class="text-danger">*</span></label>
            <input type="number" name="paymant" id="paymant" class="form-control" min="0" step="0.01" required>
          </div>

          <div class="mb-3">
            <label for="delivery_date" class="form-label fw-bold">تاريخ التسليم <span class="text-danger">*</span></label>
            <input type="date" name="delivery_date" id="delivery_date" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="distributor_id" class="form-label fw-bold">الموزع <span class="text-danger">*</span></label>
            <select name="distributor_id" id="distributor_id" class="form-control" required>
              <option value="">-- اختر الموزع --</option>
              @foreach($distributors ?? [] as $distributor)
                <option value="{{ $distributor->id }}">{{ $distributor->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="modal-footer border-top-0 p-4">
          <button type="submit" class="btn btn-success px-4" style="border-radius: 12px; font-weight: 700;">
            <i class="la la-save"></i> حفظ التعديلات
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Loaded inline so editDelivery exists even when layouts omit @stack('after_scripts') --}}
<script>
(function () {
var deliveryModal = null;
const deliveryEditBaseUrl = '{{ backpack_url("delivery") }}';

document.addEventListener('DOMContentLoaded', function () {
    const modalEl = document.getElementById('editDeliveryModal');
    if (modalEl && modalEl.parentElement !== document.body) {
        document.body.appendChild(modalEl);
    }
});

window.closeEditModal = function closeEditModal() {
    if (deliveryModal && typeof deliveryModal.hide === 'function') {
        deliveryModal.hide();
    } else if (typeof window.$ !== 'undefined' && $('#editDeliveryModal').length) {
        $('#editDeliveryModal').modal('hide');
    } else {
        var modalDom = document.getElementById('editDeliveryModal');
        if (modalDom) {
            modalDom.classList.remove('show');
            modalDom.style.display = 'none';
            var bd = document.querySelector('.modal-backdrop');
            if (bd) { bd.remove(); }
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
        }
    }
};

window.editDelivery = function editDelivery(deliveryId) {
    if (!deliveryId) return;

    var modalDom = document.getElementById('editDeliveryModal');
    if (!modalDom) return;

    if (!deliveryModal) {
        if (typeof window.bootstrap !== 'undefined' && window.bootstrap && window.bootstrap.Modal) {
            deliveryModal = new window.bootstrap.Modal(modalDom);
        } else if (typeof window.$ !== 'undefined' && window.$.fn && window.$.fn.modal) {
            window.$(modalDom).modal({ show: false });
            deliveryModal = {
                show: function () { window.$(modalDom).modal('show'); },
                hide: function () { window.$(modalDom).modal('hide'); },
            };
        }
    }

    fetch(deliveryEditBaseUrl + '/' + deliveryId + '/modal-data', {
        credentials: 'same-origin',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
    })
        .then(function (res) {
            return res.json().then(function (data) {
                return { ok: res.ok, status: res.status, data: data };
            });
        })
        .then(function (wrapped) {
            if (!wrapped.ok || !wrapped.data || wrapped.data.id == null) {
                var msg =
                    (wrapped.data && wrapped.data.message) ||
                    ('تعذر تحميل بيانات التسليم (' + wrapped.status + ')');
                alert(msg);
                return;
            }
            var data = wrapped.data;
            document.getElementById('delivery_id').value = data.id;
            document.getElementById('edit_delivery_client_id').value = data.client_id ?? '';
            document.getElementById('required_amount').value =
                data.required_amount != null ? data.required_amount : '';
            document.getElementById('inventory_item_id').value =
                data.inventory_item_id != null ? data.inventory_item_id : '1';
            document.getElementById('bottle_received').value = data.bottle_received ?? 0;
            document.getElementById('bottle_empty').value = data.bottle_empty ?? 0;
            document.getElementById('paymant').value = data.paymant ?? 0;
            document.getElementById('delivery_date').value = data.delivery_date ?? '';
            document.getElementById('distributor_id').value = data.distributor_id ?? '';
            if (deliveryModal) {
                deliveryModal.show();
            }
        })
        .catch(function () {
            alert('حدث خطأ أثناء جلب البيانات');
        });
};

document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('editDeliveryForm');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(form);
        var deliveryPk = formData.get('delivery_id');
        formData.append('_method', 'PUT');

        fetch(deliveryEditBaseUrl + '/' + deliveryPk, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData,
        })
            .then(function (res) {
                return res.json().then(function (data) {
                    return { ok: res.ok, data: data, status: res.status };
                });
            })
            .then(function (wrapped) {
                var data = wrapped.data;
                if (!wrapped.ok) {
                    var errs = data.errors || {};
                    var flat = [];
                    Object.keys(errs).forEach(function (k) {
                        [].concat(errs[k] || []).forEach(function (m) {
                            flat.push(m);
                        });
                    });
                    var msg =
                        data.message ||
                        (flat.length ? flat.join('\n') : '') ||
                        'فشل التحقق من البيانات (' + wrapped.status + ')';
                    alert(msg);
                    return;
                }
                if (data.status) {
                    window.closeEditModal();
                    window.location.reload();
                } else {
                    alert(data.message || 'حدث خطأ');
                }
            })
            .catch(function () {
                alert('حدث خطأ أثناء حفظ التعديلات');
            });
    });
});
})();
</script>
