<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * Business Purpose: الموردون (Vendors) - الشركات/الأفراد الذين نشتري منهم
 * - الرصيد = opening_balance + SUM(expenses.total_amount) - SUM(payments.amount)
 * - الرصيد يُحسب على المبلغ الكامل للفاتورة (ignoring amortization)
 */
class Vendor extends Model
{
    use CrudTrait;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'opening_balance',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'opening_balance' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * المعلَم المستخدم عند عرض المورد في القوائم المنسدلة وعلاقات Backpack.
     */
    public function identifiableAttribute(): string
    {
        return 'name';
    }

    /**
     * العلاقة مع المصروفات
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'vendor_id');
    }

    /**
     * العلاقة مع المدفوعات
     */
    public function payments()
    {
        return $this->hasMany(VendorPayment::class, 'vendor_id');
    }

    /**
     * Business Purpose: فواتير مشتريات المورد (مؤكدة تزيد الالتزام المالي).
     */
    public function purchaseInvoices()
    {
        return $this->hasMany(PurchaseInvoice::class, 'vendor_id');
    }

    /**
     * حساب الرصيد الحالي للمورد
     * Business Purpose: الرصيد = opening_balance + المصروفات + فواتير المشتريات المؤكدة - المدفوعات
     */
    public function getBalanceAttribute()
    {
        $totalExpenses = $this->expenses()->sum('total_amount');
        $totalPurchases = $this->purchaseInvoices()
            ->where('status', 'confirmed')
            ->sum('total_amount');
        $totalPayments = $this->payments()->sum('amount');

        return $this->opening_balance + $totalExpenses + $totalPurchases - $totalPayments;
    }
}
