<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Carbon\Carbon;

class DatabaseBackupController
{
    /**
     * تحميل نسخة احتياطية من قاعدة البيانات
     */
    public function download()
    {
        try {
            // معلومات قاعدة البيانات من .env
            $dbName = config('database.connections.mysql.database');
            $dbUser = config('database.connections.mysql.username');
            $dbPassword = config('database.connections.mysql.password');
            $dbHost = config('database.connections.mysql.host');
            
            // اسم الملف مع التاريخ والوقت
            $fileName = 'eliyaa_backup_' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';
            $filePath = storage_path('app/backups/' . $fileName);
            
            // إنشاء مجلد backups إذا لم يكن موجوداً
            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }
            
            // أمر mysqldump
            $command = sprintf(
                'mysqldump -h %s -u %s -p%s %s > %s',
                escapeshellarg($dbHost),
                escapeshellarg($dbUser),
                escapeshellarg($dbPassword),
                escapeshellarg($dbName),
                escapeshellarg($filePath)
            );
            
            // تنفيذ الأمر
            exec($command, $output, $returnVar);
            
            // التحقق من نجاح العملية
            if ($returnVar !== 0 || !file_exists($filePath)) {
                // إذا فشل mysqldump، نستخدم طريقة بديلة
                return $this->downloadUsingLaravel($fileName);
            }
            
            // حذف النسخ القديمة (الأقدم من 7 أيام)
            $this->cleanOldBackups();
            
            // تحميل الملف
            return response()->download($filePath, $fileName)->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            \Alert::error('فشل في إنشاء النسخة الاحتياطية: ' . $e->getMessage())->flash();
            return redirect()->back();
        }
    }
    
    /**
     * طريقة بديلة باستخدام Laravel (أبطأ لكن تعمل دائماً)
     */
    private function downloadUsingLaravel($fileName)
    {
        try {
            $tables = DB::select('SHOW TABLES');
            $dbName = config('database.connections.mysql.database');
            $tableKey = 'Tables_in_' . $dbName;
            
            $sql = "-- Eliyaa Database Backup\n";
            $sql .= "-- Date: " . Carbon::now()->toDateTimeString() . "\n";
            $sql .= "-- Database: {$dbName}\n\n";
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";
            
            foreach ($tables as $table) {
                $tableName = $table->$tableKey;
                
                // بنية الجدول
                $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
                $sql .= "-- Table: {$tableName}\n";
                $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
                $sql .= $createTable[0]->{'Create Table'} . ";\n\n";
                
                // البيانات
                $rows = DB::table($tableName)->get();
                
                if ($rows->count() > 0) {
                    $sql .= "-- Data for table: {$tableName}\n";
                    
                    foreach ($rows as $row) {
                        $row = (array) $row;
                        $columns = array_keys($row);
                        $values = array_values($row);
                        
                        // تنظيف القيم
                        $values = array_map(function($value) {
                            if (is_null($value)) {
                                return 'NULL';
                            }
                            return "'" . addslashes($value) . "'";
                        }, $values);
                        
                        $sql .= sprintf(
                            "INSERT INTO `{$tableName}` (`%s`) VALUES (%s);\n",
                            implode('`, `', $columns),
                            implode(', ', $values)
                        );
                    }
                    
                    $sql .= "\n";
                }
            }
            
            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
            
            // حفظ الملف
            $filePath = storage_path('app/backups/' . $fileName);
            file_put_contents($filePath, $sql);
            
            // حذف النسخ القديمة
            $this->cleanOldBackups();
            
            // تحميل الملف
            return response()->download($filePath, $fileName)->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            \Alert::error('فشل في إنشاء النسخة الاحتياطية: ' . $e->getMessage())->flash();
            return redirect()->back();
        }
    }
    
    /**
     * حذف النسخ الاحتياطية القديمة
     */
    private function cleanOldBackups()
    {
        $backupPath = storage_path('app/backups');
        
        if (!file_exists($backupPath)) {
            return;
        }
        
        $files = glob($backupPath . '/eliyaa_backup_*.sql');
        $now = time();
        
        foreach ($files as $file) {
            if (is_file($file)) {
                // حذف الملفات الأقدم من 7 أيام
                if ($now - filemtime($file) >= 7 * 24 * 60 * 60) {
                    unlink($file);
                }
            }
        }
    }
}

