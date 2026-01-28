<div class="form-group col-md-12">
    <label>الأصناف</label>
    <div id="items-container">
        <table class="table table-bordered" id="items-table">
            <thead>
                <tr>
                    <th>اسم الصنف</th>
                    <th>الكمية</th>
                    <th>سعر الوحدة</th>
                    <th>الإجمالي</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody id="items-tbody">
                @if(isset($invoice) && $invoice->items->count() > 0)
                    @foreach($invoice->items as $item)
                        <tr class="item-row">
                            <td>
                                <select name="items[{{ $loop->index }}][item_name]" class="form-control item-name" required>
                                    <option value="">اختر الصنف</option>
                                    @foreach(\App\Models\InventoryItem::orderBy('item_name')->get() as $inventoryItem)
                                        <option value="{{ $inventoryItem->item_name }}" {{ $item->item_name == $inventoryItem->item_name ? 'selected' : '' }}>
                                            {{ $inventoryItem->item_name }} (متوفر: {{ $inventoryItem->quantity }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" name="items[{{ $loop->index }}][quantity]" class="form-control item-quantity" value="{{ $item->quantity }}" min="1" required>
                            </td>
                            <td>
                                <input type="number" name="items[{{ $loop->index }}][unit_price]" class="form-control item-price" value="{{ $item->unit_price }}" step="0.01" min="0.01" required>
                            </td>
                            <td>
                                <input type="text" class="form-control item-total" value="{{ number_format($item->total_price, 2) }}" readonly>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger remove-item">حذف</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="item-row">
                        <td>
                            <select name="items[0][item_name]" class="form-control item-name" required>
                                <option value="">اختر الصنف</option>
                                @foreach(\App\Models\InventoryItem::orderBy('item_name')->get() as $inventoryItem)
                                    <option value="{{ $inventoryItem->item_name }}">
                                        {{ $inventoryItem->item_name }} (متوفر: {{ $inventoryItem->quantity }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="items[0][quantity]" class="form-control item-quantity" value="1" min="1" required>
                        </td>
                        <td>
                            <input type="number" name="items[0][unit_price]" class="form-control item-price" value="0.00" step="0.01" min="0.01" required>
                        </td>
                        <td>
                            <input type="text" class="form-control item-total" value="0.00" readonly>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger remove-item">حذف</button>
                        </td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>المجموع الكلي:</strong></td>
                    <td>
                        <input type="text" id="grand-total" class="form-control" value="0.00" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-success" id="add-item">إضافة صنف</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@php
    $inventoryItems = \App\Models\InventoryItem::orderBy('item_name')->get();
@endphp

<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = {{ isset($invoice) && $invoice->items->count() > 0 ? $invoice->items->count() : 1 }};
    
    // قائمة الأصناف المتاحة
    const inventoryItems = @json($inventoryItems->map(function($item) {
        return [
            'name' => $item->item_name,
            'quantity' => $item->quantity
        ];
    }));
    
    // دالة لإنشاء select للأصناف
    function createItemSelect(index) {
        let options = '<option value="">اختر الصنف</option>';
        inventoryItems.forEach(function(item) {
            options += `<option value="${item.name}">${item.name} (متوفر: ${item.quantity})</option>`;
        });
        return `<select name="items[${index}][item_name]" class="form-control item-name" required>${options}</select>`;
    }
    
    // إضافة صنف جديد
    document.getElementById('add-item').addEventListener('click', function() {
        const tbody = document.getElementById('items-tbody');
        const row = document.createElement('tr');
        row.className = 'item-row';
        row.innerHTML = `
            <td>
                ${createItemSelect(itemIndex)}
            </td>
            <td>
                <input type="number" name="items[${itemIndex}][quantity]" class="form-control item-quantity" value="1" min="1" required>
            </td>
            <td>
                <input type="number" name="items[${itemIndex}][unit_price]" class="form-control item-price" value="0.00" step="0.01" min="0.01" required>
            </td>
            <td>
                <input type="text" class="form-control item-total" value="0.00" readonly>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger remove-item">حذف</button>
            </td>
        `;
        tbody.appendChild(row);
        itemIndex++;
        attachEventListeners(row);
    });
    
    // حذف صنف
    function attachEventListeners(row) {
        const removeBtn = row.querySelector('.remove-item');
        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                if (document.querySelectorAll('.item-row').length > 1) {
                    row.remove();
                    calculateTotal();
                } else {
                    alert('يجب أن تحتوي الفاتورة على صنف واحد على الأقل');
                }
            });
        }
        
        const quantityInput = row.querySelector('.item-quantity');
        const priceInput = row.querySelector('.item-price');
        const totalInput = row.querySelector('.item-total');
        
        [quantityInput, priceInput].forEach(input => {
            input.addEventListener('input', function() {
                const quantity = parseFloat(quantityInput.value) || 0;
                const price = parseFloat(priceInput.value) || 0;
                const total = quantity * price;
                totalInput.value = total.toFixed(2);
                calculateTotal();
            });
        });
    }
    
    // حساب المجموع الكلي
    function calculateTotal() {
        let grandTotal = 0;
        document.querySelectorAll('.item-total').forEach(input => {
            grandTotal += parseFloat(input.value) || 0;
        });
        document.getElementById('grand-total').value = grandTotal.toFixed(2);
        
        // تحديث المبلغ المدفوع تلقائياً إذا كان "مدفوع كامل"
        const paymentStatusField = document.getElementById('payment_status_field');
        const amountPaidField = document.getElementById('amount_paid_field');
        if (paymentStatusField && amountPaidField && paymentStatusField.value === 'paid') {
            amountPaidField.value = grandTotal.toFixed(2);
        }
    }
    
    // إرفاق Event Listeners للصفوف الموجودة
    document.querySelectorAll('.item-row').forEach(row => {
        attachEventListeners(row);
    });
    
    // حساب المجموع الأولي
    calculateTotal();
});
</script>
