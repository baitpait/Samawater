<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * Business Purpose: جدول المخزون (Inventory Items)
 * - جدول ديناميكي مستقل عن المصروفات
 * - يحتوي على: اسم الصنف والعدد فقط
 * - يتم تحديثه تلقائياً عند شراء مخزون عبر ExpenseCrudController
 */
class InventoryItem extends Model
{
    use CrudTrait;

    protected $fillable = [
        'item_name',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    /**
     * Business Purpose: إضافة كمية جديدة للصنف
     * - إذا كان الصنف موجود: يضيف الكمية الجديدة
     * - إذا كان غير موجود: ينشئ سجل جديد
     */
    public static function addQuantity(string $itemName, int $quantity): self
    {
        $item = self::where('item_name', $itemName)->first();
        
        if ($item) {
            $item->quantity += $quantity;
            $item->save();
        } else {
            $item = self::create([
                'item_name' => $itemName,
                'quantity' => $quantity,
            ]);
        }
        
        return $item;
    }

    /**
     * Business Purpose: خصم كمية من الصنف
     */
    public static function subtractQuantity(string $itemName, int $quantity): self
    {
        $item = self::where('item_name', $itemName)->first();
        
        if ($item) {
            $item->quantity = max(0, $item->quantity - $quantity);
            $item->save();
        }
        
        return $item;
    }
}
