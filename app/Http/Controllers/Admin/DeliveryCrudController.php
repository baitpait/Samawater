<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Delivery;
use App\Models\InventoryItem;
use App\Models\ClientPayment;
use App\Models\Client;
use App\Services\ClientSelectFieldService;
use App\Http\Requests\DeliveryRequest;
use Illuminate\Http\Request;

class DeliveryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(Delivery::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/delivery');
        CRUD::setEntityNameStrings('توصيل', 'التوصيلات');
    }

    /**
     * Redirect list page to the custom delivery list.
     */
    public function index(Request $request)
    {
        return redirect()->route('delivery.list', $request->query());
    }

    protected function setupListOperation()
    {
        CRUD::setHeading('قائمة التسليم');
        
        // تغيير الـ Model لصفحة List فقط - استخدام VClientsDueByTypeDaysIds
        $this->crud->setModel(\App\Models\VClientsDueByTypeDaysIds::class);
        
        // استخدام VClientsDueByTypeDaysIds لعرض المشتركين المستحقين للتسليم
        $this->crud->query = \App\Models\VClientsDueByTypeDaysIds::query()
            ->leftJoin('cities', 'cities.id', '=', 'v_clients_due_by_type_days_ids.city_id')
            ->select('v_clients_due_by_type_days_ids.*', 'cities.city_name as city_name')
            ->orderByDesc('days_since_last_delivery');
        
        // إزالة جميع الأعمدة الافتراضية بشكل كامل
        $this->crud->removeAllColumns();
        
        // التأكد من إزالة أي أعمدة متبقية
        $allColumns = $this->crud->columns();
        foreach ($allColumns as $column) {
            $this->crud->removeColumn($column['name']);
        }
        
        // المشترك (اسم + رقم العقد)
        CRUD::addColumn([
            'name' => 'client_name',
            'label' => 'المشترك',
            'type' => 'custom_html',
            'value' => function($entry) {
                $name = $entry->client_name ?? '-';
                $contract = $entry->contract_no ?? '-';
                return '<div class="fw-bold">' . e($name) . '</div><div class="text-muted small">' . e($contract) . '</div>';
            }
        ]);
        
        // المدينة
        CRUD::addColumn([
            'name' => 'city_name',
            'label' => 'المدينة',
            'type' => 'custom_html',
            'value' => function($entry) {
                return e($entry->city_name ?? '-');
            }
        ]);
        
        // الهاتف (الأول والثاني في عمود واحد)
        CRUD::addColumn([
            'name' => 'phone',
            'label' => 'الهاتف',
            'type' => 'custom_html',
            'value' => function($entry) {
                $phone1 = $entry->phone_one ?? '';
                $phone2 = $entry->phone_two ?? '';
                if (empty($phone1) && empty($phone2)) {
                    return '-';
                }
                $html = '';
                if (!empty($phone1)) {
                    $html .= '<div>' . e($phone1) . '</div>';
                }
                if (!empty($phone2)) {
                    $html .= '<div class="text-muted small">' . e($phone2) . '</div>';
                }
                return $html;
            }
        ]);
        
        // تاريخ آخر تسليم
        CRUD::addColumn([
            'name' => 'last_delivery_date',
            'label' => 'تاريخ آخر تسليم',
            'type' => 'custom_html',
            'value' => function($entry) {
                $date = $entry->last_delivery_date ?? null;
                if (!$date) {
                    return '<span style="color: #6b7280;">لم يتسلم بعد</span>';
                }
                return '<span style="color: #6f6af8; font-weight: 600;">' . \Carbon\Carbon::parse($date)->format('Y-m-d') . '</span>';
            }
        ]);
        
        // إجراءات (dropdown menu)
        CRUD::addColumn([
            'name' => 'actions',
            'label' => 'إجراء',
            'type' => 'custom_html',
            'value' => function($entry) {
                $clientId = $entry->client_id ?? null;
                if (!$clientId) return '-';
                
                $showUrl = url(config('backpack.base.route_prefix') . '/client/' . $clientId . '/show');
                $reportUrl = url(config('backpack.base.route_prefix') . '/client-report?client_id=' . $clientId);
                $newDeliveryUrl = url(config('backpack.base.route_prefix') . '/delivery/create?client_id=' . $clientId);
                
                return '
                <div class="btn-group unified-actions-dropdown" style="position: relative;">
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%); border: none; border-radius: 8px; padding: 6px 12px; font-weight: 600; box-shadow: 0 2px 8px rgba(111, 106, 248, 0.3);">
                        <i class="la la-cog"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" style="right: 0 !important; left: auto !important; direction: rtl !important;">
                        <a class="dropdown-item" href="'.$showUrl.'">
                            <i class="la la-eye"></i> معاينة
                        </a>
                        <a class="dropdown-item" href="'.$reportUrl.'">
                            <i class="la la-file-alt"></i> تقرير
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="'.$newDeliveryUrl.'">
                            <i class="la la-truck"></i> تسليم
                        </a>
                    </div>
                </div>';
            }
        ]);
        
        // إزالة الأزرار الافتراضية
        CRUD::removeButton('show');
        CRUD::removeButton('create');
        CRUD::removeButton('delete');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(DeliveryRequest::class);

        // Ensure AMD define exists before Select2 i18n script loads
        CRUD::addField([
            'name' => 'amd_define_shim',
            'type' => 'custom_html',
            'value' => '<script>// Removed window.define.amd=true as it breaks DataTables</script>',
        ]);

        // إذا كان هناك client_id في query parameter، نحدد المشترك تلقائياً
        $clientId = request()->query('client_id');
        $selectedId = old('client_id', $clientId);
        if ($this->crud->getOperation() === 'update') {
            $selectedId = old('client_id', $this->crud->getCurrentEntry()?->client_id ?? $clientId);
        }

        $clientSelectService = app(ClientSelectFieldService::class);

        CRUD::addField([
            'name' => 'client_id',
            'type' => 'custom_html',
            'value' => $clientSelectService->crudFieldHtml([
                'label' => 'المشترك',
                'selectedId' => $selectedId,
                'required' => true,
                'allowEmpty' => true,
                'emptyLabel' => '-- اختر المشترك --',
                'selectId' => 'client_id_select',
                'placeholder' => 'ابحث عن اسم المشترك أو رقم العقد أو الهاتف…',
                'richLabels' => true,
            ]),
        ]);

        CRUD::field('delivery_date')
            ->type('date')
            ->default(now()->format('Y-m-d'))
            ->label('تاريخ التسليم')
            ->attributes([
                'required' => 'required'
            ]);

        CRUD::field('bottle_received')
            ->type('number')
            ->default(0)
            ->attributes([
                'min' => 0,
                'required' => 'required'
            ])
            ->label('العبوات المستلمة');

        CRUD::field('bottle_empty')
            ->type('number')
            ->default(0)
            ->attributes([
                'min' => 0,
                'required' => 'required'
            ])
            ->label('العبوات الفارغة');

        // المبلغ المدفوع أولاً
        CRUD::field('paymant')
            ->type('number')
            ->default(0)
            ->attributes([
                'min' => 0,
                'step' => '0.01',
                'required' => 'required',
                'id' => 'paymant_field'
            ])
            ->label('المبلغ المدفوع')
            ->hint('المبلغ الذي دفعه المشترك فعلياً')
            ->wrapper(['class' => 'form-group col-sm-12 mb-4']);

        // المبلغ المطلوب ثانياً
        CRUD::field('required_amount')
            ->type('number')
            ->default(0)
            ->attributes([
                'min' => 0,
                'step' => '0.01',
                'required' => 'required',
                'id' => 'required_amount_field'
            ])
            ->label('المبلغ المطلوب')
            ->hint('المبلغ الكامل المطلوب من المشترك')
            ->wrapper(['class' => 'form-group col-sm-12 mb-4']);

        // حقل JavaScript لإظهار الدين المتبقي - تم نقله هنا ليكون أسفل المبلغ المطلوب
        CRUD::field('remaining_debt')
            ->type('custom_html')
            ->value('<div class="form-group col-sm-12 mb-4">
                <label class="control-label">الدين المتبقي</label>
                <div class="form-control" id="remaining_debt_display" style="background-color: #f8f9fa; font-weight: bold; color: #dc3545;">
                    0.00
                </div>
            </div>
            <script>
            document.addEventListener("DOMContentLoaded", function() {
                const requiredAmountField = document.getElementById("required_amount_field");
                const paymantField = document.getElementById("paymant_field");
                const remainingDebtDisplay = document.getElementById("remaining_debt_display");
                
                function updateRemainingDebt() {
                    const requiredAmount = parseFloat(requiredAmountField.value) || 0;
                    const paymant = parseFloat(paymantField.value) || 0;
                    const remaining = requiredAmount - paymant;
                    
                    if (remaining > 0) {
                        remainingDebtDisplay.textContent = remaining.toFixed(2) + " (دين)";
                        remainingDebtDisplay.style.color = "#dc3545";
                    } else if (remaining < 0) {
                        remainingDebtDisplay.textContent = Math.abs(remaining).toFixed(2) + " (زيادة)";
                        remainingDebtDisplay.style.color = "#28a745";
                    } else {
                        remainingDebtDisplay.textContent = "0.00 (مدفوع بالكامل)";
                        remainingDebtDisplay.style.color = "#28a745";
                    }
                }
                
                if (requiredAmountField && paymantField && remainingDebtDisplay) {
                    requiredAmountField.addEventListener("input", updateRemainingDebt);
                    paymantField.addEventListener("input", updateRemainingDebt);
                    updateRemainingDebt(); // تحديث أولي
                }
            });
            </script>');

        CRUD::field('inventory_item_id')
            ->type('hidden')
            ->default(1)
            ->attributes([
                'value' => 1
            ]);

        $loggedDistributor = null;
        $loggedUser = backpack_user();
        if ($loggedUser && $loggedUser->isDistributor()) {
            $loggedDistributor = $loggedUser->distributor;
        }

        if ($loggedDistributor) {
            CRUD::field('distributor_display')
                ->type('custom_html')
                ->value('<div class="form-group">
                    <label class="control-label">الموزع</label>
                    <div class="form-control" style="background-color: #f8f9fa; font-weight: 600;">
                        ' . e($loggedDistributor->name) . '
                    </div>
                </div>');

            CRUD::field('distributor_id')
                ->type('hidden')
                ->default($loggedDistributor->id)
                ->attributes([
                    'value' => $loggedDistributor->id,
                ]);
        } else {
            CRUD::field('distributor_id')
                ->type('select')
                ->model('App\Models\Distributor')
                ->attribute('name')
                ->label('الموزع')
                ->attributes([
                    'required' => 'required',
                ])
                ->options(function ($query) {
                    return $query->orderBy('name')->get();
                });
        }

        $initialClientNotes = $selectedId
            ? (string) (Client::whereKey((int) $selectedId)->value('notes') ?? '')
            : '';
        $notesByClientIdJson = json_encode(
            Client::query()->pluck('notes', 'id')->map(static fn ($n) => (string) ($n ?? ''))->toArray(),
            JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
        );

        CRUD::field('client_notes_panel')
            ->type('custom_html')
            ->value(
                '<div class="form-group col-sm-12 mb-3 mt-4" style="padding-top: 16px; border-top: 2px solid rgba(111,106,248,.13);">'
                . '<label class="control-label form-label" for="client_notes_field">ملاحظات المشترك</label>'
                . '<textarea name="client_notes" id="client_notes_field" rows="4" class="form-control">'
                . e($initialClientNotes)
                . '</textarea>'
                . '<p class="help-block mb-0 mt-1 small text-muted">تُحفظ على بطاقة المشترك عند حفظ التسليم. يمكنك تعديلها هنا.</p>'
                . '</div>'
                . '<script type="application/json" id="delivery-client-notes-map">' . $notesByClientIdJson . '</script>'
                . '<script>
document.addEventListener("DOMContentLoaded", function () {
    var sel = document.getElementById("client_id_select");
    var ta = document.getElementById("client_notes_field");
    var mapEl = document.getElementById("delivery-client-notes-map");
    var map = {};
    try {
        map = mapEl ? JSON.parse(mapEl.textContent || "{}") : {};
    } catch (ignore) {}
    if (!sel || !ta) {
        return;
    }
    function syncNotesFromMap() {
        var id = sel.value;
        ta.value = id !== "" && Object.prototype.hasOwnProperty.call(map, id) ? String(map[id]) : "";
    }
    if (window.jQuery) {
        jQuery(sel).on("change", syncNotesFromMap);
    } else {
        sel.addEventListener("change", syncNotesFromMap);
    }
});
</script>'
            );
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();

        $fromOverview = request()->get('return_to_report') === 'clients_delivery_overview'
            || request()->get('from') === 'clients_delivery_overview';
        if ($fromOverview) {
            CRUD::addField([
                'name'  => 'return_to_report',
                'type'  => 'hidden',
                'value' => 'clients_delivery_overview',
            ]);
        }
    }

    /**
     * Business Purpose: إنشاء تسليم جديد مع إدارة المخزون والدفعات
     * - خصم العبوات المستلمة من المخزون
     * - إضافة العبوات الفارغة للمخزون
     * - إنشاء ClientPayment تلقائياً إذا كان paymant > 0
     * - تحديث ملاحظات المشترك (clients.notes) من حقول النموذج عند وجودها
     * - إعادة التوجيه إلى إنشاء تسليم آخر لنفس المشترك (تسريع رحلة إدخال تسليمات متتالية)
     */
    public function store()
    {
        $request = $this->crud->validateRequest();
        
        // التحقق من وجود الصنف id=1 في المخزون
        $inventoryItem = InventoryItem::find($request->inventory_item_id);
        if (!$inventoryItem) {
            \Alert::error('⚠️ صنف العبوات غير موجود في المخزون. يرجى التأكد من وجود الصنف id=1.')->flash();
            return redirect()->back()->withInput();
        }
        
        // إنشاء التسليم
        $delivery = $this->crud->create([
            'client_id' => $request->client_id,
            'delivery_date' => $request->delivery_date,
            'bottle_received' => $request->bottle_received,
            'bottle_empty' => $request->bottle_empty,
            'required_amount' => $request->required_amount,
            'inventory_item_id' => $request->inventory_item_id ?? 1,
            'paymant' => $request->paymant ?? 0,
            'distributor_id' => $request->distributor_id,
        ]);
        
        // إدارة المخزون
        // العبوات المستلمة تنقص من المخزون
        if ($delivery->bottle_received > 0) {
            InventoryItem::subtractQuantity($inventoryItem->item_name, $delivery->bottle_received);
        }
        
        // العبوات الفارغة تزيد في المخزون
        if ($delivery->bottle_empty > 0) {
            InventoryItem::addQuantity($inventoryItem->item_name, $delivery->bottle_empty);
        }
        
        // تحديث المشترك: إرجاع delivery_on_demand وملاحظات البطاقة
        $client = Client::find($delivery->client_id);
        if ($client) {
            if ($client->delivery_on_demand) {
                $client->delivery_on_demand = false;
            }
            if ($request->has('client_notes')) {
                $client->notes = $request->input('client_notes');
            }
            $client->save();
        }
        
        // إنشاء ClientPayment إذا كان paymant > 0
        // المدفوعات تُحمل على المشترك الأب فقط (parent client)
        $clientPayment = null;
        if ($delivery->paymant > 0) {
            $parentClient = $client ? $client->getParentClient() : null;
            
            if (!$parentClient) {
                \Alert::error('⚠️ لا يمكن إنشاء الدفعة: العميل الأب غير موجود.')->flash();
                return redirect()->back()->withInput();
            }
            
            $clientPayment = ClientPayment::create([
                'client_id' => $parentClient->id, // استخدام العميل الأب
                'amount' => $delivery->paymant,
                'payment_date' => $delivery->delivery_date,
                'payment_method' => 'cash', // يمكن تعديله لاحقاً
                'notes' => "دفعة من تسليم #{$delivery->id}" . ($client->id != $parentClient->id ? " (عنوان: {$client->name})" : ''),
                'created_by' => backpack_user()->id,
            ]);
            
            // ربط الدفعة بالتسليم
            $delivery->client_payment_id = $clientPayment->id;
            $delivery->save();
        }
        
        \Alert::success('تم إنشاء التسليم بنجاح.')->flash();

        return redirect(backpack_url('delivery/create?client_id=' . $delivery->client_id));
    }

    /**
     * Business Purpose: تحديث تسليم مع إدارة المخزون والدفعات
     * - إرجاع الكميات القديمة للمخزون (عكس العملية)
     * - تطبيق الكميات الجديدة
     * - تحديث ClientPayment إذا تغير paymant
     */
    public function update()
    {
        $deliveryId = request()->route('id');
        $existingForMerge = $deliveryId ? Delivery::query()->find($deliveryId) : null;
        if ($existingForMerge) {
            $mergePayload = [];
            if (!request()->filled('inventory_item_id')) {
                $mergePayload['inventory_item_id'] = $existingForMerge->inventory_item_id ?? 1;
            }
            if (!request()->has('required_amount')
                || request()->input('required_amount') === null
                || request()->input('required_amount') === '') {
                $mergePayload['required_amount'] = $existingForMerge->required_amount ?? 0;
            }
            if (!request()->filled('client_id')) {
                $mergePayload['client_id'] = $existingForMerge->client_id;
            }
            if ($mergePayload !== []) {
                request()->merge($mergePayload);
            }
        }

        $request = $this->crud->validateRequest();
        $entry = $this->crud->getCurrentEntry();

        $expectsJsonResponse = request()->expectsJson();

        if (!$entry) {
            if ($expectsJsonResponse) {
                return response()->json([
                    'status' => false,
                    'message' => 'التسليم غير موجود.',
                ], 404);
            }

            \Alert::error('التسليم غير موجود.')->flash();

            return redirect($this->crud->route);
        }
        // التحقق من وجود الصنف في المخزون
        $inventoryItem = InventoryItem::find($request->inventory_item_id ?? 1);
        if (!$inventoryItem) {
            if ($expectsJsonResponse) {
                return response()->json([
                    'status' => false,
                    'message' => 'صنف العبوات غير موجود في المخزون.',
                ], 422);
            }

            \Alert::error('⚠️ صنف العبوات غير موجود في المخزون.')->flash();

            return redirect()->back()->withInput();
        }
        
        // حفظ القيم القديمة
        $oldBottleReceived = $entry->bottle_received;
        $oldBottleEmpty = $entry->bottle_empty;
        $oldPaymant = $entry->paymant;
        $oldClientPaymentId = $entry->client_payment_id;
        
        // إرجاع الكميات القديمة للمخزون (عكس العملية)
        // العبوات المستلمة القديمة كانت ناقصة → نضيفها الآن
        if ($oldBottleReceived > 0) {
            InventoryItem::addQuantity($inventoryItem->item_name, $oldBottleReceived);
        }
        
        // العبوات الفارغة القديمة كانت مضافة → نخصمها الآن
        if ($oldBottleEmpty > 0) {
            InventoryItem::subtractQuantity($inventoryItem->item_name, $oldBottleEmpty);
        }
        
        // تحديث بيانات التسليم
        $entry->update([
            'client_id' => $request->client_id,
            'delivery_date' => $request->delivery_date,
            'bottle_received' => $request->bottle_received,
            'bottle_empty' => $request->bottle_empty,
            'required_amount' => $request->required_amount,
            'inventory_item_id' => $request->inventory_item_id ?? 1,
            'paymant' => $request->paymant ?? 0,
            'distributor_id' => $request->distributor_id,
        ]);
        
        // تطبيق الكميات الجديدة
        // العبوات المستلمة الجديدة تنقص من المخزون
        if ($entry->bottle_received > 0) {
            InventoryItem::subtractQuantity($inventoryItem->item_name, $entry->bottle_received);
        }
        
        // العبوات الفارغة الجديدة تزيد في المخزون
        if ($entry->bottle_empty > 0) {
            InventoryItem::addQuantity($inventoryItem->item_name, $entry->bottle_empty);
        }
        
        // تحديث المشترك: إرجاع delivery_on_demand وملاحظات البطاقة
        $client = Client::find($entry->client_id);
        if ($client) {
            if ($client->delivery_on_demand) {
                $client->delivery_on_demand = false;
            }
            if ($request->has('client_notes')) {
                $client->notes = $request->input('client_notes');
            }
            $client->save();
        }
        
        // تحديث ClientPayment
        // المدفوعات تُحمل على المشترك الأب فقط (parent client)
        if ($entry->paymant > 0) {
            $parentClient = $client ? $client->getParentClient() : null;
            
            if (!$parentClient) {
                if ($expectsJsonResponse) {
                    return response()->json([
                        'status' => false,
                        'message' => 'لا يمكن حفظ الدفعة: العميل الأب غير موجود.',
                    ], 422);
                }

                \Alert::error('⚠️ لا يمكن إنشاء الدفعة: العميل الأب غير موجود.')->flash();

                return redirect()->back()->withInput();
            }

            // إذا كان هناك دفعة قديمة، حدثها
            if ($oldClientPaymentId) {
                $oldPayment = ClientPayment::find($oldClientPaymentId);
                if ($oldPayment) {
                    $oldPayment->update([
                        'client_id' => $parentClient->id, // تحديث المشترك الأب أيضاً
                        'amount' => $entry->paymant,
                        'payment_date' => $entry->delivery_date,
                        'notes' => "دفعة من تسليم #{$entry->id}" . ($client->id != $parentClient->id ? " (عنوان: {$client->name})" : ''),
                    ]);
                }
            } else {
                // إنشاء دفعة جديدة
                $clientPayment = ClientPayment::create([
                    'client_id' => $parentClient->id, // استخدام العميل الأب
                    'amount' => $entry->paymant,
                    'payment_date' => $entry->delivery_date,
                    'payment_method' => 'cash',
                    'notes' => "دفعة من تسليم #{$entry->id}" . ($client->id != $parentClient->id ? " (عنوان: {$client->name})" : ''),
                    'created_by' => backpack_user()->id,
                ]);
                
                $entry->client_payment_id = $clientPayment->id;
                $entry->save();
            }
        } else {
            // إذا كان paymant = 0، احذف الدفعة القديمة إن وجدت
            if ($oldClientPaymentId) {
                $oldPayment = ClientPayment::find($oldClientPaymentId);
                if ($oldPayment) {
                    $oldPayment->delete();
                }
                $entry->client_payment_id = null;
                $entry->save();
            }
        }
        
        if ($expectsJsonResponse) {
            return response()->json([
                'status' => true,
                'message' => 'تم تحديث التسليم بنجاح.',
            ]);
        }

        \Alert::success('تم تحديث التسليم بنجاح.')->flash();

        $fromOverview = request()->get('return_to_report') === 'clients_delivery_overview'
            || request()->get('from') === 'clients_delivery_overview';
        if ($fromOverview) {
            return redirect()->route('reports.clients_delivery_overview', ['search' => 1]);
        }

        return redirect($this->crud->route);
    }

    /**
     * Business Purpose: حذف تسليم مع إرجاع الكميات للمخزون
     * - إرجاع العبوات المستلمة للمخزون (لأنها كانت ناقصة)
     * - خصم العبوات الفارغة من المخزون (لأنها كانت مضافة)
     * - حذف ClientPayment المرتبط إن وجد
     */
    public function destroy($id)
    {
        $entry = $this->crud->getCurrentEntry();
        
        if (!$entry) {
            \Alert::error('التسليم غير موجود.')->flash();
            return redirect($this->crud->route);
        }
        
        // جلب الصنف من المخزون
        $inventoryItem = $entry->inventoryItem;
        if (!$inventoryItem) {
            $inventoryItem = InventoryItem::find(1);
        }
        
        if ($inventoryItem) {
            // إرجاع العبوات المستلمة للمخزون (لأنها كانت ناقصة)
            if ($entry->bottle_received > 0) {
                InventoryItem::addQuantity($inventoryItem->item_name, $entry->bottle_received);
            }
            
            // خصم العبوات الفارغة من المخزون (لأنها كانت مضافة)
            if ($entry->bottle_empty > 0) {
                InventoryItem::subtractQuantity($inventoryItem->item_name, $entry->bottle_empty);
            }
        }
        
        // حذف ClientPayment المرتبط إن وجد
        if ($entry->client_payment_id) {
            $clientPayment = ClientPayment::find($entry->client_payment_id);
            if ($clientPayment) {
                $clientPayment->delete();
            }
        }
        
        // حذف التسليم
        $entry->delete();
        
        \Alert::success('تم حذف التسليم بنجاح.')->flash();
        return redirect($this->crud->route);
    }

    /**
     * البحث عن المشتركين للـ Select2
     */
    public function searchClients()
    {
        $term = request()->get('q', request()->get('term', ''));
        $id = request()->get('id'); // للمشترك المحدد مسبقاً في حالة التعديل أو التحميل الأولي
        
        $results = [];
        
        // إذا كان هناك id محدد (في حالة التعديل)، نضيفه للنتائج
        if ($id) {
            $selectedClient = \App\Models\Client::find($id);
            if ($selectedClient) {
                $results[] = [
                    'id' => $selectedClient->id,
                    'text' => $selectedClient->name . ($selectedClient->contract_no ? ' (' . $selectedClient->contract_no . ')' : '') . ($selectedClient->phone_one ? ' - ' . $selectedClient->phone_one : '')
                ];
            }
        }
        
        // البحث عن المشتركين
        if ($term) {
            $clients = \App\Models\Client::query()
                ->where(function($query) use ($term) {
                    $query->where('name', 'like', '%' . $term . '%')
                        ->orWhere('contract_no', 'like', '%' . $term . '%')
                        ->orWhere('phone_one', 'like', '%' . $term . '%')
                        ->orWhere('phone_two', 'like', '%' . $term . '%');
                })
                ->when($id, function($query) use ($id) {
                    $query->where('id', '!=', $id); // استبعاد المشترك المحدد مسبقاً من نتائج البحث
                })
                ->orderBy('name')
                ->limit(50)
                ->get();

            foreach ($clients as $client) {
                $results[] = [
                    'id' => $client->id,
                    'text' => $client->name . ($client->contract_no ? ' (' . $client->contract_no . ')' : '') . ($client->phone_one ? ' - ' . $client->phone_one : '')
                ];
            }
        }

        return response()->json($results);
    }

    /**
     * Business Purpose: بيانات تسليم واحد بصيغة JSON لنافذة التعديل السريع من تقرير المشترك (بدلاً من GET edit الذي يعيد HTML).
     */
    public function deliveryModalJson(int $id): \Illuminate\Http\JsonResponse
    {
        $delivery = Delivery::query()->findOrFail($id);

        return response()->json([
            'id' => $delivery->id,
            'client_id' => $delivery->client_id,
            'bottle_received' => (int) $delivery->bottle_received,
            'bottle_empty' => (int) $delivery->bottle_empty,
            'paymant' => (float) $delivery->paymant,
            'required_amount' => (float) $delivery->required_amount,
            'delivery_date' => $delivery->delivery_date?->format('Y-m-d'),
            'distributor_id' => $delivery->distributor_id,
            'inventory_item_id' => (int) ($delivery->inventory_item_id ?? 1),
        ]);
    }
}
