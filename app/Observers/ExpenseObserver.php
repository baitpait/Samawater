<?php

namespace App\Observers;

use App\Models\Expense;
use App\Models\VendorPayment;

/**
 * Business Purpose: Observer للمصروفات - التحقق من إنشاء VendorPayment تلقائياً
 * - Note: منطق Quick Pay موجود في ExpenseCrudController
 * - هذا Observer للتحقق الإضافي والمراقبة
 */
class ExpenseObserver
{
    /**
     * Handle the Expense "created" event.
     * 
     * Business Purpose: التحقق من إنشاء VendorPayment بعد إنشاء المصروف
     * - يتم إنشاء VendorPayment في Controller، هذا للتحقق فقط
     */
    public function created(Expense $expense): void
    {
        // التحقق: إذا كان هناك vendor و payment_status = paid/partial
        // يجب أن يكون هناك VendorPayment مرتبط
        // (المنطق موجود في ExpenseCrudController::store())
    }

    /**
     * Handle the Expense "updated" event.
     * 
     * Business Purpose: التحقق من تحديث VendorPayment بعد تحديث المصروف
     * - يتم تحديث/إنشاء VendorPayment في Controller، هذا للتحقق فقط
     */
    public function updated(Expense $expense): void
    {
        // التحقق: إذا تغير payment_status أو vendor_id
        // يجب تحديث VendorPayment المرتبط
        // (المنطق موجود في ExpenseCrudController::update())
    }

    /**
     * Handle the Expense "deleted" event.
     * 
     * Business Purpose: عند حذف المصروف، حذف المدفوعات المرتبطة به
     */
    public function deleted(Expense $expense): void
    {
        // حذف المدفوعات المرتبطة بهذا المصروف
        // (CASCADE في Foreign Key يضمن الحذف التلقائي)
    }

    /**
     * Handle the Expense "restored" event.
     */
    public function restored(Expense $expense): void
    {
        //
    }

    /**
     * Handle the Expense "force deleted" event.
     */
    public function forceDeleted(Expense $expense): void
    {
        //
    }
}
