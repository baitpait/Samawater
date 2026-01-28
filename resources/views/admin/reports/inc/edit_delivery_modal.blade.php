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
          <input type="hidden" name="client_id" id="client_id">

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

@push('after_scripts')
<script>
var deliveryModal = null;
const deliveryEditBaseUrl = '{{ backpack_url("delivery") }}';

// نقل الـ Modal إلى نهاية الـ body لضمان ظهوره فوق الـ backdrop
document.addEventListener('DOMContentLoaded', function() {
    const modalEl = document.getElementById('editDeliveryModal');
    if (modalEl) {
        document.body.appendChild(modalEl);
    }
});

function closeEditModal() {
    if (deliveryModal && typeof deliveryModal.hide === 'function') {
        deliveryModal.hide();
    } else if (typeof $ !== 'undefined' && $('#editDeliveryModal').length) {
        $('#editDeliveryModal').modal('hide');
    } else {
        const modalEl = document.getElementById('editDeliveryModal');
        if (modalEl) {
            modalEl.classList.remove('show');
            modalEl.style.display = 'none';
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
        }
    }
}

function editDelivery(deliveryId) {
    if (!deliveryId) return;
    
    if (!deliveryModal) {
        const modalEl = document.getElementById('editDeliveryModal');
        if (!modalEl) return;
        
        if (typeof window.bootstrap !== 'undefined' && window.bootstrap && window.bootstrap.Modal) {
            deliveryModal = new window.bootstrap.Modal(modalEl);
        } else if (typeof window.jQuery !== 'undefined' && window.jQuery.fn && window.jQuery.fn.modal) {
            window.jQuery(modalEl).modal({ show: false });
            deliveryModal = {
                show: function() { window.jQuery(modalEl).modal('show'); },
                hide: function() { window.jQuery(modalEl).modal('hide'); }
            };
        }
    }
    
    fetch(`${deliveryEditBaseUrl}/${deliveryId}/edit`, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.id) {
            document.getElementById('delivery_id').value = data.id;
            document.getElementById('client_id').value = data.client_id ?? '';
            document.getElementById('bottle_received').value = data.bottle_received ?? 0;
            document.getElementById('bottle_empty').value = data.bottle_empty ?? 0;
            document.getElementById('paymant').value = data.paymant ?? 0;
            document.getElementById('delivery_date').value = data.delivery_date ?? '';
            if (document.getElementById('distributor_id')) {
                document.getElementById('distributor_id').value = data.distributor_id ?? '';
            }
            if (deliveryModal) deliveryModal.show();
        }
    })
    .catch(err => alert('حدث خطأ أثناء جلب البيانات'));
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editDeliveryForm');
    if (form) {
        form.addEventListener('submit', function(e){
            e.preventDefault();
            const formData = new FormData(this);
            const deliveryId = formData.get('delivery_id');
            formData.append('_method', 'PUT');

            fetch(`${deliveryEditBaseUrl}/${deliveryId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.status){
                    closeEditModal();
                    location.reload();
                } else {
                    alert(data.message || 'حدث خطأ');
                }
            })
            .catch(err => alert('حدث خطأ أثناء حفظ التعديلات'));
        });
    }
});
</script>
@endpush
