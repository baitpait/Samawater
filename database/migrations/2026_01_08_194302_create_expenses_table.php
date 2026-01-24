<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Business Purpose: إنشاء جدول المصروفات مع إمكانية توزيعها على عدة أشهر للتقارير المالية
     * - المصروف يتم دفعه دفعة واحدة (payment_date)
     * - يتم توزيعه على عدة أشهر للتقارير المالية فقط
     */
    public function up(): void
    {
        if (!Schema::hasTable('expenses')) {
            Schema::create('expenses', function (Blueprint $table) {
                $table->id();
                $table->foreignId('expense_category_id')->constrained('expense_categories')->onDelete('restrict');
                $table->decimal('total_amount', 10, 2);
                $table->integer('number_of_months');
                $table->decimal('monthly_amount', 10, 2);
                $table->date('start_month');
                $table->date('end_month');
                $table->date('payment_date');
                $table->text('notes')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
