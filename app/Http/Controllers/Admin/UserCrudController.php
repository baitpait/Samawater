<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('مستخدم', 'المستخدمين');
    }

    protected function setupListOperation()
    {
        // Eager loading للعلاقات لتحسين الأداء
        $this->crud->addClause('with', ['role', 'distributor']);

        // إزالة جميع الأزرار الافتراضية لإخفاء عمود الإجراءات
        CRUD::removeButton('show');
        CRUD::removeButton('edit');
        CRUD::removeButton('delete');
        CRUD::removeButton('revisions');
        CRUD::removeButton('reorder');

        CRUD::column('name')
            ->label('الاسم')
            ->type('text');

        CRUD::column('email')
            ->label('البريد الإلكتروني')
            ->type('email');

        CRUD::column('role')
            ->label('نوع المستخدم')
            ->type('custom_html')
            ->value(function($entry) {
                if ($entry->role) {
                    $badgeColor = $entry->role->name === 'super_admin' ? 'bg-danger' : ($entry->role->name === 'admin' ? 'bg-primary' : 'bg-info');
                    return '<span class="badge ' . $badgeColor . ' text-white">' . e($entry->role->display_name ?? $entry->role->name) . '</span>';
                }
                return '<span class="text-muted">-</span>';
            })
            ->searchLogic(function ($query, $column, $searchTerm) {
                $query->orWhereHas('role', function ($q) use ($searchTerm) {
                    $q->where('display_name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('name', 'like', '%' . $searchTerm . '%');
                });
            });

        CRUD::column('distributor')
            ->label('الموزع')
            ->type('custom_html')
            ->value(function($entry) {
                if ($entry->distributor) {
                    return '<span class="fw-semibold text-primary-deep">' . e($entry->distributor->name) . '</span>';
                }
                return '<span class="text-muted">-</span>';
            })
            ->searchLogic(function ($query, $column, $searchTerm) {
                $query->orWhereHas('distributor', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%');
                });
            });

        CRUD::column('created_at')
            ->type('datetime')
            ->label('تاريخ الإنشاء')
            ->format('Y-m-d H:i');
    }

    protected function setupCreateOperation()
    {
        CRUD::field('name')
            ->label('الاسم')
            ->type('text')
            ->attributes(['required' => true]);

        CRUD::field('email')
            ->label('البريد الإلكتروني')
            ->type('email')
            ->attributes(['required' => true]);

        CRUD::field('password')
            ->label('كلمة المرور')
            ->type('password')
            ->attributes(['required' => true]);

        CRUD::field('role_id')
            ->label('نوع المستخدم')
            ->type('select')
            ->model('App\Models\Role')
            ->attribute('display_name')
            ->options(function ($query) {
                // عرض فقط مسؤول و موزع (استبعاد super_admin)
                return $query->whereIn('name', ['admin', 'distributor'])
                    ->orderByRaw("CASE WHEN name = 'admin' THEN 1 ELSE 2 END")
                    ->get();
            })
            ->default(function() {
                // افتراضي: نوع "مسؤول"
                return \App\Models\Role::where('name', 'admin')->first()?->id;
            });

        CRUD::field('distributor_id')
            ->label('الموزع (للموزعين فقط)')
            ->type('select')
            ->model('App\Models\Distributor')
            ->attribute('name')
            ->options(function ($query) {
                return $query->orderBy('name')->get();
            })
            ->allows_null(true);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();

        // في التعديل، كلمة المرور اختيارية
        CRUD::field('password')
            ->label('كلمة المرور (اتركه فارغاً إذا لم تريد تغييره)')
            ->type('password')
            ->attributes(['required' => false]);
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'distributor_id' => 'nullable|exists:distributors,id',
        ]);

        $request->merge([
            'password' => bcrypt($request->password),
        ]);

        return parent::store($request);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'distributor_id' => 'nullable|exists:distributors,id',
        ]);

        // إذا لم يتم إدخال كلمة مرور جديدة، احذفها من الطلب
        if (empty($request->password)) {
            $request->request->remove('password');
        } else {
            $request->merge([
                'password' => bcrypt($request->password),
            ]);
        }

        return parent::update($request, $id);
    }
}
