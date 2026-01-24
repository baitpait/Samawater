<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VendorRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class VendorCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class VendorCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Vendor::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/vendor');
        CRUD::setEntityNameStrings('مورد', 'الموردين');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // Eager loading للعلاقات
        $this->crud->addClause('with', ['expenses', 'payments']);
        
        CRUD::column('name')
            ->label('اسم المورد')
            ->type('text');
        
        CRUD::column('phone')
            ->label('الهاتف')
            ->type('text');
        
        CRUD::column('email')
            ->label('البريد الإلكتروني')
            ->type('email');
        
        CRUD::column('opening_balance')
            ->label('الرصيد الافتتاحي')
            ->type('number')
            ->suffix(' شيكل')
            ->decimals(2);
        
        // حساب الرصيد الحالي
        CRUD::column('current_balance')
            ->label('الرصيد الحالي')
            ->type('custom_html')
            ->value(function($entry) {
                $balance = $entry->balance;
                $color = $balance >= 0 ? 'text-success' : 'text-danger';
                return '<span class="' . $color . ' font-weight-bold">' . number_format($balance, 2) . ' شيكل</span>';
            });
        
        CRUD::column('is_active')
            ->label('نشط')
            ->type('boolean')
            ->options([0 => 'غير نشط', 1 => 'نشط']);
        
        $this->crud->query->orderBy('name', 'asc');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(VendorRequest::class);
        
        CRUD::field('name')
            ->label('اسم المورد')
            ->type('text')
            ->attributes(['required' => true]);
        
        CRUD::field('phone')
            ->label('الهاتف')
            ->type('text');
        
        CRUD::field('email')
            ->label('البريد الإلكتروني')
            ->type('email');
        
        CRUD::field('address')
            ->label('العنوان')
            ->type('textarea');
        
        CRUD::field('opening_balance')
            ->label('الرصيد الافتتاحي (شيكل)')
            ->type('number')
            ->attributes(['step' => '0.01', 'default' => 0])
            ->default(0)
            ->hint('الرصيد الافتتاحي للمورد (يمكن أن يكون مدين أو دائن)');
        
        CRUD::field('notes')
            ->label('ملاحظات')
            ->type('textarea');
        
        CRUD::field('is_active')
            ->label('نشط')
            ->type('boolean')
            ->default(true);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
