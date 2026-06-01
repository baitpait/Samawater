<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InvoiceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Client;
use App\Models\InventoryItem;
use App\Models\ClientPayment;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * Business Purpose: إدارة فواتير المبيعات
 * - فواتير مبيعات للعملاء
 * - تحتوي على أصناف من المخزون
 * - يتم خصم المخزون عند تأكيد الفاتورة
 * - يمكن تعديل وحذف الفواتير المؤكدة
 */
class InvoiceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(Invoice::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/invoice');
        CRUD::setEntityNameStrings('فاتورة', 'فواتير مبيعات');
    }

    protected function setupListOperation()
    {
        // فلترة: عرض الفواتير للعملاء الأب فقط (parent_id = null)
        $this->crud->addClause('whereHas', 'client', function($query) {
            $query->whereNull('parent_id');
        });

        // فلترة حسب معلمات الطلب (بدون Backpack PRO)
        $this->crud->addClause(function ($query) {
            if (request()->filled('client_id')) {
                $query->where('client_id', request('client_id'));
            }
            if (request()->filled('subscription_status_id')) {
                $query->whereHas('client', function ($q) {
                    $q->where('subscription_status_id', request('subscription_status_id'));
                });
            }
            if (request()->filled('date_from')) {
                $query->whereDate('invoice_date', '>=', request('date_from'));
            }
            if (request()->filled('date_to')) {
                $query->whereDate('invoice_date', '<=', request('date_to'));
            }
            if (request()->filled('status')) {
                $query->where('status', request('status'));
            }
            if (request()->filled('payment_status')) {
                $query->where('payment_status', request('payment_status'));
            }
        });
        
        CRUD::column('invoice_number')
            ->label('رقم الفاتورة')
            ->type('text');
        
        CRUD::column('client.name')
            ->label('المشترك')
            ->type('text');
        
        CRUD::column('invoice_date')
            ->label('تاريخ الفاتورة')
            ->type('date');
        
        CRUD::column('total_amount')
            ->label('المبلغ الإجمالي')
            ->type('number')
            ->suffix(' شيكل')
            ->decimals(2);
        
        CRUD::column('status')
            ->label('الحالة')
            ->type('select_from_array')
            ->options([
                'draft' => 'مسودة',
                'confirmed' => 'مؤكدة',
                'cancelled' => 'ملغاة',
            ]);
        
        CRUD::column('payment_status')
            ->label('حالة الدفع')
            ->type('select_from_array')
            ->options([
                'paid' => 'مدفوع كامل',
                'partial' => 'مدفوع جزئي',
                'unpaid' => 'دين',
            ]);
        
        CRUD::column('amount_paid')
            ->label('المبلغ المدفوع')
            ->type('number')
            ->suffix(' شيكل')
            ->decimals(2);
        
        CRUD::column('items_count')
            ->label('عدد الأصناف')
            ->type('custom_html')
            ->value(function($entry) {
                return $entry->items()->count();
            });
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(InvoiceRequest::class);

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
        
        CRUD::field('invoice_number')
            ->label('رقم الفاتورة')
            ->type('text')
            ->attributes(['readonly' => 'readonly', 'id' => 'invoice_number_field', 'placeholder' => 'سيتم توليده تلقائياً'])
            ->hint('سيتم توليد رقم الفاتورة تلقائياً عند تحميل الصفحة');
        
        // JavaScript لتوليد رقم الفاتورة عند تحميل الصفحة
        CRUD::field('invoice_number_script')
            ->type('custom_html')
            ->value('
            <script>
            document.addEventListener("DOMContentLoaded", function() {
                const invoiceNumberField = document.getElementById("invoice_number_field");
                if (invoiceNumberField && !invoiceNumberField.value) {
                    // توليد رقم فاتورة جديد عبر AJAX
                    fetch("' . route('invoice.generate-number') . '", {
                        method: "GET",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": document.querySelector(\'meta[name="csrf-token"]\')?.getAttribute("content") || "",
                            "Accept": "application/json"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.invoice_number) {
                            invoiceNumberField.value = data.invoice_number;
                        }
                    })
                    .catch(error => {
                        console.error("Error generating invoice number:", error);
                    });
                }
            });
            </script>
            ');
        
        CRUD::field('invoice_date')
            ->label('تاريخ الفاتورة')
            ->type('date')
            ->attributes(['required' => true])
            ->default(Carbon::now()->format('Y-m-d'));
        
        CRUD::field('status')
            ->label('الحالة')
            ->type('select_from_array')
            ->options([
                'draft' => 'مسودة',
                'confirmed' => 'مؤكدة',
                'cancelled' => 'ملغاة',
            ])
            ->default('draft');
        
        CRUD::field('payment_status')
            ->label('حالة الدفع')
            ->type('select_from_array')
            ->options([
                'paid' => 'مدفوع كامل',
                'partial' => 'مدفوع جزئي',
                'unpaid' => 'دين',
            ])
            ->default('unpaid')
            ->attributes(['id' => 'payment_status_field']);
        
        CRUD::field('amount_paid')
            ->label('المبلغ المدفوع (شيكل)')
            ->type('number')
            ->attributes(['step' => '0.01', 'min' => '0', 'id' => 'amount_paid_field'])
            ->hint('يظهر فقط عند "مدفوع جزئي" - سيتم إنشاء دفعة تلقائياً')
            ->wrapper(['class' => 'form-group col-md-6 payment-field']);
        
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
            ->wrapper(['class' => 'form-group col-md-6 payment-field'])
            ->attributes(['id' => 'payment_method_field']);
        
        CRUD::field('payment_date')
            ->label('تاريخ الدفع')
            ->type('date')
            ->default(Carbon::now()->format('Y-m-d'))
            ->wrapper(['class' => 'form-group col-md-6 payment-field'])
            ->attributes(['id' => 'payment_date_field']);
        
        CRUD::field('notes')
            ->label('ملاحظات')
            ->type('textarea');
        
        // JavaScript لإظهار/إخفاء حقول الدفع
        CRUD::field('payment_fields_script')
            ->type('custom_html')
            ->value('
            <script>
            document.addEventListener("DOMContentLoaded", function() {
                const paymentStatusField = document.getElementById("payment_status_field");
                const paymentFields = document.querySelectorAll(".payment-field");
                
                function togglePaymentFields() {
                    const status = paymentStatusField ? paymentStatusField.value : "unpaid";
                    
                    paymentFields.forEach(field => {
                        const parent = field.closest(".form-group");
                        if (parent) {
                            // فقط "مدفوع جزئي" يظهر حقول الدفع
                            if (status === "partial") {
                                parent.style.display = "block";
                            } else {
                                // "دين" أو "مدفوع كامل" → إخفاء جميع حقول الدفع
                                parent.style.display = "none";
                            }
                        }
                    });
                    
                    // إذا كان "مدفوع كامل"، تعبئة المبلغ تلقائياً من المجموع الكلي
                    if (status === "paid") {
                        const grandTotal = parseFloat(document.getElementById("grand-total")?.value || 0);
                        const amountPaidField = document.getElementById("amount_paid_field");
                        if (amountPaidField) {
                            amountPaidField.value = grandTotal.toFixed(2);
                        }
                    } else if (status === "unpaid") {
                        // إذا كان "دين"، مسح المبلغ المدفوع
                        const amountPaidField = document.getElementById("amount_paid_field");
                        if (amountPaidField) {
                            amountPaidField.value = "0.00";
                        }
                    }
                }
                
                if (paymentStatusField) {
                    paymentStatusField.addEventListener("change", togglePaymentFields);
                }
                
                // الاستماع لتغيير المجموع الكلي (من items_repeater)
                const observer = new MutationObserver(function() {
                    const status = paymentStatusField ? paymentStatusField.value : "unpaid";
                    if (status === "paid") {
                        const grandTotal = parseFloat(document.getElementById("grand-total")?.value || 0);
                        const amountPaidField = document.getElementById("amount_paid_field");
                        if (amountPaidField) {
                            amountPaidField.value = grandTotal.toFixed(2);
                        }
                    }
                });
                
                const grandTotalElement = document.getElementById("grand-total");
                if (grandTotalElement) {
                    observer.observe(grandTotalElement, { attributes: true, childList: true, subtree: true });
                }
                
                // Initial state
                setTimeout(togglePaymentFields, 100);
            });
            </script>
            ');
        
        // حقول الأصناف (سيتم إدارتها عبر JavaScript)
        CRUD::field('items_json')
            ->label('الأصناف')
            ->type('custom_html')
            ->value(view('admin.invoices.items_repeater')->render());
        
        CRUD::field('created_by')
            ->type('hidden')
            ->default(auth()->id());
    }

    /**
     * Business Purpose: معاينة الفاتورة بالعربية مع جدول الأصناف وجميع التفاصيل المالية.
     */
    protected function setupShowOperation(): void
    {
        CRUD::setShowView('admin.invoices.show');
    }

    /**
     * Business Purpose: تحميل علاقات الفاتورة قبل عرض صفحة المعاينة.
     */
    public function show($id)
    {
        $this->crud->hasAccessOrFail('show');

        $id = $this->crud->getCurrentEntryId() ?? $id;
        $this->data['entry'] = Invoice::query()
            ->with(['client', 'items', 'creator'])
            ->findOrFail($id);
        $this->data['crud'] = $this->crud;

        return view($this->crud->getShowView(), $this->data);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
        
        // تحميل الأصناف الحالية
        $invoice = $this->crud->getCurrentEntry();
        if ($invoice) {
            CRUD::field('items_json')
                ->value(view('admin.invoices.items_repeater', ['invoice' => $invoice])->render());
        }
    }

    /**
     * Business Purpose: حفظ الفاتورة مع أصنافها
     */
    public function store(Request $request)
    {
        // التحقق من أن المشترك هو الأب (parent_id = null)
        $client = Client::find($request->client_id);
        if (!$client || $client->parent_id !== null) {
            \Alert::error('يمكن إنشاء الفواتير للعملاء الرئيسيين فقط (الأب).')->flash();
            return redirect()->back()->withInput();
        }
        
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_date' => 'required|date',
            'status' => 'required|in:draft,confirmed,cancelled',
            'payment_status' => 'required|in:paid,partial,unpaid',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0.01',
        ]);

        // حساب المبلغ الإجمالي
        $totalAmount = 0;
        foreach ($request->items as $itemData) {
            $totalPrice = $itemData['quantity'] * $itemData['unit_price'];
            $totalAmount += $totalPrice;
        }

        // تحديد المبلغ المدفوع
        $amountPaid = 0;
        if ($request->payment_status === 'paid') {
            // مدفوع كامل = المبلغ الإجمالي
            $amountPaid = $totalAmount;
        } elseif ($request->payment_status === 'partial') {
            // مدفوع جزئي = المبلغ المدخل
            $amountPaid = $request->amount_paid ?? 0;
        }
        // unpaid = 0 (لا يتم إنشاء دفعة، المبلغ الإجمالي = الدين)

        // توليد رقم الفاتورة مع إعادة المحاولة في حالة التكرار
        $maxRetries = 3;
        $retryCount = 0;
        $invoice = null;
        
        while ($retryCount < $maxRetries) {
            try {
                $invoiceNumber = $request->invoice_number ?: Invoice::generateInvoiceNumber();
                
                $invoice = Invoice::create([
                    'client_id' => $request->client_id,
                    'invoice_number' => $invoiceNumber,
                    'invoice_date' => $request->invoice_date,
                    'status' => $request->status,
                    'payment_status' => $request->payment_status,
                    'amount_paid' => $amountPaid,
                    'payment_method' => ($amountPaid > 0) ? ($request->payment_method ?? 'cash') : null,
                    'payment_date' => ($amountPaid > 0) ? ($request->payment_date ?? Carbon::now()) : null,
                    'notes' => $request->notes,
                    'created_by' => auth()->id(),
                ]);
                
                // نجح الإنشاء، نخرج من الحلقة
                break;
                
            } catch (\Illuminate\Database\QueryException $e) {
                // إذا كان الخطأ بسبب duplicate entry
                if ($e->getCode() == 23000 && strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    $retryCount++;
                    
                    if ($retryCount >= $maxRetries) {
                        \Alert::error('حدث خطأ في توليد رقم الفاتورة. يرجى المحاولة مرة أخرى.')->flash();
                        \Log::error('Failed to generate unique invoice number after ' . $maxRetries . ' attempts', [
                            'request' => $request->all(),
                            'error' => $e->getMessage()
                        ]);
                        return redirect()->back()->withInput();
                    }
                    
                    // انتظار قصير قبل إعادة المحاولة (للمساعدة في تجنب race conditions)
                    usleep(100000); // 0.1 ثانية
                    continue;
                }
                
                // خطأ آخر، نرميه
                throw $e;
            }
        }

        // إضافة الأصناف
        foreach ($request->items as $itemData) {
            $totalPrice = $itemData['quantity'] * $itemData['unit_price'];
            
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_name' => $itemData['item_name'],
                'quantity' => $itemData['quantity'],
                'unit_price' => $itemData['unit_price'],
                'total_price' => $totalPrice,
            ]);
        }

        $invoice->total_amount = $totalAmount;
        $invoice->save();

        // إذا كانت الفاتورة مؤكدة، خصم من المخزون
        if ($request->status === 'confirmed') {
            $invoice->confirm();
        }

        // إنشاء دفعة تلقائياً إذا كان هناك مبلغ مدفوع (paid أو partial)
        if ($amountPaid > 0) {
            ClientPayment::create([
                'client_id' => $invoice->client_id,
                'amount' => $amountPaid,
                'payment_date' => ($request->payment_status === 'paid') ? ($request->invoice_date ?? Carbon::now()) : ($request->payment_date ?? Carbon::now()),
                'payment_method' => ($request->payment_status === 'paid') ? ($request->payment_method ?? 'cash') : ($request->payment_method ?? 'cash'),
                'notes' => 'دفعة تلقائية من الفاتورة: ' . $invoice->invoice_number . ($request->payment_status === 'partial' ? ' (جزئي)' : ''),
                'created_by' => auth()->id(),
            ]);
        }

        $message = 'تم إنشاء الفاتورة بنجاح';
        if ($request->payment_status === 'paid') {
            $message .= ' وتم تسجيل الدفعة الكاملة تلقائياً';
        } elseif ($request->payment_status === 'partial') {
            $message .= ' وتم تسجيل الدفعة الجزئية تلقائياً';
        } else {
            $message .= ' (دين على المشترك)';
        }
        
        \Alert::success($message . '.')->flash();
        return redirect($this->crud->route);
    }

    /**
     * Business Purpose: تحديث الفاتورة مع أصنافها
     */
    public function update(Request $request)
    {
        // التحقق من أن المشترك هو الأب (parent_id = null)
        $client = Client::find($request->client_id);
        if (!$client || $client->parent_id !== null) {
            \Alert::error('يمكن إنشاء الفواتير للعملاء الرئيسيين فقط (الأب).')->flash();
            return redirect()->back()->withInput();
        }
        
        $invoice = $this->crud->getCurrentEntry();
        
        if (!$invoice) {
            \Alert::error('الفاتورة غير موجودة.')->flash();
            return redirect($this->crud->route);
        }

        $oldStatus = $invoice->status;
        $wasConfirmed = $oldStatus === 'confirmed';

        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_date' => 'required|date',
            'status' => 'required|in:draft,confirmed,cancelled',
            'payment_status' => 'required|in:paid,partial,unpaid',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0.01',
        ]);

        // حساب المبلغ الإجمالي
        $totalAmount = 0;
        foreach ($request->items as $itemData) {
            $totalPrice = $itemData['quantity'] * $itemData['unit_price'];
            $totalAmount += $totalPrice;
        }

        // تحديد المبلغ المدفوع
        $amountPaid = 0;
        if ($request->payment_status === 'paid') {
            // مدفوع كامل = المبلغ الإجمالي
            $amountPaid = $totalAmount;
        } elseif ($request->payment_status === 'partial') {
            // مدفوع جزئي = المبلغ المدخل
            $amountPaid = $request->amount_paid ?? 0;
        }
        // unpaid = 0 (لا يتم إنشاء دفعة، المبلغ الإجمالي = الدين)

        // إذا كانت مؤكدة، إرجاع المخزون أولاً
        if ($wasConfirmed) {
            $invoice->cancel(); // إرجاع المخزون
        }

        // حذف الدفعة القديمة المرتبطة بهذه الفاتورة (إن وجدت)
        $oldPayment = ClientPayment::where('notes', 'like', '%' . $invoice->invoice_number . '%')
            ->where('client_id', $invoice->client_id)
            ->first();
        if ($oldPayment) {
            $oldPayment->delete();
        }

        // تحديث بيانات الفاتورة
        $invoice->update([
            'client_id' => $request->client_id,
            'invoice_date' => $request->invoice_date,
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'amount_paid' => $amountPaid,
            'payment_method' => ($amountPaid > 0) ? ($request->payment_method ?? 'cash') : null,
            'payment_date' => ($amountPaid > 0) ? ($request->payment_date ?? Carbon::now()) : null,
            'notes' => $request->notes,
        ]);

        // حذف الأصناف القديمة وإضافة الجديدة
        $invoice->items()->delete();
        
        foreach ($request->items as $itemData) {
            $totalPrice = $itemData['quantity'] * $itemData['unit_price'];
            
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_name' => $itemData['item_name'],
                'quantity' => $itemData['quantity'],
                'unit_price' => $itemData['unit_price'],
                'total_price' => $totalPrice,
            ]);
        }

        $invoice->total_amount = $totalAmount;
        $invoice->save();

        // إذا أصبحت مؤكدة، خصم من المخزون
        if ($request->status === 'confirmed') {
            $invoice->confirm();
        }

        // إنشاء دفعة جديدة إذا كان هناك مبلغ مدفوع (paid أو partial)
        if ($amountPaid > 0) {
            ClientPayment::create([
                'client_id' => $invoice->client_id,
                'amount' => $amountPaid,
                'payment_date' => ($request->payment_status === 'paid') ? ($request->invoice_date ?? Carbon::now()) : ($request->payment_date ?? Carbon::now()),
                'payment_method' => ($request->payment_status === 'paid') ? ($request->payment_method ?? 'cash') : ($request->payment_method ?? 'cash'),
                'notes' => 'دفعة تلقائية من الفاتورة: ' . $invoice->invoice_number . ($request->payment_status === 'partial' ? ' (جزئي)' : ''),
                'created_by' => auth()->id(),
            ]);
        }

        $message = 'تم تحديث الفاتورة بنجاح';
        if ($request->payment_status === 'paid') {
            $message .= ' وتم تسجيل الدفعة الكاملة تلقائياً';
        } elseif ($request->payment_status === 'partial') {
            $message .= ' وتم تسجيل الدفعة الجزئية تلقائياً';
        } else {
            $message .= ' (دين على المشترك)';
        }
        
        \Alert::success($message . '.')->flash();
        return redirect($this->crud->route);
    }

    /**
     * Business Purpose: حذف الفاتورة
     */
    public function destroy($id)
    {
        $invoice = $this->crud->getCurrentEntry();
        
        if (!$invoice) {
            \Alert::error('الفاتورة غير موجودة.')->flash();
            return redirect($this->crud->route);
        }

        // إذا كانت مؤكدة، إرجاع المخزون
        if ($invoice->status === 'confirmed') {
            $invoice->cancel();
        }

        $invoice->delete();

        \Alert::success('تم حذف الفاتورة بنجاح.')->flash();
        return redirect($this->crud->route);
    }

    /**
     * Business Purpose: توليد رقم فاتورة جديد عبر AJAX
     * يستخدم عند تحميل صفحة الإنشاء
     */
    public function generateInvoiceNumber(Request $request)
    {
        try {
            $invoiceNumber = Invoice::generateInvoiceNumber();
            return response()->json([
                'success' => true,
                'invoice_number' => $invoiceNumber
            ]);
        } catch (\Exception $e) {
            \Log::error('Error generating invoice number: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'حدث خطأ في توليد رقم الفاتورة'
            ], 500);
        }
    }
}
