<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_id' => 'required|integer|exists:clients,id',
            'delivery_date' => 'required|date',
            'bottle_received' => 'required|integer|min:0',
            'bottle_empty' => 'required|integer|min:0',
            'required_amount' => 'required|numeric|min:0',
            'inventory_item_id' => 'required|integer|exists:inventory_items,id',
            'paymant' => 'required|numeric|min:0',
            'distributor_id' => 'required|integer|exists:distributors,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'client_id.required' => 'يجب اختيار العميل',
            'client_id.exists' => 'العميل المحدد غير موجود',
            'delivery_date.required' => 'تاريخ التوصيل مطلوب',
            'delivery_date.date' => 'تاريخ التوصيل يجب أن يكون تاريخاً صحيحاً',
            'bottle_received.required' => 'عدد العبوات المستلمة مطلوب',
            'bottle_received.integer' => 'عدد العبوات المستلمة يجب أن يكون رقماً صحيحاً',
            'bottle_received.min' => 'عدد العبوات المستلمة لا يمكن أن يكون سالباً',
            'bottle_empty.required' => 'عدد العبوات الفارغة مطلوب',
            'bottle_empty.integer' => 'عدد العبوات الفارغة يجب أن يكون رقماً صحيحاً',
            'bottle_empty.min' => 'عدد العبوات الفارغة لا يمكن أن يكون سالباً',
            'required_amount.required' => 'المبلغ المطلوب مطلوب',
            'required_amount.numeric' => 'المبلغ المطلوب يجب أن يكون رقماً',
            'required_amount.min' => 'المبلغ المطلوب لا يمكن أن يكون سالباً',
            'inventory_item_id.required' => 'يجب اختيار صنف العبوات',
            'inventory_item_id.exists' => 'صنف العبوات المحدد غير موجود',
            'paymant.required' => 'المبلغ المدفوع مطلوب',
            'paymant.numeric' => 'المبلغ المدفوع يجب أن يكون رقماً',
            'paymant.min' => 'المبلغ المدفوع لا يمكن أن يكون سالباً',
            'distributor_id.required' => 'يجب اختيار الموزع',
            'distributor_id.exists' => 'الموزع المحدد غير موجود',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // إذا كان delivery_date فارغاً، استخدم تاريخ اليوم كقيمة افتراضية
        if (empty($this->delivery_date)) {
            $this->merge([
                'delivery_date' => now()->format('Y-m-d'),
            ]);
        }
        
        // إذا كان inventory_item_id فارغاً، استخدم id=1 كقيمة افتراضية
        if (empty($this->inventory_item_id)) {
            $this->merge([
                'inventory_item_id' => 1,
            ]);
        }
        
        // إذا كان required_amount فارغاً، استخدم 0 كقيمة افتراضية
        if (empty($this->required_amount)) {
            $this->merge([
                'required_amount' => 0,
            ]);
        }
    }
}

