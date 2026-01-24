<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class VClientsDueByTypeDaysIdsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\VClientsDueByTypeDaysIds::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/clients-due');
        CRUD::setEntityNameStrings('عميل مستحق', 'قائمة المستحقين للتوزيع');
    }

  protected function setupListOperation()
{
    
    
    // 1️⃣ إجبار Backpack على ترتيب ثابت لتجنب order by فارغ
    $this->crud->query->orderBy('client_id', 'asc');

    // 2️⃣ تعريف الأعمدة كما في الـ VIEW

    CRUD::addColumn(['name' => 'client_id', 'label' => 'رقم العميل']);
    CRUD::addColumn(['name' => 'client_name', 'label' => 'اسم العميل']);
    CRUD::addColumn(['name' => 'city_name', 'label' => 'المدينة']);
    
    CRUD::addColumn(['name' => 'subscription_type_name', 'label' => 'نوع الاشتراك']);
    CRUD::addColumn(['name' => 'distribution_days', 'label' => 'أيام التوزيع']);

    CRUD::addColumn(['name' => 'last_delivery_date', 'label' => 'آخر توزيع']);
    CRUD::addColumn(['name' => 'days_since_last_delivery', 'label' => 'أيام منذ آخر توزيع']);

    CRUD::addColumn(['name' => 'bottle_on_hand_calculated', 'label' => 'رصيد القوارير']);
    CRUD::addColumn(['name' => 'percentage_delivery_rate', 'label' => 'نسبة الالتزام %']);
    CRUD::addColumn(['name' => 'client_status_name', 'label' => 'تصنيف العميل']);
}







    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
}