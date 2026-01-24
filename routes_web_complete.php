<?php

use Illuminate\Support\Facades\Route;

// Route الرئيسية - توجيه مباشر إلى login (بدون حلقة إعادة توجيه)
Route::get('/', function () {
    return redirect(backpack_url('login'));
});

Route::get('clients-due-report', [App\Http\Controllers\Admin\ClientsDueReportController::class, 'index'])
    ->name('clients.due.report');

Route::get(
    'admin/reports/clients-due/{client_id}',
    [\App\Http\Controllers\Admin\ClientsDueViewController::class, 'show']
)->name('reports.clients_due.show');


// Routes moved to backpack/custom.php

