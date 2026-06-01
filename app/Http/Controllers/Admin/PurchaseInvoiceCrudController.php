<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PurchaseInvoiceRequest;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceItem;
use App\Models\Vendor;
use App\Models\VendorPayment;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Business Purpose: فواتير مشتريات الموردين — عند التأكيد تُزاد كميات المخزون.
 */
class PurchaseInvoiceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    public function setup(): void
    {
        $this->assertFeatureEnabled();

        CRUD::setModel(PurchaseInvoice::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/purchase-invoice');
        CRUD::setEntityNameStrings('فاتورة مشتريات', 'فواتير المشتريات');
    }

    protected function setupListOperation(): void
    {
        $this->crud->addClause(function ($query): void {
            if (request()->filled('vendor_id')) {
                $query->where('vendor_id', request('vendor_id'));
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

        CRUD::column('invoice_number')->label('رقم الفاتورة')->type('text');
        CRUD::column('vendor.name')->label('المورد')->type('text');
        CRUD::column('invoice_date')->label('تاريخ الفاتورة')->type('date');
        CRUD::column('total_amount')->label('الإجمالي')->type('number')->suffix(' شيكل')->decimals(2);
        CRUD::column('status')->label('الحالة')->type('select_from_array')->options([
            'draft' => 'مسودة',
            'confirmed' => 'مؤكدة',
            'cancelled' => 'ملغاة',
        ]);
        CRUD::column('payment_status')->label('حالة الدفع')->type('select_from_array')->options([
            'paid' => 'مدفوع كامل',
            'partial' => 'مدفوع جزئي',
            'unpaid' => 'دين',
        ]);
        CRUD::column('amount_paid')->label('المدفوع')->type('number')->suffix(' شيكل')->decimals(2);
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(PurchaseInvoiceRequest::class);

        $prefillVendorId = request()->filled('vendor_id') ? (int) request('vendor_id') : null;

        $vendorField = CRUD::field('vendor_id')
            ->label('المورد')
            ->type('select')
            ->model(Vendor::class)
            ->attribute('name')
            ->options(fn ($query) => $query->where('is_active', true)->orderBy('name')->get())
            ->attributes(['required' => 'required']);

        if ($prefillVendorId !== null) {
            $vendorField->default($prefillVendorId);
        }

        CRUD::field('invoice_number')
            ->label('رقم الفاتورة')
            ->type('text')
            ->attributes(['readonly' => 'readonly', 'id' => 'purchase_invoice_number_field', 'placeholder' => 'يُولَّد تلقائياً']);

        CRUD::field('invoice_number_script')
            ->type('custom_html')
            ->value('
            <script>
            document.addEventListener("DOMContentLoaded", function() {
                const field = document.getElementById("purchase_invoice_number_field");
                if (!field || field.value) return;
                fetch("' . route('purchase-invoice.generate-number') . '", {
                    headers: { "X-Requested-With": "XMLHttpRequest", "Accept": "application/json" }
                })
                .then(r => r.json())
                .then(data => { if (data.success && data.invoice_number) field.value = data.invoice_number; });
            });
            </script>');

        CRUD::field('invoice_date')
            ->label('تاريخ الفاتورة')
            ->type('date')
            ->default(Carbon::now()->format('Y-m-d'))
            ->attributes(['required' => 'required']);

        CRUD::field('status')
            ->label('الحالة')
            ->type('select_from_array')
            ->options(['draft' => 'مسودة', 'confirmed' => 'مؤكدة', 'cancelled' => 'ملغاة'])
            ->default('draft');

        CRUD::field('payment_status')
            ->label('حالة الدفع')
            ->type('select_from_array')
            ->options(['paid' => 'مدفوع كامل', 'partial' => 'مدفوع جزئي', 'unpaid' => 'دين'])
            ->default('unpaid')
            ->attributes(['id' => 'payment_status_field']);

        CRUD::field('amount_paid')
            ->label('المبلغ المدفوع الآن')
            ->type('number')
            ->attributes(['step' => '0.01', 'min' => '0', 'id' => 'amount_paid_field']);

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
            ->default('cash');

        CRUD::field('payment_date')
            ->label('تاريخ الدفع')
            ->type('date')
            ->default(Carbon::now()->format('Y-m-d'));

        CRUD::field('notes')->label('ملاحظات')->type('textarea');

        CRUD::field('items_repeater')
            ->type('custom_html')
            ->value(view('admin.purchase_invoices.items_repeater')->render());

        CRUD::field('created_by')->type('hidden')->default(auth()->id());
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();

        $entry = $this->crud->getCurrentEntry();
        if ($entry instanceof PurchaseInvoice) {
            CRUD::field('items_repeater')
                ->value(view('admin.purchase_invoices.items_repeater', ['purchaseInvoice' => $entry])->render());
        }
    }

    protected function setupShowOperation(): void
    {
        CRUD::setShowView('admin.purchase_invoices.show');
    }

    /**
     * Business Purpose: عرض فاتورة المشتريات مع المورد والبنود.
     */
    public function show($id)
    {
        $this->crud->hasAccessOrFail('show');

        $id = $this->crud->getCurrentEntryId() ?? $id;
        $this->data['entry'] = PurchaseInvoice::query()
            ->with(['vendor', 'items', 'creator', 'vendorPayments'])
            ->findOrFail($id);
        $this->data['crud'] = $this->crud;

        return view($this->crud->getShowView(), $this->data);
    }

    /**
     * Business Purpose: حفظ فاتورة مشتريات جديدة مع بنودها ودفعة المورد.
     */
    public function store(PurchaseInvoiceRequest $request): RedirectResponse
    {
        $items = $this->normalizeItems($request->input('items', []));
        $totalAmount = $this->sumItemsTotal($items);
        $amountPaid = $this->resolveAmountPaid($request, $totalAmount);

        $targetStatus = (string) $request->status;
        $invoice = $this->createPurchaseInvoiceRecord($request, $totalAmount, $amountPaid);
        $this->persistItems($invoice, $items);
        $this->applyInvoiceStatus($invoice, $targetStatus);

        $this->syncVendorPayment($invoice, $request, $amountPaid);

        \Alert::success($this->buildSuccessMessage($request, 'تم إنشاء فاتورة المشتريات'))->flash();

        return redirect($this->crud->route);
    }

    /**
     * Business Purpose: تحديث فاتورة مشتريات مع عكس/إعادة المخزون حسب الحالة.
     */
    public function update(PurchaseInvoiceRequest $request): RedirectResponse
    {
        $invoice = $this->crud->getCurrentEntry();
        if (! $invoice instanceof PurchaseInvoice) {
            \Alert::error('الفاتورة غير موجودة.')->flash();

            return redirect($this->crud->route);
        }

        $wasConfirmed = $invoice->status === 'confirmed';
        $items = $this->normalizeItems($request->input('items', []));
        $totalAmount = $this->sumItemsTotal($items);
        $amountPaid = $this->resolveAmountPaid($request, $totalAmount);

        if ($wasConfirmed) {
            $invoice->cancel();
        }

        $targetStatus = (string) $request->status;

        $invoice->update([
            'vendor_id' => $request->vendor_id,
            'invoice_date' => $request->invoice_date,
            'status' => 'draft',
            'payment_status' => $request->payment_status,
            'amount_paid' => $amountPaid,
            'payment_method' => $amountPaid > 0 ? ($request->payment_method ?? 'cash') : null,
            'payment_date' => $amountPaid > 0 ? ($request->payment_date ?? Carbon::now()) : null,
            'notes' => $request->notes,
            'total_amount' => $totalAmount,
        ]);

        $invoice->items()->delete();
        $this->persistItems($invoice, $items);
        $this->applyInvoiceStatus($invoice, $targetStatus);

        $this->syncVendorPayment($invoice, $request, $amountPaid);

        \Alert::success($this->buildSuccessMessage($request, 'تم تحديث فاتورة المشتريات'))->flash();

        return redirect($this->crud->route);
    }

    /**
     * Business Purpose: حذف فاتورة (مع عكس المخزون إن كانت مؤكدة).
     */
    public function destroy($id): RedirectResponse
    {
        $invoice = $this->crud->getCurrentEntry();
        if (! $invoice instanceof PurchaseInvoice) {
            \Alert::error('الفاتورة غير موجودة.')->flash();

            return redirect($this->crud->route);
        }

        if ($invoice->status === 'confirmed') {
            $invoice->cancel();
        }

        $invoice->vendorPayments()->delete();
        $invoice->delete();

        \Alert::success('تم حذف فاتورة المشتريات.')->flash();

        return redirect($this->crud->route);
    }

    /**
     * Business Purpose: توليد رقم فاتورة مشتريات عبر AJAX.
     */
    public function generateInvoiceNumber(Request $request): JsonResponse
    {
        $this->assertFeatureEnabled();

        try {
            return response()->json([
                'success' => true,
                'invoice_number' => PurchaseInvoice::generateInvoiceNumber(),
            ]);
        } catch (\Throwable $e) {
            \Log::error('purchase_invoice.generate_number_failed', [
                'message' => $e->getMessage(),
            ]);

            return response()->json(['success' => false, 'error' => 'تعذّر توليد رقم الفاتورة'], 500);
        }
    }

    /**
     * Business Purpose: إيقاف الوحدة عند تعطيل Feature Flag.
     */
    private function assertFeatureEnabled(): void
    {
        if (! config('features.purchase_invoices', true)) {
            abort(404);
        }
    }

    /**
     * @param  array<int, array<string, mixed>>  $items
     * @return array<int, array{item_name: string, quantity: int, unit_cost: float}>
     */
    private function normalizeItems(array $items): array
    {
        $normalized = [];

        foreach ($items as $row) {
            $name = (string) ($row['item_name'] ?? '');
            if ($name === '__new__') {
                $name = trim((string) ($row['new_item_name'] ?? ''));
            }
            if ($name === '') {
                continue;
            }

            $normalized[] = [
                'item_name' => $name,
                'quantity' => (int) ($row['quantity'] ?? 0),
                'unit_cost' => (float) ($row['unit_cost'] ?? 0),
            ];
        }

        return $normalized;
    }

    /**
     * @param  array<int, array{item_name: string, quantity: int, unit_cost: float}>  $items
     */
    private function sumItemsTotal(array $items): float
    {
        $total = 0.0;
        foreach ($items as $item) {
            $total += $item['quantity'] * $item['unit_cost'];
        }

        return round($total, 2);
    }

    private function resolveAmountPaid(Request $request, float $totalAmount): float
    {
        if ($request->payment_status === 'paid') {
            return $totalAmount;
        }
        if ($request->payment_status === 'partial') {
            return round((float) ($request->amount_paid ?? 0), 2);
        }

        return 0.0;
    }

    private function createPurchaseInvoiceRecord(PurchaseInvoiceRequest $request, float $totalAmount, float $amountPaid): PurchaseInvoice
    {
        $maxRetries = 3;
        $retryCount = 0;

        while ($retryCount < $maxRetries) {
            try {
                return PurchaseInvoice::create([
                    'vendor_id' => $request->vendor_id,
                    'invoice_number' => $request->invoice_number ?: PurchaseInvoice::generateInvoiceNumber(),
                    'invoice_date' => $request->invoice_date,
                    'total_amount' => $totalAmount,
                    'status' => 'draft',
                    'payment_status' => $request->payment_status,
                    'amount_paid' => $amountPaid,
                    'payment_method' => $amountPaid > 0 ? ($request->payment_method ?? 'cash') : null,
                    'payment_date' => $amountPaid > 0 ? ($request->payment_date ?? Carbon::now()) : null,
                    'notes' => $request->notes,
                    'created_by' => auth()->id(),
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() === '23000' && str_contains($e->getMessage(), 'Duplicate entry')) {
                    $retryCount++;
                    usleep(100000);
                    continue;
                }
                throw $e;
            }
        }

        throw new \RuntimeException('Failed to generate unique purchase invoice number');
    }

    /**
     * @param  array<int, array{item_name: string, quantity: int, unit_cost: float}>  $items
     */
    private function persistItems(PurchaseInvoice $invoice, array $items): void
    {
        foreach ($items as $item) {
            $totalCost = round($item['quantity'] * $item['unit_cost'], 2);
            PurchaseInvoiceItem::create([
                'purchase_invoice_id' => $invoice->id,
                'item_name' => $item['item_name'],
                'quantity' => $item['quantity'],
                'unit_cost' => $item['unit_cost'],
                'total_cost' => $totalCost,
            ]);
        }
    }

    /**
     * Business Purpose: تطبيق الحالة النهائية بعد حفظ البنود (تأكيد = إدخال مخزون).
     */
    private function applyInvoiceStatus(PurchaseInvoice $invoice, string $targetStatus): void
    {
        $invoice->refresh();

        if ($targetStatus === 'confirmed') {
            $invoice->confirm();

            return;
        }

        if ($targetStatus === 'cancelled') {
            $invoice->update(['status' => 'cancelled']);

            return;
        }

        $invoice->update(['status' => 'draft']);
    }

    private function syncVendorPayment(PurchaseInvoice $invoice, Request $request, float $amountPaid): void
    {
        $invoice->vendorPayments()->delete();

        if ($amountPaid <= 0 || ! $invoice->vendor_id) {
            return;
        }

        VendorPayment::create([
            'vendor_id' => $invoice->vendor_id,
            'purchase_invoice_id' => $invoice->id,
            'amount' => $amountPaid,
            'method' => $request->payment_method ?? 'cash',
            'payment_date' => $request->payment_date ?? Carbon::now(),
            'notes' => 'دفعة من فاتورة مشتريات: ' . $invoice->invoice_number
                . ($request->payment_status === 'partial' ? ' (جزئي)' : ''),
            'created_by' => auth()->id(),
        ]);
    }

    private function buildSuccessMessage(Request $request, string $prefix): string
    {
        $message = $prefix . ' بنجاح';
        if ($request->status === 'confirmed') {
            $message .= ' وتمت إضافة الأصناف للمخزون';
        }
        if ($request->payment_status === 'paid') {
            $message .= ' مع تسجيل الدفع الكامل';
        } elseif ($request->payment_status === 'partial') {
            $message .= ' مع تسجيل دفع جزئي';
        }

        return $message . '.';
    }
}
