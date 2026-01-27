<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Business Purpose: إضافة الأعمدة المطلوبة لجدول deliveries لدعم نظام التوصيلات
     * - client_id: ربط التوصيل بالعميل
     * - delivery_date: تاريخ التوصيل
     * - bottle_received: عدد القوارير المستلمة
     * - bottle_empty: عدد القوارير الفارغة
     * - paymant: المبلغ المدفوع
     * - distributor_id: ربط التوصيل بالموزع
     */
    public function up(): void
    {
        // تأكد من وجود جدول clients قبل إنشاء القيود
        if (!Schema::hasTable('clients')) {
            Schema::create('clients', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
            });
        }

        // تأكد من وجود جدول deliveries قبل إضافة الأعمدة
        if (!Schema::hasTable('deliveries')) {
            Schema::create('deliveries', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
            });
        }

        Schema::table('deliveries', function (Blueprint $table) {
            if (!Schema::hasColumn('deliveries', 'client_id')) {
                $table->foreignId('client_id')->after('id')->constrained('clients')->onDelete('cascade');
            }
            if (!Schema::hasColumn('deliveries', 'delivery_date')) {
                $table->date('delivery_date')->after('client_id');
            }
            if (!Schema::hasColumn('deliveries', 'bottle_received')) {
                $table->integer('bottle_received')->default(0)->after('delivery_date');
            }
            if (!Schema::hasColumn('deliveries', 'bottle_empty')) {
                $table->integer('bottle_empty')->default(0)->after('bottle_received');
            }
            if (!Schema::hasColumn('deliveries', 'paymant')) {
                $table->decimal('paymant', 10, 2)->default(0)->after('bottle_empty');
            }
            if (!Schema::hasColumn('deliveries', 'distributor_id')) {
                $table->foreignId('distributor_id')->nullable()->after('paymant')->constrained('distributors')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropForeign(['distributor_id']);
            $table->dropColumn(['client_id', 'delivery_date', 'bottle_received', 'bottle_empty', 'paymant', 'distributor_id']);
        });
    }
};
