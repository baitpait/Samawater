<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;

/**
 * Business Purpose: المصروفات مع إمكانية توزيعها على عدة أشهر للتقارير المالية
 * - المصروف يتم دفعه دفعة واحدة (payment_date)
 * - يتم توزيعه على عدة أشهر للتقارير المالية فقط
 */
class Expense extends Model
{
    use CrudTrait;

    protected $fillable = [
        'expense_category_id',
        'expense_beneficiary_id',
        'vendor_id',
        'is_inventory',
        'payment_status',
        'total_amount',
        'number_of_months',
        'monthly_amount',
        'start_month',
        'end_month',
        'payment_date',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'monthly_amount' => 'decimal:2',
        'start_month' => 'date',
        'end_month' => 'date',
        'payment_date' => 'date',
        'is_inventory' => 'boolean',
    ];

    /**
     * العلاقة مع فئة المصروف
     */
    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    /**
     * العلاقة مع صاحب المصروف
     */
    public function beneficiary()
    {
        return $this->belongsTo(ExpenseBeneficiary::class, 'expense_beneficiary_id');
    }

    /**
     * Business Purpose: تسمية العرض = الفئة ( صاحب المصروف ).
     */
    public function displayLabel(): string
    {
        return app(\App\Services\ExpenseQueryService::class)->formatExpenseLabel($this);
    }

    /**
     * العلاقة مع المورد (اختياري)
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    /**
     * العلاقة مع المدفوعات المرتبطة بهذا المصروف
     */
    public function vendorPayments()
    {
        return $this->hasMany(VendorPayment::class, 'expense_id');
    }

    /**
     * العلاقة مع التوزيعات الشهرية
     */
    public function monthlyAllocations()
    {
        return $this->hasMany(ExpenseMonthlyAllocation::class, 'expense_id');
    }

    /**
     * العلاقة مع المستخدم الذي أنشأ المصروف
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    /**
     * إنشاء التوزيعات الشهرية تلقائياً
     * Business Purpose: عند إنشاء مصروف، يتم توزيعه على الأشهر المحددة
     * - جميع المصروفات مرحلة تلقائياً عند الإضافة
     */
    public function createMonthlyAllocations()
    {
        $monthlyAmount = $this->total_amount / $this->number_of_months;
        $startMonth = Carbon::parse($this->start_month);

        for ($i = 0; $i < $this->number_of_months; $i++) {
            $month = $startMonth->copy()->addMonths($i)->format('Y-m-01');
            
            // جميع المصروفات مرحلة تلقائياً عند الإضافة
            ExpenseMonthlyAllocation::create([
                'expense_id' => $this->id,
                'month' => $month,
                'amount' => $monthlyAmount,
                'is_transferred' => true,
                'transferred_at' => now(),
            ]);
        }
    }
}
