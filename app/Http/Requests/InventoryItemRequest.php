<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Business Purpose: التحقق من صحة بيانات المخزون عند الإنشاء/التحديث
 */
class InventoryItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    public function rules(): array
    {
        $itemId = $this->route('id');
        
        return [
            'item_name' => 'required|string|max:255|unique:inventory_items,item_name,' . $itemId,
            'quantity' => 'required|integer|min:0',
        ];
    }
}
