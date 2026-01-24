<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SubscriptionStatusRequest;
use App\Http\Controllers\Admin\Traits\HasUnifiedActionsDropdown;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class SubscriptionStatusCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use HasUnifiedActionsDropdown;
    
    public function setup()
    {
        CRUD::setModel(\App\Models\SubscriptionStatus::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/subscription-status');
        CRUD::setEntityNameStrings('حالة اشتراك', 'حالات الاشتراكات');
    }

    protected function setupListOperation()
    {
        CRUD::column('status_name')->label('اسم الحالة');
        
        // إضافة عمود الإجراءات الموحد
        $this->addUnifiedActionsColumn('subscription-status', 'هل أنت متأكد من حذف حالة الاشتراك هذه؟', 'حالة الاشتراك');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(SubscriptionStatusRequest::class);

        CRUD::field('status_name')
            ->label('اسم الحالة')
            ->type('text')
            ->attributes([
                'required' => true,
                'placeholder' => 'مثال: نشط، موقوف، منتهي',
                'class' => 'form-control'
            ])
            ->wrapper([
                'class' => 'form-group col-12 mb-3'
            ]);
    }
    
    protected function setupShowOperation()
    {
        CRUD::column('status_name')
            ->label('اسم الحالة');

     
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
        // التحقق من وجود عملاء يستخدمون هذه الحالة
        $this->crud->addClause('withCount', 'clients');
    }

    /**
     * تنفيذ الحذف مع التحقق
     * 
     * ⚠️ منع الحذف إذا كان هناك عملاء مربوطين بهذه الحالة
     */
    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        $entry = $this->crud->getEntry($id);

        // التحقق من وجود عملاء يستخدمون هذه الحالة
        $clientsCount = $entry->clients()->count();
        
        // ⚠️ منع الحذف إذا كان هناك عملاء مربوطين
        if ($clientsCount > 0) {
            \Alert::error(
                'لا يمكن حذف حالة الاشتراك "' . $entry->status_name . '" لأن هناك ' . $clientsCount . ' عميل يستخدمونها. ' .
                'يرجى تغيير حالة هؤلاء العملاء أولاً قبل الحذف.'
            )->flash();
            return redirect($this->crud->route);
        }

        // ✅ السماح بالحذف فقط إذا لم يكن هناك عملاء مربوطين
        $statusName = $entry->status_name; // حفظ الاسم قبل الحذف
        $entry->delete();
        
        // إضافة رسالة نجاح صحيحة
        \Alert::success('تم حذف حالة الاشتراك "' . $statusName . '" بنجاح.')->flash();
        
        // Redirect صحيح إلى قائمة الحالات
        return redirect($this->crud->route);
    }
}