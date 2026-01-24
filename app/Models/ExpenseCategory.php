<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * Business Purpose: فئات المصروفات (صيانة، كهرباء، إيجار، إلخ)
 */
class ExpenseCategory extends Model
{
    use CrudTrait;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * العلاقة مع المصروفات
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'expense_category_id');
    }
}
