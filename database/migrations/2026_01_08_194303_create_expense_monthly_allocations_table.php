<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Business Purpose: إنشاء جدول توزيع المصروفات الشهرية
     * - كل شهر له سجل منفصل
     * - عند انتهاء الشهر أو عند الإدخال، يتم ترحيل المصروفات تلقائياً
     */
    public function up(): void
    {
        if (!Schema::hasTable('expense_monthly_allocations')) {
            Schema::create('expense_monthly_allocations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('expense_id')->constrained('expenses')->onDelete('cascade');
                $table->date('month');
                $table->decimal('amount', 10, 2);
                $table->boolean('is_transferred')->default(false);
                $table->timestamp('transferred_at')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
                
                // Index للاستعلامات السريعة
                $table->index(['month', 'is_transferred']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_monthly_allocations');
    }
};
