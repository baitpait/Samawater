<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Business Purpose: إضافة رصيد بداية المدة لكل مشترك.
     * - opening_balance_amount: الرصيد الافتتاحي المالي (شيكل)
     * - opening_balance_as_of: تاريخ اعتماد الرصيد الافتتاحي
     */
    public function up(): void
    {
        if (!Schema::hasTable('clients')) {
            return;
        }

        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'opening_balance_amount')) {
                $table->decimal('opening_balance_amount', 12, 2)->default(0)->after('delivery_on_demand');
            }

            if (!Schema::hasColumn('clients', 'opening_balance_as_of')) {
                $table->date('opening_balance_as_of')->nullable()->after('opening_balance_amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('clients')) {
            return;
        }

        Schema::table('clients', function (Blueprint $table) {
            if (Schema::hasColumn('clients', 'opening_balance_as_of')) {
                $table->dropColumn('opening_balance_as_of');
            }
            if (Schema::hasColumn('clients', 'opening_balance_amount')) {
                $table->dropColumn('opening_balance_amount');
            }
        });
    }
};
