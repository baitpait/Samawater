<div class="form-group col-md-12">
    <label>الأصناف</label>
    <div id="items-container">
        <table class="table table-bordered" id="items-table">
            <thead>
                <tr>
                    <th>اسم الصنف</th>
                    <th>الكمية</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody id="items-tbody">
                @if(isset($deposit) && $deposit->items->count() > 0)
                    @foreach($deposit->items as $item)
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
                            <button type="button" class="btn btn-sm btn-danger remove-item">حذف</button>
                        </td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-right"><strong>عدد الأصناف:</strong></td>
                    <td>
                        <span id="items-count">1</span>
                        <button type="button" class="btn btn-sm btn-success" id="add-item" style="margin-left: 10px;">إضافة صنف</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = {{ isset($deposit) && $deposit->items->count() > 0 ? $deposit->items->count() : 1 }};
    
    // إضافة صنف جديد
    document.getElementById('add-item').addEventListener('click', function() {
        const tbody = document.getElementById('items-tbody');
        const row = document.createElement('tr');
        row.className = 'item-row';
        row.innerHTML = `
            <td>
                <select name="items[${itemIndex}][item_name]" class="form-control item-name" required>
                    <option value="">اختر الصنف</option>
                    @foreach(\App\Models\InventoryItem::orderBy('item_name')->get() as $inventoryItem)
                        <option value="{{ $inventoryItem->item_name }}">
                            {{ $inventoryItem->item_name }} (متوفر: {{ $inventoryItem->quantity }})
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" name="items[${itemIndex}][quantity]" class="form-control item-quantity" value="1" min="1" required>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger remove-item">حذف</button>
            </td>
        `;
        tbody.appendChild(row);
        itemIndex++;
        attachEventListeners(row);
        updateItemsCount();
    });
    
    // حذف صنف
    function attachEventListeners(row) {
        const removeBtn = row.querySelector('.remove-item');
        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                if (document.querySelectorAll('.item-row').length > 1) {
                    row.remove();
                    updateItemsCount();
                } else {
                    alert('يجب أن تحتوي الأمانة على صنف واحد على الأقل');
                }
            });
        }
    }
    
    // تحديث عدد الأصناف
    function updateItemsCount() {
        const count = document.querySelectorAll('.item-row').length;
        document.getElementById('items-count').textContent = count;
    }
    
    // إرفاق Event Listeners للصفوف الموجودة
    document.querySelectorAll('.item-row').forEach(row => {
        attachEventListeners(row);
    });
    
    // تحديث العدد الأولي
    updateItemsCount();
});
</script>
