<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Business Purpose: إصلاح عمود parent_id المفقود في clients (خطأ 1054)، مع توافق مفاتيح Eliyaa (INT لواجب).
 * الهجرة الأصلية تحاول foreignId (BIGINT UNSIGNED) على جدول بـ PK من نوع int في بعض الاستيرادات فيفشل التنفيذ.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('clients') || Schema::hasColumn('clients', 'parent_id')) {
            return;
        }

        $legacyPk = self::referencedColumnIsLegacyInt('clients');

        Schema::table('clients', function (Blueprint $table) use ($legacyPk): void {
            if ($legacyPk === true) {
                $table->integer('parent_id')->nullable()->after('id');
                $table->foreign('parent_id')
                    ->references('id')
                    ->on('clients')
                    ->onDelete('cascade');
            } else {
                $table->foreignId('parent_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('clients')
                    ->onDelete('cascade');
            }

            $table->index('parent_id');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('clients') || ! Schema::hasColumn('clients', 'parent_id')) {
            return;
        }

        Schema::table('clients', function (Blueprint $table): void {
            $table->dropForeign(['parent_id']);
            $table->dropIndex(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }

    private static function referencedColumnIsLegacyInt(string $table): bool
    {
        if (! Schema::hasTable($table)) {
            return false;
        }

        /** @var object|null $row */
        $row = DB::selectOne('SHOW COLUMNS FROM `' . str_replace('`', '', $table) . '` WHERE Field = ?', ['id']);

        if ($row === null) {
            return false;
        }

        $attrs = array_change_key_case((array) $row, CASE_LOWER);
        $type = $attrs['type'] ?? '';

        if (! is_string($type) || $type === '') {
            return false;
        }

        return self::mysqlTypeLooksLikeLegacyIntForeignKeyTarget($type);
    }

    private static function mysqlTypeLooksLikeLegacyIntForeignKeyTarget(string $type): bool
    {
        $t = strtolower($type);

        if (str_contains($t, 'bigint')) {
            return false;
        }

        return str_contains($t, 'int')
            || str_contains($t, 'mediumint')
            || str_contains($t, 'smallint');
    }
};
