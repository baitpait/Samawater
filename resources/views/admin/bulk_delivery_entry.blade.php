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
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%);
            color: white;
            padding: 12px 8px;
            text-align: center;
            font-weight: 600;
            border: 1px solid #ddd;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .bulk-entry-table td {
            padding: 8px;
            border: 1px solid #e0e0e0;
            text-align: center;
        }
        .bulk-entry-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .bulk-entry-table tr:hover {
            background-color: #f0f0f0;
        }
        .editable-cell {
            background: #fff3cd !important;
            cursor: pointer;
            min-width: 80px;
        }
        .editable-cell:hover {
            background: #ffeaa7 !important;
        }
        .editable-cell.editing {
            background: white !important;
            border: 2px solid #6f6af8 !important;
        }
        .editable-cell input {
            width: 100%;
            border: none;
            padding: 4px;
            text-align: center;
            font-size: 14px;
        }
        .readonly-cell {
            background: #f8f9fa;
            font-weight: 500;
        }
        .debt-cell {
            font-weight: 600;
        }
        .debt-cell.positive {
            color: #dc3545;
        }
        .debt-cell.negative {
            color: #28a745;
        }
        .inventory-display {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 20px;
            text-align: center;
        }
        .save-row-btn {
            padding: 4px 12px;
            font-size: 12px;
        }
        .table-wrapper {
            max-height: 78vh;
            overflow-y: auto;
            overflow-x: auto;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        .filter-card {
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid pb-4">
    {{-- Header --}}
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-center d-print-none" bp-section="page-header">
        <div class="header-content-wrapper" style="display: flex; align-items: center; gap: 1rem; width: 100%; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div class="icon-box" style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.2); border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);">
                    <i class="la la-table" style="font-size: 28px; color: #fff; font-weight: 900;"></i>
                </div>
                <h1 class="text-capitalize mb-0" bp-section="page-heading" style="color: #fff; font-size: 24px; font-weight: 700; margin: 0; font-family: 'Cairo', sans-serif;">إدخال جماعي للتسليمات</h1>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <a href="{{ route('delivery.list', request()->query()) }}" class="btn btn-light" style="color: #6f6af8; font-weight: 600;">
                    <i class="la la-angle-double-right"></i> العودة إلى قائمة التسليم
                </a>
            </div>
        </div>
    </section>

    <style>
        section.header-operation {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%) !important;
            border-radius: 20px !important;
            padding: 1.5rem 2rem !important;
            margin-bottom: 2rem !important;
            box-shadow: 0 10px 30px rgba(111, 106, 248, 0.3) !important;
        }
    </style>

    {{-- عرض المخزون الحالي --}}
    <div class="inventory-display">
        <i class="la la-warehouse"></i> المخزون الحالي: <span id="current-inventory">{{ $currentInventory }}</span> عبوة
    </div>

    {{-- تم نقل الفلاتر إلى صفحة قائمة التسليم --}}

    {{-- أزرار الحفظ --}}
    @if(count($allClients) > 0)
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <div>
            <strong>عدد المشتركين: {{ count($allClients) }}</strong>
        </div>
        <div>
            <button type="button" class="btn btn-success" id="save-all-btn">
                <i class="la la-save"></i> حفظ جميع التغييرات
            </button>
        </div>
    </div>
    @endif

    {{-- الجدول --}}
    @if(count($allClients) > 0)
    <div class="table-wrapper">
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
                    <td class="readonly-cell">
                        <strong>{{ $client->client_name ?? $client->name ?? '-' }}</strong><br>
                        <small style="color: #6b7280;">{{ $client->phone_one ?? '-' }}</small>
                    </td>
                    <td class="editable-cell" data-field="bottle_received" data-type="number">
                        <span class="display-value">0</span>
                        <input type="number" class="edit-input" value="0" min="0" style="display: none;">
                    </td>
                    <td class="editable-cell" data-field="bottle_empty" data-type="number">
                        <span class="display-value">0</span>
                        <input type="number" class="edit-input" value="0" min="0" style="display: none;">
                    </td>
                    <td class="editable-cell" data-field="required_amount" data-type="decimal">
                        <span class="display-value">0.00</span>
                        <input type="number" class="edit-input" value="0.00" min="0" step="0.01" style="display: none;">
                    </td>
                    <td class="editable-cell" data-field="paymant" data-type="decimal">
                        <span class="display-value">0.00</span>
                        <input type="number" class="edit-input" value="0.00" min="0" step="0.01" style="display: none;">
                    </td>
                    <td class="readonly-cell debt-cell" data-field="remaining_debt">
                        <span class="debt-value">0.00</span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary save-row-btn" data-client-id="{{ $client->client_id }}">
                            <i class="la la-save"></i> حفظ
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info text-center">
        <i class="la la-info-circle"></i> لا توجد مشتركين للعرض. استخدم الفلاتر للبحث.
    </div>
    @endif
</div>
@endsection

@section('after_scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('bulk-entry-table');
    const today = new Date().toISOString().split('T')[0];
    let currentEditingCell = null;

    // تفعيل التحرير عند النقر على خلية قابلة للتعديل
    if (table) {
        table.addEventListener('click', function(e) {
            const cell = e.target.closest('.editable-cell');
            if (!cell || cell.classList.contains('editing')) return;

            // إغلاق أي خلية أخرى مفتوحة
            if (currentEditingCell && currentEditingCell !== cell) {
                finishEditing(currentEditingCell);
            }

            startEditing(cell);
        });

        // حفظ عند الضغط على Enter
        table.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && currentEditingCell) {
                e.preventDefault();
                finishEditing(currentEditingCell);
                // الانتقال للخلية التالية
                moveToNextCell(currentEditingCell);
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
        const field = cell.dataset.field;
        const type = cell.dataset.type;

        // التحقق من القيمة
        if (type === 'number') {
            value = Math.max(0, parseInt(value) || 0);
        } else if (type === 'decimal') {
            value = Math.max(0, parseFloat(value) || 0).toFixed(2);
        }

        span.textContent = value;
        cell.classList.remove('editing');
        span.style.display = 'inline';
        input.style.display = 'none';

        // تحديث الدين المتبقي
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
        input.value = span.textContent.trim();

        currentEditingCell = null;
    }

    function moveToNextCell(currentCell) {
        const row = currentCell.closest('tr');
        const cells = Array.from(row.querySelectorAll('.editable-cell'));
        const currentIndex = cells.indexOf(currentCell);
        
        if (currentIndex < cells.length - 1) {
            startEditing(cells[currentIndex + 1]);
        }
    }

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
            
            if (remaining > 0) {
                debtCell.classList.add('positive');
            } else if (remaining < 0) {
                debtCell.classList.add('negative');
            }
        }
    }

    // تحديث الدين المتبقي لجميع الصفوف عند التحميل
    document.querySelectorAll('#bulk-entry-table tbody tr').forEach(row => {
        updateRemainingDebt(row);
    });

    // حفظ صف واحد
    document.querySelectorAll('.save-row-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const clientId = this.dataset.clientId;
            const row = this.closest('tr');
            
            if (currentEditingCell) {
                finishEditing(currentEditingCell);
            }

            const data = {
                client_id: clientId,
                delivery_date: today,
                bottle_received: parseInt(row.querySelector('[data-field="bottle_received"] .display-value').textContent) || 0,
                bottle_empty: parseInt(row.querySelector('[data-field="bottle_empty"] .display-value').textContent) || 0,
                required_amount: parseFloat(row.querySelector('[data-field="required_amount"] .display-value').textContent) || 0,
                paymant: parseFloat(row.querySelector('[data-field="paymant"] .display-value').textContent) || 0,
            };

            saveSingleDelivery(data, this);
        });
    });

    // حفظ جميع الصفوف
    document.getElementById('save-all-btn')?.addEventListener('click', function() {
        if (currentEditingCell) {
            finishEditing(currentEditingCell);
        }

        const deliveries = [];
        document.querySelectorAll('#bulk-entry-table tbody tr').forEach(row => {
            const clientId = row.dataset.clientId;
            if (!clientId) return;

            const bottleReceived = parseInt(row.querySelector('[data-field="bottle_received"] .display-value').textContent) || 0;
            const bottleEmpty = parseInt(row.querySelector('[data-field="bottle_empty"] .display-value').textContent) || 0;
            const requiredAmount = parseFloat(row.querySelector('[data-field="required_amount"] .display-value').textContent) || 0;
            const paymant = parseFloat(row.querySelector('[data-field="paymant"] .display-value').textContent) || 0;

            // حفظ فقط الصفوف التي تحتوي على بيانات
            if (bottleReceived > 0 || bottleEmpty > 0 || requiredAmount > 0 || paymant > 0) {
                deliveries.push({
                    client_id: clientId,
                    delivery_date: today,
                    bottle_received: bottleReceived,
                    bottle_empty: bottleEmpty,
                    required_amount: requiredAmount,
                    paymant: paymant,
                });
            }
        });

        if (deliveries.length === 0) {
            alert('لا توجد بيانات للحفظ. يرجى إدخال بيانات في الصفوف.');
            return;
        }

        saveBulkDeliveries(deliveries, this);
    });

    function saveSingleDelivery(data, button) {
        button.disabled = true;
        button.innerHTML = '<i class="la la-spinner la-spin"></i> جاري الحفظ...';

        fetch('{{ route("delivery.bulk-store-single") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert('تم حفظ التسليم بنجاح');
                // تحديث المخزون
                if (result.inventory !== undefined) {
                    document.getElementById('current-inventory').textContent = result.inventory;
                }
                // إعادة تعيين القيم
                const row = button.closest('tr');
                row.querySelectorAll('.editable-cell').forEach(cell => {
                    const span = cell.querySelector('.display-value');
                    if (span) span.textContent = cell.dataset.type === 'decimal' ? '0.00' : '0';
                });
                updateRemainingDebt(row);
            } else {
                alert('خطأ: ' + (result.message || 'فشل الحفظ'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء الحفظ');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = '<i class="la la-save"></i> حفظ';
        });
    }

    function saveBulkDeliveries(deliveries, button) {
        button.disabled = true;
        button.innerHTML = '<i class="la la-spinner la-spin"></i> جاري الحفظ...';

        fetch('{{ route("delivery.bulk-store-bulk") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ deliveries: deliveries })
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert(result.message);
                // تحديث المخزون
                if (result.inventory !== undefined) {
                    document.getElementById('current-inventory').textContent = result.inventory;
                }
                // إعادة تحميل الصفحة بعد ثانية واحدة
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                alert('خطأ: ' + (result.message || 'فشل الحفظ'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء الحفظ');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = '<i class="la la-save"></i> حفظ جميع التغييرات';
        });
    }
});
</script>
@endsection
