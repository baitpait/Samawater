<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: إنشاء جدول أمانات العملاء (Client Deposits)
 * - أصناف معارة للعملاء من المخزون
 * - بدون سعر (كمية فقط)
 * - يتم خصمها من المخزون عند الإعارة
 * - يتم إرجاعها للمخزون عند السحب
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('client_deposits')) {
            Schema::create('client_deposits', function (Blueprint $table) {
                $table->id();
                $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
                $table->string('item_name'); // اسم الصنف من المخزون
                $table->integer('quantity'); // الكمية المعارة
                $table->date('date_given'); // تاريخ الإعارة
                $table->text('notes')->nullable(); // ملاحظات
                $table->boolean('is_withdrawn')->default(false); // هل تم السحب؟
                $table->timestamp('withdrawn_at')->nullable(); // تاريخ السحب
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamps();
                
                // Indexes
                $table->index('client_id');
                $table->index('item_name');
                $table->index('is_withdrawn');
                $table->index('date_given');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_deposits');
    }
};
