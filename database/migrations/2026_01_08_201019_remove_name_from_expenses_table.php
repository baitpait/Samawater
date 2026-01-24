<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: إزالة حقل "اسم المصروف" من جدول expenses
 * - لم يعد هناك حاجة لاسم المصروف، سيتم الاعتماد على الفئة فقط
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('expenses') && Schema::hasColumn('expenses', 'name')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('expenses') && !Schema::hasColumn('expenses', 'name')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->string('name')->after('expense_category_id');
            });
        }
    }
};
