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
        'opening_balance_amount',
        'opening_balance_as_of',
        'notes',
        'interaction_method',
        'city_name',
        'distributor_id',
        'image'
    ];
    
    protected $casts = [
        'opening_balance_amount' => 'decimal:2',
        'opening_balance_as_of' => 'date',
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
     * - يشمل كل ما في جدول المدفوعات بما فيه ما أُنشئ مع التسليم (للشفافية والتدقيق)
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
     * Business Purpose: مجموع المدفوعات التي تُخصم ضد الرصيد الافتتاحي والفواتير فقط.
     * مدفوعات التسليم مفعولة على سطر البيع؛ لا تُطرح مرة أخرى ضد مسار الفوترة لتفادي رصيد سالب كاذب.
     *
     * @param  \App\Models\Client  $billingParent  المشترك الأب (ملف الفوترة)
     */
    public function standalonePaymentsTotalFor(Client $billingParent): float
    {
        return (float) $billingParent->payments()
            ->whereDoesntHave('linkedDelivery')
            ->sum('amount');
    }

    /**
     * Business Purpose: الرصيد حسب الافتتاحي والفواتير مقابل المدفوعات غير المرتبطة بتسليم.
     * - يعمل على الأب دائماً (حتى لو كان هذا مشترك فرعي)
     */
    public function getBalanceAttribute()
    {
        $parentClient = $this->getParentClient();
        $openingBalance = (float) ($parentClient?->opening_balance_amount ?? 0);
        if (!$parentClient) {
            return round($openingBalance + $this->total_invoices_amount, 2);
        }

        $standalonePaid = $this->standalonePaymentsTotalFor($parentClient);

        return round($openingBalance + $this->total_invoices_amount - $standalonePaid, 2);
    }

    /**
     * Business Purpose: معرفات حساب الأب وجميع العناوين الفرعية لتجميع التسليمات لنفس ملف المشترك.
     *
     * @return list<int>
     */
    public function familyClientIds(): array
    {
        $parent = $this->getParentClient() ?? $this;

        $ids = array_merge(
            [(int) $parent->id],
            $parent->children()->pluck('id')->map(static fn ($id): int => (int) $id)->all()
        );

        return array_values(array_unique($ids));
    }

    /**
     * Business Purpose: مجموع المتبقي من التسليمات لجميع جهات ملف العائلة: في كل سطر ∑ max(0، المطلوب − المسدَّد على التسليم).
     */
    public function deliveryOutstandingTotal(): float
    {
        return $this->deliveryOutstandingBreakdown()['outstanding'];
    }

    /**
     * Business Purpose: مستحقّ التسليمات مع عدّاد السطور وبعدهم إجمالي عدد السطور (عائلة الأب وجميع العناوين).
     *
     * @return array{ outstanding: float, deliveries_with_gap: int, delivery_count_family: int }
     */
    public function deliveryOutstandingBreakdown(): array
    {
        $collection = Delivery::query()
            ->whereIn('client_id', $this->familyClientIds())
            ->get();

        $total = 0.0;
        $withGap = 0;
        foreach ($collection as $d) {
            $gap = max(0.0, (float) ($d->required_amount ?? 0) - (float) ($d->paymant ?? 0));
            $total += $gap;
            if ($gap > 0.0000001) {
                $withGap++;
            }
        }

        return [
            'outstanding' => round($total, 2),
            'deliveries_with_gap' => $withGap,
            'delivery_count_family' => $collection->count(),
        ];
    }

    /**
     * Business Purpose: دين المعروض في قوائم التشغيل (مثل تقارير الفلاتر) = الرصيد حسب الفواتير والمدفوعات والافتتاحي + مستحقّ التسليمات.
     */
    public function getCombinedSubscriberDebtAttribute(): float
    {
        return round((float) $this->balance + $this->deliveryOutstandingTotal(), 2);
    }

    /**
     * Business Purpose: أرقام موحّدة لوحة «الحركة المالية» في صفحة المعاينة (افتتاحي، فواتير، مدفوعات مسجّلة، مستحق تسليمات).
     *
     * @return array{
     *     billing_parent_id: int,
     *     opening: float,
     *     opening_as_of: string|null,
     *     invoices_confirmed: float,
     *     payments_total: float,
     *     payments_from_deliveries: float,
     *     payments_standalone: float,
     *     balance_per_invoices: float,
     *     delivery_outstanding: float,
     *     deliveries_with_gap: int,
     *     delivery_count_family: int
     * }
     */
    public function financialSnapshotForShow(): array
    {
        $parent = $this->getParentClient();
        if (! $parent) {
            return [
                'billing_parent_id' => (int) $this->id,
                'opening' => 0.0,
                'opening_as_of' => null,
                'invoices_confirmed' => 0.0,
                'payments_total' => 0.0,
                'payments_from_deliveries' => 0.0,
                'payments_standalone' => 0.0,
                'balance_per_invoices' => 0.0,
                'delivery_outstanding' => 0.0,
                'deliveries_with_gap' => 0,
                'delivery_count_family' => 0,
            ];
        }

        $opening = (float) ($parent->opening_balance_amount ?? 0);
        $openingAsOf = $parent->opening_balance_as_of
            ? $parent->opening_balance_as_of->format('Y-m-d')
            : null;

        $invoicesConfirmed = (float) $parent->invoices()->where('status', 'confirmed')->sum('total_amount');
        $paymentsTotal = (float) $parent->payments()->sum('amount');
        $paymentsStandalone = (float) $parent->payments()
            ->whereDoesntHave('linkedDelivery')
            ->sum('amount');
        $paymentsFromDeliveries = round(max(0.0, $paymentsTotal - $paymentsStandalone), 2);
        $balancePerInvoices = round($opening + $invoicesConfirmed - $paymentsStandalone, 2);

        $deliveryStats = $this->deliveryOutstandingBreakdown();
        $deliveryOutstanding = $deliveryStats['outstanding'];
        $deliveriesWithGap = $deliveryStats['deliveries_with_gap'];
        $deliveryCountFamily = $deliveryStats['delivery_count_family'];

        return [
            'billing_parent_id' => (int) $parent->id,
            'opening' => $opening,
            'opening_as_of' => $openingAsOf,
            'invoices_confirmed' => $invoicesConfirmed,
            'payments_total' => round($paymentsTotal, 2),
            'payments_from_deliveries' => $paymentsFromDeliveries,
            'payments_standalone' => round($paymentsStandalone, 2),
            'balance_per_invoices' => $balancePerInvoices,
            'delivery_outstanding' => $deliveryOutstanding,
            'deliveries_with_gap' => $deliveriesWithGap,
            'delivery_count_family' => $deliveryCountFamily,
        ];
    }
}