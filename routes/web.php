<?php

use App\Http\Controllers\Admin\AboutUsController as DashAboutUsController;
use App\Http\Controllers\Admin\AttributeController as DashAttributeController;
use App\Http\Controllers\Admin\AttributeGroupController as DashAttributeGroupController;
use App\Http\Controllers\Admin\BankController as DashBankController;
use App\Http\Controllers\Admin\BannerController as DashBannerController;
use App\Http\Controllers\Admin\CategoryController as DashCategoryController;
use App\Http\Controllers\Admin\CertificateController as DashCertificateController;
use App\Http\Controllers\Admin\CityController as DashCityController;
use App\Http\Controllers\Admin\ClientController as DashClientController;
use App\Http\Controllers\Admin\ContactController as DashContactController;
use App\Http\Controllers\Admin\CountryController as DashCountryController;
use App\Http\Controllers\Admin\CurrencyController as DashCurrencyController;
use App\Http\Controllers\Admin\FagController as DashFagController;
use App\Http\Controllers\Admin\FastShippingController;
use App\Http\Controllers\Admin\HowToNegotiatePriceController;
use App\Http\Controllers\Admin\HowToSpecialOrderController;
use App\Http\Controllers\Admin\LanguageController as DashLanguageController;
use App\Http\Controllers\Admin\OrderController as DashOrderController;
use App\Http\Controllers\Admin\PackageController as DashPackageController;
use App\Http\Controllers\Admin\PrivacyPolicyController as DashPrivacyPolicyController;
use App\Http\Controllers\Admin\ProductController as DashProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\QualityController as DashQualityController;
use App\Http\Controllers\Admin\RegionController as DashRegionController;
use App\Http\Controllers\Admin\ReviewController as DashReviewController;
use App\Http\Controllers\Admin\SettingController as DashSettingController;
use App\Http\Controllers\Admin\ShippingMethodController as DashShippingMethodController;
use App\Http\Controllers\Admin\ShippingWalletController as DashShippingWalletController;
use App\Http\Controllers\Admin\SizeController as DashSizeController;
use App\Http\Controllers\Admin\SpecialOrderController as DashSpecialOrderController;
use App\Http\Controllers\Admin\SubVendorController as DashSubVendorController;
use App\Http\Controllers\Admin\TermsAndConditionController as DashTermsAndConditionController;
use App\Http\Controllers\Admin\TransactionController as DashTransactionController;
use App\Http\Controllers\Admin\TypeController as DashTypeController;
use App\Http\Controllers\Admin\UnitController as DashUnitController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VendorAgreementController;
use App\Http\Controllers\Admin\VendorController as DashVendorController;
use App\Http\Controllers\Admin\VendorReportController;
use App\Http\Controllers\Admin\VendorWalletController as DashVendorWalletController;
use App\Http\Controllers\Front\TransactionController;
use App\Http\Controllers\PermissionController as DashPermissionController;
use App\Http\Controllers\RoleController as DashRoleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// special order call back
Route::get('special-order/pay-callback',[TransactionController::class,'special_order_callback'])->name('special-order-payment-callback');
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details // TODO:: add Roll
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'root'])->name('index');
///////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// Dashboard ////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

Route::group(['middleware' => 'auth:web', 'prefix' => 'admin/dashboard', 'as' => 'dashboard.'], function () {

    //////////////////////////// admin Profile ///////////////////////////////
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('update/profile', [ProfileController::class, 'update'])->name('profile.update');

    //////////////////////////// orders ///////////////////////////////
    Route::resource('orders', DashOrderController::class)->middleware('can:sample-order');
    Route::get('public-orders', [DashOrderController::class, 'public_orders'])->name('orders.public')->middleware('can:public-order');

    //////////////////////////// special orders ///////////////////////////////
    Route::resource('special-orders', DashSpecialOrderController::class)->middleware('can:special-order');

    //////////////////////////// banners ///////////////////////////////
    Route::resource('banners', DashBannerController::class)->middleware('can:banners');

    //////////////////////////// banners ///////////////////////////////
    Route::resource('banks', DashBankController::class)->middleware('can:banks');

    //////////////////////////// categories ///////////////////////////////
    Route::resource('categories', DashCategoryController::class)->middleware('can:categories');
    Route::get('categories/trashes', [DashCategoryController::class, 'trash'])->name('categories.trashes');
    Route::get('category/restore/{id}', [DashCategoryController::class, 'restore'])->name('category.restore');

    //////////////////////////// products ///////////////////////////////
    Route::resource('products', DashProductController::class)->middleware('can:products');
    Route::post('upload-image', [DashProductController::class, 'upload_image'])->name('upload.image');


    //////////////////////////// clients ///////////////////////////////
    Route::resource('clients', DashClientController::class)->middleware('can:clients');
    ////////////////////////// report vendor order ////////////////////
    Route::prefix("reports/vendors-orders")
            ->controller(VendorReportController::class)
            ->group(function() {
                Route::get("/", "vendorsOrders")->name("reports.vendors-orders");
            });
    /////////////////////////// users //////////////////////////////////
    Route::resource('users',UserController::class)->middleware('can:users');
    //////////////////////////// reviews ///////////////////////////////
    Route::resource('reviews', DashReviewController::class)->middleware('can:reviews');

    //////////////////////////// vendors ///////////////////////////////
    Route::resource('vendors', DashVendorController::class)->middleware('can:vendors');
    Route::get('vendors/banned/{vendor}', [DashVendorController::class, 'banned'])->name('vendor.banned')->middleware('can:block-vendor');
    Route::post('vendor/{vendor}/add/balance',[DashVendorController::class,'addBalance'])->name('vendor.add.balance');
    Route::post('vendor/{vendor}/deduction/balance',[DashVendorController::class,'deductionBalance'])->name('vendor.deduction.balance');

    //////////////////////////// Sub vendors ///////////////////////////////
    Route::resource('sub-vendors', DashSubVendorController::class)->middleware('can:sub-vendors');

    //////////////////////////// vendors-agreements ///////////////////////////////
    Route::prefix("vendors-agreements")
        ->controller(VendorAgreementController::class)
        ->group(function () {
            Route::get("/", "index")->name("vendors-agreements.index");
            Route::get("/send", "sendForm")->name("vendors-agreements.send-form");
            Route::post("/send", "send")->name("vendors-agreements.send");
            Route::put("/cancel/{agreement}", "cancel")->name("vendors-agreements.cancel");
            Route::put("/resend/{agreement}", "resend")->name("vendors-agreements.resend");
        });

    //////////////////////////// transactions ///////////////////////////////
    Route::resource('transactions', DashTransactionController::class)->middleware('can:transactions');

    //////////////////////////// .currencies ///////////////////////////////
    Route::resource('currencies', DashCurrencyController::class)->middleware('can:countries');

    //////////////////////////// .certificates ///////////////////////////////
    Route::resource('certificates', DashCertificateController::class)->middleware('can:certificates');

    //////////////////////////// .types ///////////////////////////////
    Route::resource('types', DashTypeController::class)->middleware('can:product-types');

    //////////////////////////// .attributes ///////////////////////////////
    Route::resource('attributes', DashAttributeController::class)->middleware('can:attributes');
    //////////////////////////// .attributes ///////////////////////////////
    Route::get('attribute/autocomplete', [DashAttributeController::class, 'autocomplete'])->name('attributes.autocomplete');

    //////////////////////////// .attributesGroupS ///////////////////////////////
    Route::resource('attributeGroups', DashAttributeGroupController::class)->middleware('can:attributeGroups');

    //////////////////////////// .units ///////////////////////////////
    Route::resource('units', DashUnitController::class)->middleware('can:units');

    //////////////////////////// .packages ///////////////////////////////
    Route::resource('packages', DashPackageController::class)->middleware('can:packages');

    //////////////////////////// .sizes ///////////////////////////////
    Route::resource('sizes', DashSizeController::class)->middleware('can:sizes');


    //////////////////////////// .qualities ///////////////////////////////
    Route::resource('qualities', DashQualityController::class)->middleware('can:qualities');

    //////////////////////////// .countries ///////////////////////////////
    Route::resource('countries', DashCountryController::class)->middleware('can:countries');

    //////////////////////////// .regions ///////////////////////////////
    Route::resource('regions', DashRegionController::class)->middleware('can:regions');

    //////////////////////////// .cities ///////////////////////////////
    Route::resource('cities', DashCityController::class)->middleware('can:cities');

    //////////////////////////// languages ///////////////////////////////
    Route::resource('languages', DashLanguageController::class)->middleware('can:languages');

    //////////////////////////// Fags ///////////////////////////////
    Route::resource('fags', DashFagController::class)->middleware('can:fags');

    //////////////////////////// Privacy Policy ///////////////////////////////
    Route::resource('privacy-policy', DashPrivacyPolicyController::class)->middleware('can:privacy-policy');

    //////////////////////////// terms and conditions ///////////////////////////////
    Route::resource('terms-conditions', DashTermsAndConditionController::class)->middleware('can:terms-conditions');


    //////////////////////////// About       Us ///////////////////////////////
    Route::resource('aboutUss', DashAboutUsController::class)->middleware('can:aboutUss');

    //////////////////////////// Privacy Policy ///////////////////////////////
    Route::resource('contact', DashContactController::class)->middleware('can:contact');
    ///////////////////////// fast shipping ///////////////////////////////////
    Route::resource('fast-shipping',FastShippingController::class);
    ////////////////////////// How To SpecialOrder Page
    Route::resource('how-to-special-order',HowToSpecialOrderController::class);
    ////////////////////////// How To SpecialOrder Page
    Route::resource('how-to-negotiate-price',HowToNegotiatePriceController::class);
    //////////////////////////// Privacy Policy ///////////////////////////////
    Route::resource('role', DashRoleController::class);
    Route::resource('permission', DashPermissionController::class)->middleware('can:user-permissions');


    //////////////////////////// .shippingMethod ///////////////////////////////
    Route::resource('shippingMethods', DashShippingMethodController::class)->middleware('can:shipping-methods');
    Route::get('shippingMethods/banned/{shippingMethod}', [DashShippingMethodController::class, 'banned'])->name('shippingMethod.banned');

    //////////////////////////// ShippingWallet ///////////////////////////////
    Route::get('shipping-wallets', [DashShippingWalletController::class, 'index'])->name('shipping-wallets')->middleware('can:shipping-wallet');
    Route::get('shipping-wallets/show/{id}', [DashShippingWalletController::class, 'show'])->name('shipping-wallets.show');
    Route::post('shipping-wallets/add_balance', [DashShippingWalletController::class, 'add_balance'])->name('shipping-wallets.add_balance');
    Route::post('shipping-wallets/balance_deduction', [DashShippingWalletController::class, 'balance_deduction'])->name('shipping-wallets.balance_deduction');

    //////////////////////////// .Settings ///////////////////////////////
    Route::get('settings/settings', [DashSettingController::class, 'show'])->name('settings.show')->middleware('can:settings');
    Route::post('settings/updateSetting', [DashSettingController::class, 'updateSetting'])->name('settings.updateSetting');

    Route::resource('vendorWallets', DashVendorWalletController::class)->only(['index', 'show', 'update'])->middleware('can:vendor-wallet');

});
