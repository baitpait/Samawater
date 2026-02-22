<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\VendorPayment;
use App\Models\Vendor;
use App\Models\Expense;

/**
 * Business Purpose: إدارة مدفوعات الموردين (Vendor Payments)
 * - تسجيل جميع المدفوعات للموردين
 * - يمكن ربطها بمصروف معين أو مستقلة
 */
class VendorPaymentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(VendorPayment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/vendor-payment');
        CRUD::setEntityNameStrings('دفع مورد', 'مدفوعات الموردين');
    }

    protected function setupListOperation()
    {
        // Eager loading للعلاقات
        $this->crud->addClause('with', ['vendor', 'expense', 'creator']);
        
        // فلترة حسب معلمات الطلب (فلاتر صفحة القائمة)
        $this->crud->addClause(function ($query) {
            if (request()->filled('vendor_id')) {
                $query->where('vendor_id', request('vendor_id'));
            }
            if (request()->filled('method')) {
                $query->where('method', request('method'));
            }
            if (request()->filled('date_from')) {
                $query->whereDate('payment_date', '>=', request('date_from'));
            }
            if (request()->filled('date_to')) {
                $query->whereDate('payment_date', '<=', request('date_to'));
            }
        });
        
        CRUD::column('vendor')
            ->label('المورد')
            ->type('custom_html')
            ->value(function($entry) {
                return $entry->vendor ? e($entry->vendor->name) : '<span class="text-muted">-</span>';
            });
        
        CRUD::column('expense')
            ->label('المصروف')
            ->type('custom_html')
            ->value(function($entry) {
                if ($entry->expense) {
                    return '<span class="badge bg-info">#' . $entry->expense->id . '</span>';
                }
                return '<span class="text-muted">-</span>';
            });
        
        CRUD::column('amount')
            ->label('المبلغ')
            ->type('number')
            ->suffix(' شيكل')
            ->decimals(2);
        
        CRUD::column('method')
            ->label('طريقة الدفع')
            ->type('select_from_array')
            ->options([
                'cash' => 'نقدي',
                'bank_transfer' => 'تحويل بنكي',
                'check' => 'شيك',
                'credit_card' => 'بطاقة ائتمان',
                'other' => 'أخرى',
            ]);
        
        CRUD::column('payment_date')
            ->label('تاريخ الدفع')
            ->type('date');
        
        CRUD::column('reference_number')
            ->label('رقم المرجع')
            ->type('text');
        
        $this->crud->query->orderBy('payment_date', 'desc');
    }

    protected function setupCreateOperation()
    {
        CRUD::field('vendor_id')
            ->label('المورد')
            ->type('select')
            ->model('App\Models\Vendor')
            ->attribute('name')
            ->attributes(['required' => 'required'])
            ->options(function ($query) {
                return $query->where('is_active', true)->orderBy('name')->get();
            });
        
        CRUD::field('expense_id')
            ->label('المصروف (اختياري)')
            ->type('select')
            ->model('App\Models\Expense')
            ->attribute('id')
            ->options(function ($query) {
                return $query->orderBy('id', 'desc')->limit(100)->get();
            })
            ->hint('يمكن تركها فارغة إذا كانت المدفوعة مستقلة');
        
        CRUD::field('amount')
            ->label('المبلغ (شيكل)')
            ->type('number')
            ->attributes(['step' => '0.01', 'min' => '0.01', 'required' => true]);
        
        CRUD::field('method')
            ->label('طريقة الدفع')
            ->type('select_from_array')
            ->options([
                'cash' => 'نقدي',
                'bank_transfer' => 'تحويل بنكي',
                'check' => 'شيك',
                'credit_card' => 'بطاقة ائتمان',
                'other' => 'أخرى',
            ])
            ->default('cash');
        
        CRUD::field('payment_date')
            ->label('تاريخ الدفع')
            ->type('date')
            ->default(now()->format('Y-m-d'))
            ->attributes(['required' => true]);
        
        CRUD::field('reference_number')
            ->label('رقم المرجع')
            ->type('text')
            ->hint('رقم الشيك، رقم التحويل، إلخ');
        
        CRUD::field('notes')
            ->label('ملاحظات')
            ->type('textarea');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
}
