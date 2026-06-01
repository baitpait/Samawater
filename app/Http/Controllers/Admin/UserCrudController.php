<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\RedirectResponse;

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
     * Business Purpose: إنشاء مستخدم جديد مع تشفير كلمة المرور وربط الدور/الموزع.
     */
    public function store(): RedirectResponse
    {
        $this->crud->hasAccessOrFail('create');

        $request = request();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'distributor_id' => 'nullable|exists:distributors,id',
        ]);

        $item = $this->crud->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt((string) $request->input('password')),
            'role_id' => $request->input('role_id'),
            'distributor_id' => $request->input('distributor_id'),
        ]);

        $this->data['entry'] = $this->crud->entry = $item;

        \Alert::success(trans('backpack::crud.insert_success'))->flash();
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }

    /**
     * Business Purpose: تحديث مستخدم مع تشفير كلمة المرور عند تغييرها فقط.
     */
    public function update(): RedirectResponse
    {
        $this->crud->hasAccessOrFail('update');

        $id = $this->crud->getCurrentEntryId();
        $request = request();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'distributor_id' => 'nullable|exists:distributors,id',
        ]);

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role_id' => $request->input('role_id'),
            'distributor_id' => $request->input('distributor_id'),
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt((string) $request->input('password'));
        }

        $item = $this->crud->update($id, $data);
        $this->data['entry'] = $this->crud->entry = $item;

        \Alert::success(trans('backpack::crud.update_success'))->flash();
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
}
