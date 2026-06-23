<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardViewTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesSeeder::class);
    }

    /**
     * Business Purpose: المالك يرى لوحة التحكم الكاملة وليس dashboard_admin المؤقتة.
     */
    public function test_admin_dashboard_uses_main_dashboard_view(): void
    {
        $adminRole = Role::where('name', Role::NAME_SUPER_ADMIN)->first();
        $admin = User::factory()->create(['role_id' => $adminRole->id]);
        $guard = config('backpack.base.guard', 'web');

        $response = $this->actingAs($admin, $guard)->get(backpack_url('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('vendor.backpack.ui.dashboard');
        $response->assertViewHas('ownerDashboard');
        $response->assertSee('التسليمات اليوم', false);
        $response->assertSee('الكاش اليوم', false);
        $response->assertDontSee('dashboard بسيط مؤقتاً', false);
    }
}
