<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * Business Purpose: أصناف الأمانات (Client Deposit Items)
 * - كل أمانة تحتوي على عدة أصناف
 * - الأصناف من المخزون (inventory_items)
 * - بدون سعر (كمية فقط)
 */
class ClientDepositItem extends Model
{
    use CrudTrait;

    protected $table = 'client_deposit_items';
    
    protected $fillable = [
        'client_deposit_id',
        'item_name',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    /**
     * العلاقة مع الأمانة
     */
    public function deposit()
    {
        return $this->belongsTo(ClientDeposit::class, 'client_deposit_id');
    }
}
