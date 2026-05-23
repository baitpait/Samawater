<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClientPaymentRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\ClientPayment;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Business Purpose: إدارة مدفوعات المشتركين
 * - المدفوعات مرتبطة بالمشترك فقط (وليس بالفواتير)
 * - يمكن استخدامها لتسجيل أي دفعة من المشترك
 */
class ClientPaymentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(ClientPayment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/client-payment');
        CRUD::setEntityNameStrings('دفعة مشترك', 'مدفوعات المشتركين');
    }

    protected function setupListOperation()
    {
        // فلترة: عرض المدفوعات للعملاء الأب فقط (parent_id = null)
        $this->crud->addClause('whereHas', 'client', function($query) {
            $query->whereNull('parent_id');
        });

        // فلترة حسب معلمات الطلب (بدون Backpack PRO)
        $this->crud->addClause(function ($query) {
            if (request()->filled('client_id')) {
                $query->where('client_id', request('client_id'));
            }
            if (request()->filled('date_from')) {
                $query->whereDate('payment_date', '>=', request('date_from'));
            }
            if (request()->filled('date_to')) {
                $query->whereDate('payment_date', '<=', request('date_to'));
            }
            if (request()->filled('payment_method')) {
                $query->where('payment_method', request('payment_method'));
            }
        });
        
        CRUD::column('client.name')
            ->label('المشترك')
            ->type('text');
        
        CRUD::column('amount')
            ->label('المبلغ')
            ->type('number')
            ->suffix(' شيكل')
            ->decimals(2);
        
        CRUD::column('payment_date')
            ->label('تاريخ الدفع')
            ->type('date');

        CRUD::column('for_future_obligation')
            ->label('لدين مستقبلي')
            ->type('boolean');
        
        CRUD::column('payment_method')
            ->label('طريقة الدفع')
            ->type('select_from_array')
            ->options([
                'cash' => 'نقدي',
                'bank_transfer' => 'تحويل بنكي',
                'check' => 'شيك',
                'credit_card' => 'بطاقة ائتمان',
                'other' => 'أخرى',
            ]);
        
        CRUD::column('reference_number')
            ->label('الرقم المرجعي')
            ->type('text');
        
        CRUD::column('notes')
            ->label('ملاحظات')
            ->type('text')
            ->limit(50);
        
        CRUD::column('creator.name')
            ->label('بواسطة')
            ->type('text');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(ClientPaymentRequest::class);

        CRUD::field('client_id')
            ->label('المشترك')
            ->type('select')
            ->model('App\Models\Client')
            ->attribute('name')
            ->attributes(['required' => 'required'])
            ->options(function ($query) {
                // عرض المشتركين الأب فقط (parent_id = null)
                return $query->whereNull('parent_id')->orderBy('name')->get();
            })
            ->hint('يتم عرض المشتركين الرئيسيين فقط (الأب)');
        
        CRUD::field('amount')
            ->label('المبلغ (شيكل)')
            ->type('number')
            ->attributes(['step' => '0.01', 'min' => '0.01', 'required' => true]);
        
        CRUD::field('payment_date')
            ->label('تاريخ الدفع')
            ->type('date')
            ->attributes(['required' => true])
            ->default(Carbon::now()->format('Y-m-d'));
        
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
            ->attributes(['required' => true]);
        
        CRUD::field('reference_number')
            ->label('الرقم المرجعي')
            ->type('text')
            ->hint('رقم الشيك، رقم التحويل، إلخ.');
        
        CRUD::field('notes')
            ->label('ملاحظات')
            ->type('textarea');

        CRUD::field('for_future_obligation')
            ->label('دفعة لسداد دين/التزام مستقبلي')
            ->type('checkbox')
            ->hint('فعّلها عندما تكون الدفعة تحصيلاً مخصّصاً لما سيستحق لاحقاً (مقدّم)، لتظهر في تقارير الصندوق ضمن هذا النوع.')
            ->wrapperAttributes(['class' => 'form-group col-md-12']);
        
        CRUD::field('created_by')
            ->type('hidden')
            ->default(auth()->id());
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
        $this->crud->removeField('created_by');
    }

    /**
     * Business Purpose: حفظ دفعة جديدة
     */
    public function store(Request $request)
    {
        // التحقق من أن المشترك هو الأب (parent_id = null)
        $client = Client::find($request->client_id);
        if (!$client || $client->parent_id !== null) {
            \Alert::error('يمكن إنشاء المدفوعات للمشتركين الرئيسيين فقط (الأب).')->flash();
            return redirect()->back()->withInput();
        }
        
        // التحقق من صحة البيانات
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,check,credit_card,other',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'for_future_obligation' => 'nullable|boolean',
        ]);
        
        // إنشاء الدفعة
        $payment = ClientPayment::create([
            'client_id' => $request->client_id,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'payment_method' => $request->payment_method,
            'reference_number' => $request->reference_number,
            'notes' => $request->notes,
            'for_future_obligation' => $request->boolean('for_future_obligation'),
            'created_by' => auth()->id(),
        ]);
        
        \Alert::success('تم إنشاء الدفعة بنجاح.')->flash();
        
        // إعادة التوجيه حسب save action
        $saveAction = $request->input('_save_action', 'save_and_back');
        $redirectUrl = $this->crud->route;
        
        if ($saveAction === 'save_and_edit') {
            return redirect($redirectUrl . '/' . $payment->id . '/edit');
        } elseif ($saveAction === 'save_and_new') {
            return redirect($redirectUrl . '/create');
        }
        
        return redirect($redirectUrl);
    }

}
