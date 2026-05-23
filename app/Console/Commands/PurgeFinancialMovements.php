<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\CashWithdraw;
use App\Models\Client;
use App\Models\ClientPayment;
use App\Models\Delivery;
use App\Models\Expense;
use App\Models\ExpenseMonthlyAllocation;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Vendor;
use App\Models\VendorPayment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: حذف كل الحركات المالية المخزَّنة (دفعات، فواتير، مصروفات، سحوبات، أرصدة افتتاحية)،
 * وحذف **جميع التسليمات** بعد إلغاء ربطها بمدفوعات المشتركين.
 *
 * ⚠️ لا يُعاد ضبط كميات المخزون تلقائياً حسب تأثير التسليمات والفواتير؛ راجع المستودع يدوياً بعد التشغيل.
 */
class PurgeFinancialMovements extends Command
{
    protected $signature = 'financial:purge-movements
                            {--force : تنفيذ دون تأكيد تفاعلي}';

    protected $description = 'حذف الحركة المالية كاملاً وفق السجلات + حذف جميع التسليمات؛ الإبقاء على المشتركين وبيانات الأساسيات';

    public function handle(): int
    {
        if (! $this->option('force') && ! $this->confirm('سيتم حذف كل المدفوعات والفواتير والمصروفات ومدفوعات الموردين والسحوبات، وحذف **جميع التسليمات**، وتصفير الرصيد الافتتاحي وأرصدة الموردين. هل تتابع؟', false)) {
            return self::SUCCESS;
        }

        try {
            DB::transaction(function (): void {
                if (Schema::hasTable('deliveries')) {
                    Delivery::query()->update(['client_payment_id' => null]);
                }

                if (Schema::hasTable('client_payments')) {
                    ClientPayment::query()->delete();
                }

                if (Schema::hasTable('deliveries')) {
                    Delivery::query()->delete();
                }

                if (Schema::hasTable('invoice_items')) {
                    InvoiceItem::query()->delete();
                }

                if (Schema::hasTable('invoices')) {
                    Invoice::query()->delete();
                }

                if (Schema::hasTable('vendor_payments')) {
                    VendorPayment::query()->delete();
                }

                if (Schema::hasTable('expense_monthly_allocations')) {
                    ExpenseMonthlyAllocation::query()->delete();
                }

                if (Schema::hasTable('expenses')) {
                    Expense::query()->delete();
                }

                if (Schema::hasTable('cash_withdraws')) {
                    CashWithdraw::query()->delete();
                }

                if (Schema::hasTable('clients')) {
                    $updates = [];
                    if (Schema::hasColumn('clients', 'opening_balance_amount')) {
                        $updates['opening_balance_amount'] = 0;
                    }
                    if (Schema::hasColumn('clients', 'opening_balance_as_of')) {
                        $updates['opening_balance_as_of'] = null;
                    }
                    if ($updates !== []) {
                        Client::query()->update($updates);
                    }
                }

                if (Schema::hasTable('vendors') && Schema::hasColumn('vendors', 'opening_balance')) {
                    Vendor::query()->update(['opening_balance' => 0]);
                }
            });
        } catch (\Throwable $e) {
            $this->error('فشل التنفيذ: ' . $e->getMessage());

            return self::FAILURE;
        }

        $this->info('تم التنفيذ: حذف كل التسليمات، وحذف المدفوعات والفواتير والمصروفات ومدفوعات الموردين والسحوبات، وتصفير أرصدة افتتاحية للعملاء والموردين حيث وُجدت الأعمدة.');
        $this->warn('تأثر المخزون: حذف التسليمات والفواتير لا يعيد كميات الأصناف تلقائياً؛ راجع فوراً أرصدة المخزون والتسوية اليدوية.');
        $this->line('جدول أمانات العبوات (client_deposits) لم يُمس — أزلها يدوياً إن احتجت.');

        return self::SUCCESS;
    }
}
