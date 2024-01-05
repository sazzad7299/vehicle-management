<?php

use App\Http\Controllers\API\V1\Auth\LoginController;
use App\Http\Controllers\API\V1\Auth\LogOutController;
use App\Http\Controllers\API\V1\Auth\RegistrationController;
use App\Http\Controllers\API\V1\CashInOutController;
use App\Http\Controllers\API\V1\CategoryController;
use App\Http\Controllers\API\V1\CostCategoryController;
use App\Http\Controllers\API\V1\CostController;
use App\Http\Controllers\API\V1\CountryWiseDivisionController;
use App\Http\Controllers\API\V1\CustomerController;
use App\Http\Controllers\API\V1\DistrictWiseUpzilaController;
use App\Http\Controllers\API\V1\DivisionWiseDistrictController;
use App\Http\Controllers\API\V1\EmployeeController;
use App\Http\Controllers\API\V1\GetCountryController;
use App\Http\Controllers\API\V1\GetPermissionController;
use App\Http\Controllers\API\V1\LeafController;
use App\Http\Controllers\API\V1\ManufacturerController;
use App\Http\Controllers\API\V1\MedicineController;
use App\Http\Controllers\API\V1\PaymentMethodController;
use App\Http\Controllers\API\V1\Pharmacy\UserController;
use App\Http\Controllers\API\V1\PharmacyController;
use App\Http\Controllers\API\V1\PlanController;
use App\Http\Controllers\API\V1\Profile\ProfileController;
use App\Http\Controllers\API\V1\PurchaseController;
use App\Http\Controllers\API\V1\Rbac\AssignRolePermissionController;
use App\Http\Controllers\API\V1\Rbac\PermissionController;
use App\Http\Controllers\API\V1\Rbac\RoleController;
use App\Http\Controllers\API\V1\Rbac\RolePermissionController;
use App\Http\Controllers\API\V1\Rbac\UserAccessController;
use App\Http\Controllers\API\V1\ReportController;
use App\Http\Controllers\API\V1\SaleController;
use App\Http\Controllers\API\V1\ShelfNumberController;
use App\Http\Controllers\API\V1\StrengthController;
use App\Http\Controllers\API\V1\SubscriptionController;
use App\Http\Controllers\API\V1\SupplierController;
use App\Http\Controllers\API\V1\TypeController;
use App\Http\Controllers\API\V1\UnitController;
use App\Http\Controllers\API\V1\UpzilaWiseUnionController;
use App\Http\Controllers\API\V1\UserPharmacyController;
use App\Http\Controllers\EmployeeSalaryController;
use App\Http\Controllers\PurchasePaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */
Route::middleware(['throttle:200,1'])->group(function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::post('register', RegistrationController::class)->name('register');
        Route::post('login', [LoginController::class, 'login'])->name('login');
        Route::post('forgot-password', [LoginController::class, 'forgotPassword'])->name('forgotPassword');
        Route::post('reset-password', [LoginController::class, 'resetPassword'])->name('resetPassword');
        Route::get('plan', [PlanController::class, 'index']);
        Route::middleware('auth:sanctum')->group(function () {

            Route::post('logout', LogOutController::class)
                ->middleware('auth:sanctum')
                ->name('logout');

            Route::get('/user-info', function (Request $request) {
                $user = auth('sanctum')->user()->load('roles:id,name');

                return $user;
            });

            Route::patch('/profile/update', [ProfileController::class, 'updateInfo'])->name('profile.update');
            Route::patch('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
            Route::get('/activity-logs', [ProfileController::class, 'loginfo'])->name('user.logs');

            Route::get('get-permissions', GetPermissionController::class)->name('get_permissions');

            // RBAC
            // Permission
            Route::get('permission/trash', [PermissionController::class, 'trash'])->name('permission_trash');
            Route::get('permission/restore/{id}', [PermissionController::class, 'restore'])->name('permission_restore');
            Route::delete('permission/forceDelete/{id}', [PermissionController::class, 'forceDelete'])->name('permission_forceDelete');

            Route::group(['prefix' => 'rbac'], function () {
                Route::resource('roles', RoleController::class);
                Route::get('roles/{role}/permissions', RolePermissionController::class);
                Route::post('assign-role-permission', [AssignRolePermissionController::class, 'singlePermission']);
                Route::post('assign-role-permissions', [AssignRolePermissionController::class, 'assignMultipleRolePermissions']);
                Route::resource('permissions', PermissionController::class);
                Route::resource('user-access', UserAccessController::class);
                Route::get('/get-roles', [RoleController::class, 'get_roles'])->name('role.list');
            });

            // Plan
            Route::resource('plan', PlanController::class)->except('index');
            Route::get('get-pharmacy-plans', [PlanController::class, 'pharmacyplan']);
            Route::get('plan/trash', [PlanController::class, 'trash'])->name('plan_trash');
            Route::get('plan/restore/{id}', [PlanController::class, 'restore'])->name('plan_restore');
            Route::delete('plan/forceDelete/{id}', [PlanController::class, 'forceDelete'])->name('plan_forceDelete');

            Route::resource('subscription', SubscriptionController::class);
            Route::get('subscription/renew/{id}', [SubscriptionController::class, 'renew'])->name('subscription.renew');
            // Pharmacy
            Route::get('current-balance', [PaymentMethodController::class, 'currentBalance']);

            Route::group(['prefix' => 'report'], function () {
                Route::get('summary', [ReportController::class, 'summary'])->name('summary');
                Route::get('expired', [ReportController::class, 'expired'])->name('expired');
                Route::get('stocks', [ReportController::class, 'stocks'])->name('stocks');
                Route::get('profit', [ReportController::class, 'profit'])->name('profit');
                Route::get('yearly-sale', [ReportController::class, 'yearly'])->name('yearly');
            });

            Route::get('models', [PlanController::class, 'modelfile']);
            // Customer
            Route::group(['middleware' => 'subscription'], function () {

                Route::resource('pharmacy', PharmacyController::class);
                // Pharmacy User
                Route::resource('user', UserController::class);
                Route::get('check-store', [UserController::class, 'AccessAvailable']);
                Route::resources([
                    'customer' => CustomerController::class,
                    'category' => CategoryController::class,
                    'unit' => UnitController::class,
                    'type' => TypeController::class,
                    'leaf' => LeafController::class,
                    'shelf' => ShelfNumberController::class,
                    'manufacturer' => ManufacturerController::class,
                    'payment-method' => PaymentMethodController::class,
                    'medicine' => MedicineController::class,
                    'supplier' => SupplierController::class,
                    'purchase' => PurchaseController::class,
                    'purchase-payment' => PurchasePaymentController::class,
                    'sale' => SaleController::class,
                    'balance-info' => CashInOutController::class,
                    'cost' => CostController::class,
                    'employee' => EmployeeController::class,
                    'employee-salary' => EmployeeSalaryController::class,
                ]);
                Route::post('purchase-return', [PurchaseController::class, 'returnPurchase'])->name('returnPurchase');
                Route::get('purchase-return', [PurchaseController::class, 'returnPurchaseList'])->name('returnPurchaseList');
                Route::post('supplier-due-payment', [PurchaseController::class, 'supplierDuePayment'])->name('supplierDuePayment');
                //sale Return
                Route::post('sale-return', [SaleController::class, 'returnSale'])->name('returnSale');
                Route::get('sale-return', [SaleController::class, 'returnSaleList'])->name('returnSaleList');
                //Sale Exchange
                Route::post('sale-exchange', [SaleController::class, 'saleExchange'])->name('saleExchange');
                //get medicine by barcode
                Route::get('medicine-by-barcode/{barcode}', [MedicineController::class, 'get_medicine_by_barcode']);
                Route::get('medicine-stock-by-barcode/{barcode}', [MedicineController::class, 'get_stock_by_barcode']);
                Route::get('medicine-by-content/{content}', [MedicineController::class, 'get_by_content']);
                Route::get('get-stock-by-expiredate', [MedicineController::class, 'get_stock_by_expiredate']);
                Route::post('sale-payment', [SaleController::class, 'salePayment'])->name('store.salePayment');
                Route::get('sale-payment', [SaleController::class, 'getPayment'])->name('getPayment');
                Route::post('customer-due-collect', [SaleController::class, 'customerDuePayment'])->name('customerDuePayment');
                Route::get('sale/invoice/{invocei}', [SaleController::class, 'saleByInvoice'])->name('saleByInvoice');
                Route::get('get-paid-salary/{employee}/{date}', [EmployeeSalaryController::class, 'getPaidSalary'])->name('getPaidSalary');
            });

            // Strength
            Route::apiResource('strength', StrengthController::class)->except(['show']);
            Route::get('strength/trash', [StrengthController::class, 'trash'])->name('strength_trash');
            Route::get('strength/restore/{id}', [StrengthController::class, 'restore'])->name('strength_restore');
            Route::delete('strength/forceDelete/{id}', [StrengthController::class, 'forceDelete'])->name('strength_forceDelete');

            // Supplier
            // Route::apiResource('supplier', SupplierController::class)->except(['show']);
            Route::get('supplier/forceDelete/{id}', [SupplierController::class, 'forceDelete'])->name('supplier_forceDelete');

            // Cost-category
            Route::apiResource('cost-category', CostCategoryController::class)->except(['show']);
            Route::get('cost-category/trash', [CostCategoryController::class, 'trash'])->name('cost-category_trash');
            Route::get('cost-category/restore/{id}', [CostCategoryController::class, 'restore'])->name('cost-category_restore');
            Route::delete('cost-category/forceDelete/{id}', [CostCategoryController::class, 'forceDelete'])->name('cost-category_forceDelete');

            //COst Category
            Route::apiResource('cost-category', CostController::class)->except(['show']);
            Route::get('cost-category/trash', [CostController::class, 'trash'])->name('cost_trash');
            Route::get('cost-category/restore/{id}', [CostController::class, 'restore'])->name('cost_restore');
            Route::delete('cost-category/forceDelete/{id}', [CostController::class, 'forceDelete'])->name('cost_forceDelete');

            Route::get('get-user-pharmacy', UserPharmacyController::class)->name('get-user-pharmacy');
            Route::get('country', GetCountryController::class)->name('country');
            Route::get('country-wise-division/{countries}', CountryWiseDivisionController::class)->name('country-wise-division');
            Route::get('division-wise-district/{division}', DivisionWiseDistrictController::class)->name('division-wise-district');
            Route::get('district-wise-upzila/{district}', DistrictWiseUpzilaController::class)->name('district-wise-upzila');
            Route::get('upzila-wise-union/{upzila}', UpzilaWiseUnionController::class)->name('upzila-wise-union');
            // Payment Method
            // Route::apiResource('payment-method', PaymentMethodController::class)->except(['show']);
            // Route::get('payment-method/trash', [PaymentMethodController::class, 'trash'])->name('payment_method_trash');
            // Route::get('payment-method/restore/{id}', [PaymentMethodController::class, 'restore'])->name('payment_method_restore');
            // Route::delete('payment-method/forceDelete/{id}', [PaymentMethodController::class, 'forceDelete'])->name('payment_method_forceDelete');
            // Cash-in-withdraw
            // Route::apiResource('cash', CashInOutController::class)->except(['show']);
            // Route::get('cash/trash', [CashInOutController::class, 'trash'])->name('cash_trash');
            // Route::get('cash/restore/{id}', [CashInOutController::class, 'restore'])->name('cash_restore');
            // Route::delete('cash/forceDelete/{id}', [CashInOutController::class, 'forceDelete'])->name('cash_forceDelete');
            // Cost
            // Route::apiResource('cost', CostController::class)->except(['show']);
            // Route::get('cost/trash', [CostController::class, 'trash'])->name('cost_trash');
            // Route::get('cost/restore/{id}', [CostController::class, 'restore'])->name('cost_restore');
            // Route::delete('cost/forceDelete/{id}', [CostController::class, 'forceDelete'])->name('cost_forceDelete');
            // Route::get('customer/trash', [CustomerController::class, 'trash'])->name('customer_trash');
            // Route::get('customer/restore/{id}', [CustomerController::class, 'restore'])->name('customer_restore');
            // Route::delete('customer/forceDelete/{id}', [CustomerController::class, 'forceDelete'])->name('customer_forceDelete');
            // Unit
            // Route::apiResource('unit', UnitController::class)->except(['show']);
            // Route::get('unit/trash', [UnitController::class, 'trash'])->name('unit_trash');
            // Route::get('unit/restore/{id}', [UnitController::class, 'restore'])->name('unit_restore');
            // Route::delete('unit/forceDelete/{id}', [UnitController::class, 'forceDelete'])->name('unit_forceDelete');

            // Leaf
            // Route::apiResource('leaf', LeafController::class)->except(['show']);
            // Route::get('leaf/trash', [LeafController::class, 'trash'])->name('leaf_trash');
            // Route::get('leaf/restore/{id}', [LeafController::class, 'restore'])->name('leaf_restore');
            // Route::delete('leaf/forceDelete/{id}', [LeafController::class, 'forceDelete'])->name('leaf_forceDelete');

            // Type
            // Route::apiResource('type', TypeController::class)->except(['show']);
            // Route::get('type/trash', [TypeController::class, 'trash'])->name('type_trash');
            // Route::get('type/restore/{id}', [TypeController::class, 'restore'])->name('type_restore');
            // Route::delete('type/forceDelete/{id}', [TypeController::class, 'forceDelete'])->name('type_forceDelete');

            // Shelf Number
            // Route::apiResource('shelf', ShelfNumberController::class)->except(['show']);
            // Route::get('shelf/trash', [ShelfNumberController::class, 'trash'])->name('shelf_trash');
            // Route::get('shelf/restore/{id}', [ShelfNumberController::class, 'restore'])->name('shelf_restore');
            // Route::delete('shelf/forceDelete/{id}', [ShelfNumberController::class, 'forceDelete'])->name('shelf_forceDelete');

            // Medicine
            // Route::apiResource('medicine', MedicineController::class)->except(['show']);
            // Route::get('medicine/trash', [MedicineController::class, 'trash'])->name('medicine_trash');
            // Route::get('medicine/restore/{id}', [MedicineController::class, 'restore'])->name('medicine_restore');
            // Route::delete('medicine/forceDelete/{id}', [MedicineController::class, 'forceDelete'])->name('medicine_forceDelete');\
            // Manufacturer
            // Route::apiResource('manufacturer', ManufacturerController::class)->except(['show']);
            // Route::get('manufacturer/trash', [ManufacturerController::class, 'trash'])->name('manufacturer_trash');
            // Route::get('manufacturer/restore/{id}', [ManufacturerController::class, 'restore'])->name('manufacturer_restore');
            // Route::delete('manufacturer/forceDelete/{id}', [ManufacturerController::class, 'forceDelete'])->name('manufacturer_forceDelete');
        });
    });
});
