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
        CRUD::column('name')
            ->label('الاسم');

        CRUD::column('email')
            ->label('البريد الإلكتروني');

        CRUD::column('role')
            ->type('relationship')
            ->attribute('display_name')
            ->label('نوع المستخدم');

        CRUD::column('created_at')
            ->type('datetime')
            ->label('تاريخ الإنشاء');
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
                return $query->orderBy('display_name')->get();
            })
            ->default(function() {
                // افتراضي: نوع "مستخدم" (ليس super_admin)
                return \App\Models\Role::where('name', 'admin')->first()?->id;
            });
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
