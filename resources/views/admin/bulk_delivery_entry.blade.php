@extends(backpack_view('blank'))

@section('after_styles')
    {{-- Unified Forms Design System --}}
    <link rel="stylesheet" href="{{ asset('css/unified-forms.css') }}">
    <style>
        .bulk-entry-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            font-size: 14px;
        }
        .bulk-entry-table th {
            background: var(--primary-deep) !important;
            color: white;
            padding: 12px 8px;
            text-align: center;
            font-weight: 700;
            border: 1px solid rgba(255,255,255,0.1);
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .bulk-entry-table td {
            padding: 12px 8px;
            border: 1px solid #f1f5f9;
            text-align: center;
            vertical-align: middle;
        }
        .bulk-entry-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .bulk-entry-table tr:hover {
            background-color: #f1f5f9;
        }
        .editable-cell {
            background: #fffbeb !important;
            cursor: pointer;
            min-width: 80px;
            transition: all 0.2s ease;
        }
        .editable-cell:hover {
            background: #fef3c7 !important;
        }
        .editable-cell.editing {
            background: white !important;
            border: 2px solid var(--primary-deep) !important;
        }
        .editable-cell input {
            width: 100%;
            border: none;
            padding: 4px;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            background: transparent;
        }
        .readonly-cell {
            background: #f8fafc;
            font-weight: 600;
            color: var(--primary-deep);
        }
        .debt-cell {
            font-weight: 700;
        }
        .debt-cell.positive {
            color: var(--danger-color);
        }
        .debt-cell.negative {
            color: var(--success-gradient);
        }
        .inventory-display {
            background: var(--success-gradient);
            color: white;
            padding: 15px 25px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 25px;
            text-align: center;
            box-shadow: var(--shadow-sm);
        }
        .save-row-btn {
            padding: 6px 16px;
            font-size: 13px;
            font-weight: 700;
            border-radius: 8px !important;
        }
        .table-wrapper {
            max-height: 70vh;
            overflow-y: auto;
            overflow-x: auto;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            width: 100%;
            box-sizing: border-box;
        }
        
        .bulk-entry-table {
            width: 100%;
            table-layout: auto;
            min-width: 800px;
        }
        
        /* Responsive Design - Mobile First */
        @media (max-width: 768px) {
            .table-wrapper {
                max-height: none !important;
                overflow-x: visible !important;
                overflow-y: visible !important;
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            
            .bulk-entry-table {
                display: block !important;
                width: 100% !important;
                min-width: 100% !important;
                max-width: 100% !important;
                table-layout: fixed !important;
            }
            
            /* Override min-width for mobile */
            @media (max-width: 768px) {
                .bulk-entry-table {
                    min-width: 100% !important;
                }
            }
            
            .bulk-entry-table thead {
                display: none !important;
            }
            
            .bulk-entry-table tbody {
                display: block !important;
                width: 100% !important;
            }
            
            .bulk-entry-table tr {
                display: block !important;
                margin-bottom: 20px !important;
                background: white !important;
                border: 1px solid #e2e8f0 !important;
                border-radius: 12px !important;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
                padding: 15px !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }
            
            .bulk-entry-table td {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                padding: 12px 0 !important;
                border: none !important;
                border-bottom: 1px solid #f1f5f9 !important;
                text-align: right !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }
            
            .bulk-entry-table td:last-child {
                border-bottom: none !important;
            }
            
            .bulk-entry-table td::before {
                content: attr(data-label) !important;
                font-weight: 700 !important;
                color: var(--primary-deep) !important;
                margin-left: 15px !important;
                flex-shrink: 0 !important;
                min-width: 120px !important;
            }
            
            .bulk-entry-table td[data-label=""]::before {
                display: none !important;
            }
            
            .bulk-entry-table td:has(.save-row-btn) {
                justify-content: center !important;
                padding-top: 15px !important;
            }
            
            .bulk-entry-table td:has(.save-row-btn)::before {
                display: none !important;
            }
            
            .readonly-cell {
                flex-direction: column !important;
                align-items: flex-start !important;
            }
            
            .readonly-cell .fw-bold {
                font-size: 16px !important;
                margin-bottom: 5px !important;
            }
            
            .readonly-cell small {
                font-size: 12px !important;
            }
            
            .editable-cell {
                min-width: auto !important;
            }
            
            .save-row-btn {
                width: 100% !important;
                padding: 12px !important;
                font-size: 14px !important;
            }
            
            .inventory-display {
                font-size: 16px !important;
                padding: 12px 20px !important;
                margin-bottom: 20px !important;
            }
            
            .mb-4.d-flex {
                flex-direction: column !important;
                gap: 15px !important;
                align-items: stretch !important;
            }
            
            #save-all-btn {
                width: 100% !important;
                padding: 15px !important;
            }
            
            .container-fluid.pb-4 {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }
        }
        
        /* Tablet - Medium Screens */
        @media (min-width: 769px) and (max-width: 1024px) {
            .table-wrapper {
                max-height: 60vh;
            }
            
            .bulk-entry-table th,
            .bulk-entry-table td {
                padding: 10px 6px;
                font-size: 13px;
            }
            
            .bulk-entry-table th {
                min-width: auto;
            }
        }
        
        /* Ensure container doesn't overflow */
        @media (max-width: 768px) {
            .container-fluid.pb-4 {
                padding-left: 10px !important;
                padding-right: 10px !important;
                max-width: 100% !important;
                overflow-x: hidden !important;
            }
            
            .table-responsive {
                width: 100% !important;
                overflow-x: visible !important;
                overflow-y: visible !important;
            }
        }
        
    </style>
@endsection

@section('content')
<div class="container-fluid pb-4">
    {{-- Header --}}
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header" style="background: var(--primary-deep) !important; border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 2rem; box-shadow: var(--shadow-md) !important; width: 100%; display: flex; align-items: center; justify-content: space-between; position: relative; overflow: visible;">
        <div style="display: flex; align-items: center; gap: 1rem; position: relative; z-index: 1;">
            <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.1); border-radius: 16px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center;">
                <i class="la la-table" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
            </div>
            <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 800; margin: 0; font-family: 'Cairo', sans-serif;">إدخال جماعي للتسليمات</h1>
        </div>
        <div style="display: flex; align-items: center; gap: 0.75rem; position: relative; z-index: 10;">
            <a href="{{ route('delivery.list', request()->query()) }}" class="btn btn-light" style="color: var(--primary-deep); font-weight: 700; border-radius: 12px;">
                <i class="la la-angle-double-right"></i> العودة للقائمة
            </a>
        </div>
    </section>

    {{-- عرض المخزون الحالي --}}
    <div class="inventory-display">
        <i class="la la-warehouse"></i> المخزون الحالي: <span id="current-inventory">{{ $currentInventory }}</span> عبوة
    </div>

    {{-- تاريخ التسليم + أزرار الحفظ --}}
    @if(count($allClients) > 0)
    <div class="mb-4 d-flex flex-wrap align-items-center gap-3 px-2">
        <div class="d-flex align-items-center gap-2">
            <label for="delivery-date-input" class="form-label mb-0 fw-bold" style="color: var(--primary-deep);">
                <i class="la la-calendar"></i> تاريخ التسليم:
            </label>
            <input type="date" id="delivery-date-input" class="form-control" style="width: auto; min-width: 160px; border-radius: 12px; border: 2px solid #e2e8f0; padding: 0.5rem 1rem; font-weight: 600;" value="{{ date('Y-m-d') }}" required>
        </div>
        <div style="font-size: 16px; color: var(--primary-deep); font-weight: 700;">
            <i class="la la-users"></i> عدد المشتركين: <strong>{{ count($allClients) }}</strong>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-success" id="save-all-btn" style="padding: 12px 25px; border-radius: 12px !important;">
                <i class="la la-save"></i> حفظ جميع التغييرات
            </button>
        </div>
    </div>
    @endif

    {{-- الجدول --}}
    @if(count($allClients) > 0)
    <div class="table-wrapper">
        <div class="table-responsive" style="width: 100%;">
        <table class="bulk-entry-table" id="bulk-entry-table">
            <thead>
                <tr>
                    <th style="min-width: 200px;">اسم المشترك</th>
                    <th style="min-width: 100px;">العبوات المستلمة</th>
                    <th style="min-width: 100px;">العبوات الفارغة</th>
                    <th style="min-width: 120px;">المبلغ المطلوب</th>
                    <th style="min-width: 120px;">المبلغ المدفوع</th>
                    <th style="min-width: 120px;">الدين المتبقي</th>
                    <th style="min-width: 100px;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allClients as $client)
                <tr data-client-id="{{ $client->client_id }}">
                    <td class="readonly-cell text-right ps-4" data-label="اسم المشترك">
                        <div class="fw-bold">{{ $client->client_name ?? $client->name ?? '-' }}</div>
                        <small class="text-muted">{{ $client->phone_one ?? '-' }}</small>
                    </td>
                    <td class="editable-cell" data-field="bottle_received" data-type="number" data-label="العبوات المستلمة">
                        <span class="display-value">0</span>
                        <input type="number" class="edit-input" value="0" min="0" style="display: none;">
                    </td>
                    <td class="editable-cell" data-field="bottle_empty" data-type="number" data-label="العبوات الفارغة">
                        <span class="display-value">0</span>
                        <input type="number" class="edit-input" value="0" min="0" style="display: none;">
                    </td>
                    <td class="editable-cell" data-field="required_amount" data-type="decimal" data-label="المبلغ المطلوب">
                        <span class="display-value">0.00</span>
                        <input type="number" class="edit-input" value="0.00" min="0" step="0.01" style="display: none;">
                    </td>
                    <td class="editable-cell" data-field="paymant" data-type="decimal" data-label="المبلغ المدفوع">
                        <span class="display-value">0.00</span>
                        <input type="number" class="edit-input" value="0.00" min="0" step="0.01" style="display: none;">
                    </td>
                    <td class="readonly-cell debt-cell" data-field="remaining_debt" data-label="الدين المتبقي">
                        <span class="debt-value">0.00</span>
                    </td>
                    <td data-label="">
                        <button type="button" class="btn btn-sm btn-primary save-row-btn" data-client-id="{{ $client->client_id }}">
                            <i class="la la-save"></i> حفظ
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
    @else
    <div class="card p-5 text-center" style="border-radius: 20px;">
        <i class="la la-info-circle" style="font-size: 48px; color: var(--primary-deep); margin-bottom: 15px;"></i>
        <h5 class="fw-bold">لا يوجد مشتركين للعرض</h5>
        <p class="text-muted">استخدم الفلاتر في صفحة القائمة للبحث.</p>
    </div>
    @endif
</div>
@endsection

@section('after_scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('bulk-entry-table');
    const deliveryDateInput = document.getElementById('delivery-date-input');
    let currentEditingCell = null;

    function getDeliveryDate() {
        if (deliveryDateInput && deliveryDateInput.value) return deliveryDateInput.value.trim();
        return new Date().toISOString().split('T')[0];
    }

    if (table) {
        table.addEventListener('click', function(e) {
            const cell = e.target.closest('.editable-cell');
            if (!cell || cell.classList.contains('editing')) return;
            if (currentEditingCell && currentEditingCell !== cell) finishEditing(currentEditingCell);
            startEditing(cell);
        });

        table.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && currentEditingCell) {
                e.preventDefault();
                const cellToFinish = currentEditingCell;
                finishEditing(cellToFinish);
                moveToNextCell(cellToFinish);
            }
            if (e.key === 'Escape' && currentEditingCell) {
                e.preventDefault();
                cancelEditing(currentEditingCell);
            }
        });
    }

    function startEditing(cell) {
        const span = cell.querySelector('.display-value');
        const input = cell.querySelector('.edit-input');
        if (!span || !input) return;
        currentEditingCell = cell;
        cell.classList.add('editing');
        span.style.display = 'none';
        input.style.display = 'block';
        input.value = span.textContent.trim();
        input.focus();
        input.select();
    }

    function finishEditing(cell) {
        const span = cell.querySelector('.display-value');
        const input = cell.querySelector('.edit-input');
        if (!span || !input) return;
        let value = input.value.trim();
        const type = cell.dataset.type;
        if (type === 'number') value = Math.max(0, parseInt(value) || 0);
        else if (type === 'decimal') value = Math.max(0, parseFloat(value) || 0).toFixed(2);
        span.textContent = value;
        cell.classList.remove('editing');
        span.style.display = 'inline';
        input.style.display = 'none';
        updateRemainingDebt(cell.closest('tr'));
        currentEditingCell = null;
    }

    function cancelEditing(cell) {
        const span = cell.querySelector('.display-value');
        const input = cell.querySelector('.edit-input');
        if (!span || !input) return;
        cell.classList.remove('editing');
        span.style.display = 'inline';
        input.style.display = 'none';
        currentEditingCell = null;
    }

    function moveToNextCell(currentCell) {
        const row = currentCell.closest('tr');
        const cells = Array.from(row.querySelectorAll('.editable-cell'));
        const currentIndex = cells.indexOf(currentCell);
        if (currentIndex < cells.length - 1) {
            startEditing(cells[currentIndex + 1]);
        } else {
            const saveBtn = row.querySelector('.save-row-btn');
            if (saveBtn) saveBtn.focus();
        }
    }

    table.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.target.classList.contains('save-row-btn')) {
            e.preventDefault();
            e.target.click();
        }
    });

    function updateRemainingDebt(row) {
        const requiredAmountCell = row.querySelector('[data-field="required_amount"]');
        const paymantCell = row.querySelector('[data-field="paymant"]');
        const debtCell = row.querySelector('[data-field="remaining_debt"]');
        if (!requiredAmountCell || !paymantCell || !debtCell) return;
        const requiredAmount = parseFloat(requiredAmountCell.querySelector('.display-value').textContent) || 0;
        const paymant = parseFloat(paymantCell.querySelector('.display-value').textContent) || 0;
        const remaining = requiredAmount - paymant;
        const debtValue = debtCell.querySelector('.debt-value');
        if (debtValue) {
            debtValue.textContent = Math.abs(remaining).toFixed(2);
            debtCell.classList.remove('positive', 'negative');
            if (remaining > 0) debtCell.classList.add('positive');
            else if (remaining < 0) debtCell.classList.add('negative');
        }
    }

    document.querySelectorAll('.save-row-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const clientId = this.dataset.clientId;
            const row = this.closest('tr');
            if (currentEditingCell) finishEditing(currentEditingCell);
            const deliveryDate = getDeliveryDate();
            if (!deliveryDate) {
                alert('يرجى اختيار تاريخ التسليم من التقويم.');
                return;
            }
            const data = {
                client_id: clientId,
                delivery_date: deliveryDate,
                bottle_received: parseInt(row.querySelector('[data-field="bottle_received"] .display-value').textContent) || 0,
                bottle_empty: parseInt(row.querySelector('[data-field="bottle_empty"] .display-value').textContent) || 0,
                required_amount: parseFloat(row.querySelector('[data-field="required_amount"] .display-value').textContent) || 0,
                paymant: parseFloat(row.querySelector('[data-field="paymant"] .display-value').textContent) || 0,
            };
            saveSingleDelivery(data, this);
        });
    });

    function saveSingleDelivery(data, button) {
        button.disabled = true;
        button.innerHTML = '<i class="la la-spinner la-spin"></i>';
        fetch('{{ route("delivery.bulk-store-single") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                if (result.inventory !== undefined) document.getElementById('current-inventory').textContent = result.inventory;
                const row = button.closest('tr');
                const nextRow = row.nextElementSibling;
                row.style.transition = 'all 0.4s ease';
                row.style.opacity = '0';
                row.style.transform = 'translateX(50px)';
                row.style.backgroundColor = '#d4edda';
                setTimeout(() => {
                    row.remove();
                    if (nextRow) {
                        const firstCell = nextRow.querySelector('.editable-cell');
                        if (firstCell) startEditing(firstCell);
                    }
                    const countStrong = document.querySelector('strong:contains("عدد المشتركين")') || document.querySelector('.mb-4 strong');
                    if (countStrong) countStrong.textContent = document.querySelectorAll('#bulk-entry-table tbody tr').length;
                    if (document.querySelectorAll('#bulk-entry-table tbody tr').length === 0) window.location.reload();
                }, 400);
                if (typeof Noty !== 'undefined') {
                    new Noty({ type: "success", text: "تم الحفظ بنجاح", timeout: 2000 }).show();
                }
            } else {
                alert('خطأ: ' + (result.message || 'فشل الحفظ'));
                button.disabled = false;
                button.innerHTML = '<i class="la la-save"></i> حفظ';
            }
        })
        .catch(error => {
            alert('حدث خطأ أثناء الحفظ');
            button.disabled = false;
            button.innerHTML = '<i class="la la-save"></i> حفظ';
        });
    }
});
</script>
@endsection
