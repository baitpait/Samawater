<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ExpenseBeneficiaryRequest;
use App\Models\ExpenseBeneficiary;
use App\Models\ExpenseCategory;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Business Purpose: إدارة أصحاب المصروف (علي، كازية الجنوب، …) مرتبطين بفئات المصروف.
 */
class ExpenseBeneficiaryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup(): void
    {
        CRUD::setModel(ExpenseBeneficiary::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/expense-beneficiary');
        CRUD::setEntityNameStrings('صاحب مصروف', 'أصحاب المصروف');
    }

    protected function setupListOperation(): void
    {
        $this->crud->addClause('with', ['vendor', 'category']);

        CRUD::column('name')->label('الاسم')->type('text');

        CRUD::column('expense_category_id')
            ->label('فئة المصروف')
            ->type('select')
            ->entity('category')
            ->attribute('name')
            ->model(ExpenseCategory::class);

        CRUD::addColumn([
            'name' => 'vendor_name',
            'label' => 'مورد مرتبط',
            'type' => 'custom_html',
            'escaped' => false,
            'value' => static function ($entry): string {
                if (! $entry->vendor) {
                    return '<span class="text-muted">—</span>';
                }

                return '<span class="badge bg-light text-dark border">'.e($entry->vendor->name).'</span>';
            },
        ]);
        CRUD::column('is_active')->label('نشط')->type('boolean');
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(ExpenseBeneficiaryRequest::class);

        CRUD::field('expense_category_id')
            ->label('فئة المصروف')
            ->type('select')
            ->model(ExpenseCategory::class)
            ->attribute('name')
            ->attributes(['required' => 'required'])
            ->options(function ($query) {
                return $query->where('is_active', true)->orderBy('name')->get();
            })
            ->hint('نفس الفئات المُدارة من «فئات المصروفات» — مثل: راتب، سولار');

        CRUD::field('name')
            ->label('الاسم')
            ->type('text')
            ->attributes(['required' => true])
            ->hint('مثال: علي للراتب، كازية الجنوب للسولار');

        CRUD::field('is_active')->label('نشط')->type('boolean')->default(true);
        CRUD::field('notes')->label('ملاحظات')->type('textarea');
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
