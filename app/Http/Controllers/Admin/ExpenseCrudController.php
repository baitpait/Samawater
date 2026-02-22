<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Vendor;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Business Purpose: إدارة المصروفات مع توزيعها التلقائي على الأشهر
 * - عند إنشاء مصروف، يتم توزيعه تلقائياً على الأشهر المحددة
 * - إذا كان الشهر المحدد قبل الشهر الحالي، يتم ترحيله تلقائياً
 */
class ExpenseCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(Expense::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/expense');
        CRUD::setEntityNameStrings('مصروف', 'المصروفات');
    }

    protected function setupListOperation()
    {
        // Eager loading للعلاقات لتجنب N+1 queries
        $this->crud->addClause('with', ['category', 'vendor', 'creator']);
        
        // التأكد من عدم وجود تكرار - عرض المصروفات فقط (ليس التوزيعات)
        $this->crud->addClause('orderBy', 'created_at', 'desc');
        
        // فلترة حسب معلمات الطلب (فلاتر صفحة القائمة)
        $this->crud->addClause(function ($query) {
            if (request()->filled('expense_category_id')) {
                $query->where('expense_category_id', request('expense_category_id'));
            }
            if (request()->filled('vendor_id')) {
                $query->where('vendor_id', request('vendor_id'));
            }
            if (request()->filled('payment_status')) {
                $query->where('payment_status', request('payment_status'));
            }
            if (request()->filled('date_from')) {
                $query->whereDate('payment_date', '>=', request('date_from'));
            }
            if (request()->filled('date_to')) {
                $query->whereDate('payment_date', '<=', request('date_to'));
            }
        });
        
        CRUD::column('category_name')
            ->label('الفئة')
            ->type('custom_html')
            ->value(function($entry) {
                return $entry->category ? e($entry->category->name) : '<span class="text-muted">-</span>';
            });
        
        CRUD::column('vendor')
            ->label('المورد')
            ->type('custom_html')
            ->value(function($entry) {
                return $entry->vendor ? e($entry->vendor->name) : '<span class="text-muted">-</span>';
            });
        
        CRUD::column('is_inventory')
            ->label('مخزون')
            ->type('boolean')
            ->options([0 => 'مصروف', 1 => 'مخزون']);
        
        CRUD::column('payment_status')
            ->label('حالة الدفع')
            ->type('select_from_array')
            ->options([
                'paid' => 'مدفوع',
                'partial' => 'جزئي',
                'unpaid' => 'غير مدفوع',
            ]);
        
        CRUD::column('total_amount')
            ->label('المبلغ الإجمالي')
            ->type('number')
            ->suffix(' شيكل')
            ->decimals(2);
        
        CRUD::column('number_of_months')
            ->label('عدد الأشهر')
            ->type('number')
            ->visible(function($entry) {
                return !$entry->is_inventory;
            });
        
        CRUD::column('monthly_amount')
            ->label('المبلغ الشهري')
            ->type('number')
            ->suffix(' شيكل')
            ->decimals(2)
            ->visible(function($entry) {
                return !$entry->is_inventory;
            });
        
        CRUD::column('start_month')
            ->label('الشهر الأول')
            ->type('date')
            ->format('Y-m')
            ->visible(function($entry) {
                return !$entry->is_inventory;
            });
        
        CRUD::column('payment_date')
            ->label('تاريخ الدفع')
            ->type('date');
        
        // إضافة عمود يعرض عدد التوزيعات المرحلة وغير المرحلة
        CRUD::column('allocations_summary')
            ->label('حالة التوزيع')
            ->type('custom_html')
            ->value(function($entry) {
                $total = $entry->monthlyAllocations()->count();
                $transferred = $entry->monthlyAllocations()->where('is_transferred', true)->count();
                $remaining = $total - $transferred;
                
                return '<div class="small">
                    <span class="badge bg-success">' . $transferred . ' مرحل</span>
                    <span class="badge bg-warning">' . $remaining . ' متبقي</span>
                </div>';
            });
        
        // عمود الملاحظات
        CRUD::column('notes')
            ->label('الملاحظات')
            ->type('custom_html')
            ->escaped(false)
            ->value(function($entry) {
                if (empty($entry->notes)) {
                    return '<span class="text-muted">-</span>';
                }
                $notes = e($entry->notes);
                if (mb_strlen($entry->notes) > 50) {
                    $notes = mb_substr($entry->notes, 0, 50) . '...';
                }
                return '<span title="' . e($entry->notes) . '">' . $notes . '</span>';
            });
        
        // إزالة الأزرار الافتراضية أولاً
        CRUD::removeButton('show');
        CRUD::removeButton('edit');
        CRUD::removeButton('delete');
        CRUD::removeButton('revisions');
        CRUD::removeButton('reorder');
        
        // تعطيل عمود الإجراءات الافتراضي
        CRUD::setOperationSetting('lineButtonsAsDropdown', false);
        
        // إضافة عمود الإجراءات مع dropdown menu
        CRUD::addColumn([
            'name' => 'actions',
            'label' => 'إجراءات',
            'type' => 'custom_html',
            'orderable' => false,
            'searchable' => false,
            'escaped' => false,
            'value' => function($entry) {
                $showUrl = backpack_url('expense/' . $entry->id . '/show');
                $editUrl = backpack_url('expense/' . $entry->id . '/edit');
                $deleteUrl = backpack_url('expense/' . $entry->id);
                
                return '
                <div class="btn-group unified-actions-dropdown" style="position: relative; z-index: 1000;">
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%); border: none; border-radius: 8px; padding: 6px 12px; font-weight: 600; box-shadow: 0 2px 8px rgba(111, 106, 248, 0.3);">
                        <i class="la la-cog"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" style="right: 0 !important; left: auto !important; direction: rtl !important; z-index: 10000; position: absolute;">
                        <a class="dropdown-item" href="'.$showUrl.'">
                            <i class="la la-eye"></i> معاينة
                        </a>
                        <a class="dropdown-item" href="'.$editUrl.'">
                            <i class="la la-edit"></i> تعديل
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="'.$deleteUrl.'" 
                           onclick="event.preventDefault(); if(confirm(\'هل أنت متأكد من حذف هذا المصروف وجميع التوزيعات الشهرية المرتبطة به؟\')) { document.getElementById(\'delete-form-'.$entry->id.'\').submit(); }">
                            <i class="la la-trash"></i> حذف
                        </a>
                        <form id="delete-form-'.$entry->id.'" action="'.$deleteUrl.'" method="POST" style="display: none;">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                        </form>
                    </div>
                </div>';
            }
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::field('expense_category_id')
            ->label('الفئة')
            ->type('select')
            ->model('App\Models\ExpenseCategory')
            ->attribute('name')
            ->attributes(['required' => 'required'])
            ->options(function ($query) {
                return $query->where('is_active', true)->orderBy('name')->get();
            });
        
        CRUD::field('vendor_id')
            ->label('المورد (اختياري)')
            ->type('select')
            ->model('App\Models\Vendor')
            ->attribute('name')
            ->options(function ($query) {
                return $query->where('is_active', true)->orderBy('name')->get();
            });
        
        CRUD::field('is_inventory')
            ->label('يترحل إلى المخزن')
            ->type('boolean')
            ->default(false)
            ->hint('إذا كان مخزون (مثل: قوارير مياه)، سيتم إضافة الكمية إلى المخزن')
            ->attributes(['id' => 'is_inventory_field']);
        
        // حقول المخزون (تظهر فقط عند is_inventory = true)
        // جلب جميع الأصناف من المخزن
        $inventoryItems = InventoryItem::orderBy('item_name', 'asc')->pluck('item_name', 'item_name')->toArray();
        // إضافة خيار "إضافة صنف جديد"
        $inventoryItems['__new__'] = '+ إضافة صنف جديد';
        
        CRUD::field('inventory_item_name')
            ->label('اسم الصنف')
            ->type('select_from_array')
            ->options($inventoryItems)
            ->wrapper(['class' => 'form-group col-md-6 inventory-field'])
            ->attributes(['id' => 'inventory_item_name_field', 'name' => 'inventory_item_name'])
            ->hint('اختر من الأصناف الموجودة أو اختر "إضافة صنف جديد"');
        
        // حقل إدخال اسم الصنف الجديد (يظهر فقط عند اختيار "إضافة صنف جديد")
        CRUD::field('new_inventory_item_name')
            ->label('اسم الصنف الجديد')
            ->type('text')
            ->wrapper(['class' => 'form-group col-md-6 inventory-new-field'])
            ->attributes(['id' => 'new_inventory_item_name_field', 'name' => 'new_inventory_item_name', 'placeholder' => 'أدخل اسم الصنف الجديد'])
            ->hint('يظهر فقط عند اختيار "إضافة صنف جديد"');
        
        CRUD::field('inventory_quantity')
            ->label('الكمية')
            ->type('number')
            ->attributes(['min' => 1, 'name' => 'inventory_quantity', 'id' => 'inventory_quantity_field'])
            ->wrapper(['class' => 'form-group col-md-6 inventory-field'])
            ->hint('عدد الوحدات المشتراة');
        
        CRUD::field('total_amount')
            ->label('المبلغ الإجمالي (شيكل)')
            ->type('number')
            ->attributes(['step' => '0.01', 'min' => '0.01', 'required' => true]);
        
        CRUD::field('number_of_months')
            ->label('عدد الأشهر للتوزيع')
            ->type('number')
            ->attributes(['min' => 1, 'required' => true])
            ->hint('سيتم تقسيم المبلغ الإجمالي على عدد الأشهر تلقائياً')
            ->wrapper(['class' => 'form-group col-md-6']);
        
        CRUD::field('start_month')
            ->label('الشهر الأول للتوزيع')
            ->type('date')
            ->attributes(['required' => true])
            ->default(Carbon::now()->format('Y-m-01'))
            ->wrapper(['class' => 'form-group col-md-6']);
        
        CRUD::field('payment_status')
            ->label('حالة الدفع')
            ->type('select_from_array')
            ->options([
                'unpaid' => 'غير مدفوع',
                'partial' => 'جزئي',
                'paid' => 'مدفوع',
            ])
            ->default('unpaid')
            ->attributes(['id' => 'payment_status_field']);
        
        // Quick Pay Fields (Synthetic)
        CRUD::field('amount_paid_now')
            ->label('المبلغ المدفوع الآن (شيكل)')
            ->type('number')
            ->attributes(['step' => '0.01', 'min' => '0'])
            ->wrapper(['class' => 'form-group col-md-6 quick-pay-field'])
            ->hint('يظهر فقط عند حالة "جزئي"')
            ->attributes(['id' => 'amount_paid_now_field']);
        
        CRUD::field('payment_method')
            ->label('طريقة الدفع')
            ->type('select_from_array')
            ->options([
                'cash' => 'نقدي',
                'bank_transfer' => 'تحويل بنكي',
                'check' => 'شيك',
                'credit_card' => 'بطاقة ائتمان',
                'other' => 'أخرى',
            ])
            ->default('cash')
            ->wrapper(['class' => 'form-group col-md-6 quick-pay-field'])
            ->attributes(['id' => 'payment_method_field']);
        
        CRUD::field('payment_date')
            ->label('تاريخ الدفع الفعلي')
            ->type('date')
            ->attributes(['required' => true])
            ->default(Carbon::now()->format('Y-m-d'));
        
        CRUD::field('notes')
            ->label('ملاحظات')
            ->type('textarea');
        
        // JavaScript for conditional field visibility
        $this->crud->addField([
            'name' => 'conditional_fields_script',
            'type' => 'custom_html',
            'value' => '
            <script>
            document.addEventListener("DOMContentLoaded", function() {
                const paymentStatusField = document.getElementById("payment_status_field");
                const isInventoryField = document.getElementById("is_inventory_field") || document.querySelector("input[name=\'is_inventory\']");
                const inventoryFields = document.querySelectorAll(".inventory-field");
                
                function toggleQuickPayFields() {
                    const status = paymentStatusField ? paymentStatusField.value : "unpaid";
                    const quickPayFields = document.querySelectorAll(".quick-pay-field");
                    
                    quickPayFields.forEach(field => {
                        const parent = field.closest(".form-group");
                        if (parent) {
                            if (status === "paid") {
                                // Show only method, hide amount
                                if (field.querySelector("#amount_paid_now_field")) {
                                    parent.style.display = "none";
                                } else if (field.querySelector("#payment_method_field")) {
                                    parent.style.display = "block";
                                }
                            } else if (status === "partial") {
                                // Show both
                                parent.style.display = "block";
                            } else {
                                // Hide both
                                parent.style.display = "none";
                            }
                        }
                    });
                }
                
                function toggleInventoryFields() {
                    let isInventory = false;
                    if (isInventoryField) {
                        if (isInventoryField.type === "checkbox") {
                            isInventory = isInventoryField.checked;
                        } else {
                            isInventory = isInventoryField.value === "1" || isInventoryField.value === "on";
                        }
                    }
                    
                    // إظهار/إخفاء حقول المخزون
                    inventoryFields.forEach(field => {
                        let parent = field.closest(".form-group");
                        if (!parent) {
                            parent = field.parentElement;
                        }
                        if (parent) {
                            if (isInventory) {
                                parent.style.display = "block";
                                parent.style.visibility = "visible";
                                parent.removeAttribute("hidden");
                            } else {
                                parent.style.display = "none";
                                parent.style.visibility = "hidden";
                            }
                        }
                    });
                    
                    // Make inventory fields required only if is_inventory = true
                    const itemNameField = document.getElementById("inventory_item_name_field") || document.querySelector("select[name=\'inventory_item_name\']") || document.querySelector("input[name=\'inventory_item_name\']");
                    const quantityField = document.getElementById("inventory_quantity_field") || document.querySelector("input[name=\'inventory_quantity\']");
                    
                    if (itemNameField) {
                        itemNameField.required = isInventory;
                        if (!isInventory) {
                            itemNameField.value = "";
                        }
                    }
                    if (quantityField) {
                        quantityField.required = isInventory;
                        if (!isInventory) {
                            quantityField.value = "";
                        }
                    }
                }
                
                function toggleNewItemField() {
                    const itemNameField = document.getElementById("inventory_item_name_field") || document.querySelector("select[name=\'inventory_item_name\']");
                    const newItemFields = document.querySelectorAll(".inventory-new-field");
                    const isNewItem = itemNameField && itemNameField.value === "__new__";
                    
                    newItemFields.forEach(field => {
                        let parent = field.closest(".form-group");
                        if (parent) {
                            if (isNewItem) {
                                parent.style.display = "block";
                            } else {
                                parent.style.display = "none";
                            }
                        }
                    });
                    
                    // Make new item name required only if "__new__" is selected
                    const newItemNameField = document.getElementById("new_inventory_item_name_field");
                    if (newItemNameField) {
                        newItemNameField.required = isNewItem;
                        if (!isNewItem) {
                            newItemNameField.value = "";
                        }
                    }
                }
                
                if (paymentStatusField) {
                    paymentStatusField.addEventListener("change", toggleQuickPayFields);
                }
                if (isInventoryField) {
                    isInventoryField.addEventListener("change", toggleInventoryFields);
                    isInventoryField.addEventListener("click", toggleInventoryFields);
                }
                
                // Listen to inventory item name change (for dropdown)
                setTimeout(function() {
                    const itemNameField = document.getElementById("inventory_item_name_field") || document.querySelector("select[name=\'inventory_item_name\']");
                    if (itemNameField) {
                        itemNameField.addEventListener("change", toggleNewItemField);
                    }
                }, 200);
                
                // Initial state
                setTimeout(function() {
                    toggleQuickPayFields();
                    toggleInventoryFields();
                    toggleNewItemField();
                }, 100);
            });
            </script>
            '
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /**
     * Store a newly created resource in storage.
     * 
     * Business Purpose: إنشاء مصروف جديد مع توزيعه تلقائياً على الأشهر
     * - دعم Inventory vs Amortization
     * - Quick Pay: إنشاء VendorPayment تلقائياً إذا كان هناك payment details
     */
    public function store(Request $request)
    {
        $isInventory = $request->boolean('is_inventory');
        
        $rules = [
            'expense_category_id' => 'required|exists:expense_categories,id',
            'total_amount' => 'required|numeric|min:0.01',
            'payment_status' => 'required|in:paid,partial,unpaid',
            'payment_date' => 'required|date',
            'number_of_months' => 'required|integer|min:1',
            'start_month' => 'required|date',
        ];
        
        // Inventory fields required only if is_inventory = true
        if ($isInventory) {
            $rules['inventory_item_name'] = 'required';
            $rules['inventory_quantity'] = 'required|integer|min:1';
            
            // إذا كان "__new__" محدد، يجب إدخال اسم الصنف الجديد
            if ($request->inventory_item_name === '__new__') {
                $rules['new_inventory_item_name'] = 'required|string|max:255|unique:inventory_items,item_name';
            }
        }
        
        // Quick Pay validation
        if ($request->payment_status === 'partial') {
            $rules['amount_paid_now'] = 'required|numeric|min:0.01|max:' . $request->total_amount;
            $rules['payment_method'] = 'required|in:cash,bank_transfer,check,credit_card,other';
        } elseif ($request->payment_status === 'paid') {
            $rules['payment_method'] = 'required|in:cash,bank_transfer,check,credit_card,other';
        }
        
        $request->validate($rules);

        // حساب المبلغ الشهري والشهر الأخير (دائماً متاح)
        $monthlyAmount = $request->total_amount / $request->number_of_months;
        $startMonth = Carbon::parse($request->start_month);
        $endMonth = $startMonth->copy()->addMonths($request->number_of_months - 1)->format('Y-m-01');

        // إنشاء المصروف
        $expenseData = [
            'expense_category_id' => $request->expense_category_id,
            'vendor_id' => $request->vendor_id,
            'is_inventory' => $isInventory,
            'payment_status' => $request->payment_status,
            'total_amount' => $request->total_amount,
            'number_of_months' => $request->number_of_months,
            'monthly_amount' => $monthlyAmount,
            'start_month' => $request->start_month,
            'end_month' => $endMonth,
            'payment_date' => $request->payment_date,
            'notes' => $request->notes,
            'created_by' => auth()->id(),
        ];
        
        $expense = Expense::create($expenseData);

        // إنشاء التوزيعات الشهرية (دائماً متاح)
        for ($i = 0; $i < $request->number_of_months; $i++) {
            $month = $startMonth->copy()->addMonths($i)->format('Y-m-01');
            
            $expense->monthlyAllocations()->create([
                'month' => $month,
                'amount' => $monthlyAmount,
                'is_transferred' => true,
                'transferred_at' => now(),
            ]);
        }

        // تحديث المخزون (فقط إذا كان is_inventory = true)
        if ($isInventory && $request->inventory_quantity) {
            // تحديد اسم الصنف (من القائمة أو من الحقل الجديد)
            $itemName = $request->inventory_item_name;
            if ($itemName === '__new__' && $request->new_inventory_item_name) {
                $itemName = $request->new_inventory_item_name;
            }
            
            if ($itemName && $itemName !== '__new__') {
                InventoryItem::addQuantity(
                    $itemName,
                    (int)$request->inventory_quantity
                );
            }
        }

        // Quick Pay: إنشاء VendorPayment تلقائياً إذا كان هناك payment details
        if ($expense->vendor_id && in_array($request->payment_status, ['paid', 'partial'])) {
            $paymentAmount = $request->payment_status === 'paid' 
                ? $request->total_amount 
                : ($request->amount_paid_now ?? 0);
            
            if ($paymentAmount > 0) {
                $expense->vendorPayments()->create([
                    'vendor_id' => $expense->vendor_id,
                    'amount' => $paymentAmount,
                    'method' => $request->payment_method ?? 'cash',
                    'payment_date' => $request->payment_date,
                    'created_by' => auth()->id(),
                ]);
            }
        }

        $message = $isInventory 
            ? 'تم إنشاء المصروف (مخزون) بنجاح.'
            : 'تم إنشاء المصروف وتوزيعه على ' . $request->number_of_months . ' شهر بنجاح.';
        
        \Alert::success($message)->flash();
        
        return redirect($this->crud->route);
    }

    /**
     * Update the specified resource in storage.
     * 
     * Business Purpose: تحديث مصروف موجود مع إعادة إنشاء التوزيعات الشهرية
     * - دعم Inventory vs Amortization
     * - Quick Pay: إنشاء VendorPayment تلقائياً إذا كان هناك payment details
     */
    public function update(Request $request)
    {
        try {
            $expense = $this->crud->getCurrentEntry();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Alert::error('المصروف غير موجود.')->flash();
            return redirect($this->crud->route);
        }
        
        if (!$expense) {
            \Alert::error('المصروف غير موجود.')->flash();
            return redirect($this->crud->route);
        }

        $isInventory = $request->boolean('is_inventory');
        
        $rules = [
            'expense_category_id' => 'required|exists:expense_categories,id',
            'total_amount' => 'required|numeric|min:0.01',
            'payment_status' => 'required|in:paid,partial,unpaid',
            'payment_date' => 'required|date',
            'number_of_months' => 'required|integer|min:1',
            'start_month' => 'required|date',
        ];
        
        // Inventory fields required only if is_inventory = true
        if ($isInventory) {
            $rules['inventory_item_name'] = 'required';
            $rules['inventory_quantity'] = 'required|integer|min:1';
            
            // إذا كان "__new__" محدد، يجب إدخال اسم الصنف الجديد
            if ($request->inventory_item_name === '__new__') {
                $rules['new_inventory_item_name'] = 'required|string|max:255|unique:inventory_items,item_name';
            }
        }
        
        // Quick Pay validation
        if ($request->payment_status === 'partial') {
            $rules['amount_paid_now'] = 'required|numeric|min:0.01|max:' . $request->total_amount;
            $rules['payment_method'] = 'required|in:cash,bank_transfer,check,credit_card,other';
        } elseif ($request->payment_status === 'paid') {
            $rules['payment_method'] = 'required|in:cash,bank_transfer,check,credit_card,other';
        }
        
        $request->validate($rules);

        // حساب المبلغ الشهري والشهر الأخير (دائماً متاح)
        $monthlyAmount = $request->total_amount / $request->number_of_months;
        $startMonth = Carbon::parse($request->start_month);
        $endMonth = $startMonth->copy()->addMonths($request->number_of_months - 1)->format('Y-m-01');

        // تحديث بيانات المصروف
        $expenseData = [
            'expense_category_id' => $request->expense_category_id,
            'vendor_id' => $request->vendor_id,
            'is_inventory' => $isInventory,
            'payment_status' => $request->payment_status,
            'total_amount' => $request->total_amount,
            'number_of_months' => $request->number_of_months,
            'monthly_amount' => $monthlyAmount,
            'start_month' => $request->start_month,
            'end_month' => $endMonth,
            'payment_date' => $request->payment_date,
            'notes' => $request->notes,
        ];
        
        $expense->update($expenseData);

        // حذف التوزيعات القديمة وإعادة إنشائها (دائماً متاح)
        $expense->monthlyAllocations()->delete();
        
        for ($i = 0; $i < $request->number_of_months; $i++) {
            $month = $startMonth->copy()->addMonths($i)->format('Y-m-01');
            
            $expense->monthlyAllocations()->create([
                'month' => $month,
                'amount' => $monthlyAmount,
                'is_transferred' => true,
                'transferred_at' => now(),
            ]);
        }

        // تحديث المخزون (فقط إذا كان is_inventory = true)
        if ($isInventory && $request->inventory_quantity) {
            // تحديد اسم الصنف (من القائمة أو من الحقل الجديد)
            $itemName = $request->inventory_item_name;
            if ($itemName === '__new__' && $request->new_inventory_item_name) {
                $itemName = $request->new_inventory_item_name;
            }
            
            if ($itemName && $itemName !== '__new__') {
                InventoryItem::addQuantity(
                    $itemName,
                    (int)$request->inventory_quantity
                );
            }
        }

        // Quick Pay: إنشاء VendorPayment تلقائياً إذا كان هناك payment details
        if ($expense->vendor_id && in_array($request->payment_status, ['paid', 'partial'])) {
            $paymentAmount = $request->payment_status === 'paid' 
                ? $request->total_amount 
                : ($request->amount_paid_now ?? 0);
            
            if ($paymentAmount > 0) {
                // تحقق إذا كان هناك دفع موجود بالفعل لهذا المصروف
                $existingPayment = $expense->vendorPayments()
                    ->where('payment_date', $request->payment_date)
                    ->first();
                
                if ($existingPayment) {
                    // تحديث الدفع الموجود
                    $existingPayment->update([
                        'amount' => $paymentAmount,
                        'method' => $request->payment_method ?? 'cash',
                    ]);
                } else {
                    // إنشاء دفع جديد
                    $expense->vendorPayments()->create([
                        'vendor_id' => $expense->vendor_id,
                        'amount' => $paymentAmount,
                        'method' => $request->payment_method ?? 'cash',
                        'payment_date' => $request->payment_date,
                        'created_by' => auth()->id(),
                    ]);
                }
            }
        }

        $message = $isInventory 
            ? 'تم تحديث المصروف (مخزون) بنجاح.'
            : 'تم تحديث المصروف وإعادة توزيعه على ' . $request->number_of_months . ' شهر بنجاح.';
        
        \Alert::success($message)->flash();
        
        return redirect($this->crud->route);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * Business Purpose: حذف مصروف مع جميع التوزيعات الشهرية المرتبطة به
     * - عند الحذف، يتم حذف المصروف وجميع التوزيعات الشهرية تلقائياً (CASCADE)
     * - Foreign Key constraint يضمن حذف التوزيعات تلقائياً من قاعدة البيانات
     */
    public function destroy($id)
    {
        try {
            // جلب المصروف المطلوب حذفه
            $expense = $this->crud->getCurrentEntry();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Alert::error('المصروف غير موجود.')->flash();
            return redirect($this->crud->route);
        }
        
        if (!$expense) {
            \Alert::error('المصروف غير موجود.')->flash();
            return redirect($this->crud->route);
        }

        // حساب عدد التوزيعات قبل الحذف (للعرض في الرسالة)
        $allocationsCount = $expense->monthlyAllocations()->count();
        
        // حذف المصروف (سيتم حذف التوزيعات تلقائياً بسبب CASCADE)
        $expense->delete();

        \Alert::success('تم حذف المصروف و ' . $allocationsCount . ' توزيع شهري بنجاح.')->flash();
        
        return redirect($this->crud->route);
    }
}
