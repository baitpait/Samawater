<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: إنشاء جدول الفواتير (Invoices)
 * - فواتير مبيعات للعملاء
 * - تحتوي على أصناف من المخزون
 * - يتم خصم المخزون عند تأكيد الفاتورة
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('invoices')) {
            Schema::create('invoices', function (Blueprint $table) {
                $table->id();
                $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
                $table->string('invoice_number')->unique();
                $table->date('invoice_date');
                $table->decimal('total_amount', 10, 2)->default(0);
                $table->enum('status', ['draft', 'confirmed', 'cancelled'])->default('draft');
                $table->text('notes')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamps();
                
                // Indexes
                $table->index('client_id');
                $table->index('invoice_number');
                $table->index('status');
                $table->index('invoice_date');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
