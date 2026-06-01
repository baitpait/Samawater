<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Business Purpose: التحقق من بيانات فاتورة مشتريات المورد وبنود المخزون.
 */
class PurchaseInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    /**
     * Business Purpose: تحويل «صنف جديد» إلى اسم صنف فعلي قبل التحقق.
     */
    protected function prepareForValidation(): void
    {
        $items = $this->input('items', []);
        if (! is_array($items)) {
            return;
        }

        foreach ($items as $index => $row) {
            if (($row['item_name'] ?? '') === '__new__' && ! empty($row['new_item_name'])) {
                $items[$index]['item_name'] = trim((string) $row['new_item_name']);
            }
        }

        $this->merge(['items' => $items]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'vendor_id' => ['required', 'exists:vendors,id'],
            'invoice_date' => ['required', 'date'],
            'status' => ['required', 'in:draft,confirmed,cancelled'],
            'payment_status' => ['required', 'in:paid,partial,unpaid'],
            'amount_paid' => ['nullable', 'numeric', 'min:0'],
            'payment_method' => ['nullable', 'in:cash,bank_transfer,check,credit_card,other'],
            'payment_date' => ['nullable', 'date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.item_name' => ['required', 'string', 'max:255'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_cost' => ['required', 'numeric', 'min:0.01'],
        ];
    }
}
