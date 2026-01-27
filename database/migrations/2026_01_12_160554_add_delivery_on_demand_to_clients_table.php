<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     * 
     * Business Purpose: إضافة حقل "تسليم حسب الطلب" للمشتركين
     * - إذا كان true، يظهر المشترك في قائمة التسليم حتى لو لم يتجاوز distribution_days
     * - يتم إرجاعه إلى false تلقائياً بعد التسليم
     */
    public function up(): void
    {
        if (!Schema::hasTable('clients')) {
            return;
        }

        if (!Schema::hasColumn('clients', 'delivery_on_demand')) {
            Schema::table('clients', function (Blueprint $table) {
                if (Schema::hasColumn('clients', 'bottle_balance')) {
                    $table->boolean('delivery_on_demand')->default(false)->after('bottle_balance');
                } else {
                    $table->boolean('delivery_on_demand')->default(false);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('delivery_on_demand');
        });
    }
};
