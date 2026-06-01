<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: تخزين «طريقة التعامل» مع المشترك (نص حر) منفصلة عن حقل الملاحظات العامة.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('clients')) {
            return;
        }

        Schema::table('clients', function (Blueprint $table): void {
            if (! Schema::hasColumn('clients', 'interaction_method')) {
                $table->text('interaction_method')
                    ->nullable()
                    ->after('notes')
                    ->comment('طريقة التعامل مع المشترك');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('clients') || ! Schema::hasColumn('clients', 'interaction_method')) {
            return;
        }

        Schema::table('clients', function (Blueprint $table): void {
            $table->dropColumn('interaction_method');
        });
    }
};
