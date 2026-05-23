<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: تمييز دفعات تمسّك بها لتغطية دين أو التزام مستقبلي لإظهارها في تقارير الصندوق بوضوح.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('client_payments', function (Blueprint $table) {
            if (! Schema::hasColumn('client_payments', 'for_future_obligation')) {
                $table->boolean('for_future_obligation')->default(false)->after('notes');
            }
        });
    }

    public function down(): void
    {
        Schema::table('client_payments', function (Blueprint $table) {
            if (Schema::hasColumn('client_payments', 'for_future_obligation')) {
                $table->dropColumn('for_future_obligation');
            }
        });
    }
};
