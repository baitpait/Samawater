<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: إنشاء جدول أصناف الأمانات (Client Deposit Items)
 * - كل أمانة تحتوي على عدة أصناف
 * - الأصناف من المخزون (inventory_items)
 * - بدون سعر (كمية فقط)
 * - يتم خصم الكمية من المخزون عند الإعارة
 * - يتم إرجاعها للمخزون عند السحب
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('client_deposit_items')) {
            Schema::create('client_deposit_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('client_deposit_id')->constrained('client_deposits')->onDelete('cascade');
                $table->string('item_name'); // اسم الصنف من inventory_items
                $table->integer('quantity'); // الكمية المعارة
                $table->timestamps();
                
                // Indexes
                $table->index('client_deposit_id');
                $table->index('item_name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_deposit_items');
    }
};
