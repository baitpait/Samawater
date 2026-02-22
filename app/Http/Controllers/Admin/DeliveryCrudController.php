<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Delivery;
use App\Models\InventoryItem;
use App\Models\ClientPayment;
use App\Models\Client;
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
        $selectedId = $clientId ?: (request()->route('id') ? \App\Models\Delivery::find(request()->route('id'))?->client_id : null);

        $clientOptions = ['' => '-- اختر المشترك --'];
        $clients = \App\Models\Client::query()->orderBy('name')->get();
        foreach ($clients as $client) {
            $label = $client->name;
            if (!empty($client->contract_no)) {
                $label .= ' (' . $client->contract_no . ')';
            }
            if (!empty($client->phone_one)) {
                $label .= ' - ' . $client->phone_one;
            }
            $clientOptions[$client->id] = $label;
        }

        CRUD::addField([
            'name'  => 'client_search_helper',
            'type'  => 'custom_html',
            'value' => '<div class="form-group col-sm-12 mb-2"><label class="control-label">بحث في قائمة المشتركين</label><input type="text" id="client_search_filter" class="form-control" placeholder="اكتب اسم المشترك أو رقم العقد أو الهاتف..." style="border-radius: 10px; border: 2px solid #e2e8f0;"></div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var select = document.getElementById("client_id_select");
    var filter = document.getElementById("client_search_filter");
    if (!select || !filter) return;
    var options = Array.from(select.options);
    filter.addEventListener("input", function() {
        var q = this.value.trim().toLowerCase();
        options.forEach(function(opt) {
            if (opt.value === "") { opt.hidden = false; return; }
            opt.hidden = q === "" ? false : !opt.text.toLowerCase().includes(q);
        });
    });
});
</script>',
        ]);

        CRUD::field('client_id')
            ->type('select_from_array')
            ->label('المشترك')
            ->options($clientOptions)
            ->default($selectedId)
            ->attributes([
                'required' => 'required',
                'id'       => 'client_id_select',
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

        // إضافة اختيار إرسال رسالة واتساب (تم نقله للأسفل وتعديل التصميم)
        CRUD::field('send_whatsapp')
            ->type('custom_html')
            ->value('<div class="form-group col-sm-12 mb-3 mt-4" style="padding-top: 20px; border-top: 2px solid #6f6af820;">
                <div class="form-check d-flex align-items-center p-0" style="gap: 20px;">
                    <input type="checkbox" name="send_whatsapp" id="send_whatsapp_check" value="1" checked 
                        style="width: 25px; height: 25px; cursor: pointer; accent-color: #6f6af8; margin: 0;">
                    <label class="form-check-label" for="send_whatsapp_check" 
                        style="font-size: 16px; font-weight: 700; color: #374151; cursor: pointer; margin: 0; user-select: none;">
                        إرسال إشعار واتساب للعميل ✨
                    </label>
                </div>
            </div>');
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
        
        // إرجاع delivery_on_demand إلى false بعد التسليم
        $client = Client::find($delivery->client_id);
        if ($client && $client->delivery_on_demand) {
            $client->delivery_on_demand = false;
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

        // تجهيز رسالة الوتس اب (فقط إذا تم اختيار الشيك بوكس)
        if ($request->input('send_whatsapp') == 1 && $client && $client->phone_one) {
            $phone = preg_replace('/[^0-9]/', '', $client->phone_one);
            
            $parentClient = $client->getParentClient();
            $totalBalance = $parentClient ? $parentClient->balance : 0;
            
            $message = "مرحباً بك عميلنا العزيز: {$client->name} ✨\n\n";
            $message .= "يسرّنا في مياه سما 💧 إبلاغك بإتمام عملية توريد المياه بنجاح. نحن ملتزمون دائماً بتقديم أفضل خدمة تليق بك.\n\n";
            $message .= "تفاصيل العملية الأخيرة:\n";
            $message .= "━━━━━━━━━━━━━━━━\n";
            $message .= "📦 العبوات الجديدة: {$delivery->bottle_received} عبوة\n";
            $message .= "🔄 العبوات المسترجعة: {$delivery->bottle_empty} عبوة\n";
            $message .= "💰 المبلغ المطلوب: {$delivery->required_amount}\n";
            $message .= "💵 المبلغ المدفوع: {$delivery->paymant}\n";
            $message .= "━━━━━━━━━━━━━━━━\n";
            $message .= "📊 رصيد حسابك الإجمالي: {$totalBalance}\n\n";
            $message .= "نشكرك على ثقتك الدائمة بـ مياه سما.. خيارك الأمثل للنقاء والانتعاش 🌊\n\n";
            $message .= "لأي استفسار، نحن دائماً في خدمتك.";

            $whatsappUrl = "https://wa.me/{$phone}?text=" . urlencode($message);
            
            // تسجيل لوج للتحقق من الرابط
            \Log::info("WhatsApp URL generated: " . $whatsappUrl);
            
            // تخزين الرابط في السيشن ليقوم الجافاسكريبت بفتحه
            session()->flash('whatsapp_url', $whatsappUrl);
            session()->put('whatsapp_url_persistent', $whatsappUrl);
        }

        return redirect($this->crud->route);
    }

    /**
     * Business Purpose: تحديث تسليم مع إدارة المخزون والدفعات
     * - إرجاع الكميات القديمة للمخزون (عكس العملية)
     * - تطبيق الكميات الجديدة
     * - تحديث ClientPayment إذا تغير paymant
     */
    public function update()
    {
        // إذا كان الطلب JSON (من AJAX)، استخدم المنطق القديم
        if (request()->wantsJson() || request()->expectsJson()) {
            try {
                $id = request()->route('id');
                $entry = $this->crud->getEntry($id);
                
                if (!$entry) {
                    return response()->json([
                        'status' => false,
                        'message' => 'التوصيل غير موجود'
                    ], 404);
                }
                
                // التحقق من البيانات - استخدام client_id من التوصيل الأصلي إذا لم يتم إرساله
                $requestData = request()->all();
                
                // إذا لم يتم إرسال client_id، استخدم client_id من التوصيل الأصلي
                if (!isset($requestData['client_id']) || empty($requestData['client_id'])) {
                    $requestData['client_id'] = $entry->client_id;
                }
                
                // التحقق من البيانات
                $validator = \Validator::make($requestData, [
                    'client_id' => 'required|integer|exists:clients,id',
                    'delivery_date' => 'required|date',
                    'bottle_received' => 'required|integer|min:0',
                    'bottle_empty' => 'required|integer|min:0',
                    'paymant' => 'required|numeric|min:0',
                    'distributor_id' => 'required|integer|exists:distributors,id',
                ], [
                    'client_id.required' => 'يجب اختيار المشترك',
                    'client_id.exists' => 'المشترك المحدد غير موجود',
                    'delivery_date.required' => 'تاريخ التوصيل مطلوب',
                    'delivery_date.date' => 'تاريخ التوصيل يجب أن يكون تاريخاً صحيحاً',
                    'bottle_received.required' => 'عدد العبوات المستلمة مطلوب',
                    'bottle_received.integer' => 'عدد العبوات المستلمة يجب أن يكون رقماً صحيحاً',
                    'bottle_received.min' => 'عدد العبوات المستلمة لا يمكن أن يكون سالباً',
                    'bottle_empty.required' => 'عدد العبوات الفارغة مطلوب',
                    'bottle_empty.integer' => 'عدد العبوات الفارغة يجب أن يكون رقماً صحيحاً',
                    'bottle_empty.min' => 'عدد العبوات الفارغة لا يمكن أن يكون سالباً',
                    'paymant.required' => 'الدفعة مطلوبة',
                    'paymant.numeric' => 'الدفعة يجب أن تكون رقماً',
                    'paymant.min' => 'الدفعة لا يمكن أن تكون سالبة',
                    'distributor_id.required' => 'يجب اختيار الموزع',
                    'distributor_id.exists' => 'الموزع المحدد غير موجود',
                ]);
                
                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'التحقق من البيانات فشل',
                        'errors' => $validator->errors()
                    ], 422);
                }
                
                // تحديث البيانات
                $entry->update([
                    'client_id' => $requestData['client_id'],
                    'delivery_date' => $requestData['delivery_date'],
                    'bottle_received' => $requestData['bottle_received'],
                    'bottle_empty' => $requestData['bottle_empty'],
                    'paymant' => $requestData['paymant'],
                    'distributor_id' => $requestData['distributor_id'],
                ]);
                
                return response()->json([
                    'status' => true,
                    'message' => 'تم تحديث التوصيل بنجاح'
                ]);
            } catch (\Exception $e) {
                \Log::error('Error updating delivery: ' . $e->getMessage());
                return response()->json([
                    'status' => false,
                    'message' => 'حدث خطأ أثناء تحديث التوصيل: ' . $e->getMessage()
                ], 500);
            }
        }
        
        // إذا كان الطلب عادي (HTML)، استخدم المنطق الجديد
        $request = $this->crud->validateRequest();
        $entry = $this->crud->getCurrentEntry();
        
        if (!$entry) {
            \Alert::error('التسليم غير موجود.')->flash();
            return redirect($this->crud->route);
        }
        
        // التحقق من وجود الصنف في المخزون
        $inventoryItem = InventoryItem::find($request->inventory_item_id ?? 1);
        if (!$inventoryItem) {
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
        
        // إرجاع delivery_on_demand إلى false بعد تحديث التسليم
        $client = Client::find($entry->client_id);
        if ($client && $client->delivery_on_demand) {
            $client->delivery_on_demand = false;
            $client->save();
        }
        
        // تحديث ClientPayment
        // المدفوعات تُحمل على المشترك الأب فقط (parent client)
        if ($entry->paymant > 0) {
            $parentClient = $client ? $client->getParentClient() : null;
            
            if (!$parentClient) {
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
}
