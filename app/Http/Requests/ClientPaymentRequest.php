<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;

class ClientPaymentRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'for_future_obligation' => $this->boolean('for_future_obligation'),
        ]);
    }

    public function authorize()
    {
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'client_id' => ['required', 'exists:clients,id', function ($attribute, $value, $fail) {
                $client = Client::find($value);
                if (!$client || $client->parent_id !== null) {
                    $fail('يمكن إنشاء المدفوعات للمشتركين الرئيسيين فقط (الأب).');
                }
            }],
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,check,credit_card,other',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'for_future_obligation' => ['nullable', 'boolean'],
        ];
    }

    public function attributes()
    {
        return [
            'client_id' => 'العميل',
            'amount' => 'المبلغ',
            'payment_date' => 'تاريخ الدفع',
            'payment_method' => 'طريقة الدفع',
            'reference_number' => 'الرقم المرجعي',
            'notes' => 'ملاحظات',
            'for_future_obligation' => 'لدين مستقبلي',
        ];
    }
}
