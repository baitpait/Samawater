<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Expense;
use App\Models\ExpenseBeneficiary;
use App\Observers\ExpenseObserver;
use App\Observers\ExpenseBeneficiaryObserver;
use App\Services\DashboardService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // تسجيل Observer للمصروفات
        Expense::observe(ExpenseObserver::class);
        ExpenseBeneficiary::observe(ExpenseBeneficiaryObserver::class);

        View::composer('vendor.backpack.ui.dashboard', function ($view): void {
            $user = backpack_user();
            if ($user !== null && ! $user->isDistributor()) {
                $view->with('ownerDashboard', app(DashboardService::class)->buildForOwner());
            }
        });
    }
}
