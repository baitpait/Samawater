<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: إنشاء جدول أصناف الفاتورة (Invoice Items)
 * - كل فاتورة تحتوي على عدة أصناف
 * - الأصناف من المخزون (inventory_items)
 * - يتم خصم الكمية من المخزون عند تأكيد الفاتورة
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('invoice_items')) {
            Schema::create('invoice_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
                $table->string('item_name'); // اسم الصنف من inventory_items
                $table->integer('quantity');
                $table->decimal('unit_price', 10, 2);
                $table->decimal('total_price', 10, 2); // quantity × unit_price
                $table->timestamps();
                
                // Indexes
                $table->index('invoice_id');
                $table->index('item_name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
