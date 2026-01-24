<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * Business Purpose: أصناف الفاتورة
 * - كل فاتورة تحتوي على عدة أصناف
 * - الأصناف من المخزون (inventory_items)
 */
class InvoiceItem extends Model
{
    use CrudTrait;

    protected $table = 'invoice_items';
    
    protected $fillable = [
        'invoice_id',
        'item_name',
        'quantity',
        'unit_price',
        'total_price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /**
     * العلاقة مع الفاتورة
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    /**
     * Business Purpose: حساب total_price تلقائياً قبل الحفظ
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            $item->total_price = $item->quantity * $item->unit_price;
        });
    }
}
