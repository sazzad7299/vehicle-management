<?php

namespace App\Providers;

use App\Models\CashHistory;
use App\Models\CashInOut;
use App\Models\Category;
use App\Models\Cost;
use App\Models\CostCategory;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\EmployeeSalary;
use App\Models\Leaf;
use App\Models\Manufacturer;
use App\Models\Medicine;
use App\Models\PaymentMethod;
use App\Models\Pharmacy;
use App\Models\Plan;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use App\Models\PurchaseReturn;
use App\Models\Sale;
use App\Models\SalePayment;
use App\Models\SaleReturn;
use App\Models\Supplier;
use App\Observers\GlobalObserve;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\TelescopeServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Observe the model using the GlobalObserve class
        if (Auth::user()) {
            CashInOut::observe(GlobalObserve::class);
            CashHistory::observe(GlobalObserve::class);
            Category::observe(GlobalObserve::class);
            Cost::observe(GlobalObserve::class);
            CostCategory::observe(GlobalObserve::class);
            Employee::observe(GlobalObserve::class);
            EmployeeSalary::observe(GlobalObserve::class);
            Leaf::observe(GlobalObserve::class);
            Manufacturer::observe(GlobalObserve::class);
            Medicine::observe(GlobalObserve::class);
            PaymentMethod::observe(GlobalObserve::class);
            Pharmacy::observe(GlobalObserve::class);
            Plan::observe(GlobalObserve::class);
            Sale::observe(GlobalObserve::class);
            SalePayment::observe(GlobalObserve::class);
            SaleReturn::observe(GlobalObserve::class);
            Purchase::observe(GlobalObserve::class);
            PurchasePayment::observe(GlobalObserve::class);
            PurchaseReturn::observe(GlobalObserve::class);
            Supplier::observe(GlobalObserve::class);
            Customer::observe(GlobalObserve::class);
        }
    }
}
