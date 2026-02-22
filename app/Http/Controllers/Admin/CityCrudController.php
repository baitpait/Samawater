<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CityRequest;
use App\Http\Controllers\Admin\Traits\HasUnifiedActionsDropdown;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class CityCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use HasUnifiedActionsDropdown;

    public function setup()
    {
        CRUD::setModel(\App\Models\City::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/city');

        // تعريب اسم الكيان
        CRUD::setEntityNameStrings('مدينة', 'المدن');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name'  => 'city_name',
            'label' => 'اسم المدينة',
            'type'  => 'text',
        ]);

        // إضافة عمود الإجراءات الموحد مع dropdown menu
        $this->addUnifiedActionsColumn('city', 'هل أنت متأكد من حذف هذه المدينة؟', 'المدينة');

        // ترتيب الصفوف أبجدياً حسب اسم المدينة
        $this->crud->query->orderBy('city_name', 'asc');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CityRequest::class);

        CRUD::addField([
            'name'  => 'city_name',
            'label' => 'اسم المدينة',
            'type'  => 'text',
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        CRUD::addColumn([
            'name'  => 'city_name',
            'label' => 'اسم المدينة',
            'type'  => 'text',
        ]);

    }

    /**
     * التحقق قبل الحذف
     */
    protected function setupDeleteOperation()
    {
        // التحقق من وجود عملاء مربوطين بهذه المدينة
        $this->crud->addClause('withCount', 'clients');
    }

    /**
     * تنفيذ الحذف مع التحقق
     * 
     * ⚠️ منع الحذف إذا كان هناك عملاء مربوطين بهذه المدينة
     */
    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        $entry = $this->crud->getEntry($id);

        // التحقق من وجود عملاء مربوطين بهذه المدينة
        $clientsCount = $entry->clients()->count();
        
        // ⚠️ منع الحذف إذا كان هناك عملاء مربوطين
        if ($clientsCount > 0) {
            \Alert::error(
                'لا يمكن حذف المدينة "' . $entry->city_name . '" لأن هناك ' . $clientsCount . ' عميل مربوطين بها. ' .
                'يرجى تغيير المدينة لهؤلاء العملاء أولاً قبل الحذف.'
            )->flash();
            return redirect($this->crud->route);
        }

        // ✅ السماح بالحذف فقط إذا لم يكن هناك عملاء مربوطين
        $cityName = $entry->city_name; // حفظ الاسم قبل الحذف
        $entry->delete();
        
        // إضافة رسالة نجاح صحيحة
        \Alert::success('تم حذف المدينة "' . $cityName . '" بنجاح.')->flash();
        
        // Redirect صحيح إلى قائمة المدن
        return redirect($this->crud->route);
    }
}