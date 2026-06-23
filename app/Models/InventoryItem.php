<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    /**
     * Business Purpose: مجاميع الأمانات النشطة (لم تُسحَب) عند المشتركين لكل اسم صنف.
     *
     * @return array<string, int>
     */
    public static function activeDepositTotalsByItemName(): array
    {
        $rows = DB::table('client_deposit_items as cdi')
            ->join('client_deposits as cd', 'cd.id', '=', 'cdi.client_deposit_id')
            ->where('cd.is_withdrawn', false)
            ->selectRaw('TRIM(cdi.item_name) as item_name, SUM(cdi.quantity) as total_on_loan')
            ->groupBy(DB::raw('TRIM(cdi.item_name)'))
            ->get();

        $totals = [];
        foreach ($rows as $row) {
            $name = trim((string) $row->item_name);
            if ($name === '') {
                continue;
            }
            $totals[$name] = (int) $row->total_on_loan;
        }

        return $totals;
    }

    /**
     * Business Purpose: كمية الأمانات النشطة عند المشتركين لصنف مخزون محدد.
     */
    public function activeDepositQuantityOnClients(): int
    {
        $name = trim((string) $this->item_name);
        if ($name === '') {
            return 0;
        }

        return (int) DB::table('client_deposit_items as cdi')
            ->join('client_deposits as cd', 'cd.id', '=', 'cdi.client_deposit_id')
            ->where('cd.is_withdrawn', false)
            ->whereRaw('TRIM(cdi.item_name) = ?', [$name])
            ->sum('cdi.quantity');
    }
}
