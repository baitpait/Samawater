<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Business Purpose: توزيع المصروفات الشهرية
 * - كل شهر له سجل منفصل
 * - عند انتهاء الشهر أو عند الإدخال، يتم ترحيل المصروفات تلقائياً
 */
class ExpenseMonthlyAllocation extends Model
{
    protected $fillable = [
        'expense_id',
        'month',
        'amount',
        'is_transferred',
        'transferred_at',
        'notes',
    ];

    protected $casts = [
        'month' => 'date',
        'amount' => 'decimal:2',
        'is_transferred' => 'boolean',
        'transferred_at' => 'datetime',
    ];

    /**
     * العلاقة مع المصروف
     */
    public function expense()
    {
        return $this->belongsTo(Expense::class, 'expense_id');
    }

    /**
     * ترحيل المصروف
     * Business Purpose: ترحيل المصروف من "المصروفات الشهرية الحالية" إلى "قائمة المصروفات الرئيسية"
     */
    public function transfer()
    {
        $this->update([
            'is_transferred' => true,
            'transferred_at' => now(),
        ]);
    }
}
