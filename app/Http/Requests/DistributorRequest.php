<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DistributorRequest extends FormRequest
{
    /**
     * Business Purpose: تحديد صلاحية المستخدم لإدارة بيانات الموزعين.
     */
    public function authorize()
    {
        return backpack_auth()->check();
    }

    /**
     * Business Purpose: فرض قواعد تحقق تضمن صحة بيانات الموزع وعدم تكرارها.
     *
     * @return array<string, string>
     */
    public function rules()
    {
        // الحصول على ID من الـ route (في حالة التحديث)
        $id = $this->route('id') ?? $this->route('distributor') ?? null;
        
        return [
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:20|unique:distributors,phone,' . $id,
            // في حالة التحديث (عند وجود ID)، كلمة المرور اختيارية
            // في حالة الإنشاء (عند عدم وجود ID)، كلمة المرور مطلوبة
            'password_hash' => $id ? 'nullable|min:6' : 'required|min:6',
            'status'   => 'required|in:0,1',
        ];
    }

    /**
     * Business Purpose: تجاهل كلمة المرور إذا كانت فارغة أثناء التحديث.
     */
    protected function passedValidation()
    {
        if ($this->filled('password_hash') && !empty($this->password_hash)) {
            return;
        }

        // إذا كانت فارغة (خاصة في حالة التحديث)، احذفها من الطلب تماماً
        $this->request->remove('password_hash');
        $data = $this->all();
        unset($data['password_hash']);
        $this->replace($data);
    }

    /**
     * Business Purpose: تسمية الحقول برسائل عربية واضحة للمستخدم.
     *
     * @return array<string, string>
     */
    public function attributes()
    {
        return [
            'name'     => 'اسم الموزع',
            'phone'    => 'رقم الهاتف',
            'password_hash' => 'كلمة المرور',
            'status'   => 'الحالة',
        ];
    }

    /**
     * Business Purpose: رسائل تحقق واضحة تمنع تكرار البيانات الحرجة.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'يرجى إدخال اسم الموزع',
            'phone.required' => 'يرجى إدخال رقم الهاتف',
            'phone.unique' => 'رقم الهاتف مستخدم بالفعل',
            'password_hash.required' => 'يرجى إدخال كلمة المرور',
            'password_hash.min' => 'كلمة المرور يجب أن تكون على الأقل 6 أحرف',
            'status.required' => 'يرجى اختيار الحالة',
            'status.in' => 'الحالة المحددة غير صحيحة',
        ];
    }
}