<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Business Purpose: ضبط دورة «غير محدود» إلى 30 يوماً حتى لا يظهر كل من له أي تسليم كمستحق في قائمة التسليم (كان 0 = شرط دائماً متحقق).
 *
 * Force restart: php artisan migrate --force && php artisan optimize:clear
 */
return new class extends Migration
{
    /**
     * Business Purpose: تحديث أيام نوع الاشتراك «غير محدود» من 0 إلى 30 دون حذف بيانات.
     */
    public function up(): void
    {
        DB::table('subscription_types')
            ->where('type_name', 'غير محدود')
            ->where('distribution_days', 0)
            ->update([
                'distribution_days' => 30,
                'updated_at' => now(),
            ]);
    }

    /**
     * Business Purpose: إرجاع أيام «غير محدود» إلى 0 إذا لزم التراجع.
     */
    public function down(): void
    {
        DB::table('subscription_types')
            ->where('type_name', 'غير محدود')
            ->where('distribution_days', 30)
            ->update([
                'distribution_days' => 0,
                'updated_at' => now(),
            ]);
    }
};
