<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: ربط دفعات المورد بفاتورة المشتريات عند الدفع من الفاتورة.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('vendor_payments')) {
            return;
        }

        Schema::table('vendor_payments', function (Blueprint $table) {
            if (! Schema::hasColumn('vendor_payments', 'purchase_invoice_id')) {
                $table->foreignId('purchase_invoice_id')
                    ->nullable()
                    ->after('expense_id')
                    ->constrained('purchase_invoices')
                    ->nullOnDelete();
                $table->index('purchase_invoice_id');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('vendor_payments')) {
            return;
        }

        Schema::table('vendor_payments', function (Blueprint $table) {
            if (Schema::hasColumn('vendor_payments', 'purchase_invoice_id')) {
                $table->dropForeign(['purchase_invoice_id']);
                $table->dropColumn('purchase_invoice_id');
            }
        });
    }
};
