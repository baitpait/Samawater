<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * التحقق من صفحة تقرير نظرة التسليمات وعمود الإجراءات.
 */
class ClientsDeliveryOverviewTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesSeeder::class);
    }

    /** @test */
    public function report_page_requires_admin(): void
    {
        $response = $this->get(route('reports.clients_delivery_overview'));
        $response->assertRedirect();
    }

    /** @test */
    public function report_page_with_search_returns_200_for_admin(): void
    {
        $adminRole = Role::where('name', Role::NAME_SUPER_ADMIN)->first();
        $this->assertNotNull($adminRole, 'Super Admin role must exist (run RolesSeeder)');
        $admin = User::factory()->create(['role_id' => $adminRole->id]);

        $guard = config('backpack.base.guard', 'web');
        $response = $this->actingAs($admin, $guard)
            ->get(route('reports.clients_delivery_overview', ['search' => 1]));

        $response->assertStatus(200);
        $response->assertViewIs('admin.reports.clients_delivery_overview');
        $response->assertViewHas(['rows', 'cities', 'distributors']);
    }

    /** @test */
    public function report_view_has_actions_column_markup(): void
    {
        $adminRole = Role::where('name', Role::NAME_SUPER_ADMIN)->first();
        $this->assertNotNull($adminRole, 'Super Admin role must exist (run RolesSeeder)');
        $admin = User::factory()->create(['role_id' => $adminRole->id]);

        $guard = config('backpack.base.guard', 'web');
        $response = $this->actingAs($admin, $guard)
            ->get(route('reports.clients_delivery_overview', ['search' => 1]));

        $response->assertStatus(200);
        $body = $response->getContent();
        $this->assertNotNull($body);
        $hasEditOrAdd = str_contains($body, 'تعديل') || str_contains($body, 'إضافة تسليم') || str_contains($body, 'actions-cell');
        $this->assertTrue($hasEditOrAdd, 'Expected actions column (تعديل or إضافة تسليم or actions-cell) in response');
    }
}
