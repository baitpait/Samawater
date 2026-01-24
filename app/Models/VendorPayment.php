<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * Business Purpose: مدفوعات الموردين (Vendor Payments)
 * - تسجيل جميع المدفوعات للموردين
 * - يمكن ربطها بمصروف معين (expense_id) أو مستقلة
 */
class VendorPayment extends Model
{
    use CrudTrait;

    protected $fillable = [
        'vendor_id',
        'expense_id',
        'amount',
        'method',
        'payment_date',
        'reference_number',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    /**
     * العلاقة مع المورد
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    /**
     * العلاقة مع المصروف (اختياري)
     */
    public function expense()
    {
        return $this->belongsTo(Expense::class, 'expense_id');
    }

    /**
     * العلاقة مع المستخدم الذي أنشأ الدفع
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
