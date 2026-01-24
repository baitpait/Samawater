<?php

use Illuminate\Support\Facades\Route;

// Route الرئيسية - تم التعديل للتوجيه إلى لوحة التحكم (Dashboard) لمنع تكرار التحويل
Route::get('/', function () {
        return redirect(backpack_url('dashboard'));
});

Route::get('clients-due-report', [App\Http\Controllers\Admin\ClientsDueReportController::class, 'index'])
    ->name('clients.due.report');

Route::get(
    'admin/reports/clients-due/{client_id}',
    [\App\Http\Controllers\Admin\ClientsDueViewController::class, 'show']
)->name('reports.clients_due.show');

// تحميل نسخة احتياطية من قاعدة البيانات
Route::get('admin/backup/download', [App\Http\Controllers\Admin\DatabaseBackupController::class, 'download'])
    ->middleware(['web', 'admin'])
    ->name('backup.download');

// Routes moved to backpack/custom.php