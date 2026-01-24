<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: إضافة حقول الموردين والمخزون إلى جدول المصروفات
 * - vendor_id: ربط المصروف بمورد معين
 * - is_inventory: هل هذا المصروف مخزون (COGS) أم مصروف عادي
 * - payment_status: حالة الدفع (paid, partial, unpaid)
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('expenses')) {
            Schema::table('expenses', function (Blueprint $table) {
                if (!Schema::hasColumn('expenses', 'vendor_id')) {
                    $table->foreignId('vendor_id')->nullable()->after('expense_category_id')->constrained('vendors')->onDelete('set null');
                    $table->index('vendor_id');
                }
                if (!Schema::hasColumn('expenses', 'is_inventory')) {
                    $table->boolean('is_inventory')->default(false)->after('vendor_id');
                    $table->index('is_inventory');
                }
                if (!Schema::hasColumn('expenses', 'payment_status')) {
                    $table->enum('payment_status', ['paid', 'partial', 'unpaid'])->default('unpaid')->after('is_inventory');
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
        if (Schema::hasTable('expenses')) {
            Schema::table('expenses', function (Blueprint $table) {
                if (Schema::hasColumn('expenses', 'vendor_id')) {
                    $table->dropForeign(['vendor_id']);
                    $table->dropColumn('vendor_id');
                }
                if (Schema::hasColumn('expenses', 'is_inventory')) {
                    $table->dropColumn('is_inventory');
                }
                if (Schema::hasColumn('expenses', 'payment_status')) {
                    $table->dropColumn('payment_status');
                }
            });
        }
    }
};
