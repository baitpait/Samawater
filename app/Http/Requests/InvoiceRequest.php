<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    public function authorize()
    {
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'invoice_date' => 'required|date',
            'status' => 'required|in:draft,confirmed,cancelled',
            'payment_status' => 'required|in:paid,partial,unpaid',
            'amount_paid' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|in:cash,bank_transfer,check,credit_card,other',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0.01',
        ];
    }

    public function attributes()
    {
        return [
            'client_id' => 'العميل',
            'invoice_date' => 'تاريخ الفاتورة',
            'status' => 'الحالة',
            'notes' => 'ملاحظات',
            'items' => 'الأصناف',
            'items.*.item_name' => 'اسم الصنف',
            'items.*.quantity' => 'الكمية',
            'items.*.unit_price' => 'سعر الوحدة',
        ];
    }
}
