<?php


use App\Http\Controllers\Shipping\HomeController;
use App\Http\Controllers\Shipping\LoginController;
use App\Http\Controllers\Shipping\OfferController;
use App\Http\Controllers\Shipping\OrderController;
use App\Http\Controllers\Shipping\ProfileController;
use App\Http\Controllers\Shipping\ShippingWalletController;
use App\Http\Controllers\Shipping\SpecialOrderController;
use App\Http\Controllers\Shipping\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shipping\SpecialOfferController;

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
//////////////////////////////////// Shipping ////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

Route::group(['middleware' => ['guest']], function () {
    //////////////////////////// Vendor Login Form ///////////////////////////////
    Route::get('/login', [LoginController::class, 'index'])->name('login.form');

    //////////////////////////// Shipping Login Action ///////////////////////////////
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
Route::group(['middleware' => ['auth:shipping']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('root');
    ////////////////////////////  Profile ///////////////////////////////
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    //////////////////////////// Orders ///////////////////////////////
    Route::get('sample-orders',[OrderController::class,'sample_orders'])->name('orders.sample');
    Route::resource('special-orders', SpecialOrderController::class);
    Route::post('special-orders/shipping/add/offer',[SpecialOrderController::class,'addOffer'])->name('add.offer');
    Route::group(['prefix' => 'public-orders'],function(){
        Route::get('/', [OrderController::class, 'public_orders'])->name('orders.public');
        // show public order
        Route::get('{id}/show',[OrderController::class,'show_public_orders'])->name('orders.public.show');
        // add offer in public order
        Route::post('shipping/add/offer',[OrderController::class,'addOffer'])->name('public-orders.add.offer');
    });
    //////////////////////////////////////// offers ////////////////////////////////////////////////////
    Route::resource('offers', OfferController::class);
    /////////////////////////////////////// special offers ////////////////////////////////////
    Route::resource('special-offers',SpecialOfferController::class);
    //////////////////////////////////////// ShippingWalletController ////////////////////////////////////////////////////
    Route::get('shipping-wallets/show', [ShippingWalletController::class, 'show'])->name('shipping-wallets.show');
    /////////////////////////////////// Transaction Controller ///////////////////////////////////////////////////////////
    Route::resource('transactions',TransactionController::class);
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
});
