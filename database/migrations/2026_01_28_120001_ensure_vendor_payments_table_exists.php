<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: التأكد من وجود جدول vendor_payments (للمشاريع التي لم تُنفّذ فيها الهجرة الأصلية أو حُذف الجدول).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('vendor_payments')) {
            Schema::create('vendor_payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');
                $table->foreignId('expense_id')->nullable()->constrained('expenses')->onDelete('set null');
                $table->decimal('amount', 10, 2);
                $table->enum('method', ['cash', 'bank_transfer', 'check', 'credit_card', 'other'])->default('cash');
                $table->date('payment_date');
                $table->string('reference_number')->nullable();
                $table->text('notes')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamps();
                $table->index('vendor_id');
                $table->index('expense_id');
                $table->index('payment_date');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_payments');
    }
};
