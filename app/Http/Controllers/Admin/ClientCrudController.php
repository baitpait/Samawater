<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClientRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use App\Models\InventoryItem;

class ClientCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    
    /**
     * تطبيق الفلاتر على الاستعلام
     * هذا يضمن تطبيقها بشكل صحيح مع DataTables server-side processing
     * يتم استدعاؤها من addClause في setupListOperation
     */
    protected function applyFiltersToQuery($query)
    {
        // تطبيق الفلاتر بنفس الترتيب الموجود في Blade view
        // 1. المدينة
        $cityId = request('city_id');
        if (!empty($cityId)) {
            $query->where('city_id', $cityId);
        }
        
        // 2. نوع المشترك
        $clientType = request('client_type');
        if (!empty($clientType)) {
            $query->where('client_type', $clientType);
        }
        
        // 3. حالة المشترك
        $clientStatusId = request('client_status_id');
        if (!empty($clientStatusId)) {
            $query->where('client_status_id', $clientStatusId);
        }
        
        // 4. نوع الاشتراك
        $subscriptionTypeId = request('subscription_type_id');
        if (!empty($subscriptionTypeId)) {
            $query->where('subscription_type_id', $subscriptionTypeId);
        }
        
        // 5. حالة الاشتراك
        $subscriptionStatusId = request('subscription_status_id');
        if (!empty($subscriptionStatusId)) {
            $query->where('subscription_status_id', $subscriptionStatusId);
        }
        
        // 6. البحث (اسم، هاتف، عنوان) - في النهاية
        // دعم كلا من 'search' و 'phone' للتوافق مع الروابط القديمة
        $searchTerm = request('search') ?: request('phone');
        // التأكد من أن $searchTerm هو string وليس array
        if (is_array($searchTerm)) {
            $searchTerm = isset($searchTerm[0]) ? (string)$searchTerm[0] : '';
        } else {
            $searchTerm = $searchTerm ? (string)$searchTerm : '';
        }
        // تنظيف $searchTerm من المسافات الزائدة
        $searchTerm = trim($searchTerm);
        if (!empty($searchTerm)) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('phone_one', 'like', '%' . $searchTerm . '%')
                  ->orWhere('phone_two', 'like', '%' . $searchTerm . '%')
                  ->orWhere('address', 'like', '%' . $searchTerm . '%');
            });
        }
        
        return $query;
    }

    public function setup()
    {
        CRUD::setModel(\App\Models\Client::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/client');
        CRUD::setEntityNameStrings('مشترك', 'المشتركين');
        
        // تعطيل البحث الافتراضي في DataTables لتجنب التضارب مع الفلاتر المخصصة
        CRUD::setOperationSetting('searchableTable', false);
    }

    /* =======================
       قائمة المشتركين (List)
    ======================== */
    protected function setupListOperation()
    {
        // تعطيل responsive table details row (إزالة النقاط الثلاث)
        CRUD::setOperationSetting('responsiveTable', false);
        CRUD::setOperationSetting('detailsRow', false);
        
        // إزالة جميع الأزرار الافتراضية (ما عدا زر الإضافة)
        CRUD::removeButton('show');
        CRUD::removeButton('edit');
        CRUD::removeButton('delete');
        CRUD::removeButton('revisions');
        CRUD::removeButton('reorder');
        
        // تفعيل زر الإضافة بشكل صريح
        CRUD::allowAccess('create');
        
        // تعطيل عمود الإجراءات الافتراضي
        CRUD::setOperationSetting('lineButtonsAsDropdown', false);
        
        // Eager loading للعلاقات
        $this->crud->addClause('with', ['city', 'subscriptionStatus', 'lastDelivery']);
        
        // تطبيق الفلاتر - استخدام addClause مع closure
        // هذا يضمن تطبيقها في كل مرة يتم فيها جلب البيانات (حتى في AJAX requests)
        $this->crud->addClause(function ($query) {
            return $this->applyFiltersToQuery($query);
        });

        // الأعمدة: اسم المشترك، رقم الهاتف، العنوان فقط
        
        // 1. اسم المشترك
  CRUD::addColumn([
            'name'  => 'client_name',
            'label' => 'اسم المشترك',
            'type'  => 'custom_html',
            'orderable' => true,
            'searchable' => true,
            'priority' => 1,
            'value' => function ($entry) {
                return '<div style="font-size: 15px; color: #1f2937; font-weight: 600; text-align: right; direction: rtl;">' . e($entry->name) . '</div>';
            },
        ]);

        // 2. رقم الهاتف
        CRUD::addColumn([
            'name'  => 'client_phone',
            'label' => 'رقم الهاتف',
            'type'  => 'custom_html',
            'orderable' => false,
            'searchable' => false,
            'priority' => 2,
            'value' => function ($entry) {
                $phone = $entry->phone_one ? $entry->phone_one : ($entry->phone_two ? $entry->phone_two : '-');
                return '<div style="font-size: 14px; color: #374151; text-align: center;">' . e($phone) . '</div>';
            },
        ]);

        // 3. العنوان
        CRUD::addColumn([
            'name'  => 'client_address',
            'label' => 'العنوان',
            'type'  => 'custom_html',
            'orderable' => false,
            'searchable' => false,
            'priority' => 3,
            'value' => function ($entry) {
                $address = $entry->address ? $entry->address : '-';
                return '<div style="font-size: 14px; color: #374151; text-align: right; direction: rtl;">' . e($address) . '</div>';
            },
        ]);

        // لا نضيف عمود الإجراءات - عرض فقط
    }
    
    /**
     * Override getEntriesAsJsonForDatatables to ensure filters are applied in AJAX requests
     * This method is called when DataTables makes AJAX requests for data
     */
    public function getEntriesAsJsonForDatatables()
    {
        // التأكد من تطبيق الفلاتر في كل طلب AJAX
        // إعادة تطبيق الفلاتر قبل جلب البيانات
        $this->crud->addClause(function ($query) {
            return $this->applyFiltersToQuery($query);
        });
        
        // استدعاء الـ parent method
        return parent::getEntriesAsJsonForDatatables();
    }

    /* =======================
       صفحة الإضافة (Create)
    ======================== */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ClientRequest::class);

        // جلب المشتركين الأب فقط (parent_id = null)
        $parentClients = \App\Models\Client::whereNull('parent_id')
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();

        CRUD::addFields([

            [
                'name'      => 'parent_id',
                'label'     => 'المشترك الأب (اختياري)',
                'type'      => 'select_from_array',
                'options'   => $parentClients,
                'hint'      => 'اختر المشترك الأب إذا كان هذا عنوان فرعي. اتركه فارغاً إذا كان هذا مشترك رئيسي.',
                'allows_null' => true,
            ],

            [
                'name'  => 'contract_no',
                'label' => 'رقم العقد',
                'type'  => 'text',
            ],

            [
                'name'  => 'name',
                'label' => 'اسم المشترك / العنوان',
                'type'  => 'text',
                'hint'  => 'إذا كان عنوان فرعي، يمكن كتابة اسم العنوان هنا (مثل: المنزل، المصنع، المكتب)',
            ],

            [
                'name'      => 'city_id',
                'label'     => 'المدينة',
                'type'      => 'select',
                'entity'    => 'city',
                'model'     => \App\Models\City::class,
                'attribute' => 'city_name',
            ],

            [
                'name'  => 'address',
                'label' => 'العنوان',
                'type'  => 'textarea',
            ],

            [
                'name'  => 'phone_one',
                'label' => 'رقم الهاتف الأول',
                'type'  => 'text',
            ],

            [
                'name'  => 'phone_two',
                'label' => 'رقم الهاتف الثاني',
                'type'  => 'text',
            ],

            [
                'name'      => 'subscription_type_id',
                'label'     => 'نوع الاشتراك',
                'type'      => 'select',
                'entity'    => 'subscriptionType',
                'model'     => \App\Models\SubscriptionType::class,
                'attribute' => 'type_name',
            ],

            [
                'name'      => 'subscription_status_id',
                'label'     => 'حالة الاشتراك',
                'type'      => 'select',
                'entity'    => 'subscriptionStatus',
                'model'     => \App\Models\SubscriptionStatus::class,
                // ✅ هنا كان الخطأ غالبًا – الحقل اسمه status_name
                'attribute' => 'status_name',
            ],

            [
                'name'  => 'subscription_start_date',
                'label' => 'تاريخ بدء الاشتراك',
                'type'  => 'date',
            ],

            [
                'name'  => 'opening_balance_amount',
                'label' => 'رصيد بداية المدة (شيكل)',
                'type'  => 'number',
                'attributes' => ['step' => '0.01'],
                'default' => 0,
                'hint'  => 'الرصيد الافتتاحي للمشترك قبل حركات الفواتير والمدفوعات داخل النظام.',
            ],

            [
                'name'  => 'opening_balance_as_of',
                'label' => 'تاريخ رصيد بداية المدة',
                'type'  => 'date',
                'hint'  => 'تاريخ اعتماد الرصيد الافتتاحي (اختياري).',
            ],

            [
                'name'  => 'bottle_balance',
                'label' => 'رصيد القوارير',
                'type'  => 'number',
            ],
            
            [
                'name'  => 'delivery_on_demand',
                'label' => 'تسليم حسب الطلب',
                'type'  => 'checkbox',
                'default' => 0,
                'hint'  => 'إذا كان مفعلاً، سيظهر المشترك في قائمة التسليم حتى لو لم يتجاوز عدد أيام الاشتراك. سيتم إرجاعه تلقائياً إلى false بعد التسليم.',
            ],

            [
                'name'  => 'notes',
                'label' => 'ملاحظات',
                'type'  => 'textarea',
            ],
        ]);
    }

    /* =======================
       صفحة التعديل (Update)
    ======================== */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /* =======================
       حفظ مشترك جديد (Store)
    ======================== */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'phone_one' => 'nullable|string|max:20',
            'phone_two' => 'nullable|string|max:20',
            'subscription_type_id' => 'nullable|exists:subscription_types,id',
            'subscription_status_id' => 'nullable|exists:subscription_statuses,id',
            'bottle_balance' => 'nullable|integer|min:0',
            'opening_balance_amount' => 'nullable|numeric',
            'opening_balance_as_of' => 'nullable|date',
        ]);
        
        // التحقق من رصيد القوارير وخصمه من المخزون
        $bottleBalance = (int) ($request->bottle_balance ?? 0);
        
        if ($bottleBalance > 0) {
            // جلب صنف العبوات من المخزون (id=1)
            $inventoryItem = InventoryItem::find(1);
            
            if (!$inventoryItem) {
                \Alert::error('⚠️ صنف العبوات غير موجود في المخزون. يرجى التأكد من وجود الصنف id=1.')->flash();
                return redirect()->back()->withInput();
            }
            
            // التحقق من توفر الكمية في المخزون
            if ($inventoryItem->quantity < $bottleBalance) {
                \Alert::error('⚠️ الكمية المطلوبة غير متوفرة في المخزون. الكمية المتاحة: ' . $inventoryItem->quantity . '، المطلوبة: ' . $bottleBalance)->flash();
                return redirect()->back()->withInput();
            }
            
            // خصم الكمية من المخزون
            InventoryItem::subtractQuantity($inventoryItem->item_name, $bottleBalance);
        }
        
        // إنشاء المشترك
        $client = \App\Models\Client::create([
            'parent_id' => $request->parent_id,
            'contract_no' => $request->contract_no,
            'name' => $request->name,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'phone_one' => $request->phone_one,
            'phone_two' => $request->phone_two,
            'client_type' => $request->client_type ?? 1,
            'subscription_type_id' => $request->subscription_type_id,
            'subscription_status_id' => $request->subscription_status_id,
            'subscription_start_date' => $request->subscription_start_date,
            'bottle_balance' => $bottleBalance,
            'opening_balance_amount' => $request->opening_balance_amount ?? 0,
            'opening_balance_as_of' => $request->opening_balance_as_of,
            'notes' => $request->notes,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
        ]);
        
        \Alert::success('تم إنشاء المشترك بنجاح' . ($bottleBalance > 0 ? ' وتم خصم ' . $bottleBalance . ' قارورة من المخزون' : '') . '.')->flash();
        
        // إعادة التوجيه حسب save action
        $saveAction = $request->input('_save_action', 'save_and_back');
        $redirectUrl = $this->crud->route;
        
        if ($saveAction === 'save_and_edit') {
            return redirect($redirectUrl . '/' . $client->id . '/edit');
        } elseif ($saveAction === 'save_and_new') {
            return redirect($redirectUrl . '/create');
        }
        
        return redirect($redirectUrl);
    }

    /**
     * Preserve client_type on update when field is not in form (DB-only).
     */
    public function update($id = null)
    {
        $id = $id ?? request()->route('id') ?? request()->route('client');
        $entry = $this->crud->getEntry($id);
        if ($entry) {
            request()->merge(['client_type' => $entry->client_type ?? 1]);
        }
        return $this->traitUpdate();
    }

    /* =======================
       دالة مساعدة: جلب خيارات الموزعين
    ======================== */
    protected function getDistributorOptions()
    {
        $distributors = \App\Models\Distributor::orderBy('name')->get();
        $options = ['' => '-- اختر الموزع --'];
        
        foreach ($distributors as $distributor) {
            $clientsCount = \App\Models\Client::where('distributor_id', $distributor->id)->count();
            $options[$distributor->id] = $distributor->name . ' (عدد المشتركين: ' . $clientsCount . ')';
        }
        
        return $options;
    }

    /* =======================
       صفحة المعاينة (Show)
    ======================== */
    protected function setupShowOperation()
    {
        // 1. اسم المشترك
        CRUD::addColumn([
            'name'  => 'name',
            'label' => 'اسم المشترك',
            'type'  => 'text',
        ]);

        // 2. رقم العقد
        CRUD::addColumn([
            'name'  => 'contract_no',
            'label' => 'رقم العقد',
            'type'  => 'text',
        ]);

        // 3. الصورة - سيتم عرضها في show.blade.php

        // 4. المدينة
        CRUD::addColumn([
            'name'      => 'city_id',
            'label'     => 'المدينة',
            'type'      => 'select',
            'entity'    => 'city',
            'model'     => \App\Models\City::class,
            'attribute' => 'city_name',
        ]);

        // 5. العنوان
        CRUD::addColumn([
            'name'  => 'address',
            'label' => 'العنوان',
            'type'  => 'text',
        ]);

        // 6. رقم الهاتف الأول
        CRUD::addColumn([
            'name'  => 'phone_one',
            'label' => 'رقم الهاتف الأول',
            'type'  => 'text',
        ]);

        // 7. رقم الهاتف الثاني
        CRUD::addColumn([
            'name'  => 'phone_two',
            'label' => 'رقم الهاتف الثاني',
            'type'  => 'text',
        ]);

        // 8. تاريخ الاشتراك
        CRUD::addColumn([
            'name'     => 'subscription_start_date',
            'label'    => 'تاريخ الاشتراك',
            'type'     => 'custom_html',
            'escaped'  => false,
            'value'    => function ($entry) {
                if (!$entry->subscription_start_date) {
                    return '<span style="color: #9ca3af; font-style: italic;">-</span>';
                }
                return '<span style="color: #1f2937; font-weight: 600;">'.\Carbon\Carbon::parse($entry->subscription_start_date)->format('Y-m-d').'</span>';
            },
        ]);

        // 9. تاريخ آخر تسليم
        CRUD::addColumn([
            'name'  => 'last_delivery_date',
            'label' => 'تاريخ آخر تسليم',
            'type'  => 'custom_html',
            'escaped' => false,
            'value' => function ($entry) {
                if (!$entry->lastDelivery) {
                    return '<span style="color: #9ca3af; font-style: italic;">-</span>';
                }
                $lastDate = \Carbon\Carbon::parse($entry->lastDelivery->delivery_date)->format('Y-m-d');
                return '<span style="color: #1f2937; font-weight: 600;">'.$lastDate.'</span>';
            },
        ]);

        // 10. المدة
        CRUD::addColumn([
            'name'  => 'days_since_last_delivery',
            'label' => 'المدة',
            'type'  => 'custom_html',
            'escaped' => false,
            'value' => function ($entry) {
                if (!$entry->lastDelivery) {
                    return '<span class="info-badge badge-secondary">لم يستلم بعد</span>';
                }
                $days = (int) \Carbon\Carbon::parse($entry->lastDelivery->delivery_date)->startOfDay()->diffInDays(now()->startOfDay());
                if ($days === 0) {
                    return '<span class="info-badge badge-success">اليوم</span>';
                } elseif ($days === 1) {
                    return '<span class="info-badge badge-primary">أمس</span>';
                } elseif ($days === 2) {
                    return '<span class="info-badge badge-primary">منذ يومين</span>';
                } elseif ($days <= 10) {
                    return '<span class="info-badge badge-warning">منذ '.$days.' أيام</span>';
                } else {
                    return '<span class="info-badge badge-danger">منذ '.$days.' يوم</span>';
                }
            },
        ]);

        // 11. رصيد القوارير
        CRUD::addColumn([
            'name'  => 'bottle_balance',
            'label' => 'رصيد القوارير',
            'type'  => 'number',
        ]);

        // 12. نوع الاشتراك
        CRUD::addColumn([
            'name'      => 'subscription_type_id',
            'label'     => 'نوع الاشتراك',
            'type'      => 'select',
            'entity'    => 'subscriptionType',
            'model'     => \App\Models\SubscriptionType::class,
            'attribute' => 'type_name',
        ]);

        // 13. حالة الاشتراك
        CRUD::addColumn([
            'name'      => 'subscription_status_id',
            'label'     => 'حالة الاشتراك',
            'type'      => 'select',
            'entity'    => 'subscriptionStatus',
            'model'     => \App\Models\SubscriptionStatus::class,
            'attribute' => 'status_name',
        ]);

        // 14. الموقع العميل
CRUD::addColumn([
            'name'  => 'location',
            'label' => 'موقع المشترك',
    'type'  => 'custom_html',
    'escaped' => false,
    'value' => function ($entry) {
                // التحقق من وجود القيم بشكل صحيح
                $latitude = $entry->latitude;
                $longitude = $entry->longitude;
                
                // التحقق من أن القيم موجودة وليست null أو 0 أو فارغة
                if (is_null($latitude) || is_null($longitude) || 
                    $latitude == 0 || $longitude == 0 || 
                    $latitude == '' || $longitude == '') {
                    return '<div style="padding: 20px; text-align: center; background: #f3f4f6; border-radius: 12px;">
                        <span style="color: #9ca3af; font-style: italic; font-size: 14px;">لم يتم تحديد الموقع</span>
                    </div>';
                }
                
                // تنظيف القيم للتأكد من أنها أرقام صحيحة
                $latitude = floatval($latitude);
                $longitude = floatval($longitude);
                
                // التحقق من أن القيم ضمن النطاق الصحيح
                if ($latitude < -90 || $latitude > 90 || $longitude < -180 || $longitude > 180) {
                    return '<div style="padding: 20px; text-align: center; background: #f3f4f6; border-radius: 12px;">
                        <span style="color: #9ca3af; font-style: italic; font-size: 14px;">إحداثيات الموقع غير صحيحة</span>
                    </div>';
        }

                // عرض الخريطة
                return '<div style="width:100%;height:300px;border-radius:12px;overflow:hidden;box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                    <iframe
                        width="100%"
                        height="300"
                        frameborder="0"
                        style="border:0; border-radius: 12px;"
                        src="https://maps.google.com/maps?q='.$latitude.','.$longitude.'&z=15&output=embed"
                        allowfullscreen>
                    </iframe>
                </div>';
    },
]);

        // 15. اسم الموزع
CRUD::addColumn([
    'name'      => 'distributor_id',
            'label'     => 'من طرف الموزع',
    'type'      => 'select',
    'entity'    => 'distributor',
    'model'     => \App\Models\Distributor::class,
    'attribute' => 'name',
]);

        // 16. الملاحظات
        CRUD::addColumn([
            'name'  => 'opening_balance_amount',
            'label' => 'رصيد بداية المدة',
            'type'  => 'number',
            'decimals' => 2,
            'suffix' => ' ₪',
        ]);

        // 17. الملاحظات
        CRUD::addColumn([
            'name'  => 'notes',
            'label' => 'ملاحظات',
            'type'  => 'text',
        ]);
    }

    /**
     * Business Purpose: حذف المشترك مع منع الحذف إذا كان مرتبطاً بتسليمات أو فواتير أو مدفوعات أو أمانات
     */
    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        $entry = $this->crud->getEntry($id);

        if (!$entry) {
            \Alert::error('المشترك غير موجود.')->flash();
            return redirect($this->crud->route);
        }

        $reasons = [];
        if ($entry->deliveries()->exists()) {
            $reasons[] = 'تسليمات';
        }
        if ($entry->invoices()->exists()) {
            $reasons[] = 'فواتير';
        }
        if ($entry->payments()->exists()) {
            $reasons[] = 'مدفوعات';
        }
        if ($entry->deposits()->exists()) {
            $reasons[] = 'أمانات';
        }
        if ($entry->children()->exists()) {
            $reasons[] = 'عناوين فرعية';
        }

        if (!empty($reasons)) {
            \Alert::error(
                'لا يجوز حذف العميل لأنه مرتبط بـ: ' . implode('، ', $reasons) . '. ' .
                'يرجى إزالة أو نقل هذه البيانات أولاً.'
            )->flash();
            return redirect()->back();
        }

        $clientName = $entry->name;
        $entry->delete();

        \Alert::success('تم حذف المشترك "' . $clientName . '" بنجاح.')->flash();
        return redirect($this->crud->route);
    }
}