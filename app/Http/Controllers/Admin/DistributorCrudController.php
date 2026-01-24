<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DistributorRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class DistributorCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Distributor::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/distributor');
        CRUD::setEntityNameStrings('موزع', 'الموزعين');
    }

    protected function setupListOperation()
    {
        // تعطيل responsive table details row (إزالة النقاط الثلاث)
        // تفعيل scrollbar أفقي بدلاً من النقاط الثلاث
        CRUD::setOperationSetting('responsiveTable', false);
        CRUD::setOperationSetting('detailsRow', false);
        
        // تطبيق البحث
        if (request()->has('search') && request('search')) {
            $search = request('search');
            
            // التأكد من أن $search هو string وليس array
            if (is_array($search)) {
                $search = isset($search[0]) ? (string)$search[0] : '';
            } else {
                $search = (string)$search;
            }
            
            // تطبيق البحث فقط إذا كان $search غير فارغ
            if (!empty($search)) {
                CRUD::addClause(function ($query) use ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%')
                          ->orWhere('phone', 'like', '%' . $search . '%')
                          ->orWhere('username', 'like', '%' . $search . '%');
                    });
                });
            }
        }

        // إزالة جميع الأزرار الافتراضية من stack 'line'
        CRUD::removeButton('show');
        CRUD::removeButton('edit');
        CRUD::removeButton('delete');
        CRUD::removeButton('revisions');
        CRUD::removeButton('reorder');
        
        // تعطيل عمود الإجراءات الافتراضي تماماً
        CRUD::setOperationSetting('lineButtonsAsDropdown', false);
        
        // التأكد من عدم وجود أزرار في stack 'line' - هذا يمنع Backpack من إضافة عمود الإجراءات
        // لا نضيف أي أزرار في stack 'line' هنا

        // إضافة الأعمدة
        CRUD::addColumn([
            'name' => 'name',
            'label' => 'اسم الموزع',
        ]);

        CRUD::addColumn([
            'name' => 'phone',
            'label' => 'رقم الهاتف',
        ]);

        CRUD::addColumn([
            'name' => 'username',
            'label' => 'اسم المستخدم',
        ]);

        CRUD::addColumn([
            'name' => 'balance',
            'label' => 'الرصيد الحالي',
            'type' => 'number',
            'prefix' => '₪ ',
            'decimals' => 2,
        ]);

        // إضافة عمود الإجراءات المخصص مع dropdown (Bootstrap 5)
        CRUD::addColumn([
            'name'    => 'actions',
            'label'   => 'أجراءات',
            'type'    => 'custom_html',
            'escaped' => false,
            'orderable' => false,
            'searchable' => false,
            'value'   => function ($entry) {
                $showUrl = url(config('backpack.base.route_prefix').'/distributor/'.$entry->id.'/show');
                $editUrl = url(config('backpack.base.route_prefix').'/distributor/'.$entry->id.'/edit');
                $deleteUrl = url(config('backpack.base.route_prefix').'/distributor/'.$entry->id);
                $reportUrl = url(config('backpack.base.route_prefix').'/distributor/'.$entry->id.'/financial-report');
                $clientsUrl = url(config('backpack.base.route_prefix').'/distributor/'.$entry->id.'/clients');

                return '
                <div class="btn-group unified-actions-dropdown dropdown" style="position: relative;">
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="la la-cog"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="'.$showUrl.'">
                            <i class="la la-eye"></i> معاينة
                        </a></li>
                        <li><a class="dropdown-item" href="'.$editUrl.'">
                            <i class="la la-edit"></i> تعديل
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><button type="button" class="dropdown-item open-withdraw-modal" 
                                data-id="'.$entry->id.'" 
                                data-balance="'.$entry->balance.'">
                            <i class="la la-money-bill"></i> سحب
                        </button></li>
                        <li><a class="dropdown-item" href="'.$reportUrl.'">
                            <i class="la la-file-invoice-dollar"></i> التقرير المالي
                        </a></li>
                        <li><a class="dropdown-item" href="'.$clientsUrl.'">
                            <i class="la la-users"></i> العملاء
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="'.$deleteUrl.'" 
                           onclick="event.preventDefault(); if(confirm(\'هل أنت متأكد من حذف هذا الموزع؟\')) { document.getElementById(\'delete-form-'.$entry->id.'\').submit(); }">
                            <i class="la la-trash"></i> حذف
                        </a></li>
                        <form id="delete-form-'.$entry->id.'" action="'.$deleteUrl.'" method="POST" style="display: none;">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                        </form>
                    </ul>
                </div>';
            },
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(DistributorRequest::class);

        CRUD::addField([
            'name' => 'name',
            'label' => 'اسم الموزع',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name' => 'phone',
            'label' => 'رقم الهاتف',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name' => 'username',
            'label' => 'اسم المستخدم',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name'  => 'password_hash',
            'label' => 'كلمة المرور',
            'type'  => 'password',
            'attributes' => [
                'autocomplete' => 'new-password',
                'placeholder'  => 'اتركه فارغًا إذا لا تريد تغيير كلمة المرور',
            ],
        ]);

        CRUD::addField([
            'name' => 'status',
            'label' => 'الحالة',
            'type' => 'select_from_array',
            'options' => [
                1 => 'نشط',
                0 => 'معطل',
            ],
        ]);

        CRUD::addField([
            'name' => 'notes',
            'label' => 'ملاحظات',
            'type' => 'textarea',
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
        
        // في حالة التحديث، كلمة المرور اختيارية
        CRUD::modifyField('password_hash', [
            'attributes' => [
                'autocomplete' => 'new-password',
                'placeholder'  => 'اتركه فارغًا إذا لا تريد تغيير كلمة المرور',
            ],
        ]);
    }

    protected function setupShowOperation()
    {
        // استخدام view مخصص لصفحة show
        CRUD::setShowView('admin.distributor_show');
        
        CRUD::addColumn([
            'name' => 'name',
            'label' => 'اسم الموزع',
            'tab' => 'البيانات الأساسية',
        ]);

        CRUD::addColumn([
            'name' => 'phone',
            'label' => 'رقم الهاتف',
            'tab' => 'البيانات الأساسية',
        ]);

        CRUD::addColumn([
            'name' => 'username',
            'label' => 'اسم المستخدم',
            'tab' => 'البيانات الأساسية',
        ]);

        CRUD::addColumn([
            'name' => 'status',
            'label' => 'الحالة',
            'type' => 'select_from_array',
            'options' => [
                1 => 'نشط',
                0 => 'معطل',
            ],
            'tab' => 'البيانات الأساسية',
        ]);

        CRUD::addColumn([
            'name' => 'notes',
            'label' => 'ملاحظات',
            'type' => 'textarea',
            'tab' => 'البيانات الأساسية',
        ]);
    }

    /**
     * التحقق قبل الحذف
     */
    protected function setupDeleteOperation()
    {
        // التحقق من وجود عملاء مربوطين بهذا الموزع
        $this->crud->addClause('withCount', 'clients');
    }

    /**
     * تنفيذ الحذف مع التحقق
     * 
     * ⚠️ منع الحذف إذا كان هناك عملاء مربوطين بهذا الموزع
     */
    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        $entry = $this->crud->getEntry($id);

        // التحقق من وجود عملاء مربوطين بهذا الموزع
        $clientsCount = $entry->clients()->count();
        
        // ⚠️ منع الحذف إذا كان هناك عملاء مربوطين
        if ($clientsCount > 0) {
            \Alert::error(
                'لا يمكن حذف الموزع "' . $entry->name . '" لأن هناك ' . $clientsCount . ' عميل مربوطين به. ' .
                'يرجى تغيير الموزع لهؤلاء العملاء أولاً قبل الحذف.'
            )->flash();
            return redirect($this->crud->route);
        }

        // ✅ السماح بالحذف فقط إذا لم يكن هناك عملاء مربوطين
        $distributorName = $entry->name; // حفظ الاسم قبل الحذف
        $entry->delete();
        
        // إضافة رسالة نجاح صحيحة
        \Alert::success('تم حذف الموزع "' . $distributorName . '" بنجاح.')->flash();
        
        // Redirect صحيح إلى قائمة الموزعين
        return redirect($this->crud->route);
    }
}
