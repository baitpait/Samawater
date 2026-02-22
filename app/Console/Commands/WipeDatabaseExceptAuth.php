<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * تفريغ قاعدة البيانات مع الإبقاء على جداول تسجيل الدخول فقط (users, roles, migrations).
 * Business Purpose: إعادة ضبط البيانات التشغيلية مع الاحتفاظ بقدرة المسؤول على تسجيل الدخول.
 */
class WipeDatabaseExceptAuth extends Command
{
    protected $signature = 'db:wipe-except-auth {--force : تشغيل بدون تأكيد }';

    protected $description = 'تفريغ جميع جداول البيانات مع الإبقاء على users و roles و migrations فقط';

    private const TABLES_TO_KEEP = ['users', 'roles', 'migrations'];

    public function handle(): int
    {
        if (! $this->option('force') && ! $this->confirm('هل تريد تفريغ قاعدة البيانات مع الإبقاء على بيانات تسجيل الدخول فقط؟')) {
            return self::SUCCESS;
        }

        $connection = DB::connection();
        $driver = $connection->getDriverName();

        if ($driver !== 'mysql') {
            $this->error('هذا الأمر يدعم MySQL فقط.');
            return self::FAILURE;
        }

        $this->info('جاري إبطال المراجع الأجنبية للمستخدمين (distributor_id)...');
        User::query()->update(['distributor_id' => null]);

        $connection->getPdo()->exec('SET FOREIGN_KEY_CHECKS = 0');

        try {
            $dbName = $connection->getDatabaseName();
            $rows = $connection->select("SHOW TABLES FROM `{$dbName}`");
            $truncated = 0;

            foreach ($rows as $row) {
                $row = (array) $row;
                $name = (string) reset($row);
                if (in_array($name, self::TABLES_TO_KEEP, true)) {
                    continue;
                }
                try {
                    $connection->getPdo()->exec("TRUNCATE TABLE `{$name}`");
                    $this->line("  تم تفريغ: {$name}");
                    $truncated++;
                } catch (\Throwable $e) {
                    $this->warn("  تخطي {$name}: " . $e->getMessage());
                }
            }

            $connection->getPdo()->exec('SET FOREIGN_KEY_CHECKS = 1');
            $this->newLine();
            $this->info("تم تفريغ {$truncated} جدولاً. تم الإبقاء على: users, roles, migrations.");
        } catch (\Throwable $e) {
            $connection->getPdo()->exec('SET FOREIGN_KEY_CHECKS = 1');
            $this->error('حدث خطأ: ' . $e->getMessage());
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
