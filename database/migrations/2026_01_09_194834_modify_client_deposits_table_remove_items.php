<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Business Purpose: تعديل جدول الأمانات لإزالة item_name و quantity
 * - تم نقلها إلى جدول client_deposit_items
 * - الآن كل أمانة يمكن أن تحتوي على عدة أصناف
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('client_deposits')) {
            Schema::table('client_deposits', function (Blueprint $table) {
                // نقل البيانات أولاً (إذا كانت موجودة)
                if (Schema::hasColumn('client_deposits', 'item_name') && 
                    Schema::hasColumn('client_deposits', 'quantity')) {
                    // نقل البيانات إلى client_deposit_items قبل الحذف
                    $deposits = DB::table('client_deposits')->get();
                    foreach ($deposits as $deposit) {
                        if ($deposit->item_name && $deposit->quantity) {
                            DB::table('client_deposit_items')->insert([
                                'client_deposit_id' => $deposit->id,
                                'item_name' => $deposit->item_name,
                                'quantity' => $deposit->quantity,
                                'created_at' => $deposit->created_at,
                                'updated_at' => $deposit->updated_at,
                            ]);
                        }
                    }
                }
                
                // حذف الأعمدة
                if (Schema::hasColumn('client_deposits', 'item_name')) {
                    $table->dropColumn('item_name');
                }
                if (Schema::hasColumn('client_deposits', 'quantity')) {
                    $table->dropColumn('quantity');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('client_deposits')) {
            Schema::table('client_deposits', function (Blueprint $table) {
                // إعادة الأعمدة
                $table->string('item_name')->nullable()->after('client_id');
                $table->integer('quantity')->nullable()->after('item_name');
                
                // إعادة index
                $table->index('item_name');
                
                // استعادة البيانات من client_deposit_items (أول صنف فقط)
                $deposits = DB::table('client_deposits')->get();
                foreach ($deposits as $deposit) {
                    $firstItem = DB::table('client_deposit_items')
                        ->where('client_deposit_id', $deposit->id)
                        ->first();
                    if ($firstItem) {
                        DB::table('client_deposits')
                            ->where('id', $deposit->id)
                            ->update([
                                'item_name' => $firstItem->item_name,
                                'quantity' => $firstItem->quantity,
                            ]);
                    }
                }
            });
        }
    }
};
