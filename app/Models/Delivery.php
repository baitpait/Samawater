<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;

class Delivery extends Model
{
    use CrudTrait;

    protected $table = 'deliveries'; // اسم الجدول الصحيح

    protected $fillable = [
        'client_id',
        'delivery_date',
        'bottle_received',
        'bottle_empty',
        'required_amount',
        'inventory_item_id',
        'paymant',
        'client_payment_id',
        'distributor_id',
    ];

    protected $casts = [
        'delivery_date' => 'date',
        'required_amount' => 'decimal:2',
        'paymant' => 'decimal:2',
    ];
    
    /**
     * Set delivery_date attribute - إذا كان فارغاً، استخدم تاريخ اليوم
     */
    public function setDeliveryDateAttribute($value)
    {
        $this->attributes['delivery_date'] = $value ?: Carbon::now()->format('Y-m-d');
    }
    
    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Business Purpose: العلاقة مع صنف العبوات في المخزون
     */
    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }

    /**
     * Business Purpose: العلاقة مع الدفعة المرتبطة
     */
    public function clientPayment()
    {
        return $this->belongsTo(ClientPayment::class, 'client_payment_id');
    }
}