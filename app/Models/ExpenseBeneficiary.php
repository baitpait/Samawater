<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Business Purpose: أصحاب المصروف مرتبطون بفئة مصروف (راتب، سولار، …).
 */
class ExpenseBeneficiary extends Model
{
    use CrudTrait;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'expense_category_id',
        'vendor_id',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Business Purpose: اسم العرض في القوائم المنسدلة لـ Backpack.
     */
    public function identifiableAttribute(): string
    {
        return 'name';
    }

    /**
     * Business Purpose: فئة المصروف التي ينتمي إليها هذا الصاحب.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    /**
     * Business Purpose: ربط اختياري بمورد مسجّل بنفس الاسم (مثل كازية الجنوب).
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    /**
     * Business Purpose: المصروفات المرتبطة بهذا الصاحب.
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'expense_beneficiary_id');
    }
}
