<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: إضافة حقول الدفع إلى جدول الفواتير
 * - payment_status: حالة الدفع (paid, partial, unpaid)
 * - amount_paid: المبلغ المدفوع
 * - payment_method: طريقة الدفع (عند الدفع)
 * - payment_date: تاريخ الدفع
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('invoices')) {
            Schema::table('invoices', function (Blueprint $table) {
                if (!Schema::hasColumn('invoices', 'payment_status')) {
                    $table->enum('payment_status', ['paid', 'partial', 'unpaid'])->default('unpaid')->after('status');
                }
                if (!Schema::hasColumn('invoices', 'amount_paid')) {
                    $table->decimal('amount_paid', 10, 2)->default(0)->after('payment_status');
                }
                if (!Schema::hasColumn('invoices', 'payment_method')) {
                    $table->enum('payment_method', ['cash', 'bank_transfer', 'check', 'credit_card', 'other'])->nullable()->after('amount_paid');
                }
                if (!Schema::hasColumn('invoices', 'payment_date')) {
                    $table->date('payment_date')->nullable()->after('payment_method');
                }
                
                // Index
                if (!Schema::hasColumn('invoices', 'payment_status')) {
                    $table->index('payment_status');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('invoices')) {
            Schema::table('invoices', function (Blueprint $table) {
                if (Schema::hasColumn('invoices', 'payment_status')) {
                    $table->dropIndex(['payment_status']);
                    $table->dropColumn('payment_status');
                }
                if (Schema::hasColumn('invoices', 'amount_paid')) {
                    $table->dropColumn('amount_paid');
                }
                if (Schema::hasColumn('invoices', 'payment_method')) {
                    $table->dropColumn('payment_method');
                }
                if (Schema::hasColumn('invoices', 'payment_date')) {
                    $table->dropColumn('payment_date');
                }
            });
        }
    }
};
