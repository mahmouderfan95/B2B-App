<?php

use App\Http\Controllers\Vendor\HomeController;
use \App\Http\Controllers\SubVendor\ProductController;
use App\Http\Controllers\Vendor\ProfileController;
use App\Http\Controllers\Vendor\SubVendorController;
use App\Http\Controllers\SubVendor\SubVendorController as SubVendor;
use App\Http\Controllers\SubVendor\AgreementController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\SubVendor\VendorWalletController;
use \App\Http\Controllers\SubVendor\OrderController;
use \App\Http\Controllers\SubVendor\SpecialOrderController;
/*
|--------------------------------------------------------------------------
| Sub-Vendor Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Sub-Vendor /////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Sub-Vendor Auth /////////////////////////////////////////
Route::group(['middleware' => ['auth:sub_vendor', 'role:SubVendor']], function () {


    //////////////////////////// Sub-Vendor Dashboard ///////////////////////////////
    Route::get('', [HomeController::class, 'subVendorIndex'])->name('root');

    // Show edit Sub Vendor //
    Route::get('/sub-vendors/profile', [SubVendorController::class, 'editProfile'])->name('profile.update.form');
    Route::put('/sub-vendors/profile', [SubVendorController::class, 'updateProfile'])->name('profile.update');

    /*////////////////////////// Sub-Vendor Products ///////////////////////////////
    ############################################################################
    /*////////////////////////// Mange Sub ///////////////////////////////
    ############################################################################ */
    // Sub Vendors List //
    Route::get('/sub-vendors', [SubVendorController::class, 'index'])->name('sub.list');

    // Create Sub Vendor //
    Route::get('/sub-vendors/create', [SubVendor::class, 'create'])->name('sub.create.form');
    Route::post('/sub-vendors/create', [SubVendor::class, 'store'])->name('sub.create');


    // Show edit Sub Vendor //
    Route::get('/sub-vendors/edit/{id}', [SubVendor::class, 'edit'])->name('sub.edit.form');
    Route::put('/sub-vendors/edit/{id}', [SubVendor::class, 'update'])->name('sub.update');

    // Delete Sub Vendor Form //
    Route::delete('/sub-vendors/delete/{id}', [SubVendor::class, 'delete'])->name('sub.delete');

    //////////////////////////// Sub Vendor Products List /////////////////////////////*/
    Route::resource('/products', ProductController::class);
    Route::post('upload-image', [ProductController::class, 'upload_image'])->name('upload.image');
    ///////////////////////// vendor wallet //////////////////////////////////
    Route::get('my-wallet', [VendorWalletController::class, 'show'])->name('my_wallet');
    //////////////////////////// Sub Vendor Orders ///////////////////////////////
    Route::resource('orders', OrderController::class);
    Route::get('public-orders', [OrderController::class, 'public_orders'])->name('orders.public');
    Route::post('public-orders/approve/{order_id}', [OrderController::class, 'approve'])->name('orders.public.approve');
    Route::post('public-orders/reject/{order_id}', [OrderController::class, 'reject'])->name('orders.public.reject');
    Route::post('public-orders/get-ready-for-shipping/{order_id}', [OrderController::class, 'reject'])->name('orders.public.getshippingReady');

    //////////////////////////// Sub Vendor Special order And Quotations ///////////////////////////////
    Route::get('special-orders', [SpecialOrderController::class, 'index'])->name('orders.special');
    Route::get('special-orders/show/{id}', [SpecialOrderController::class, 'show'])->name('orders.special.show');
    Route::put('special-orders/accepted/{id}', [SpecialOrderController::class, 'acceptedByVendor'])->name('orders.special.accepted');
    Route::post('special-orders/add_total', [SpecialOrderController::class, 'add_total'])->name('quotations.add_total');
    Route::post('special-orders/quotations/accept', [SpecialOrderController::class, 'accept'])->name('quotations.accept');
    Route::post('special-orders/quotations/refused', [SpecialOrderController::class, 'refused'])->name('quotations.refused');
    Route::post('special-orders/shipping/accept', [SpecialOrderController::class, 'shipping_offer_accept'])->name('shipping.special.offer.accept');
    Route::post('special-orders/shipping/refused', [SpecialOrderController::class, 'shipping_offer_refused'])->name('shipping.special.offer.refused');
    ////////////////////// Sub Vendor agreements /////////////////////////////////
    Route::prefix("agreements")
        ->controller(AgreementController::class)
        ->as('agreements.')
        ->group(function () {
            Route::put('approve', 'approve')->name("approve");
            Route::get('/', 'index')->name("index");
        });


});

