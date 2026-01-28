<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SubscriptionTypeRequest;
use App\Http\Controllers\Admin\Traits\HasUnifiedActionsDropdown;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SubscriptionTypeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SubscriptionTypeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use HasUnifiedActionsDropdown;


    public function setup()
    {
        CRUD::setModel(\App\Models\SubscriptionType::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/subscription-type');
        CRUD::setEntityNameStrings(' نوع اشتراك', 'انواع الاشتراكات');
    }

    protected function setupListOperation()
    {
        CRUD::column('type_name')->label('اسم الاشتراك');
        CRUD::column('description')->label('الوصف');
        CRUD::column('distribution_days')->label('عدد الايام');
        
        // إضافة عمود الإجراءات الموحد مع dropdown menu
        $this->addUnifiedActionsColumn('subscription-type', 'هل أنت متأكد من حذف نوع الاشتراك هذا؟', 'نوع الاشتراك');
    }

    protected function setupCreateOperation()
    {
        CRUD::field('type_name')
            ->label('اسم الاشتراك')
            ->type('text')
            ->attributes(['required' => true]);

        CRUD::field('description')
            ->label('الوصف')
            ->type('textarea');

        CRUD::field('distribution_days')
            ->label('عدد الايام')
            ->type('number')
            ->attributes(['min' => 1]);
    }
    
    protected function setupShowOperation()
    {
        CRUD::column('type_name')
            ->label('اسم الاشتراك');
            
        CRUD::column('description')
            ->label('الوصف');
            
        CRUD::column('distribution_days')
            ->label('عدد الايام');

        
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
                'لا يمكن حذف نوع الاشتراك "' . $entry->type_name . '" لأن هناك ' . $clientsCount . ' عميل يستخدمونه. ' .
                'يرجى تغيير نوع الاشتراك لهؤلاء العملاء أولاً قبل الحذف.'
            )->flash();
            return redirect($this->crud->route);
        }

        // ✅ السماح بالحذف فقط إذا لم يكن هناك عملاء مربوطين
        $typeName = $entry->type_name; // حفظ الاسم قبل الحذف
        $entry->delete();
        
        // إضافة رسالة نجاح صحيحة
        \Alert::success('تم حذف نوع الاشتراك "' . $typeName . '" بنجاح.')->flash();
        
        // Redirect صحيح إلى قائمة الأنواع
        return redirect($this->crud->route);
    }
}