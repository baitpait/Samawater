<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Http\Controllers\Admin\DeliveryListController;
use App\Http\Controllers\Admin\ReportFilterController;
use App\Models\Client;
use App\Models\Delivery;
use App\Models\InventoryItem;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

/**
 * Business Purpose: زر «حسب الطلب» يحفظ العلم ويظهر المشترك في قائمة التسليم دون فلتر الأيام.
 */
class DeliveryOnDemandToggleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesSeeder::class);
    }

    public function test_toggle_enables_flag_and_redirects_to_filters_with_query(): void
    {
        $client = Client::create(['name' => 'مشترك حسب الطلب']);

        $request = Request::create(
            route('reports.filters.toggle_delivery_on_demand', $client, false),
            'POST',
            [
                'enabled' => '1',
                'q' => 'حسب الطلب',
                'subscription_status_id' => '',
            ]
        );
        $request->setLaravelSession(app('session')->driver());

        $response = app(ReportFilterController::class)->toggleDeliveryOnDemand($request, $client);

        $this->assertTrue($response->isRedirect());
        $this->assertSame(
            route('reports.filters', [
                'q' => 'حسب الطلب',
                'subscription_status_id' => '',
            ]),
            $response->getTargetUrl()
        );
        $this->assertTrue((bool) $client->fresh()->getAttributes()['delivery_on_demand']);
        $this->assertNotEmpty($response->getSession()->get('success'));
    }

    public function test_on_demand_client_appears_in_delivery_list_despite_zero_days_and_default_min_days(): void
    {
        $item = InventoryItem::create(['item_name' => 'OnDemandBottle', 'quantity' => 100]);

        $other = Client::create(['name' => 'عميل آخر للتسليم']);
        Delivery::create([
            'client_id' => $other->id,
            'delivery_date' => now()->toDateString(),
            'bottle_received' => 1,
            'bottle_empty' => 0,
            'required_amount' => '0.00',
            'paymant' => '0.00',
            'inventory_item_id' => $item->id,
            'distributor_id' => null,
        ]);

        $client = Client::create([
            'name' => 'مستهدف حسب الطلب',
            'delivery_on_demand' => true,
        ]);

        Delivery::create([
            'client_id' => $client->id,
            'delivery_date' => now()->toDateString(),
            'bottle_received' => 2,
            'bottle_empty' => 1,
            'required_amount' => '0.00',
            'paymant' => '0.00',
            'inventory_item_id' => $item->id,
            'distributor_id' => null,
        ]);

        $controller = app(DeliveryListController::class);
        $view = $controller->index(Request::create('/admin/delivery-list', 'GET', [
            'search' => '1',
        ]));

        $clients = $view->getData()['clients'];
        $ids = collect($clients->items())->pluck('client_id')->map(static fn ($id): int => (int) $id)->all();

        $this->assertContains((int) $client->id, $ids);
    }

    public function test_toggle_ajax_returns_json_without_redirect(): void
    {
        $client = Client::create(['name' => 'مشترك AJAX حسب الطلب']);

        $request = Request::create(
            route('reports.filters.toggle_delivery_on_demand', $client, false),
            'POST',
            ['enabled' => '1']
        );
        $request->headers->set('X-Requested-With', 'XMLHttpRequest');
        $request->headers->set('Accept', 'application/json');
        $request->setLaravelSession(app('session')->driver());

        $response = app(ReportFilterController::class)->toggleDeliveryOnDemand($request, $client);

        $this->assertSame(200, $response->getStatusCode());
        $payload = $response->getData(true);
        $this->assertTrue($payload['success']);
        $this->assertTrue($payload['enabled']);
        $this->assertTrue((bool) $client->fresh()->getAttributes()['delivery_on_demand']);
    }

    public function test_filters_page_cancel_button_uses_red_style_class(): void
    {
        $client = Client::create([
            'name' => 'زر إلغاء أحمر',
            'delivery_on_demand' => true,
        ]);

        $html = view('admin.reports.filters', [
            'clients' => Client::query()->whereKey($client->id)->paginate(50),
            'bottleSnapshotsByClientId' => [],
            'cities' => collect(),
            'subscriptions' => collect(),
            'subscriptionStatuses' => collect(),
            'selectedSubscriptionStatusId' => null,
        ])->render();

        $this->assertStringContainsString('btn-delivery-on-demand-cancel', $html);
        $this->assertStringContainsString('js-delivery-on-demand-form', $html);
    }
}
