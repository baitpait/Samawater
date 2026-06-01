<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ClientTypeCrudController;
use App\Http\Controllers\Admin\ClientCrudController;
use App\Http\Controllers\Admin\CityCrudController;
use App\Http\Controllers\Admin\DistributorCrudController;
use App\Http\Controllers\Admin\DeliveryCrudController;
use App\Http\Controllers\Admin\VClientsDueByTypeDaysIdsCrudController;
use App\Http\Controllers\Admin\SubscriptionTypeCrudController;
use App\Http\Controllers\Admin\ClientStatusCrudController;
use App\Http\Controllers\Admin\SubscriptionStatusCrudController;
use App\Http\Controllers\Admin\ExpenseCategoryCrudController;
use App\Http\Controllers\Admin\ExpenseCrudController;
use App\Http\Controllers\Admin\CurrentMonthExpensesController;
use App\Http\Controllers\Admin\CashWithdrawController;
use App\Http\Controllers\Admin\ClientReportController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AdvancedReportsController;
use App\Http\Controllers\Admin\UserCrudController;
use App\Http\Controllers\Admin\VendorCrudController;
use App\Http\Controllers\Admin\VendorPaymentCrudController;
use App\Http\Controllers\Admin\InventoryItemCrudController;
use App\Http\Controllers\Admin\InvoiceCrudController;
use App\Http\Controllers\Admin\ClientPaymentCrudController;
use App\Http\Controllers\Admin\ClientBalanceReportController;
use App\Http\Controllers\Admin\ClientFinancialLedgerReportController;
use App\Http\Controllers\Admin\TreasuryCustodyReportController;
use App\Http\Controllers\Admin\UnifiedFinancialLedgerController;
use App\Http\Controllers\Admin\CompanyTreasuryReportController;
use App\Http\Controllers\Admin\ClientDepositCrudController;
use App\Http\Controllers\Admin\DiagnosisController;
use App\Http\Middleware\CheckUserManagementPermission;

// ============================================
// Auth Routes (Custom - Phone Login Support)
// ============================================
Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => config('backpack.base.web_middleware', 'web'),
], function () {
    // Custom login routes with phone support
    Route::get('login', [\App\Http\Controllers\Auth\BackpackAuthController::class, 'showLoginForm'])
        ->name('backpack.auth.login');
    Route::post('login', [\App\Http\Controllers\Auth\BackpackAuthController::class, 'login'])
        ->name('backpack.auth.login.post');
    
    // Logout routes - support both GET and POST
    Route::get('logout', [\App\Http\Controllers\Auth\BackpackAuthController::class, 'logout'])
        ->name('backpack.auth.logout');
    Route::post('logout', [\App\Http\Controllers\Auth\BackpackAuthController::class, 'logout'])
        ->name('backpack.auth.logout.post');
});

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
], function () {
    
    // Custom dashboard route
    Route::get('dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])
        ->name('backpack.dashboard');
    
    // Redirect /admin/account to /admin/edit-account-info
    Route::get('account', function () {
        return redirect(route('backpack.account.info'));
    })->name('backpack.account');
    
    // Delivery routes are handled by Backpack CRUD automatically

    Route::get('client-report', [ClientReportController::class, 'index'])
    ->name('client.report');

Route::get('/reports/filters', [\App\Http\Controllers\Admin\ReportFilterController::class, 'index'])
    ->name('reports.filters');

Route::get('/reports/filters/export/excel', [\App\Http\Controllers\Admin\ReportFilterController::class, 'exportExcel'])
    ->name('reports.filters.export.excel');

Route::get('/reports/filters/export/pdf', [\App\Http\Controllers\Admin\ReportFilterController::class, 'exportPdf'])
    ->name('reports.filters.export.pdf');

Route::post(
    '/reports/filters/client/{client}/delivery-on-demand',
    [\App\Http\Controllers\Admin\ReportFilterController::class, 'toggleDeliveryOnDemand']
)->name('reports.filters.toggle_delivery_on_demand');

Route::get(
    'reports/clients-due-advanced',
    [\App\Http\Controllers\Admin\ClientsDueViewController::class, 'index']
)->name('reports.clients_due_advanced');

Route::get(
    'delivery-list',
    [\App\Http\Controllers\Admin\DeliveryListController::class, 'index']
)->name('delivery.list');

// صفحة الإدخال الجماعي للتسليمات (Excel-like)
Route::get(
    'delivery/bulk-entry',
    [\App\Http\Controllers\Admin\BulkDeliveryController::class, 'index']
)->name('delivery.bulk-entry');

Route::post(
    'delivery/bulk-entry/single',
    [\App\Http\Controllers\Admin\BulkDeliveryController::class, 'storeSingle']
)->name('delivery.bulk-store-single');

Route::post(
    'delivery/bulk-entry/bulk',
    [\App\Http\Controllers\Admin\BulkDeliveryController::class, 'storeBulk']
)->name('delivery.bulk-store-bulk');

Route::get(
    'reports/clients-due-advanced/export/excel',
    [\App\Http\Controllers\Admin\ClientsDueViewController::class, 'exportExcel']
)->name('reports.clients_due_advanced.export.excel');

Route::get(
    'reports/clients-due-advanced/export/pdf',
    [\App\Http\Controllers\Admin\ClientsDueViewController::class, 'exportPdf']
)->name('reports.clients_due_advanced.export.pdf');

Route::get('distributor/{id}/clients', function ($id) {

    $distributor = \App\Models\Distributor::findOrFail($id);

    $clients = \App\Models\Client::where('distributor_id', $id)
        ->with(['city', 'subscriptionStatus'])
        ->paginate(20);

    return view('admin.distributor_clients', compact('distributor', 'clients'));

})->name('distributor.clients');


Route::get(
    'reports/clients_delivery_overview',
    [\App\Http\Controllers\Admin\ClientsDeliveryOverviewController::class, 'index']
)->name('reports.clients_delivery_overview');

Route::get(
    'reports/clients_delivery_overview/export/excel',
    [\App\Http\Controllers\Admin\ClientsDeliveryOverviewController::class, 'exportExcel']
)->name('reports.clients_delivery_overview.export.excel');

Route::get(
    'reports/clients_delivery_overview/export/pdf',
    [\App\Http\Controllers\Admin\ClientsDeliveryOverviewController::class, 'exportPdf']
)->name('reports.clients_delivery_overview.export.pdf');



Route::get('distributor/{id}/financial-report', function ($id) {

    $entry = \App\Models\Distributor::with('cashWithdraws')->findOrFail($id);

    return view('admin.distributor_financial_report_page', compact('entry'));

})->name('distributor.financial-report');

Route::get('/reports/results', [\App\Http\Controllers\Admin\ReportFilterController::class, 'results'])
    ->name('reports.results');

Route::get('/reports/advanced', [AdvancedReportsController::class, 'index'])
    ->name('reports.advanced');

Route::get('/api/search-clients', [\App\Http\Controllers\Admin\DeliveryCrudController::class, 'searchClients'])
    ->name('api.search.clients');

Route::get('/reports/advanced/export/excel', [AdvancedReportsController::class, 'exportExcel'])
    ->name('reports.advanced.export.excel');

Route::get('/reports/advanced/export/pdf', [AdvancedReportsController::class, 'exportPdf'])
    ->name('reports.advanced.export.pdf');

Route::get('/client/report/pdf', [ReportController::class, 'exportClientReportPdf'])
    ->name('client.report.pdf');
    
Route::get('/distributors-list', [\App\Http\Controllers\Admin\DistributorListController::class, 'index'])
    ->name('distributors.list');
    
    Route::post('cash-withdraw', [CashWithdrawController::class, 'store']);
    Route::get('clear-whatsapp-session', function() {
        session()->forget('whatsapp_url');
        session()->forget('whatsapp_url_persistent');
        return response()->json(['status' => true]);
    });

    Route::crud('client-type', ClientTypeCrudController::class);
    // تحويل admin/client/{id} إلى صفحة العرض admin/client/{id}/show
    Route::get('client/{id}', function ($id) {
        return redirect()->route('client.show', ['id' => $id], 301);
    })->where('id', '[0-9]+')->name('client.redirect_to_show');
    Route::crud('client', ClientCrudController::class);
    Route::crud('city', CityCrudController::class);
    
    Route::crud('distributor', DistributorCrudController::class);
    Route::get('delivery/{id}/modal-data', [DeliveryCrudController::class, 'deliveryModalJson'])
        ->whereNumber('id')
        ->name('delivery.modal-data');
    Route::crud('delivery', DeliveryCrudController::class);
    Route::crud('clients-due', VClientsDueByTypeDaysIdsCrudController::class);
    Route::crud('subscription-type', SubscriptionTypeCrudController::class);
    Route::crud('client-status', ClientStatusCrudController::class);
    Route::crud('subscription-status', SubscriptionStatusCrudController::class);
    
    // إدارة المستخدمين - فقط Super Admin
    Route::group(['middleware' => [CheckUserManagementPermission::class]], function () {
        Route::crud('user', UserCrudController::class);
    });
    Route::crud('expense-category', ExpenseCategoryCrudController::class);
    Route::crud('expense', ExpenseCrudController::class);
    
    // المصروفات الشهرية
    Route::get('expenses/current-month', [CurrentMonthExpensesController::class, 'index'])
        ->name('expenses.current-month');
    Route::post('expenses/current-month/transfer/{id}', [CurrentMonthExpensesController::class, 'transfer'])
        ->name('expenses.current-month.transfer');
    Route::post('expenses/current-month/transfer-all', [CurrentMonthExpensesController::class, 'transferAll'])
        ->name('expenses.current-month.transfer-all');
    Route::crud('vendor', VendorCrudController::class);
    Route::crud('vendor-payment', VendorPaymentCrudController::class);
    Route::crud('inventory-item', InventoryItemCrudController::class);
    Route::crud('invoice', InvoiceCrudController::class);
    Route::get('invoice/generate-number', [InvoiceCrudController::class, 'generateInvoiceNumber'])->name('invoice.generate-number');
    Route::crud('client-payment', ClientPaymentCrudController::class);
    Route::crud('client-deposit', ClientDepositCrudController::class);
    Route::post('client-deposit/{id}/withdraw', [ClientDepositCrudController::class, 'withdraw'])->name('client-deposit.withdraw');
    Route::post('client-deposit/{id}/withdraw-item/{itemId}', [ClientDepositCrudController::class, 'withdrawItem'])->name('client-deposit.withdraw-item');
    Route::post('client-deposit/withdraw-all', [ClientDepositCrudController::class, 'withdrawAll'])->name('client-deposit.withdraw-all');
    
    // تقرير رصيد المشتركين
    Route::get('reports/client-balance', [ClientBalanceReportController::class, 'index'])
        ->name('reports.client-balance');
    Route::get('reports/client-ledger', [ClientFinancialLedgerReportController::class, 'index'])
        ->name('reports.client-ledger');
    Route::get('reports/treasury-custody', [TreasuryCustodyReportController::class, 'index'])
        ->name('reports.treasury-custody');
    Route::get('reports/financial-movements-unified', [UnifiedFinancialLedgerController::class, 'index'])
        ->name('reports.financial-movements-unified');
    Route::get('reports/company-treasury', [CompanyTreasuryReportController::class, 'index'])
        ->name('reports.company-treasury');

    Route::get('diagnosis', [DiagnosisController::class, 'index'])->name('admin.diagnosis');
});
