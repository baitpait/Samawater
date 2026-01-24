<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: جعل حقول التوزيع الشهري (Amortization) nullable
 * - عندما يكون المصروف مخزون (is_inventory = true)، لا نحتاج لحقول التوزيع
 * - هذه الحقول مطلوبة فقط للمصروفات العادية التي يتم توزيعها على أشهر
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
                // جعل حقول التوزيع الشهري nullable
                if (Schema::hasColumn('expenses', 'number_of_months')) {
                    $table->integer('number_of_months')->nullable()->change();
                }
                if (Schema::hasColumn('expenses', 'monthly_amount')) {
                    $table->decimal('monthly_amount', 10, 2)->nullable()->change();
                }
                if (Schema::hasColumn('expenses', 'start_month')) {
                    $table->date('start_month')->nullable()->change();
                }
                if (Schema::hasColumn('expenses', 'end_month')) {
                    $table->date('end_month')->nullable()->change();
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
                // إعادة الحقول إلى required (لكن هذا قد يفشل إذا كان هناك NULL values)
                if (Schema::hasColumn('expenses', 'number_of_months')) {
                    $table->integer('number_of_months')->nullable(false)->change();
                }
                if (Schema::hasColumn('expenses', 'monthly_amount')) {
                    $table->decimal('monthly_amount', 10, 2)->nullable(false)->change();
                }
                if (Schema::hasColumn('expenses', 'start_month')) {
                    $table->date('start_month')->nullable(false)->change();
                }
                if (Schema::hasColumn('expenses', 'end_month')) {
                    $table->date('end_month')->nullable(false)->change();
                }
            });
        }
    }
};
