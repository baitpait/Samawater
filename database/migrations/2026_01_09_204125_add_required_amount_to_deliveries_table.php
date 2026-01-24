<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Business Purpose: إضافة الحقول المطلوبة لجدول deliveries
     * - required_amount: المبلغ المطلوب الكامل من العميل
     * - inventory_item_id: ربط بصنف العبوات في المخزون (id=1)
     * - client_payment_id: ربط بالدفعة المرتبطة (إن وجدت)
     * - paymant: المبلغ المدفوع فعلياً
     * - إذا كان paymant < required_amount → دفع جزئي → يظهر دين
     */
    public function up(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            // إضافة required_amount
            if (!Schema::hasColumn('deliveries', 'required_amount')) {
                $table->decimal('required_amount', 10, 2)->default(0)->after('bottle_empty')->comment('المبلغ المطلوب الكامل من العميل');
            }
            
            // إضافة inventory_item_id
            if (!Schema::hasColumn('deliveries', 'inventory_item_id')) {
                $table->foreignId('inventory_item_id')->default(1)->after('required_amount')->constrained('inventory_items')->onDelete('restrict')->comment('ربط بصنف العبوات في المخزون');
            }
            
            // إضافة client_payment_id
            if (!Schema::hasColumn('deliveries', 'client_payment_id')) {
                $table->foreignId('client_payment_id')->nullable()->after('paymant')->constrained('client_payments')->onDelete('set null')->comment('ربط بالدفعة المرتبطة');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            if (Schema::hasColumn('deliveries', 'client_payment_id')) {
                $table->dropForeign(['client_payment_id']);
                $table->dropColumn('client_payment_id');
            }
            if (Schema::hasColumn('deliveries', 'inventory_item_id')) {
                $table->dropForeign(['inventory_item_id']);
                $table->dropColumn('inventory_item_id');
            }
            if (Schema::hasColumn('deliveries', 'required_amount')) {
                $table->dropColumn('required_amount');
            }
        });
    }
};
