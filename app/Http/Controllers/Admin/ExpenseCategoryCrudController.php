<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ExpenseCategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ExpenseCategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ExpenseCategoryCrudController extends CrudController
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
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * Business Purpose: إعداد CRUD لفئات المصروفات
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\ExpenseCategory::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/expense-category');
        CRUD::setEntityNameStrings('فئة مصروف', 'فئات المصروفات');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name')
            ->label('اسم الفئة')
            ->type('text');
        
        CRUD::column('description')
            ->label('الوصف')
            ->type('text');
        
        CRUD::column('is_active')
            ->label('نشط')
            ->type('boolean')
            ->options([0 => 'غير نشط', 1 => 'نشط']);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ExpenseCategoryRequest::class);

        CRUD::field('name')
            ->label('اسم الفئة')
            ->type('text')
            ->attributes(['required' => true]);
        
        CRUD::field('description')
            ->label('الوصف')
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
