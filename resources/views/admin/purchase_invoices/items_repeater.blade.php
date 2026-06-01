<div class="form-group col-md-12">
    <label>أصناف المشتريات (تُضاف للمخزون عند تأكيد الفاتورة)</label>
    <div id="purchase-items-container">
        <table class="table table-bordered" id="purchase-items-table">
            <thead>
                <tr>
                    <th>اسم الصنف</th>
                    <th>الكمية</th>
                    <th>تكلفة الوحدة</th>
                    <th>الإجمالي</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody id="purchase-items-tbody">
                @if(isset($purchaseInvoice) && $purchaseInvoice->items->count() > 0)
                    @foreach($purchaseInvoice->items as $item)
                        <tr class="purchase-item-row">
                            <td>
                                <select name="items[{{ $loop->index }}][item_name]" class="form-control purchase-item-name" required>
                                    <option value="">اختر الصنف</option>
                                    @foreach(\App\Models\InventoryItem::orderBy('item_name')->get() as $inventoryItem)
                                        <option value="{{ $inventoryItem->item_name }}" @selected($item->item_name === $inventoryItem->item_name)>
                                            {{ $inventoryItem->item_name }} (متوفر: {{ $inventoryItem->quantity }})
                                        </option>
                                    @endforeach
                                    <option value="__new__">+ إضافة صنف جديد</option>
                                </select>
                                <input type="text" name="items[{{ $loop->index }}][new_item_name]" class="form-control mt-1 purchase-new-item-name" placeholder="اسم الصنف الجديد" value="" style="display:none;">
                            </td>
                            <td>
                                <input type="number" name="items[{{ $loop->index }}][quantity]" class="form-control purchase-item-quantity" value="{{ $item->quantity }}" min="1" required>
                            </td>
                            <td>
                                <input type="number" name="items[{{ $loop->index }}][unit_cost]" class="form-control purchase-item-cost" value="{{ $item->unit_cost }}" step="0.01" min="0.01" required>
                            </td>
                            <td>
                                <input type="text" class="form-control purchase-item-total" value="{{ number_format($item->total_cost, 2) }}" readonly>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger purchase-remove-item">حذف</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="purchase-item-row">
                        <td>
                            <select name="items[0][item_name]" class="form-control purchase-item-name" required>
                                <option value="">اختر الصنف</option>
                                @foreach(\App\Models\InventoryItem::orderBy('item_name')->get() as $inventoryItem)
                                    <option value="{{ $inventoryItem->item_name }}">
                                        {{ $inventoryItem->item_name }} (متوفر: {{ $inventoryItem->quantity }})
                                    </option>
                                @endforeach
                                <option value="__new__">+ إضافة صنف جديد</option>
                            </select>
                            <input type="text" name="items[0][new_item_name]" class="form-control mt-1 purchase-new-item-name" placeholder="اسم الصنف الجديد" style="display:none;">
                        </td>
                        <td>
                            <input type="number" name="items[0][quantity]" class="form-control purchase-item-quantity" value="1" min="1" required>
                        </td>
                        <td>
                            <input type="number" name="items[0][unit_cost]" class="form-control purchase-item-cost" value="0.00" step="0.01" min="0.01" required>
                        </td>
                        <td>
                            <input type="text" class="form-control purchase-item-total" value="0.00" readonly>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger purchase-remove-item">حذف</button>
                        </td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><strong>المجموع الكلي:</strong></td>
                    <td>
                        <input type="text" id="purchase-grand-total" class="form-control" value="0.00" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-success" id="purchase-add-item">إضافة صنف</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@php
    $inventoryItemsJson = \App\Models\InventoryItem::orderBy('item_name')->get(['item_name', 'quantity']);
@endphp

<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = {{ isset($purchaseInvoice) && $purchaseInvoice->items->count() > 0 ? $purchaseInvoice->items->count() : 1 }};
    const inventoryItems = @json($inventoryItemsJson);

    function createItemSelect(index) {
        let options = '<option value="">اختر الصنف</option>';
        inventoryItems.forEach(function(item) {
            options += '<option value="' + item.item_name + '">' + item.item_name + ' (متوفر: ' + item.quantity + ')</option>';
        });
        options += '<option value="__new__">+ إضافة صنف جديد</option>';
        return '<select name="items[' + index + '][item_name]" class="form-control purchase-item-name" required>' + options + '</select>' +
            '<input type="text" name="items[' + index + '][new_item_name]" class="form-control mt-1 purchase-new-item-name" placeholder="اسم الصنف الجديد" style="display:none;">';
    }

    function toggleNewItemField(selectEl) {
        const row = selectEl.closest('tr');
        const newInput = row ? row.querySelector('.purchase-new-item-name') : null;
        if (!newInput) return;
        if (selectEl.value === '__new__') {
            newInput.style.display = 'block';
            newInput.required = true;
        } else {
            newInput.style.display = 'none';
            newInput.required = false;
            newInput.value = '';
        }
    }

    function attachEventListeners(row) {
        const removeBtn = row.querySelector('.purchase-remove-item');
        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                if (document.querySelectorAll('.purchase-item-row').length > 1) {
                    row.remove();
                    calculateTotal();
                } else {
                    alert('يجب أن تحتوي الفاتورة على صنف واحد على الأقل');
                }
            });
        }

        const nameSelect = row.querySelector('.purchase-item-name');
        if (nameSelect) {
            nameSelect.addEventListener('change', function() { toggleNewItemField(nameSelect); });
            toggleNewItemField(nameSelect);
        }

        const quantityInput = row.querySelector('.purchase-item-quantity');
        const costInput = row.querySelector('.purchase-item-cost');
        const totalInput = row.querySelector('.purchase-item-total');

        [quantityInput, costInput].forEach(function(input) {
            if (!input) return;
            input.addEventListener('input', function() {
                const quantity = parseFloat(quantityInput.value) || 0;
                const cost = parseFloat(costInput.value) || 0;
                totalInput.value = (quantity * cost).toFixed(2);
                calculateTotal();
            });
        });
    }

    function calculateTotal() {
        let grandTotal = 0;
        document.querySelectorAll('.purchase-item-total').forEach(function(input) {
            grandTotal += parseFloat(input.value) || 0;
        });
        const grandField = document.getElementById('purchase-grand-total');
        if (grandField) {
            grandField.value = grandTotal.toFixed(2);
        }
        const paymentStatusField = document.getElementById('payment_status_field');
        const amountPaidField = document.getElementById('amount_paid_field');
        if (paymentStatusField && amountPaidField && paymentStatusField.value === 'paid') {
            amountPaidField.value = grandTotal.toFixed(2);
        }
    }

    document.getElementById('purchase-add-item').addEventListener('click', function() {
        const tbody = document.getElementById('purchase-items-tbody');
        const row = document.createElement('tr');
        row.className = 'purchase-item-row';
        row.innerHTML = '<td>' + createItemSelect(itemIndex) + '</td>' +
            '<td><input type="number" name="items[' + itemIndex + '][quantity]" class="form-control purchase-item-quantity" value="1" min="1" required></td>' +
            '<td><input type="number" name="items[' + itemIndex + '][unit_cost]" class="form-control purchase-item-cost" value="0.00" step="0.01" min="0.01" required></td>' +
            '<td><input type="text" class="form-control purchase-item-total" value="0.00" readonly></td>' +
            '<td><button type="button" class="btn btn-sm btn-danger purchase-remove-item">حذف</button></td>';
        tbody.appendChild(row);
        itemIndex++;
        attachEventListeners(row);
    });

    document.querySelectorAll('.purchase-item-row').forEach(attachEventListeners);
    calculateTotal();
});
</script>
