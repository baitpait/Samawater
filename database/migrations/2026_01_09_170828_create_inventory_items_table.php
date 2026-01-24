<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: إنشاء جدول المخزون (Inventory Items)
 * - جدول ديناميكي مستقل عن المصروفات
 * - يحتوي على: اسم الصنف والعدد فقط
 * - يتم تحديثه تلقائياً عند شراء مخزون
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('inventory_items')) {
            Schema::create('inventory_items', function (Blueprint $table) {
                $table->id();
                $table->string('item_name')->unique();
                $table->integer('quantity')->default(0);
                $table->timestamps();
                
                // Indexes
                $table->index('item_name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
