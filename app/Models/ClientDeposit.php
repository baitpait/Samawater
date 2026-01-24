<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;

/**
 * Business Purpose: أمانات المشتركين (Client Deposits)
 * - أصناف معارة للعملاء من المخزون
 * - بدون سعر (كمية فقط)
 * - يتم خصمها من المخزون عند الإعارة
 * - يتم إرجاعها للمخزون عند السحب
 */
class ClientDeposit extends Model
{
    use CrudTrait;

    protected $table = 'client_deposits';
    
    protected $fillable = [
        'client_id',
        'date_given',
        'notes',
        'is_withdrawn',
        'withdrawn_at',
        'created_by',
    ];

    protected $casts = [
        'date_given' => 'date',
        'is_withdrawn' => 'boolean',
        'withdrawn_at' => 'datetime',
    ];

    /**
     * العلاقة مع المشترك
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * العلاقة مع المستخدم الذي أنشأ الأمانة
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * العلاقة مع أصناف الأمانة
     */
    public function items()
    {
        return $this->hasMany(ClientDepositItem::class, 'client_deposit_id');
    }

    /**
     * Business Purpose: سحب الأمانة (إرجاعها للمخزون)
     * - تحديث is_withdrawn = true
     * - تحديث withdrawn_at = now()
     * - إضافة جميع الكميات للمخزون (من جميع الأصناف)
     */
    public function withdraw(): void
    {
        if (!$this->is_withdrawn) {
            // إضافة جميع الكميات للمخزون (من جميع الأصناف)
            foreach ($this->items as $item) {
                InventoryItem::addQuantity($item->item_name, $item->quantity);
            }
            
            // تحديث حالة الأمانة
            $this->is_withdrawn = true;
            $this->withdrawn_at = Carbon::now();
            $this->save();
        }
    }

    /**
     * Business Purpose: سحب جميع أمانات مشترك معين
     * - إرجاع جميع الأمانات غير المسحوبة للمخزون
     */
    public static function withdrawAllForClient(int $clientId): int
    {
        $deposits = self::where('client_id', $clientId)
            ->where('is_withdrawn', false)
            ->get();
        
        $count = 0;
        foreach ($deposits as $deposit) {
            $deposit->withdraw();
            $count++;
        }
        
        return $count;
    }
}
