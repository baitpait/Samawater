@php
    $inventoryItems = \App\Models\InventoryItem::query()
        ->orderBy('item_name')
        ->get()
        ->map(static function ($item) {
            $item->item_name = trim((string) $item->item_name);

            return $item;
        });
    $initialRowCount = isset($deposit) && $deposit->items->count() > 0 ? $deposit->items->count() : 1;
@endphp

<div class="form-group col-md-12 client-deposit-items-repeater">
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
                                    @foreach($inventoryItems as $inventoryItem)
                                        <option value="{{ $inventoryItem->item_name }}" @selected(trim((string) $item->item_name) === $inventoryItem->item_name)>
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
                                @foreach($inventoryItems as $inventoryItem)
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
                        <span id="items-count">{{ $initialRowCount }}</span>
                        <button type="button" class="btn btn-sm btn-success" id="add-item" style="margin-left: 10px;">إضافة صنف</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<style>
    .client-deposit-items-repeater #items-container,
    .client-deposit-items-repeater #items-table {
        overflow: visible;
    }
    .client-deposit-items-repeater .item-name {
        min-width: 220px;
        width: 100%;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const inventoryItems = @json($inventoryItems->map(static fn ($item) => [
        'name' => $item->item_name,
        'quantity' => (int) $item->quantity,
    ])->values());

    let itemIndex = {{ $initialRowCount }};

    const tbody = document.getElementById('items-tbody');
    const addBtn = document.getElementById('add-item');
    const countEl = document.getElementById('items-count');

    if (!tbody || !addBtn || !countEl) {
        return;
    }

    /**
     * Business Purpose: بناء قائمة أصناف المخزون بأمان (بدون Blade داخل JavaScript).
     */
    function createItemSelect(index) {
        const select = document.createElement('select');
        select.name = 'items[' + index + '][item_name]';
        select.className = 'form-control item-name';
        select.required = true;

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = 'اختر الصنف';
        select.appendChild(placeholder);

        inventoryItems.forEach(function (item) {
            const option = document.createElement('option');
            option.value = item.name;
            option.textContent = item.name + ' (متوفر: ' + item.quantity + ')';
            select.appendChild(option);
        });

        return select;
    }

    function createQuantityInput(index) {
        const input = document.createElement('input');
        input.type = 'number';
        input.name = 'items[' + index + '][quantity]';
        input.className = 'form-control item-quantity';
        input.value = '1';
        input.min = '1';
        input.required = true;

        return input;
    }

    function updateItemsCount() {
        countEl.textContent = String(document.querySelectorAll('.item-row').length);
    }

    function attachEventListeners(row) {
        const removeBtn = row.querySelector('.remove-item');
        if (!removeBtn) {
            return;
        }

        removeBtn.addEventListener('click', function () {
            if (document.querySelectorAll('.item-row').length > 1) {
                row.remove();
                updateItemsCount();
            } else {
                alert('يجب أن تحتوي الأمانة على صنف واحد على الأقل');
            }
        });
    }

    addBtn.addEventListener('click', function () {
        const row = document.createElement('tr');
        row.className = 'item-row';

        const nameCell = document.createElement('td');
        nameCell.appendChild(createItemSelect(itemIndex));

        const qtyCell = document.createElement('td');
        qtyCell.appendChild(createQuantityInput(itemIndex));

        const actionCell = document.createElement('td');
        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-sm btn-danger remove-item';
        removeButton.textContent = 'حذف';
        actionCell.appendChild(removeButton);

        row.appendChild(nameCell);
        row.appendChild(qtyCell);
        row.appendChild(actionCell);

        tbody.appendChild(row);
        itemIndex++;
        attachEventListeners(row);
        updateItemsCount();
    });

    document.querySelectorAll('.item-row').forEach(attachEventListeners);
    updateItemsCount();
});
</script>
