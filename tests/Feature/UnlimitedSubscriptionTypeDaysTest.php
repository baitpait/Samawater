<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\SubscriptionType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Business Purpose: نوع «غير محدود» يجب أن يستخدم دورة 30 يوماً وليس 0 حتى لا تنهار قائمة المستحقين.
 */
class UnlimitedSubscriptionTypeDaysTest extends TestCase
{
    use RefreshDatabase;

    public function test_unlimited_subscription_type_migration_sets_days_to_thirty(): void
    {
        SubscriptionType::query()->create([
            'type_name' => 'غير محدود',
            'description' => null,
            'distribution_days' => 0,
        ]);

        $migration = require database_path(
            'migrations/2026_08_24_161924_set_unlimited_subscription_type_days_to_thirty.php'
        );
        $migration->up();

        $type = SubscriptionType::query()->where('type_name', 'غير محدود')->first();
        $this->assertNotNull($type);
        $this->assertSame(30, (int) $type->distribution_days);
    }
}
