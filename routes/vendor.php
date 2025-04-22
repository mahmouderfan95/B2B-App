<?php

use App\Http\Controllers\RoleAndPermissionController;
use App\Http\Controllers\Vendor\AgreementController;
use App\Http\Controllers\Vendor\HomeController;
use App\Http\Controllers\Vendor\LoginController;
use App\Http\Controllers\Vendor\OrderController;
use App\Http\Controllers\Vendor\PermissionController;
use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\Vendor\ProfileController;
use App\Http\Controllers\Vendor\QuotationController;
use App\Http\Controllers\Vendor\RoleController;
use App\Http\Controllers\Vendor\SpecialOrderController;
use App\Http\Controllers\Vendor\SubVendorController;
use App\Http\Controllers\Vendor\VendorWalletController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| vendor Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//});
///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Vendor /////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

Route::group(['middleware' => ['guest']], function () {
    //////////////////////////// Vendor Login Form ///////////////////////////////
    Route::get('/login', [LoginController::class, 'index'])->name('login.form');

    //////////////////////////// Vendor Login Action ///////////////////////////////
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
///////////////////////////////////// Vendor Auth /////////////////////////////////////////
Route::group(['middleware' => ['auth:vendor', 'vendor_status', 'vendor.agreement-requested']], function () { // , 'role:Admin'

    //////////////////////////// Vendor Dashboard ///////////////////////////////
    Route::get('', [HomeController::class, 'index'])->name('root');

    //////////////////////////// Vendor Profile ///////////////////////////////
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    /*////////////////////////// Mange Sub ///////////////////////////////
    ############################################################################
    */
    // Sub Vendors List //
    Route::get('/sub-vendors', [SubVendorController::class, 'index'])->name('sub.list');

    // Create Sub Vendor //
    Route::get('/sub-vendors/create', [SubVendorController::class, 'create'])->name('sub.create.form');
    Route::post('/sub-vendors/create', [SubVendorController::class, 'store'])->name('sub.create');


    // Show edit Sub Vendor //
    Route::get('/sub-vendors/edit/{id}', [SubVendorController::class, 'edit'])->name('sub.edit.form');
    Route::put('/sub-vendors/edit/{id}', [SubVendorController::class, 'update'])->name('sub.update');

    // Delete Sub Vendor Form //
    Route::delete('/sub-vendors/delete/{id}', [SubVendorController::class, 'delete'])->name('sub.delete');


    //////////////////////////// products ///////////////////////////////
    Route::resource('products', ProductController::class);
    Route::post('upload-image', [ProductController::class, 'upload_image'])->name('upload.image');

    //////////////////////////// Orders ///////////////////////////////
    Route::resource('orders', OrderController::class);
    Route::group(['prefix' => 'public-orders'],function(){
        Route::get('/', [OrderController::class, 'public_orders'])->name('orders.public');
        Route::put('approve/{order_id}', [OrderController::class, 'approve'])->name('orders.public.approve');
        Route::post('reject/{order_id}', [OrderController::class, 'reject'])->name('orders.public.reject');
        Route::post('get-ready-for-shipping/{order_id}', [OrderController::class,'readyForShip'])->name('orders.public.readyForShip');
        Route::post('delivery/{order_id}', [OrderController::class,'delivery'])->name('orders.public.delivery');
    });

    //////////////////////////// Special order And Quotations ///////////////////////////////
    Route::group(['prefix' => 'special-orders'],function(){
        Route::get('/', [SpecialOrderController::class, 'index'])->name('orders.special');
        Route::get('show/{id}', [SpecialOrderController::class, 'show'])->name('orders.special.show');
        Route::delete('delete/{id}',[SpecialOrderController::class,'destroy'])->name('orders.special.destroy');
        Route::put('accepted/{id}', [SpecialOrderController::class, 'acceptedByVendor'])->name('orders.special.accepted');
        Route::post('reject/{id}', [SpecialOrderController::class, 'rejectByVendor'])->name('orders.special.reject');
        Route::post('get-ready-for-shipping/{id}', [SpecialOrderController::class,'readyForShip'])->name('orders.special.readyForShip');
        Route::post('delivery/{id}', [SpecialOrderController::class,'delivery'])->name('orders.special.delivery');
        Route::post('add_total', [SpecialOrderController::class, 'add_total'])->name('quotations.add_total');
        Route::post('quotations/accept', [SpecialOrderController::class, 'accept'])->name('quotations.accept');
        Route::post('quotations/refused', [SpecialOrderController::class, 'refused'])->name('quotations.refused');
        Route::post('shipping/accept', [SpecialOrderController::class, 'shipping_offer_accept'])->name('shipping.special.offer.accept');
        Route::post('shipping/refused', [SpecialOrderController::class, 'shipping_offer_refused'])->name('shipping.special.offer.refused');
    });
    //////////////////////////// Privacy Policy ///////////////////////////////
    Route::get('my-wallet', [VendorWalletController::class, 'show'])->name('my_wallet');
    //////////////////////////// Privacy Policy ///////////////////////////////
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);

    Route::get('wallet', 'WalletController@show')->name('wallet');

    // quotation route
    Route::resource('quotations',QuotationController::class);
    // vendor send replay page
    Route::get('quotation/{id}/send-replay',[QuotationController::class,'sendReplayPage'])->name('quotations.send.replay.page');
    // vendor post send replay
    Route::post('quotation/{id}/send/replay',[QuotationController::class,'sendReplay'])->name('quotations.send.replay');

    Route::prefix("agreements")
        ->controller(AgreementController::class)
        ->as('agreements.')
        ->group(function () {
            Route::put('approve', 'approve')->name("approve");
            Route::get('/', 'index')->name("index");
        });
});

