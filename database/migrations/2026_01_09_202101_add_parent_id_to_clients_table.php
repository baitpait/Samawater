<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: إضافة عمود parent_id لجدول clients
 * - يسمح بربط العناوين الفرعية بالعميل الرئيسي (الأب)
 * - الأب: parent_id = null
 * - الأبناء: parent_id = id الأب
 * - الفواتير والمدفوعات: فقط للأب
 * - التسليمات والأمانات: لكل العناوين (الأب + الأبناء)
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('clients')) {
            Schema::table('clients', function (Blueprint $table) {
                if (!Schema::hasColumn('clients', 'parent_id')) {
                    $table->foreignId('parent_id')
                        ->nullable()
                        ->after('id')
                        ->constrained('clients')
                        ->onDelete('cascade');
                    
                    // Index للأداء
                    $table->index('parent_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('clients')) {
            Schema::table('clients', function (Blueprint $table) {
                if (Schema::hasColumn('clients', 'parent_id')) {
                    $table->dropForeign(['parent_id']);
                    $table->dropIndex(['parent_id']);
                    $table->dropColumn('parent_id');
                }
            });
        }
    }
};
