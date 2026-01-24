<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Business Purpose: إنشاء جدول deliveries الأساسي للتوصيلات
     */
    public function up(): void
    {
        if (!Schema::hasTable('deliveries')) {
            Schema::create('deliveries', function (Blueprint $table) {
                $table->id();
                $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
                $table->date('delivery_date');
                $table->integer('bottle_received')->default(0);
                $table->integer('bottle_empty')->default(0);
                $table->decimal('paymant', 10, 2)->default(0);
                $table->foreignId('distributor_id')->nullable()->constrained('distributors')->onDelete('set null');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
