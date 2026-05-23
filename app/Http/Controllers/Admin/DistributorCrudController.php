<?php

namespace App\Http\Controllers\Admin;

use App\Models\Distributor;
use App\Http\Requests\DistributorRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

class DistributorCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Distributor::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/distributor');
        CRUD::setEntityNameStrings('موزع', 'الموزعين');
    }

    /**
     * عرض قائمة الموزعين بواجهة مخصصة بدل جدول Backpack.
     */
    public function index(Request $request)
    {
        $this->crud->hasAccessOrFail('list');

        $query = Distributor::query();

        if ($request->has('search') && $request->search) {
            $search = (string) $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $sortBy = $request->get('sort_by', 'id');
        $sortDir = $request->get('sort_dir', 'desc') === 'asc' ? 'asc' : 'desc';

        $allowedSorts = ['id', 'name', 'phone', 'balance'];
        if (!in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'id';
        }

        $query->orderBy($sortBy, $sortDir);

        $perPage = (int) $request->get('per_page', 50);
        if ($perPage < 1) {
            $perPage = 25;
        }

        $distributors = $query->paginate($perPage);

        return view('admin.distributors_list', compact('distributors'));
    }

    protected function setupListOperation()
    {
        // تعطيل responsive table details row (إزالة النقاط الثلاث)
        // تفعيل scrollbar أفقي بدلاً من النقاط الثلاث
        CRUD::setOperationSetting('responsiveTable', false);
        CRUD::setOperationSetting('detailsRow', false);
        
        // تطبيق البحث
        if (request()->has('search') && request('search')) {
            $search = request('search');
            
            // التأكد من أن $search هو string وليس array
            if (is_array($search)) {
                $search = isset($search[0]) ? (string)$search[0] : '';
            } else {
                $search = (string)$search;
            }
            
            // تطبيق البحث فقط إذا كان $search غير فارغ
            if (!empty($search)) {
                CRUD::addClause(function ($query) use ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%')
                          ->orWhere('phone', 'like', '%' . $search . '%');
                    });
                });
            }
        }

        // إزالة جميع الأزرار الافتراضية من stack 'line'
        CRUD::removeButton('show');
        CRUD::removeButton('edit');
        CRUD::removeButton('delete');
        CRUD::removeButton('revisions');
        CRUD::removeButton('reorder');
        
        // تعطيل عمود الإجراءات الافتراضي تماماً
        CRUD::setOperationSetting('lineButtonsAsDropdown', false);
        
        // التأكد من عدم وجود أزرار في stack 'line' - هذا يمنع Backpack من إضافة عمود الإجراءات
        // لا نضيف أي أزرار في stack 'line' هنا

        // إضافة الأعمدة
        CRUD::addColumn([
            'name' => 'name',
            'label' => 'اسم الموزع',
        ]);

        CRUD::addColumn([
            'name' => 'phone',
            'label' => 'رقم الهاتف',
        ]);


        CRUD::addColumn([
            'name' => 'balance',
            'label' => 'الرصيد الحالي',
            'type' => 'number',
            'prefix' => '₪ ',
            'decimals' => 2,
        ]);

        // إضافة عمود الإجراءات المخصص مع dropdown (Bootstrap 5)
        CRUD::addColumn([
            'name'    => 'actions',
            'label'   => 'أجراءات',
            'type'    => 'custom_html',
            'escaped' => false,
            'orderable' => false,
            'searchable' => false,
            'value'   => function ($entry) {
                $showUrl = url(config('backpack.base.route_prefix').'/distributor/'.$entry->id.'/show');
                $editUrl = url(config('backpack.base.route_prefix').'/distributor/'.$entry->id.'/edit');
                $deleteUrl = url(config('backpack.base.route_prefix').'/distributor/'.$entry->id);
                $reportUrl = url(config('backpack.base.route_prefix').'/distributor/'.$entry->id.'/financial-report');
                $clientsUrl = url(config('backpack.base.route_prefix').'/distributor/'.$entry->id.'/clients');

                return '
                <div class="btn-group unified-actions-dropdown dropdown" style="position: relative;">
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="la la-cog"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="'.$showUrl.'">
                            <i class="la la-eye"></i> معاينة
                        </a></li>
                        <li><a class="dropdown-item" href="'.$editUrl.'">
                            <i class="la la-edit"></i> تعديل
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><button type="button" class="dropdown-item open-withdraw-modal" 
                                data-id="'.$entry->id.'" 
                                data-balance="'.$entry->balance.'">
                            <i class="la la-money-bill"></i> سحب
                        </button></li>
                        <li><a class="dropdown-item" href="'.$reportUrl.'">
                            <i class="la la-file-invoice-dollar"></i> التقرير المالي
                        </a></li>
                        <li><a class="dropdown-item" href="'.$clientsUrl.'">
                            <i class="la la-users"></i> العملاء
                        </a></li>
                    </ul>
                </div>';
            },
        ]);
        
        // إضافة JavaScript لإعادة تهيئة dropdowns بعد تحميل الجدول
        // سيتم إضافة الـ script عبر view مخصص
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(DistributorRequest::class);

        CRUD::addField([
            'name' => 'name',
            'label' => 'اسم الموزع',
            'type' => 'text',
        ]);

        CRUD::addField([
            'name' => 'phone',
            'label' => 'رقم الهاتف (يستخدم لتسجيل الدخول)',
            'type' => 'text',
            'hint' => 'سيتم استخدام رقم الهاتف لتسجيل الدخول',
        ]);

        CRUD::addField([
            'name'  => 'password_hash',
            'label' => 'كلمة المرور',
            'type'  => 'custom_html',
            'value' => '
                <div class="input-group" style="direction: rtl;">
                    <input 
                        type="password" 
                        name="password_hash" 
                        id="distributor_password_field" 
                        class="form-control" 
                        autocomplete="new-password" 
                        placeholder="اتركه فارغًا إذا لا تريد تغيير كلمة المرور"
                        style="border-radius: 0.375rem 0 0 0.375rem; border-left: none; padding-right: 15px;"
                    />
                    <button 
                        class="btn btn-outline-secondary" 
                        type="button" 
                        id="toggle-password"
                        style="border-radius: 0 0.375rem 0.375rem 0; border-right: none; padding: 0 12px; background: #f8f9fa; border-color: #ced4da; color: #6c757d;"
                        onclick="togglePasswordVisibility()"
                    >
                        <i class="la la-eye" id="toggle-icon" style="font-size: 18px;"></i>
                    </button>
                </div>
                <script>
                function togglePasswordVisibility() {
                    const passwordField = document.getElementById("distributor_password_field");
                    const toggleIcon = document.getElementById("toggle-icon");
                    
                    if (passwordField.type === "password") {
                        passwordField.type = "text";
                        toggleIcon.className = "la la-eye-slash";
                    } else {
                        passwordField.type = "password";
                        toggleIcon.className = "la la-eye";
                    }
                }
                </script>',
        ]);


        CRUD::addField([
            'name' => 'status',
            'label' => 'الحالة',
            'type' => 'select_from_array',
            'options' => [
                1 => 'نشط',
                0 => 'معطل',
            ],
        ]);

        CRUD::addField([
            'name' => 'notes',
            'label' => 'ملاحظات',
            'type' => 'textarea',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * إنشاء الموزع + إنشاء حساب مستخدم مرتبط تلقائياً
     */
    public function store(DistributorRequest $request)
    {
        $this->crud->hasAccessOrFail('create');

        try {
            // التحقق من كلمة المرور قبل الإنشاء
            if (empty($request->password_hash) || strlen($request->password_hash) < 6) {
                \Alert::error('خطأ: كلمة المرور يجب أن تكون على الأقل 6 أحرف.')->flash();
                return redirect($this->crud->route);
            }

            // تشفير كلمة المرور مرة واحدة فقط
            $hashedPassword = bcrypt($request->password_hash);
            
            // إنشاء الموزع أولاً
            $distributor = \App\Models\Distributor::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'username' => $request->phone, // استخدام phone كـ username
                'password_hash' => $hashedPassword,
                'status' => $request->status ?? 1,
                'notes' => $request->notes,
            ]);

            // البحث عن دور "الموزع"
            $distributorRole = \App\Models\Role::where('name', 'distributor')->first();
            
            if (!$distributorRole) {
                // حذف الموزع إذا فشل إنشاء الدور
                $distributor->delete();
                \Alert::error('خطأ: لم يتم العثور على دور "الموزع" في النظام.')->flash();
                return redirect($this->crud->route);
            }

            // إنشاء حساب مستخدم للموزع تلقائياً
            // استخدام phone + @distributor.local كـ email
            $email = $distributor->phone . '@distributor.local';
            
            // التحقق من عدم وجود email مكرر
            if (\App\Models\User::where('email', $email)->exists()) {
                // حذف الموزع إذا كان email مكرر
                $distributor->delete();
                \Alert::error('خطأ: البريد الإلكتروني "' . $email . '" مستخدم بالفعل.')->flash();
                return redirect($this->crud->route);
            }
            
            // إنشاء المستخدم بنفس كلمة المرور المشفرة
            $user = \App\Models\User::create([
                'name' => $distributor->name,
                'email' => $email,
                'password' => $hashedPassword, // استخدام نفس الـ hash
                'role_id' => $distributorRole->id,
                'distributor_id' => $distributor->id,
            ]);

            // التحقق من نجاح الإنشاء
            if (!$user || !$user->id) {
                // حذف الموزع إذا فشل إنشاء المستخدم
                $distributor->delete();
                \Alert::error('خطأ: فشل إنشاء حساب المستخدم.')->flash();
                return redirect($this->crud->route);
            }

            \Alert::success('تم إنشاء الموزع "' . $distributor->name . '" وحساب المستخدم المرتبط بنجاح.')->flash();
            
        } catch (\Exception $e) {
            // في حالة حدوث خطأ، حذف الموزع إذا كان موجوداً
            if (isset($distributor) && $distributor->id) {
                $distributor->delete();
            }

            \Alert::error('خطأ: ' . $e->getMessage())->flash();
            \Log::error('خطأ في إنشاء موزع', [
                'error' => $e->getMessage(),
                'distributor_id' => isset($distributor) ? $distributor->id : null,
            ]);
        }
        
        return redirect($this->crud->route);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
        
        // في حالة التحديث، كلمة المرور اختيارية
        CRUD::modifyField('password_hash', [
            'attributes' => [
                'autocomplete' => 'new-password',
                'placeholder'  => 'اتركه فارغًا إذا لا تريد تغيير كلمة المرور',
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     * تحديث الموزع + تحديث حساب المستخدم المرتبط
     */
    public function update(DistributorRequest $request, $id)
    {
        $this->crud->hasAccessOrFail('update');

        $distributor = \App\Models\Distributor::findOrFail($id);
        
        // تحديث بيانات الموزع
        $updateData = [
            'name' => $request->name,
            'phone' => $request->phone,
            'username' => $request->phone, // استخدام phone كـ username
            'status' => $request->status ?? 1,
            'notes' => $request->notes,
        ];

        // إذا تم إدخال كلمة مرور جديدة
        if (!empty($request->password_hash)) {
            $updateData['password_hash'] = bcrypt($request->password_hash);
        }

        $distributor->update($updateData);

        // البحث عن المستخدم المرتبط أو إنشاؤه
        $user = \App\Models\User::where('distributor_id', $distributor->id)->first();
        $distributorRole = \App\Models\Role::where('name', 'distributor')->first();

        try {
            if (!$user && $distributorRole) {
                // إنشاء حساب مستخدم إذا لم يكن موجوداً
                $email = $distributor->phone . '@distributor.local';
                
                // التحقق من عدم وجود email مكرر
                if (\App\Models\User::where('email', $email)->exists()) {
                    \Alert::error('خطأ: البريد الإلكتروني "' . $email . '" مستخدم بالفعل.')->flash();
                    return redirect($this->crud->route);
                }
                
                // استخدام كلمة المرور الجديدة أو الافتراضية
                $passwordToUse = !empty($request->password_hash) ? $request->password_hash : '123456';
                $hashedPassword = bcrypt($passwordToUse);
                
                $user = \App\Models\User::create([
                    'name' => $distributor->name,
                    'email' => $email,
                    'password' => $hashedPassword,
                    'role_id' => $distributorRole->id,
                    'distributor_id' => $distributor->id,
                ]);
                
                // تحديث كلمة مرور الموزع أيضاً
                if (!empty($request->password_hash)) {
                    $distributor->password_hash = $hashedPassword;
                    $distributor->save();
                }
                
                \Alert::success('تم تحديث الموزع وإنشاء حساب المستخدم المرتبط.')->flash();
            } elseif ($user) {
                // تحديث حساب المستخدم الموجود
                $email = $distributor->phone . '@distributor.local';
                
                // التحقق من عدم وجود email مكرر (إذا تغير phone)
                if ($user->email !== $email && \App\Models\User::where('email', $email)->exists()) {
                    \Alert::error('خطأ: البريد الإلكتروني "' . $email . '" مستخدم بالفعل.')->flash();
                    return redirect($this->crud->route);
                }
                
                $userUpdate = [
                    'name' => $distributor->name,
                    'email' => $email,
                ];
                
                // تحديث كلمة المرور إذا تم إدخالها
                if (!empty($request->password_hash)) {
                    $hashedPassword = bcrypt($request->password_hash);
                    $userUpdate['password'] = $hashedPassword;
                    // تحديث كلمة مرور الموزع أيضاً
                    $distributor->password_hash = $hashedPassword;
                    $distributor->save();
                }
                
                $user->update($userUpdate);
                \Alert::success('تم تحديث الموزع وحساب المستخدم المرتبط.')->flash();
            }
        } catch (\Exception $e) {
            \Alert::error('خطأ: ' . $e->getMessage())->flash();
            \Log::error('خطأ في تحديث موزع', [
                'error' => $e->getMessage(),
                'distributor_id' => $id,
            ]);
        }

        return redirect($this->crud->route);
    }

    protected function setupShowOperation()
    {
        // استخدام view مخصص لصفحة show
        CRUD::setShowView('admin.distributor_show');
        
        CRUD::addColumn([
            'name' => 'name',
            'label' => 'اسم الموزع',
            'tab' => 'البيانات الأساسية',
        ]);

        CRUD::addColumn([
            'name' => 'phone',
            'label' => 'رقم الهاتف',
            'tab' => 'البيانات الأساسية',
        ]);


        CRUD::addColumn([
            'name' => 'status',
            'label' => 'الحالة',
            'type' => 'select_from_array',
            'options' => [
                1 => 'نشط',
                0 => 'معطل',
            ],
            'tab' => 'البيانات الأساسية',
        ]);

        CRUD::addColumn([
            'name' => 'notes',
            'label' => 'ملاحظات',
            'type' => 'textarea',
            'tab' => 'البيانات الأساسية',
        ]);
    }

    /**
     * التحقق قبل الحذف
     */
    protected function setupDeleteOperation()
    {
        // التحقق من وجود عملاء مربوطين بهذا الموزع
        $this->crud->addClause('withCount', 'clients');
    }

    /**
     * تنفيذ الحذف مع التحقق
     * 
     * ⚠️ منع الحذف إذا كان هناك عملاء مربوطين بهذا الموزع
     */
    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        $entry = $this->crud->getEntry($id);

        // التحقق من وجود عملاء مربوطين بهذا الموزع
        $clientsCount = $entry->clients()->count();
        
        // ⚠️ منع الحذف إذا كان هناك عملاء مربوطين
        if ($clientsCount > 0) {
            \Alert::error(
                'لا يمكن حذف الموزع "' . $entry->name . '" لأن هناك ' . $clientsCount . ' عميل مربوطين به. ' .
                'يرجى تغيير الموزع لهؤلاء العملاء أولاً قبل الحذف.'
            )->flash();
            return redirect($this->crud->route);
        }

        // ✅ السماح بالحذف فقط إذا لم يكن هناك عملاء مربوطين
        $distributorName = $entry->name; // حفظ الاسم قبل الحذف
        $entry->delete();
        
        // إضافة رسالة نجاح صحيحة
        \Alert::success('تم حذف الموزع "' . $distributorName . '" بنجاح.')->flash();
        
        // Redirect صحيح إلى قائمة الموزعين
        return redirect($this->crud->route);
    }

}
