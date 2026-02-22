<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\ClientDeposit;
use App\Models\ClientDepositItem;
use App\Models\Client;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * Business Purpose: إدارة أمانات العملاء
 * - أصناف معارة للعملاء من المخزون
 * - بدون سعر (كمية فقط)
 * - يتم خصمها من المخزون عند الإعارة
 * - يتم إرجاعها للمخزون عند السحب
 */
class ClientDepositCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(ClientDeposit::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/client-deposit');
        CRUD::setEntityNameStrings('أمانة عميل', 'أمانات العملاء');
        $this->crud->addClause('with', ['client', 'creator', 'items']);
    }

    protected function setupListOperation()
    {
        CRUD::column('client.name')
            ->label('العميل')
            ->type('text');
        
        CRUD::column('items_summary')
            ->label('الأصناف')
            ->type('custom_html')
            ->value(function($entry) {
                $items = $entry->items;
                if ($items->count() > 0) {
                    $html = '<ul style="margin: 0; padding-right: 20px;">';
                    foreach ($items as $item) {
                        $html .= '<li>' . $item->item_name . ' (' . $item->quantity . ')</li>';
                    }
                    $html .= '</ul>';
                    return $html;
                }
                return '-';
            })
            ->wrapper(['style' => 'min-width: 300px;']);
        
        CRUD::column('date_given')
            ->label('تاريخ الإعارة')
            ->type('date');
        
        // زر سحب لكل صنف
        CRUD::column('withdraw_action')
            ->label('الإجراءات')
            ->type('custom_html')
            ->value(function($entry) {
                if (!$entry->is_withdrawn) {
                    $withdrawUrl = route('client-deposit.withdraw', ['id' => $entry->id]);
                    return '<a href="' . $withdrawUrl . '" 
                             class="btn btn-sm btn-warning" 
                             onclick="return confirm(\'هل تريد سحب هذه الأمانة وإرجاعها للمخزون؟\');">
                             <i class="la la-undo"></i> سحب
                           </a>';
                } else {
                    $withdrawnDate = $entry->withdrawn_at ? $entry->withdrawn_at->format('Y-m-d H:i') : '-';
                    return '<span class="badge bg-secondary">تم السحب في ' . $withdrawnDate . '</span>';
                }
            });
        
        // زر سحب كل الأمانات (يظهر في أعلى الصفحة)
        $this->crud->addButtonFromView('top', 'withdraw_all', 'backpack::crud.buttons.withdraw_all', 'end');

        // فلترة حسب معلمات الطلب (بدون Backpack PRO)
        $this->crud->addClause(function ($query) {
            if (request()->filled('client_id')) {
                $query->where('client_id', request('client_id'));
            }
            if (request()->filled('date_from')) {
                $query->whereDate('date_given', '>=', request('date_from'));
            }
            if (request()->filled('date_to')) {
                $query->whereDate('date_given', '<=', request('date_to'));
            }
            if (request()->filled('status')) {
                if (request('status') === 'withdrawn') {
                    $query->where('is_withdrawn', true);
                } elseif (request('status') === 'active') {
                    $query->where('is_withdrawn', false);
                }
            }
        });
    }

    protected function setupCreateOperation()
    {
        // جلب جميع العملاء للقائمة المنسدلة
        $clients = Client::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        
        CRUD::field('client_id')
            ->label('العميل')
            ->type('select_from_array')
            ->options($clients)
            ->attributes(['required' => 'required'])
            ->default(request()->get('client_id'))
            ->hint('اختر العميل');
        
        CRUD::field('date_given')
            ->label('تاريخ الإعارة')
            ->type('date')
            ->attributes(['required' => true])
            ->default(Carbon::now()->format('Y-m-d'));
        
        // Repeater للأصناف
        CRUD::field('items_repeater')
            ->type('custom_html')
            ->value(view('admin.client_deposits.items_repeater')->render());
        
        CRUD::field('notes')
            ->label('ملاحظات')
            ->type('textarea');
        
        CRUD::field('created_by')
            ->type('hidden')
            ->default(auth()->id());
    }

    protected function setupUpdateOperation()
    {
        // جلب جميع العملاء للقائمة المنسدلة
        $clients = Client::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        
        $deposit = $this->crud->getCurrentEntry();
        
        // منع تعديل الأمانات المسحوبة
        if ($deposit && $deposit->is_withdrawn) {
            CRUD::field('is_withdrawn_info')
                ->type('custom_html')
                ->value('<div class="alert alert-warning">هذه الأمانة تم سحبها في ' . $deposit->withdrawn_at->format('Y-m-d H:i') . ' ولا يمكن تعديلها.</div>');
            return;
        }
        
        CRUD::field('client_id')
            ->label('العميل')
            ->type('select_from_array')
            ->options($clients)
            ->attributes(['required' => 'required'])
            ->default($deposit ? $deposit->client_id : null)
            ->hint('اختر العميل');
        
        CRUD::field('date_given')
            ->label('تاريخ الإعارة')
            ->type('date')
            ->attributes(['required' => true])
            ->default($deposit ? $deposit->date_given->format('Y-m-d') : Carbon::now()->format('Y-m-d'));
        
        // Repeater للأصناف مع البيانات الموجودة
        CRUD::field('items_repeater')
            ->type('custom_html')
            ->value(view('admin.client_deposits.items_repeater', ['deposit' => $deposit])->render());
        
        CRUD::field('notes')
            ->label('ملاحظات')
            ->type('textarea')
            ->default($deposit ? $deposit->notes : null);
        
        CRUD::field('created_by')
            ->type('hidden')
            ->default(auth()->id());
    }

    /**
     * Business Purpose: تخصيص صفحة المعاينة لعرض الأصناف على شكل جدول مع أزرار السحب
     */
    protected function setupShowOperation()
    {
        // استخدام view مخصص
        CRUD::setShowView('admin.client_deposits.show');
        
        CRUD::column('client.name')
            ->label('العميل');
        
        CRUD::column('date_given')
            ->label('تاريخ الإعارة')
            ->type('date');
        
        CRUD::column('is_withdrawn')
            ->label('الحالة')
            ->type('boolean')
            ->options([
                0 => 'معارة',
                1 => 'مسحوبة',
            ]);
        
        CRUD::column('withdrawn_at')
            ->label('تاريخ السحب')
            ->type('datetime')
            ->format('Y-m-d H:i');
        
        CRUD::column('notes')
            ->label('ملاحظات')
            ->type('textarea');
        
        CRUD::column('creator.name')
            ->label('أنشأ بواسطة');
    }

    /**
     * Business Purpose: حفظ أمانة جديدة وخصم الكميات من المخزون
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'date_given' => 'required|date',
        ]);

        // التحقق من وجود جميع الكميات في المخزون
        foreach ($request->items as $item) {
            $inventoryItem = InventoryItem::where('item_name', $item['item_name'])->first();
            if (!$inventoryItem || $inventoryItem->quantity < $item['quantity']) {
                \Alert::error('الكمية المطلوبة غير متوفرة في المخزون للصنف: ' . $item['item_name'] . '. الكمية المتاحة: ' . ($inventoryItem ? $inventoryItem->quantity : 0))->flash();
                return redirect()->back()->withInput();
            }
        }

        // إنشاء الأمانة
        $deposit = ClientDeposit::create([
            'client_id' => $request->client_id,
            'date_given' => $request->date_given,
            'notes' => $request->notes,
            'created_by' => auth()->id(),
        ]);

        // إضافة الأصناف وخصم الكميات من المخزون
        foreach ($request->items as $item) {
            ClientDepositItem::create([
                'client_deposit_id' => $deposit->id,
                'item_name' => $item['item_name'],
                'quantity' => $item['quantity'],
            ]);
            
            // خصم الكمية من المخزون
            InventoryItem::subtractQuantity($item['item_name'], $item['quantity']);
        }

        \Alert::success('تم إنشاء الأمانة بنجاح وتم خصم الكميات من المخزون.')->flash();
        return redirect($this->crud->route);
    }

    /**
     * Business Purpose: تحديث أمانة (فقط إذا لم تكن مسحوبة)
     */
    public function update(Request $request)
    {
        $deposit = $this->crud->getCurrentEntry();
        
        if (!$deposit) {
            \Alert::error('الأمانة غير موجودة.')->flash();
            return redirect($this->crud->route);
        }

        if ($deposit->is_withdrawn) {
            \Alert::error('لا يمكن تعديل أمانة مسحوبة.')->flash();
            return redirect($this->crud->route);
        }

        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'date_given' => 'required|date',
        ]);

        // إرجاع جميع الكميات القديمة للمخزون
        foreach ($deposit->items as $oldItem) {
            InventoryItem::addQuantity($oldItem->item_name, $oldItem->quantity);
        }

        // التحقق من وجود جميع الكميات الجديدة في المخزون
        foreach ($request->items as $item) {
            $inventoryItem = InventoryItem::where('item_name', $item['item_name'])->first();
            if (!$inventoryItem || $inventoryItem->quantity < $item['quantity']) {
                // إرجاع الكميات القديمة مرة أخرى
                foreach ($deposit->items as $oldItem) {
                    InventoryItem::subtractQuantity($oldItem->item_name, $oldItem->quantity);
                }
                \Alert::error('الكمية المطلوبة غير متوفرة في المخزون للصنف: ' . $item['item_name'] . '. الكمية المتاحة: ' . ($inventoryItem ? $inventoryItem->quantity : 0))->flash();
                return redirect()->back()->withInput();
            }
        }

        // تحديث بيانات الأمانة
        $deposit->update([
            'client_id' => $request->client_id,
            'date_given' => $request->date_given,
            'notes' => $request->notes,
        ]);

        // حذف الأصناف القديمة
        $deposit->items()->delete();

        // إضافة الأصناف الجديدة وخصم الكميات من المخزون
        foreach ($request->items as $item) {
            ClientDepositItem::create([
                'client_deposit_id' => $deposit->id,
                'item_name' => $item['item_name'],
                'quantity' => $item['quantity'],
            ]);
            
            // خصم الكمية من المخزون
            InventoryItem::subtractQuantity($item['item_name'], $item['quantity']);
        }

        \Alert::success('تم تحديث الأمانة بنجاح.')->flash();
        return redirect($this->crud->route);
    }

    /**
     * Business Purpose: حذف أمانة (إرجاع جميع الكميات للمخزون أولاً)
     */
    public function destroy($id)
    {
        $deposit = $this->crud->getCurrentEntry();
        
        if (!$deposit) {
            \Alert::error('الأمانة غير موجودة.')->flash();
            return redirect($this->crud->route);
        }

        // إذا لم تكن مسحوبة، إرجاع جميع الكميات للمخزون
        if (!$deposit->is_withdrawn) {
            foreach ($deposit->items as $item) {
                InventoryItem::addQuantity($item->item_name, $item->quantity);
            }
        }

        $deposit->delete();

        \Alert::success('تم حذف الأمانة بنجاح.')->flash();
        return redirect($this->crud->route);
    }

    /**
     * Business Purpose: سحب أمانة واحدة (إرجاعها للمخزون)
     */
    public function withdraw($id)
    {
        $deposit = ClientDeposit::findOrFail($id);
        
        if ($deposit->is_withdrawn) {
            \Alert::error('هذه الأمانة تم سحبها مسبقاً.')->flash();
            return redirect($this->crud->route);
        }

        $deposit->withdraw();

        \Alert::success('تم سحب الأمانة بنجاح وتم إرجاع الكميات للمخزون.')->flash();
        return redirect($this->crud->route);
    }

    /**
     * Business Purpose: سحب صنف واحد من الأمانة
     */
    public function withdrawItem(Request $request, $id, $itemId)
    {
        $deposit = ClientDeposit::findOrFail($id);
        $item = ClientDepositItem::findOrFail($itemId);
        
        if ($deposit->is_withdrawn) {
            \Alert::error('هذه الأمانة تم سحبها مسبقاً.')->flash();
            return redirect()->back();
        }

        if ($item->client_deposit_id != $deposit->id) {
            \Alert::error('هذا الصنف لا ينتمي لهذه الأمانة.')->flash();
            return redirect()->back();
        }

        // إرجاع الكمية للمخزون
        InventoryItem::addQuantity($item->item_name, $item->quantity);
        
        // حذف الصنف من الأمانة
        $item->delete();
        
        // تحديث الأمانة بعد الحذف
        $deposit->refresh();
        
        // إذا لم يبق أي أصناف، سحب الأمانة بالكامل
        if ($deposit->items()->count() == 0) {
            $deposit->is_withdrawn = true;
            $deposit->withdrawn_at = Carbon::now();
            $deposit->save();
        }

        \Alert::success('تم سحب الصنف بنجاح وتم إرجاع الكمية للمخزون.')->flash();
        return redirect()->back();
    }

    /**
     * Business Purpose: سحب جميع أمانات عميل معين
     */
    public function withdrawAll(Request $request)
    {
        $clientId = $request->input('client_id');
        
        if (!$clientId) {
            \Alert::error('العميل غير محدد.')->flash();
            return redirect($this->crud->route);
        }

        $count = ClientDeposit::withdrawAllForClient($clientId);

        if ($count > 0) {
            \Alert::success("تم سحب {$count} أمانة بنجاح وتم إرجاع الكميات للمخزون.")->flash();
        } else {
            \Alert::info('لا توجد أمانات غير مسحوبة لهذا العميل.')->flash();
        }

        $redirectUrl = $this->crud->route;
        if ($clientId) {
            $redirectUrl .= '?client_id=' . $clientId;
        }
        return redirect($redirectUrl);
    }
}
