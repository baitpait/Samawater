<?php

namespace App\Support;

use App\Models\City;
use App\Models\ClientStatus;
use App\Models\Distributor;
use App\Models\SubscriptionStatus;
use App\Models\SubscriptionType;
use Illuminate\Support\Facades\Cache;

/**
 * Business Purpose: تخزين قوائم الفلاتر (مدن، أنواع اشتراك، إلخ) في الكاش لفترات قصيرة
 * لتقليل تكرار استعلامات الجداول المرجعية في كل طلب قائمة التسليم / الإدخال الجماعي دون تغيير سلوك الواجهة.
 */
final class CachedDeliveryFormOptions
{
    private const TTL_SECONDS = 600;

    private const KEYS = [
        'cities' => 'delivery_form_opts.v1.cities',
        'subscription_types' => 'delivery_form_opts.v1.subscription_types',
        'subscription_statuses' => 'delivery_form_opts.v1.subscription_statuses',
        'client_statuses' => 'delivery_form_opts.v1.client_statuses',
        'distributors' => 'delivery_form_opts.v1.distributors',
    ];

    /**
     * Business Purpose: إرجاع كل الجداول المرجعية المستخدمة في نماذج التسليم مع كاش موحّد.
     *
     * @return array{
     *     cities: \Illuminate\Database\Eloquent\Collection<int, City>,
     *     subscriptionTypes: \Illuminate\Database\Eloquent\Collection<int, SubscriptionType>,
     *     subscriptionStatuses: \Illuminate\Database\Eloquent\Collection<int, SubscriptionStatus>,
     *     clientStatuses: \Illuminate\Database\Eloquent\Collection<int, ClientStatus>,
     *     distributors: \Illuminate\Database\Eloquent\Collection<int, Distributor>
     * }
     */
    public static function all(): array
    {
        return [
            'cities' => Cache::remember(
                self::KEYS['cities'],
                self::TTL_SECONDS,
                static fn () => City::query()->orderBy('city_name')->get()
            ),
            'subscriptionTypes' => Cache::remember(
                self::KEYS['subscription_types'],
                self::TTL_SECONDS,
                static fn () => SubscriptionType::query()->orderBy('type_name')->get()
            ),
            'subscriptionStatuses' => Cache::remember(
                self::KEYS['subscription_statuses'],
                self::TTL_SECONDS,
                static fn () => SubscriptionStatus::query()->orderBy('status_name')->get()
            ),
            'clientStatuses' => Cache::remember(
                self::KEYS['client_statuses'],
                self::TTL_SECONDS,
                static fn () => ClientStatus::query()->orderBy('status_name')->get()
            ),
            'distributors' => Cache::remember(
                self::KEYS['distributors'],
                self::TTL_SECONDS,
                static fn () => Distributor::query()->orderBy('name')->get(['id', 'name'])
            ),
        ];
    }

    /** فهرس رسمي لتفريغ الكاش بعد تغييرات CRUD مستقبلية إذا لزم. */
    public static function flush(): void
    {
        foreach (self::KEYS as $cacheKey) {
            Cache::forget($cacheKey);
        }
    }
}
