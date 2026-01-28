<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClientTypeRequest;
use App\Http\Controllers\Admin\Traits\HasUnifiedActionsDropdown;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class ClientTypeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use HasUnifiedActionsDropdown;

    public function setup()
    {
        CRUD::setModel(\App\Models\ClientType::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/client-type');

        // 🔥 تعريب اسم الكيان
        CRUD::setEntityNameStrings('نوع عميل', 'أنواع العملاء');
    }

    protected function setupListOperation()
    {
        CRUD::setColumns([
            [
                'name'  => 'type_name',
                'label' => 'نوع العميل',
                'type'  => 'text',
            ],
        ]);

        // إضافة عمود الإجراءات الموحد مع dropdown menu
        $this->addUnifiedActionsColumn('client-type', 'هل أنت متأكد من حذف نوع العميل هذا؟', 'نوع العميل');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(ClientTypeRequest::class);

        CRUD::addField([
            'name'  => 'type_name',
            'label' => 'نوع العميل',
            'type'  => 'text',
        ]);
    }
    
    protected function setupShowOperation()
    {
        CRUD::column('type_name')
            ->label('نوع العميل');

    }
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /**
     * التحقق قبل الحذف
     */
    protected function setupDeleteOperation()
    {
        // التحقق من وجود عملاء يستخدمون هذا النوع
        $this->crud->addClause('withCount', 'clients');
    }

    /**
     * تنفيذ الحذف مع التحقق
     * 
     * ⚠️ منع الحذف إذا كان هناك عملاء مربوطين بهذا النوع
     */
    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        $entry = $this->crud->getEntry($id);

        // التحقق من وجود عملاء يستخدمون هذا النوع
        $clientsCount = $entry->clients()->count();
        
        // ⚠️ منع الحذف إذا كان هناك عملاء مربوطين
        if ($clientsCount > 0) {
            \Alert::error(
                'لا يمكن حذف نوع العميل "' . $entry->type_name . '" لأن هناك ' . $clientsCount . ' عميل يستخدمونه. ' .
                'يرجى تغيير نوع العميل لهؤلاء العملاء أولاً قبل الحذف.'
            )->flash();
            return redirect($this->crud->route);
        }

        // ✅ السماح بالحذف فقط إذا لم يكن هناك عملاء مربوطين
        $typeName = $entry->type_name; // حفظ الاسم قبل الحذف
        $entry->delete();
        
        // إضافة رسالة نجاح صحيحة
        \Alert::success('تم حذف نوع العميل "' . $typeName . '" بنجاح.')->flash();
        
        // Redirect صحيح إلى قائمة الأنواع
        return redirect($this->crud->route);
    }
}