<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Business Purpose: إضافة جميع الأعمدة المطلوبة لجدول clients لدعم نظام إدارة المشتركين
     * - contract_no: رقم العقد
     * - name: اسم العميل
     * - city_id: المدينة
     * - address: العنوان
     * - phone_one, phone_two: أرقام الهاتف
     * - client_type: نوع العميل
     * - subscription_type_id, subscription_status_id: نوع وحالة الاشتراك
     * - subscription_start_date: تاريخ بداية الاشتراك
     * - longitude, latitude: الإحداثيات الجغرافية
     * - bottle_balance: رصيد القوارير
     * - distributor_id: الموزع المسؤول
     * - image: صورة العميل
     * - notes: ملاحظات
     */
    public function up(): void
    {
        // تأكد من وجود الجدول قبل إضافة الأعمدة
        if (!Schema::hasTable('clients')) {
            Schema::create('clients', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('subscription_types')) {
            Schema::create('subscription_types', function (Blueprint $table) {
                $table->id();
                $table->string('type_name')->nullable();
                $table->string('description')->nullable();
                $table->integer('distribution_days')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('subscription_statuses')) {
            Schema::create('subscription_statuses', function (Blueprint $table) {
                $table->id();
                $table->string('status_name')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'contract_no')) {
                $table->string('contract_no')->nullable()->after('id');
            }
            if (!Schema::hasColumn('clients', 'name')) {
                $table->string('name')->after('contract_no');
            }
            if (!Schema::hasColumn('clients', 'city_id')) {
                $table->foreignId('city_id')->nullable()->after('name')->constrained('cities')->onDelete('set null');
            }
            if (!Schema::hasColumn('clients', 'address')) {
                $table->text('address')->nullable()->after('city_id');
            }
            if (!Schema::hasColumn('clients', 'phone_one')) {
                $table->string('phone_one')->nullable()->after('address');
            }
            if (!Schema::hasColumn('clients', 'phone_two')) {
                $table->string('phone_two')->nullable()->after('phone_one');
            }
            if (!Schema::hasColumn('clients', 'client_type')) {
                $table->string('client_type')->nullable()->after('phone_two');
            }
            if (!Schema::hasColumn('clients', 'subscription_type_id')) {
                $table->foreignId('subscription_type_id')->nullable()->after('client_type')->constrained('subscription_types')->onDelete('set null');
            }
            if (!Schema::hasColumn('clients', 'subscription_status_id')) {
                $table->foreignId('subscription_status_id')->nullable()->after('subscription_type_id')->constrained('subscription_statuses')->onDelete('set null');
            }
            if (!Schema::hasColumn('clients', 'subscription_start_date')) {
                $table->date('subscription_start_date')->nullable()->after('subscription_status_id');
            }
            if (!Schema::hasColumn('clients', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable()->after('subscription_start_date');
            }
            if (!Schema::hasColumn('clients', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable()->after('longitude');
            }
            if (!Schema::hasColumn('clients', 'bottle_balance')) {
                $table->integer('bottle_balance')->default(0)->after('latitude');
            }
            if (!Schema::hasColumn('clients', 'distributor_id')) {
                $table->foreignId('distributor_id')->nullable()->after('bottle_balance')->constrained('distributors')->onDelete('set null');
            }
            if (!Schema::hasColumn('clients', 'image')) {
                $table->string('image')->nullable()->after('distributor_id');
            }
            if (!Schema::hasColumn('clients', 'notes')) {
                $table->text('notes')->nullable()->after('image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropForeign(['subscription_type_id']);
            $table->dropForeign(['subscription_status_id']);
            $table->dropForeign(['distributor_id']);
            $table->dropColumn([
                'contract_no', 'name', 'city_id', 'address', 'phone_one', 'phone_two',
                'client_type', 'subscription_type_id', 'subscription_status_id',
                'subscription_start_date', 'longitude', 'latitude', 'bottle_balance',
                'distributor_id', 'image', 'notes'
            ]);
        });
    }
};
