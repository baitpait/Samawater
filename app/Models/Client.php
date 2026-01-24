<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use CrudTrait;
    use HasFactory;

    // حذف التسليمات تلقائياً عند حذف المشترك
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($client) {
            // حذف جميع التسليمات المرتبطة بالمشترك
            $client->deliveries()->delete();
        });
    }
   
    protected $table = 'clients';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'parent_id',
        'contract_no',
        'name',
        'city_id',
        'address',
        'phone_one',
        'phone_two',
        'client_type',
        'subscription_type_id',
        'subscription_status_id',
        'subscription_start_date',
        'longitude',
        'latitude',
        'bottle_balance',
        'delivery_on_demand',
        'notes',
        'city_name',
        'distributor_id',
        'image'
    ];
    
 

public function lastDelivery()
{
    return $this->hasOne(\App\Models\Delivery::class, 'client_id')
                ->latest('delivery_date');
}


    public function city()
    {
        return $this->belongsTo(\App\Models\City::class, 'city_id');
    }

    public function subscriptionType()
    {
        return $this->belongsTo(\App\Models\SubscriptionType::class, 'subscription_type_id');
    }

    public function subscriptionStatus()
    {
        return $this->belongsTo(\App\Models\SubscriptionStatus::class, 'subscription_status_id');
    }
    
    // عدد مرات الدفع (كل سجل فيه مبلغ)
public function getPaymentsCountAttribute()
{
    return $this->deliveries()->where('paymant', '>', 0)->count();
}
 public function distributor()
    {
        return $this->belongsTo(
            \App\Models\Distributor::class,
            'distributor_id'
        );
    }
// إجمالي المدفوع
public function getTotalPaidAttribute()
{
    return $this->deliveries()->sum('paymant');
}

// عدد مرات التوصيل
public function getDeliveriesCountAttribute()
{
    return $this->deliveries()->count();
}
public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'client_id');
    }

// القوارير الممتلئة
public function getFilledBottlesAttribute()
{
    return $this->deliveries()->sum('bottle_received');
}

// القوارير الفارغة
public function getEmptyBottlesAttribute()
{
    return $this->deliveries()->sum('bottle_empty');
}

// رصيد القوارير عند المشترك
public function getBottleBalanceAttribute()
{
    return $this->filled_bottles - $this->empty_bottles;
}

    /**
     * العلاقة مع الفواتير
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'client_id');
    }

    /**
     * العلاقة مع المدفوعات
     */
    public function payments()
    {
        return $this->hasMany(ClientPayment::class, 'client_id');
    }

    /**
     * العلاقة مع الأمانات
     */
    public function deposits()
    {
        return $this->hasMany(ClientDeposit::class, 'client_id');
    }

    /**
     * العلاقة مع المشترك الأب (parent)
     */
    public function parent()
    {
        return $this->belongsTo(Client::class, 'parent_id');
    }

    /**
     * العلاقة مع العناوين الفرعية (children)
     */
    public function children()
    {
        return $this->hasMany(Client::class, 'parent_id');
    }

    /**
     * Business Purpose: التحقق من أن هذا المشترك هو الأب (parent_id = null)
     */
    public function isParent(): bool
    {
        return $this->parent_id === null;
    }

    /**
     * Business Purpose: الحصول على المشترك الأب (إذا كان هذا ابن)
     */
    public function getParentClient(): ?Client
    {
        if ($this->isParent()) {
            return $this;
        }
        return $this->parent;
    }

    /**
     * Business Purpose: إجمالي الفواتير المؤكدة
     * - إذا كان هذا مشترك فرعي، يتم حساب فواتير الأب
     */
    public function getTotalInvoicesAmountAttribute()
    {
        $parentClient = $this->getParentClient();
        if (!$parentClient) {
            return 0;
        }
        return $parentClient->invoices()
            ->where('status', 'confirmed')
            ->sum('total_amount');
    }

    /**
     * Business Purpose: إجمالي المدفوعات
     * - إذا كان هذا مشترك فرعي، يتم حساب مدفوعات الأب
     */
    public function getTotalPaidAmountAttribute()
    {
        $parentClient = $this->getParentClient();
        if (!$parentClient) {
            return 0;
        }
        return $parentClient->payments()->sum('amount');
    }

    /**
     * Business Purpose: الرصيد المستحق (الفواتير - المدفوعات)
     * - يعمل على الأب دائماً (حتى لو كان هذا مشترك فرعي)
     */
    public function getBalanceAttribute()
    {
        return $this->total_invoices_amount - $this->total_paid_amount;
    }
}