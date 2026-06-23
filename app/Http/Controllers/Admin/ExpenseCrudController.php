<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Expense;
use App\Services\ExpenseQueryService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

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

    public function __construct(
        private readonly ExpenseQueryService $expenseQuery,
    ) {
        parent::__construct();
    }

    public function setup()
    {
        CRUD::setModel(Expense::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/expense');
        CRUD::setEntityNameStrings('مصروف', 'المصروفات');
    }

    protected function setupListOperation()
    {
        $this->crud->query = $this->expenseQuery->filteredOperationalQuery(request());

        CRUD::column('expense_display')
            ->label('المصروف')
            ->type('custom_html')
            ->value(function ($entry): string {
                return '<span class="fw-bold" style="color: var(--primary-deep);">'
                    .e($this->expenseQuery->formatExpenseLabel($entry))
                    .'</span>';
            });

        CRUD::column('beneficiary_name')
            ->label('صاحب المصروف')
            ->type('custom_html')
            ->value(function ($entry): string {
                $name = trim((string) ($entry->beneficiary?->name ?? ''));

                return $name !== ''
                    ? '<span class="badge bg-primary">'.e($name).'</span>'
                    : '<span class="text-muted">—</span>';
            });
        
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
            ->type('number');
        
        CRUD::column('monthly_amount')
            ->label('المبلغ الشهري')
            ->type('number')
            ->suffix(' شيكل')
            ->decimals(2);
        
        CRUD::column('start_month')
            ->label('الشهر الأول')
            ->type('date')
            ->format('Y-m');
        
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

        CRUD::field('expense_beneficiary_id')
            ->label('صاحب المصروف')
            ->type('select')
            ->model('App\Models\ExpenseBeneficiary')
            ->attribute('name')
            ->attributes(['required' => 'required'])
            ->options(function ($query) {
                $categoryId = (int) (request()->input('expense_category_id')
                    ?? optional($this->crud->getCurrentEntry())->expense_category_id
                    ?? 0);

                $builder = $query->where('is_active', true)->orderBy('name');
                if ($categoryId > 0) {
                    $builder->where('expense_category_id', $categoryId);
                }

                return $builder->get();
            })
            ->hint('يُعرض أصحاب المصروف المرتبطون بالفئة المختارة — أضفهم من «أصحاب المصروف»');
        
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
        
        $this->crud->addField([
            'name' => 'expense_quick_pay_script',
            'type' => 'custom_html',
            'value' => '
            <script>
            document.addEventListener("DOMContentLoaded", function() {
                const paymentStatusField = document.getElementById("payment_status_field");
                function toggleQuickPayFields() {
                    const status = paymentStatusField ? paymentStatusField.value : "unpaid";
                    document.querySelectorAll(".quick-pay-field").forEach(function(field) {
                        const parent = field.closest(".form-group");
                        if (!parent) return;
                        if (status === "paid") {
                            parent.style.display = field.querySelector("#amount_paid_now_field") ? "none" : "block";
                        } else if (status === "partial") {
                            parent.style.display = "block";
                        } else {
                            parent.style.display = "none";
                        }
                    });
                }
                if (paymentStatusField) {
                    paymentStatusField.addEventListener("change", toggleQuickPayFields);
                }
                setTimeout(toggleQuickPayFields, 100);
            });
            </script>
            ',
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /**
     * Store a newly created resource in storage.
     * 
     * Business Purpose: إنشاء مصروف تشغيلي مع توزيعه تلقائياً على الأشهر.
     */
    public function store(Request $request)
    {
        $rules = [
            'expense_category_id' => 'required|exists:expense_categories,id',
            'expense_beneficiary_id' => [
                'required',
                Rule::exists('expense_beneficiaries', 'id')->where(
                    static fn ($query) => $query->where('expense_category_id', (int) $request->input('expense_category_id'))
                ),
            ],
            'total_amount' => 'required|numeric|min:0.01',
            'payment_status' => 'required|in:paid,partial,unpaid',
            'payment_date' => 'required|date',
            'number_of_months' => 'required|integer|min:1',
            'start_month' => 'required|date',
        ];
        
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

        $expense = Expense::create([
            'expense_category_id' => $request->expense_category_id,
            'expense_beneficiary_id' => $request->expense_beneficiary_id,
            'vendor_id' => null,
            'is_inventory' => false,
            'payment_status' => $request->payment_status,
            'total_amount' => $request->total_amount,
            'number_of_months' => $request->number_of_months,
            'monthly_amount' => $monthlyAmount,
            'start_month' => $request->start_month,
            'end_month' => $endMonth,
            'payment_date' => $request->payment_date,
            'notes' => $request->notes,
            'created_by' => auth()->id(),
        ]);

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

        \Alert::success('تم إنشاء المصروف وتوزيعه على ' . $request->number_of_months . ' شهر بنجاح.')->flash();
        
        return redirect($this->crud->route);
    }

    /**
     * Update the specified resource in storage.
     * 
     * Business Purpose: تحديث مصروف تشغيلي مع إعادة إنشاء التوزيعات الشهرية.
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

        if ($expense->is_inventory) {
            \Alert::error('هذا السجل من نوع مخزون قديم — عدّله من فواتير المشتريات أو اتصل بالدعم.')->flash();

            return redirect($this->crud->route);
        }

        $rules = [
            'expense_category_id' => 'required|exists:expense_categories,id',
            'expense_beneficiary_id' => [
                'required',
                Rule::exists('expense_beneficiaries', 'id')->where(
                    static fn ($query) => $query->where('expense_category_id', (int) $request->input('expense_category_id'))
                ),
            ],
            'total_amount' => 'required|numeric|min:0.01',
            'payment_status' => 'required|in:paid,partial,unpaid',
            'payment_date' => 'required|date',
            'number_of_months' => 'required|integer|min:1',
            'start_month' => 'required|date',
        ];

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

        $expense->update([
            'expense_category_id' => $request->expense_category_id,
            'expense_beneficiary_id' => $request->expense_beneficiary_id,
            'vendor_id' => null,
            'is_inventory' => false,
            'payment_status' => $request->payment_status,
            'total_amount' => $request->total_amount,
            'number_of_months' => $request->number_of_months,
            'monthly_amount' => $monthlyAmount,
            'start_month' => $request->start_month,
            'end_month' => $endMonth,
            'payment_date' => $request->payment_date,
            'notes' => $request->notes,
        ]);

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

        \Alert::success('تم تحديث المصروف وإعادة توزيعه على ' . $request->number_of_months . ' شهر بنجاح.')->flash();
        
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

    /**
     * Business Purpose: تصدير المصروفات التشغيلية المفلترة إلى CSV مع صاحب المصروف.
     */
    public function exportExcel(Request $request)
    {
        $expenses = $this->expenseQuery->filteredOperationalQuery($request)->get();

        $filename = 'المصروفات_'.date('Y-m-d').'.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $paymentLabels = [
            'paid' => 'مدفوع',
            'partial' => 'جزئي',
            'unpaid' => 'غير مدفوع',
        ];

        $callback = function () use ($expenses, $paymentLabels): void {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['المصروفات التشغيلية'], ';');
            fputcsv($file, []); 

            fputcsv($file, [
                'المصروف',
                'الفئة',
                'صاحب المصروف',
                'المبلغ الإجمالي',
                'حالة الدفع',
                'تاريخ الدفع',
                'عدد الأشهر',
                'المبلغ الشهري',
                'ملاحظات',
            ], ';');

            foreach ($expenses as $expense) {
                fputcsv($file, [
                    $this->expenseQuery->formatExpenseLabel($expense),
                    $expense->category?->name ?? '',
                    $expense->beneficiary?->name ?? '',
                    number_format((float) $expense->total_amount, 2, '.', ''),
                    $paymentLabels[$expense->payment_status] ?? $expense->payment_status,
                    $expense->payment_date?->format('Y-m-d') ?? '',
                    (int) $expense->number_of_months,
                    number_format((float) $expense->monthly_amount, 2, '.', ''),
                    $expense->notes ?? '',
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Business Purpose: تصدير المصروفات التشغيلية المفلترة إلى PDF مع صاحب المصروف.
     */
    public function exportPdf(Request $request)
    {
        $expenses = $this->expenseQuery->filteredOperationalQuery($request)->get();

        $html = view('admin.expenses.export_pdf', [
            'expenses' => $expenses,
            'expenseQuery' => $this->expenseQuery,
        ])->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'directionality' => 'rtl',
            'default_font' => 'dejavusans',
            'tempDir' => storage_path('app/mpdf'),
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output(
            'المصروفات_'.date('Y-m-d').'.pdf',
            'I'
        ))->header('Content-Type', 'application/pdf');
    }
}
