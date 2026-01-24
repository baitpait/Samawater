<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\InventoryItem;

/**
 * Business Purpose: إدارة المخزون (Inventory Items)
 * - جدول ديناميكي مستقل عن المصروفات
 * - يحتوي على: اسم الصنف والعدد فقط
 * - يتم تحديثه تلقائياً عند شراء مخزون عبر ExpenseCrudController
 */
class InventoryItemCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(InventoryItem::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/inventory-item');
        CRUD::setEntityNameStrings('صنف مخزون', 'المخزون');
    }

    protected function setupListOperation()
    {
        CRUD::column('item_name')
            ->label('اسم الصنف')
            ->type('text');
        
        CRUD::column('quantity')
            ->label('الكمية')
            ->type('number');
        
        // إزالة الأزرار الافتراضية
        CRUD::removeButton('show');
        CRUD::removeButton('edit');
        CRUD::removeButton('delete');
        
        // إضافة عمود الإجراءات المخصص
        CRUD::addColumn([
            'name' => 'actions',
            'label' => 'إجراءات',
            'type' => 'custom_html',
            'value' => function($entry) {
                $showUrl = backpack_url('inventory-item/' . $entry->id . '/show');
                $editUrl = backpack_url('inventory-item/' . $entry->id . '/edit');
                $deleteUrl = backpack_url('inventory-item/' . $entry->id);
                
                $html = '<div class="btn-group" role="group">';
                
                // زر المعاينة
                $html .= '<a href="' . $showUrl . '" class="btn btn-sm btn-link" title="معاينة">
                    <i class="la la-eye"></i>
                </a>';
                
                // زر التعديل
                $html .= '<a href="' . $editUrl . '" class="btn btn-sm btn-link" title="تعديل">
                    <i class="la la-edit"></i>
                </a>';
                
                // زر الحذف - مخفي للصنف id=1
                if ($entry->id != 1) {
                    $html .= '<a href="' . $deleteUrl . '" 
                        class="btn btn-sm btn-link text-danger" 
                        title="حذف"
                        onclick="return confirm(\'هل أنت متأكد من حذف هذا الصنف؟\')">
                        <i class="la la-trash"></i>
                    </a>';
                } else {
                    // للصنف id=1، نعرض رسالة توضيحية
                    $html .= '<span class="btn btn-sm btn-link text-muted" 
                        title="هذا الصنف محمي من الحذف (يستخدم في نظام التسليمات)"
                        style="cursor: not-allowed; opacity: 0.5;">
                        <i class="la la-lock"></i>
                    </span>';
                }
                
                $html .= '</div>';
                
                return $html;
            },
            'orderable' => false,
            'searchable' => false,
        ]);
        
        $this->crud->query->orderBy('item_name', 'asc');
    }

    protected function setupCreateOperation()
    {
        CRUD::field('item_name')
            ->label('اسم الصنف')
            ->type('text')
            ->attributes(['required' => true])
            ->hint('مثال: قوارير مياه، مواد خام، إلخ');
        
        CRUD::field('quantity')
            ->label('الكمية')
            ->type('number')
            ->attributes(['min' => 0, 'required' => true])
            ->default(0);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
        
        // منع تعديل الصنف id=1 (العبوات)
        $entry = $this->crud->getCurrentEntry();
        if ($entry && $entry->id == 1) {
            CRUD::field('item_name')
                ->attributes(['readonly' => 'readonly', 'disabled' => 'disabled'])
                ->hint('⚠️ هذا الصنف محمي من التعديل (يستخدم في نظام التسليمات)');
            
            CRUD::field('quantity')
                ->attributes(['readonly' => 'readonly', 'disabled' => 'disabled'])
                ->hint('⚠️ الكمية تُحدّث تلقائياً من خلال نظام التسليمات');
        }
    }

    /**
     * Business Purpose: منع حذف الصنف id=1 (العبوات)
     */
    public function destroy($id)
    {
        $entry = $this->crud->getCurrentEntry();
        
        if ($entry && $entry->id == 1) {
            \Alert::error('⚠️ لا يمكن حذف هذا الصنف لأنه محمي ويستخدم في نظام التسليمات.')->flash();
            return redirect($this->crud->route);
        }
        
        return parent::destroy($id);
    }
}
