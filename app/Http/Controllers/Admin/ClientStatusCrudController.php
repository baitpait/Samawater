<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClientStatusRequest;
use App\Http\Controllers\Admin\Traits\HasUnifiedActionsDropdown;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ClientStatusCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ClientStatusCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use HasUnifiedActionsDropdown;

    /**
     * الإعدادات العامة
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\ClientStatus::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/client-status');
        CRUD::setEntityNameStrings('حالة العميل', 'حالات العملاء');
    }

    /**
     * قائمة العرض
     */
    protected function setupListOperation()
    {
        CRUD::column('status_name')
            ->label('اسم الحالة');

        CRUD::column('min_percentage')
            ->label('الحد الأدنى للنسبة')
            ->type('number')
            ->suffix('%');
            
         CRUD::column('max_percentage')
            ->label('الحد الأعلى للنسبة')
            ->type('number')
            ->suffix('%');
            
        // إضافة عمود الإجراءات الموحد
        $this->addUnifiedActionsColumn('client-status', 'هل أنت متأكد من حذف حالة العميل هذه؟', 'حالة العميل');
    }

    /**
     * صفحة الإضافة
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ClientStatusRequest::class);

        // اسم الحالة - كامل العرض
        CRUD::field('status_name')
            ->label('اسم الحالة')
            ->type('text')
            ->attributes([
                'placeholder' => 'مثال: نشط – متأخر – موقوف',
                'class' => 'form-control'
            ])
            ->wrapper([
                'class' => 'form-group col-12 mb-3'
            ]);

        // الحد الأدنى والأعلى للنسبة - في نفس السطر
        CRUD::field('min_percentage')
            ->label('الحد الأدنى للنسبة')
            ->type('number')
            ->prefix('%')
            ->attributes([
                'min' => 0,
                'max' => 100,
                'class' => 'form-control',
                'dir' => 'ltr',
                'style' => 'text-align: left;'
            ])
            ->wrapper([
                'class' => 'form-group col-12 col-md-6 mb-3'
            ]);
            
        CRUD::field('max_percentage')
            ->label('الحد الأعلى للنسبة')
            ->type('number')
            ->prefix('%')
            ->attributes([
                'min' => 0,
                'max' => 100,
                'class' => 'form-control',
                'dir' => 'ltr',
                'style' => 'text-align: left;'
            ])
            ->wrapper([
                'class' => 'form-group col-12 col-md-6 mb-3'
            ]);
    }
    
    
    protected function setupShowOperation()
    {
        CRUD::column('status_name')
            ->label('اسم الحالة');

        CRUD::column('min_percentage')
            ->label('الحد الأدنى للنسبة')
            ->type('number')
            ->suffix('%');
            
         CRUD::column('max_percentage')
            ->label('الحد الأعلى للنسبة')
            ->type('number')
            ->suffix('%');
    }
    
    /**
     * صفحة التعديل
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}