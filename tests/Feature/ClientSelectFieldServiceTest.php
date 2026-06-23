<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Client;
use App\Services\ClientSelectFieldService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientSelectFieldServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_crud_field_html_includes_select2_class_and_rich_labels(): void
    {
        $parent = Client::create(['name' => 'فادي الصبار', 'parent_id' => null, 'contract_no' => 'C-1', 'phone_one' => '0599999999']);
        Client::create(['name' => 'عنوان فرعي', 'parent_id' => $parent->id]);

        $service = app(ClientSelectFieldService::class);

        $deliveryHtml = $service->crudFieldHtml([
            'label' => 'المشترك',
            'selectId' => 'client_id_select',
            'richLabels' => true,
        ]);

        $this->assertStringContainsString('client-select-searchable', $deliveryHtml);
        $this->assertStringContainsString('client_id_select', $deliveryHtml);
        $this->assertStringContainsString('فادي الصبار (C-1) - 0599999999', $deliveryHtml);

        $parentsHtml = $service->crudFieldHtml([
            'name' => 'parent_id',
            'label' => 'المشترك الأب',
            'parentsOnly' => true,
        ]);

        $this->assertStringContainsString('name="parent_id"', $parentsHtml);
        $this->assertStringContainsString('فادي الصبار', $parentsHtml);
        $this->assertStringNotContainsString('عنوان فرعي', $parentsHtml);
    }
}
