<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Http\Controllers\Admin\ClientsDeliveryOverviewController;
use App\Models\Role;
use App\Models\User;
use App\Models\VClientsDeliveryOverview;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use ReflectionMethod;
use Tests\TestCase;

class ClientsDeliveryOverviewDateFilterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesSeeder::class);
    }

    public function test_empty_dates_do_not_filter_last_delivery_date(): void
    {
        if (! Schema::hasTable('v_clients_delivery_overview')) {
            $this->markTestSkipped('v_clients_delivery_overview view is not available in the test database.');
        }

        $controller = new ClientsDeliveryOverviewController();
        $method = new ReflectionMethod($controller, 'applyOverviewFilters');
        $method->setAccessible(true);

        $unfiltered = VClientsDeliveryOverview::query()->count();

        $query = VClientsDeliveryOverview::query();
        $method->invoke($controller, $query, Request::create('/', 'GET', [
            'search' => '1',
            'from' => '',
            'to' => '',
        ]));

        $this->assertSame($unfiltered, $query->count());
    }

    public function test_search_without_dates_returns_results_for_admin(): void
    {
        if (! Schema::hasTable('v_clients_delivery_overview')) {
            $this->markTestSkipped('v_clients_delivery_overview view is not available in the test database.');
        }

        $adminRole = Role::where('name', Role::NAME_SUPER_ADMIN)->first();
        $this->assertNotNull($adminRole);

        $admin = User::factory()->create(['role_id' => $adminRole->id]);
        $guard = config('backpack.base.guard', 'web');

        $response = $this->actingAs($admin, $guard)
            ->get(route('reports.clients_delivery_overview', [
                'search' => 1,
                'client_id' => '',
                'from' => '',
                'to' => '',
            ]));

        $response->assertOk();
        $rows = $response->viewData('rows');
        $this->assertGreaterThan(0, $rows->total());
    }
}
