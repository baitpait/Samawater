@extends(backpack_view('blank'))

@section('content')
<div class="container-fluid pb-4">

    {{-- ===============================
        Header - Unified Design
    =============================== --}}
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header">
        <div class="header-content-wrapper" style="display: flex; align-items: center; gap: 1rem; width: 100%; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <i class="la la-truck" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
                <h1 class="text-capitalize mb-0" bp-section="page-heading">التسليمات</h1>
            </div>
            <div class="page-header-actions" style="display: flex; gap: 0.75rem;">
                @if(request('search'))
                <a href="{{ route('reports.clients_delivery_overview.export.excel', request()->all()) }}" class="btn btn-success-unified">
                    <i class="la la-file-excel"></i>
                    تصدير Excel
                </a>
                <a href="{{ route('reports.clients_delivery_overview.export.pdf', request()->all()) }}" class="btn btn-danger" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border: none; border-radius: 12px; padding: 10px 20px; font-weight: 600; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3); transition: all 0.2s ease;">
                    <i class="la la-file-pdf"></i>
                    تصدير PDF
                </a>
                @endif
                <a href="{{ backpack_url('delivery/create') }}" class="btn btn-success-unified">
                    <i class="la la-plus"></i>
                    إضافة تسليم
                </a>
            </div>
        </div>
    </section>

    {{-- Unified Header CSS --}}
    <style>
        section.header-operation {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
            border-radius: 20px !important;
            padding: 1.5rem 2rem !important;
            margin-bottom: 2rem !important;
            box-shadow: 0 10px 30px rgba(111, 106, 248, 0.3) !important;
            position: relative !important;
            overflow: hidden !important;
        }

        section.header-operation::before {
            content: '' !important;
            position: absolute !important;
            top: -50% !important;
            right: -50% !important;
            width: 200% !important;
            height: 200% !important;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%) !important;
            animation: pulse 3s ease-in-out infinite !important;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 0.8; }
        }

        section.header-operation h1 {
            color: #fff !important;
            font-size: 24px !important;
            font-weight: 700 !important;
            margin: 0 !important;
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
            position: relative !important;
            z-index: 1 !important;
        }

        section.header-operation .page-header-actions .btn {
            height: 42px !important;
            border-radius: 12px !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            padding: 0 18px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            transition: all 0.2s ease !important;
            position: relative !important;
            z-index: 1 !important;
            color: #fff !important;
        }

        section.header-operation .page-header-actions .btn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.3) !important;
        }
    </style>

    {{-- ===============================
        Filters
    =============================== --}}
    <div class="card filter-card mb-4">
        <div class="card-body">
            {{-- Results Header - في بداية card-body --}}
            @if(request()->has('search'))
            <div class="row mb-4">
                <div class="col-12">
                    <div class="results-header-modern">
                        <div class="results-header-item results-count-item">
                            <div class="results-count-wrapper">
                                <span class="results-label">عدد المشتركين المستلمين:</span>
                                <strong class="results-value">{{ number_format($rows->total()) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <form method="GET" class="row g-3 align-items-end">
                <input type="hidden" name="search" value="1">
                
                {{-- الصف الأول --}}
                <div class="col-12 col-md-3">
                    <label class="form-label">من تاريخ</label>
                    <input type="date" name="from" class="form-control modern-input" value="{{ request('from') }}">
                </div>

                <div class="col-12 col-md-3">
                    <label class="form-label">إلى تاريخ</label>
                    <input type="date" name="to" class="form-control modern-input" value="{{ request('to') }}">
                </div>

                <div class="col-12 col-md-3">
                    <label class="form-label">المدينة</label>
                    <select name="city_id" class="form-select modern-select">
                        <option value="">الكل</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" @selected(request('city_id') == $city->id)>
                                {{ $city->city_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-3">
                    <label class="form-label">الموزع</label>
                    <select name="distributor_id" class="form-select modern-select">
                        <option value="">الكل</option>
                        @foreach($distributors as $distributor)
                            <option value="{{ $distributor->id }}" @selected(request('distributor_id') == $distributor->id)>
                                {{ $distributor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- الصف الثاني --}}
                <div class="col-12 col-md-4">
                    <label class="form-label">حالة الاشتراك</label>
                    <select name="subscription_status_id" class="form-select modern-select">
                        <option value="">الكل</option>
                        @foreach($subscriptionStatuses as $status)
                            <option value="{{ $status->id }}" @selected(request('subscription_status_id') == $status->id)>
                                {{ $status->status_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label">نوع الاشتراك</label>
                    <select name="subscription_type_id" class="form-select modern-select">
                        <option value="">الكل</option>
                        @foreach($subscriptionTypes as $type)
                            <option value="{{ $type->id }}" @selected(request('subscription_type_id') == $type->id)>
                                {{ $type->type_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-show-results w-100">
                        <i class="la la-search"></i>
                        عرض النتائج
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===============================
        Results
    =============================== --}}
    @if(request()->has('search'))

        <div class="card filter-card mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-clean align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">المشترك</th>
                            <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">المدينة</th>
                            <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">الهاتف</th>
                            <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">تاريخ الاستلام</th>
                            <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">العبوات المستلمة</th>
                            <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">العبوات الفارغة</th>
                            <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">الرصيد</th>
                            <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">الدفعة</th>
                            <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px;">الموزع</th>
                            <th style="font-weight: 700; color: #374151; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 12px; text-align: center;">تعديل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $r)
                        <tr style="background: #fcfdff; box-shadow: 0 4px 12px rgba(0,0,0,.06); border-radius: 12px; margin-bottom: 8px;">
                            <td style="padding: 12px; color: #374151; font-weight: 600;">
                                <div class="fw-bold">{{ $r->client_name }}</div>
                                <div class="text-muted small" style="color: #9ca3af;">{{ $r->contract_no }}</div>
                            </td>
                            <td style="padding: 12px; color: #374151;">{{ $r->city_name ?? '-' }}</td>
                            <td style="padding: 12px; color: #374151;">
                                <div class="d-flex flex-column gap-1">
                                    @if(!empty($r->phone_one))
                                        <div>{{ $r->phone_one }}</div>
                                    @endif
                                    @if(!empty($r->phone_two))
                                        <div class="text-muted small">{{ $r->phone_two }}</div>
                                    @endif
                                    @if(empty($r->phone_one) && empty($r->phone_two))
                                        <div>-</div>
                                    @endif
                                </div>
                            </td>
                            <td style="padding: 12px; color: #6f6af8; font-weight: 600;">
                                {{ $r->last_delivery_date_actual ? \Carbon\Carbon::parse($r->last_delivery_date_actual)->format('Y-m-d') : ($r->last_delivery_date ? \Carbon\Carbon::parse($r->last_delivery_date)->format('Y-m-d') : '-') }}
                            </td>
                            <td style="padding: 12px;">
                                <span class="badge-success-custom" style="font-size: 14px; font-weight: 600;">
                                    {{ number_format($r->last_bottle_received ?? $r->total_bottle_received ?? 0) }}
                                </span>
                            </td>
                            <td style="padding: 12px;">
                                <span class="badge-warning-custom" style="font-size: 14px; font-weight: 600;">
                                    {{ number_format($r->last_bottle_empty ?? $r->total_bottle_empty ?? 0) }}
                                </span>
                            </td>
                            <td style="padding: 12px;">
                                @php
                                    $bottleReceived = $r->last_bottle_received ?? $r->total_bottle_received ?? 0;
                                    $bottleEmpty = $r->last_bottle_empty ?? $r->total_bottle_empty ?? 0;
                                    $balance = $bottleReceived - $bottleEmpty;
                                    $balanceClass = $balance > 0 ? 'badge-balance-positive' : ($balance < 0 ? 'badge-balance-negative' : 'badge-balance-zero');
                                @endphp
                                <span class="{{ $balanceClass }}" style="font-size: 14px; font-weight: 600;">
                                    {{ number_format($balance) }}
                                </span>
                            </td>
                            <td style="padding: 12px;">
                                <span class="badge badge-soft-purple" style="font-size: 14px; font-weight: 600;">
                                    {{ number_format($r->last_paymant ?? $r->paymant ?? 0) }} ₪
                                </span>
                            </td>
                            <td style="padding: 12px; color: #374151;">{{ $r->distributor_name ?? '-' }}</td>
                            <td style="padding: 12px; text-align: center;">
                                @if($r->last_delivery_id)
                                <button type="button" 
                                        class="btn btn-sm btn-primary edit-delivery-btn" 
                                        data-id="{{ $r->last_delivery_id }}"
                                        style="background: linear-gradient(135deg, #7d5bff 0%, #6f6af8 100%); border: none; border-radius: 10px; padding: 6px 16px; font-weight: 600; box-shadow: 0 2px 8px rgba(111, 106, 248, 0.3); transition: all 0.2s ease;"
                                        title="تعديل التسليم">
                                    <i class="la la-edit"></i>
                                </button>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted" style="padding: 40px;">لا توجد نتائج مطابقة</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($rows->hasPages())
            <div class="pagination-wrapper">
                {{ $rows->withQueryString()->links('pagination::bootstrap-5') }}
                <div class="pagination-info-arabic">
                    <p class="small text-muted">
                        عرض
                        <span class="fw-semibold">{{ $rows->firstItem() }}</span>
                        إلى
                        <span class="fw-semibold">{{ $rows->lastItem() }}</span>
                        من
                        <span class="fw-semibold">{{ number_format($rows->total()) }}</span>
                        نتيجة
                    </p>
                </div>
            </div>
        @endif

    @else
        <div class="card filter-card p-5 text-center">
            <i class="la la-search" style="font-size: 64px; color: #9ca3af; margin-bottom: 1rem;"></i>
            <div class="fw-bold mb-1" style="color: #374151; font-size: 18px;">لا توجد تسليمات لعرضها</div>
            <div style="color: #6b7280;">استخدم الفلاتر أعلاه للبحث عن التسليمات ثم اضغط على <strong style="color: #6f6af8;">زر البحث</strong></div>
        </div>
    @endif
</div>

{{-- ===============================
    Modal واحد محسّن
=============================== --}}
<div class="modal fade" id="editDeliveryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4">
      <form id="editDeliveryForm">
        <div class="modal-header bg-primary text-white rounded-top-4">
          <h5 class="modal-title">تعديل التوصيل</h5>
          <button type="button"
                  class="btn-close-custom"
                  onclick="closeEditModal()"
                  aria-label="Close">
            <i class="la la-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="delivery_id" id="delivery_id">
          <input type="hidden" name="client_id" id="client_id">

          <div class="mb-3">
            <label for="bottle_received" class="form-label fw-bold">عدد العبوات المستلمة *</label>
            <input type="number" name="bottle_received" id="bottle_received" class="form-control" min="0" required>
          </div>

          <div class="mb-3">
            <label for="bottle_empty" class="form-label fw-bold">عدد العبوات الفارغة *</label>
            <input type="number" name="bottle_empty" id="bottle_empty" class="form-control" min="0" required>
          </div>

          <div class="mb-3">
            <label for="paymant" class="form-label fw-bold">الدفعة *</label>
            <input type="number" name="paymant" id="paymant" class="form-control" min="0" step="0.01" required>
          </div>

          <div class="mb-3">
            <label for="delivery_date" class="form-label fw-bold">تاريخ التسليم *</label>
            <input type="date" name="delivery_date" id="delivery_date" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="distributor_id" class="form-label fw-bold">الموزع *</label>
            <select name="distributor_id" id="distributor_id" class="form-control" required>
              <option value="">-- اختر الموزع --</option>
              @foreach($distributors ?? [] as $distributor)
                <option value="{{ $distributor->id }}">{{ $distributor->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success w-100">حفظ التعديلات</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('after_scripts')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const modalEl = document.getElementById('editDeliveryModal');
    const modal = new bootstrap.Modal(modalEl, {
        backdrop: false, // تمنع الإغلاق عند الضغط خارج المودال
        keyboard: true
    });

    document.querySelectorAll('.edit-delivery-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            // الحصول على ID من data-id أو data-delivery-id
            const id = this.getAttribute('data-id') || this.getAttribute('data-delivery-id') || this.dataset.id;
            
            if(!id){
                console.error('❌ delivery id غير موجود');
                alert('خطأ: معرف التوصيل غير موجود');
                return;
            }

            console.log('📡 جارٍ جلب بيانات التوصيل - ID:', id);

            fetch(`{{ url(config('backpack.base.route_prefix')) }}/delivery/${id}/edit`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error('فشل جلب البيانات: ' + res.status);
                }
                return res.json();
            })
            .then(data => {
                console.log('✅ تم جلب البيانات:', data);
                
                if (!data.id) {
                    alert('خطأ: البيانات غير صحيحة');
                    return;
                }

                // ملء الحقول
                document.getElementById('delivery_id').value = data.id;
                document.getElementById('client_id').value = data.client_id ?? '';
                document.getElementById('bottle_received').value = data.bottle_received ?? 0;
                document.getElementById('bottle_empty').value = data.bottle_empty ?? 0;
                document.getElementById('paymant').value = data.paymant ?? 0;
                document.getElementById('delivery_date').value = data.delivery_date ?? '';
                
                // ملء حقل الموزع
                const distributorSelect = document.getElementById('distributor_id');
                if (distributorSelect && data.distributor_id) {
                    distributorSelect.value = data.distributor_id ?? '';
                }
                
                console.log('📝 تم ملء الحقول، جارٍ فتح الـ Modal...');
                modal.show();
            })
            .catch(err => {
                console.error('❌ فشل جلب البيانات:', err);
                alert('حدث خطأ أثناء جلب البيانات: ' + err.message);
            });
        });
    });

    const form = document.getElementById('editDeliveryForm');
    if (form) {
        form.addEventListener('submit', function(e){
            e.preventDefault();
            e.stopPropagation();

            const formData = new FormData(this);
            const deliveryId = formData.get('delivery_id');
            const clientId = formData.get('client_id');
            const deliveryDate = formData.get('delivery_date');
            const bottleReceived = formData.get('bottle_received');
            const bottleEmpty = formData.get('bottle_empty');
            const paymant = formData.get('paymant');
            const distributorId = formData.get('distributor_id');

            // التحقق من البيانات
            const errors = [];
            if (!deliveryId) errors.push('معرف التوصيل غير موجود');
            if (!clientId) errors.push('يجب اختيار المشترك');
            if (!deliveryDate) errors.push('تاريخ التسليم مطلوب');
            if (!bottleReceived || bottleReceived < 0) errors.push('عدد العبوات المستلمة مطلوب');
            if (!bottleEmpty || bottleEmpty < 0) errors.push('عدد العبوات الفارغة مطلوب');
            if (!paymant || paymant < 0) errors.push('الدفعة مطلوبة');
            if (!distributorId) errors.push('يجب اختيار الموزع');

            if (errors.length > 0) {
                alert('التحقق من البيانات فشل:\n' + errors.join('\n'));
                return;
            }

            console.log('💾 جارٍ حفظ التعديلات - Delivery ID:', deliveryId);

            formData.append('_method', 'PUT');

            fetch(`{{ url(config('backpack.base.route_prefix')) }}/delivery/${deliveryId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => {
                if (!res.ok) {
                    return res.json().then(data => {
                        throw new Error(data.message || 'حدث خطأ أثناء حفظ التعديلات');
                    });
                }
                return res.json();
            })
            .then(data => {
                console.log('📥 استجابة السيرفر:', data);
                if(data.status){
                    if (modal) {
                        modal.hide();
                    }
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    alert(data.message || 'حدث خطأ');
                }
            })
            .catch(err => {
                console.error('❌ خطأ في الحفظ:', err);
                alert('حدث خطأ أثناء حفظ التعديلات: ' + err.message);
            });
        });
    }

    // دالة لإغلاق الـ modal
    function closeEditModal() {
        if (modal) {
            modal.hide();
        }
    }

    // إضافة event listener لزر الإغلاق
    const closeBtn = document.querySelector('#editDeliveryModal .btn-close-custom');
    if (closeBtn) {
        closeBtn.addEventListener('click', closeEditModal);
    }

});
</script>

@endsection

@section('after_styles')
    {{-- Unified Forms Design System - الهوية البصرية الموحدة --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    
    <style>
/* ===============================
   Layout
=============================== */
.container-fluid { 
    max-width: 1200px; 
}

/* ===============================
   Override unified-forms.css for this page only
   إزالة التعارضات مع unified-forms.css
=============================== */
.filter-card .card-body .form-label {
    font-size: 13px !important;
    font-weight: 600 !important;
    color: #55607b !important;
    margin-bottom: 8px !important;
    display: block !important;
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
}

.filter-card .card-body .form-control,
.filter-card .card-body .form-select,
.filter-card .card-body .modern-input,
.filter-card .card-body .modern-select {
    width: 100% !important;
    height: 46px !important;
    border-radius: 20px !important;
    font-size: 13px !important;
    background: #f7f9ff !important;
    border: 1px solid #e2e8ff !important;
    padding: 0 18px !important;
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
    transition: all 0.2s ease !important;
    color: #1f2937 !important;
}

.filter-card .card-body .form-control:focus,
.filter-card .card-body .form-select:focus,
.filter-card .card-body .modern-input:focus,
.filter-card .card-body .modern-select:focus {
    background: #fff !important;
    border-color: #7b7bff !important;
    box-shadow: 0 0 0 3px rgba(123, 123, 255, 0.15) !important;
    outline: none !important;
}

.filter-card .card-body .btn-show-results {
    height: 46px !important;
    border-radius: 23px !important;
    background: linear-gradient(135deg, #6f6af8, #7c7cff) !important;
    color: #fff !important;
    border: none !important;
    font-weight: 700 !important;
    font-size: 14px !important;
    box-shadow: 0 14px 30px rgba(124, 124, 255, 0.4) !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    transition: all 0.2s ease !important;
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
    padding: 0 24px !important;
}

.filter-card .card-body .btn-show-results:hover {
    color: #fff !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 20px 40px rgba(124, 124, 255, 0.5) !important;
}

/* ===============================
   Results Header Modern
=============================== */
.results-header-modern {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
    border-radius: 16px !important;
    padding: 24px 32px !important;
    box-shadow: 0 8px 24px rgba(239, 68, 68, 0.3) !important;
    margin-bottom: 24px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

.results-header-modern .results-header-item.results-count-item {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 100% !important;
}

.results-header-modern .results-count-wrapper {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 16px !important;
}

.results-header-modern .results-label,
.results-header-modern .results-count-wrapper .results-label,
.results-header-modern span.results-label {
    color: #ffffff !important;
    font-size: 56px !important;
    font-weight: 800 !important;
    font-family: 'Cairo', sans-serif !important;
}

.results-header-modern .results-value,
.results-header-modern .results-count-wrapper .results-value,
.results-header-modern .results-count-wrapper strong.results-value,
.results-header-modern strong.results-value {
    color: #ffffff !important;
    font-size: 56px !important;
    font-weight: 800 !important;
    font-family: 'Cairo', sans-serif !important;
}

/* Force white color for all text inside results-header-modern */
.results-header-modern * {
    color: #ffffff !important;
}

.results-header-modern span,
.results-header-modern strong {
    color: #ffffff !important;
}

/* ===============================
   Table Styles
=============================== */
.table-clean {
    border-collapse: separate;
    border-spacing: 0 8px;
    margin-bottom: 0;
    width: 100%;
}

.table-clean thead th {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9) !important;
    border: none !important;
    font-weight: 700;
    color: #374151;
    padding: 12px;
    text-align: right;
}

.table-clean tbody tr {
    background: #fcfdff;
    box-shadow: 0 4px 12px rgba(0,0,0,.06);
    border-radius: 12px;
    margin-bottom: 8px;
}

.table-clean tbody td {
    border: none;
    padding: 12px;
    vertical-align: middle;
}

.table-clean tbody tr:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0,0,0,.1);
    transition: all 0.2s ease;
}

.table-responsive {
    border-radius: 12px;
    overflow: visible !important;
}

/* ===============================
   Pagination
=============================== */
.pagination-wrapper {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-top: 24px;
    padding-top: 24px;
    border-top: 2px solid #e5e7eb;
    gap: 12px;
}

.pagination-info-arabic {
    text-align: center;
    margin-top: 8px;
}

.pagination-info-arabic p {
    margin: 0;
    font-family: 'Cairo', sans-serif;
    color: #6b7280;
    font-size: 14px;
}

.pagination-info-arabic .fw-semibold {
    font-weight: 600;
    color: #6f6af8;
}

.pagination {
    direction: rtl !important;
    justify-content: center !important;
    margin: 0 !important;
    padding: 0 !important;
    gap: 8px;
}

.pagination .page-item {
    margin: 0 !important;
}

.pagination .page-link {
    border-radius: 10px !important;
    margin: 0 4px !important;
    color: #6f6af8 !important;
    border-color: #e5e7eb !important;
    padding: 10px 16px !important;
    font-weight: 600 !important;
    font-size: 14px !important;
    font-family: 'Cairo', sans-serif !important;
    transition: all 0.3s ease !important;
    background: #ffffff !important;
}

.pagination .page-link:hover {
    background: #6f6af8 !important;
    color: #fff !important;
    border-color: #6f6af8 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(111, 106, 248, 0.3) !important;
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #6f6af8, #7c7cff) !important;
    border-color: #6f6af8 !important;
    color: #fff !important;
    box-shadow: 0 4px 12px rgba(111, 106, 248, 0.3) !important;
}

.pagination .page-item.disabled .page-link {
    color: #9ca3af !important;
    border-color: #e5e7eb !important;
    background: #f3f4f6 !important;
    cursor: not-allowed !important;
}

/* Hide "Showing X to Y" text */
nav[aria-label="Pagination Navigation"] .d-none,
nav[aria-label="Pagination Navigation"] .flex-sm-fill,
nav[aria-label="Pagination Navigation"] .d-none.flex-sm-fill,
nav[aria-label="Pagination Navigation"] .d-none.flex-sm-fill.d-sm-flex,
nav[aria-label="Pagination Navigation"] p.small.text-muted,
nav[aria-label="Pagination Navigation"] p,
nav[aria-label="Pagination Navigation"] .d-flex.justify-content-between > div:first-child,
nav[aria-label="Pagination Navigation"] > div.d-none,
nav.d-flex.justify-items-center.justify-content-between > div.d-none.flex-sm-fill.d-sm-flex.align-items-sm-center.justify-content-sm-between > div:first-child {
    display: none !important;
    visibility: hidden !important;
    opacity: 0 !important;
    height: 0 !important;
    width: 0 !important;
    margin: 0 !important;
    padding: 0 !important;
}

/* ===============================
   Balance Badges
=============================== */
.badge-balance-positive {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 12px;
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    color: #fff;
    box-shadow: 0 2px 8px rgba(139, 92, 246, 0.25);
}

.badge-balance-negative {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 12px;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #fff;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.25);
}

.badge-balance-zero {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 12px;
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: #fff;
    box-shadow: 0 2px 8px rgba(107, 114, 128, 0.25);
}

.badge-success-custom {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 12px;
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: #fff;
    box-shadow: 0 2px 8px rgba(34, 197, 94, 0.25);
}

.badge-warning-custom {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 12px;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: #fff;
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.25);
}

.badge-soft-purple {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 12px;
    background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%);
    color: #fff;
    box-shadow: 0 2px 8px rgba(111, 106, 248, 0.25);
}

/* ===============================
   Modal Styles
=============================== */

/* ===== Modal Container ===== */
#editDeliveryModal .modal-content {
    border: none;
    border-radius: 22px;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25);
    overflow: hidden;
}

/* ===== خلفية داكنة ناعمة ===== */
.modal-backdrop.show {
    background-color: rgba(0, 0, 0, 0.55);
}
#editDeliveryModal .modal-header {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    border-bottom: none;
    padding: 16px 22px;
}

#editDeliveryModal .modal-title {
    font-weight: 800;
    font-size: 16px;
    letter-spacing: 0.3px;
}
.btn-close-custom {
    background: rgba(255, 255, 255, 0.18);
    border: none;
    color: #fff;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all .2s ease;
}

.btn-close-custom i {
    font-size: 18px;
}

.btn-close-custom:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: rotate(90deg);
}
#editDeliveryModal .modal-body {
    padding: 24px;
}

#editDeliveryModal .form-label {
    font-size: 13px;
    font-weight: 700;
    color: #374151;
}

#editDeliveryModal .form-control {
    height: 46px;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    font-size: 14px;
}

#editDeliveryModal .form-control:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.18);
}
.modal.fade .modal-dialog {
    transform: scale(0.95);
    transition: transform .25s ease-out;
}

.modal.show .modal-dialog {
    transform: scale(1);
}
#editDeliveryModal .modal-footer {
    border-top: none;
    padding: 20px;
}

#editDeliveryModal .modal-footer .btn {
    height: 46px;
    border-radius: 14px;
    font-weight: 700;
    letter-spacing: 0.3px;
}
/* ===== Backdrop احترافي يغطي الشاشة بالكامل ===== */
.modal-backdrop {
    background: radial-gradient(
        circle at center,
        rgba(0, 0, 0, 0.85) 0%,
        rgba(0, 0, 0, 0.75) 40%,
        rgba(0, 0, 0, 0.65) 70%,
        rgba(0, 0, 0, 0.6) 100%
    );
}

/* عند الظهور */
.modal-backdrop.show {
    opacity: 1;
}
#editDeliveryModal .modal-content {
    box-shadow:
        0 30px 80px rgba(0, 0, 0, 0.45),
        0 0 0 1px rgba(255, 255, 255, 0.06);
}
const modal = new bootstrap.Modal(modalElement, {
    backdrop: true, // ❗ لا تستخدم false
    keyboard: true
});
.modal {
    z-index: 1055;
}

.modal-backdrop {
    z-index: 1050;
}
.modal-backdrop.show {
    backdrop-filter: blur(3px);
}




</style>
@endsection
