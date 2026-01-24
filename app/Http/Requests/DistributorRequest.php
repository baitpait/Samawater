<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class DistributorRequest extends FormRequest
{
    public function authorize()
    {
        return backpack_auth()->check();
    }

    public function rules()
    {
        // الحصول على ID من الـ route (في حالة التحديث)
        $id = $this->route('id') ?? $this->route('distributor') ?? null;
        
        return [
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:20',
            'username' => 'required|string|max:50|unique:distributors,username,' . $id,
            // في حالة التحديث (عند وجود ID)، كلمة المرور اختيارية
            // في حالة الإنشاء (عند عدم وجود ID)، كلمة المرور مطلوبة
            'password_hash' => $id ? 'nullable|min:6' : 'required|min:6',
            'status'   => 'required|in:0,1',
        ];
    }
    protected function passedValidation()
    {
        // إذا كانت كلمة المرور مملوءة، قم بتشفيرها
        if ($this->filled('password_hash') && !empty($this->password_hash)) {
            $this->merge([
                'password_hash' => bcrypt($this->password_hash),
            ]);
        } else {
            // إذا كانت فارغة (خاصة في حالة التحديث)، احذفها من الطلب تماماً
            // هذا يضمن عدم تحديث كلمة المرور في قاعدة البيانات
            $this->request->remove('password_hash');
            // أيضاً قم بإزالتها من البيانات المدمجة
            $data = $this->all();
            unset($data['password_hash']);
            $this->replace($data);
        }
    }

    public function attributes()
    {
        return [
            'name'     => 'اسم الموزع',
            'phone'    => 'رقم الهاتف',
            'username' => 'اسم المستخدم',
            'password_hash' => 'كلمة المرور',
            'status'   => 'الحالة',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'يرجى إدخال اسم الموزع',
            'phone.required' => 'يرجى إدخال رقم الهاتف',
            'username.required' => 'يرجى إدخال اسم المستخدم',
            'username.unique' => 'اسم المستخدم مستخدم بالفعل',
            'password_hash.required' => 'يرجى إدخال كلمة المرور',
            'password_hash.min' => 'كلمة المرور يجب أن تكون على الأقل 6 أحرف',
            'status.required' => 'يرجى اختيار الحالة',
            'status.in' => 'الحالة المحددة غير صحيحة',
        ];
    }
}