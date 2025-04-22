<?php

use App\Http\Controllers\Front\AddressController;
use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\BankController;
use App\Http\Controllers\Front\BannerController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CategoryController;
use App\Http\Controllers\Front\CityController;
use App\Http\Controllers\Front\ContactUsController;
use App\Http\Controllers\Front\CountryController;
use App\Http\Controllers\Front\CurrencyController;
use App\Http\Controllers\Front\DraftController;
use App\Http\Controllers\Front\LanguageController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\PublicOrderController;
use App\Http\Controllers\Front\QualityController;
use App\Http\Controllers\Front\QuotationController;
use App\Http\Controllers\Front\SettingController;
use App\Http\Controllers\Front\ShippingMethodController;
use App\Http\Controllers\Front\ShippingQuotationController;
use App\Http\Controllers\Front\SidePagesController;
use App\Http\Controllers\Front\TransactionController;
use App\Http\Controllers\Front\VendorController;
use App\Http\Controllers\Front\SpecialOrderController;
use App\Http\Controllers\Front\SpecialShippingOfferController;
use App\Models\Transaction;
use App\Services\Payments\Urway\UrwayServices;
use Illuminate\Support\Facades\Route;
use App\Models\Order;
use App\Http\Controllers\Front\NotificationController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// test integration ur-way
Route::post('urway/generate/{order_id}',function(Order $order){
    $payment = new UrwayServices();
    return $payment->generatePaymentUrl($order);
});
///////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// FrontAPI  ////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

Route::get('cart/pay-callback', [TransactionController::class,'pay_callback'])->name('payment-callback');
Route::get('payment/success',function(){
    dd('success');
})->name('payment.test.success');
Route::get('payment/fail',function(){
    dd('fail');
})->name('payment.test.fail');
Route::group(['prefix' => 'front', 'as' => 'front.'], function () {
    //////////////////////////// products /////////////////////////////
    Route::get('products/best-seller', [ProductController::class, 'best_seller']);
    Route::get('products/latest', [ProductController::class, 'latest']);
    Route::get('products/category/{category}', [ProductController::class, 'category']);
    Route::get('products/details/{product}', [ProductController::class, 'details']);
    Route::get('products/compare/{product}', [ProductController::class, 'compare']);
    //////////////////////////////////// products /////////////////////////////////
    // guest route
    Route::group(['middleware' => 'guest:client'],function(){
        Route::post('register', [AuthController::class, 'register']);
        Route::post('verify-email', [AuthController::class, 'verifyEmail']);
        Route::post('resend-email-verification', [AuthController::class, 'reSendVerificationMail']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('forget-password', [AuthController::class, 'forgetPassword']);
        Route::post('check-otp', [AuthController::class, 'checkOTP']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
        //////////////////////////// languages ///////////////////////////////
        Route::apiResource('languages', LanguageController::class);

        //////////////////////////// languages ///////////////////////////////
        Route::apiResource('qualities', QualityController::class);

        //////////////////////////// currencies ///////////////////////////////
        Route::apiResource('currencies', CurrencyController::class);

        //////////////////////////// banks ///////////////////////////////
        Route::get('banks/all', [BankController::class, 'index']);

        //////////////////////////// countries ///////////////////////////////
        Route::get('countries/all', [CountryController::class, 'index']);

        //////////////////////////// countries ///////////////////////////////
        Route::get('cities/all', [CityController::class, 'index']);

        //////////////////////////// banners ///////////////////////////////
        Route::apiResource('banners', BannerController::class);
        // Route::get('products/reviews', [ProductController::class,'addReview']);
        //////////////////////////// categories ///////////////////////////////
        Route::get('categories/all', [CategoryController::class, 'all']);
        Route::get('categories/details/{category}', [CategoryController::class, 'details']);
        Route::get('categories/tree/{category?}', [CategoryController::class, 'tree']);

        //////////////////////////// vendors ///////////////////////////////
        Route::get('vendors/all', [VendorController::class, 'index']);
        Route::get('vendors/details/{id}', [VendorController::class, 'details']);
        Route::get('vendors/products/{id}', [VendorController::class, 'products']);
        Route::post('vendors/register', [VendorController::class, 'register']);
        /////////////// side pages
        Route::get('faqs', [SidePagesController::class, 'faq']);
        Route::get('contact-info', [SidePagesController::class, 'contactInfo']);
        Route::get('privacy-policy', [SidePagesController::class, 'privacyPolicy']);
        Route::get('terms-conditions', [SidePagesController::class, 'tersmAnsConditions']);
        Route::get('about-us', [SidePagesController::class, 'aboutUs']);
        Route::get('fast-shipping', [SidePagesController::class, 'fastShipping']);
        Route::get('how-to-special-orders', [SidePagesController::class, 'howToSpecialOrders']);
        Route::get('how-to-negotiate-prices', [SidePagesController::class, 'howToNegotiatePrices']);
        /////////////////////////////// Shipping Method ///////////////////////////
        Route::get('shippingMethods', [ShippingMethodController::class, 'index']);
        Route::get('shippingMethods/details/{id}', [ShippingMethodController::class, 'details']);
        Route::get('shippingMethods/offer/{order_id}', [ShippingMethodController::class, 'offer']);
        Route::get('shippingMethods/special_offer/{order_id}', [ShippingMethodController::class, 'special_offer']);

        /////////////////////////////// Setting ///////////////////////////
        Route::get('setting', [SettingController::class, 'index']);
        Route::get('setting/details/{key}', [SettingController::class, 'details']);

    });
    // auth route
    Route::group(['middleware' => 'api_auth'],function(){
        ////////////////////////////
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('complete-profile', [AuthController::class, 'completeProfile']);
        Route::get('profile', [AuthController::class, 'me']);
        //////////////////////////// products ///////////////////////////////
        Route::post('products/add-to-favorate/{product}', [ProductController::class, 'addToFavorite']);
        Route::post('products/remove-from-favorate/{product}', [ProductController::class, 'removeFromFavorite']);
        Route::get('products/favorite', [ProductController::class, 'getFavorite']);
        Route::post('products/review/store', [ProductController::class, 'addReview']);
        Route::post('products/review/update/{review}', [ProductController::class, 'updateReview']);
        // search in products
        Route::get('search/products',[ProductController::class,'searchProducts']);
        ////////////////////////////
        Route::prefix('sample-order')->group(function () {
            //////////////////////////// cart ///////////////////////////////
            Route::post('cart/add-to-cart', [CartController::class, 'addToCart']);
            Route::post('cart/remove-from-cart', [CartController::class, 'removefromCart']);
            Route::post('cart/empty-cart', [CartController::class, 'emptyCart']);
            Route::post('cart/add-shipping-address', [CartController::class, 'addShippingAddress']);
            Route::get('cart/items', [CartController::class, 'getCartItems']);
            Route::post('cart/checkout', [TransactionController::class, 'checkout']);
            //////////////////////////// orders ///////////////////////////////
            Route::get('orders', [TransactionController::class, 'orders']);
            //////////////////////////// sample order details ////////////////
            Route::get('details/{id}',[TransactionController::class,'getSampleOrderDetails']);
        });
        Route::prefix('public-order')->group(function () {
            //////////////////////////// cart ///////////////////////////////
            Route::post('create', [PublicOrderController::class, 'registerOrder']);
            Route::post('vendor-accept/{order_id}', [PublicOrderController::class, 'vendorAccept']);
            Route::post('chooseShippingType/{order_id}', [PublicOrderController::class, 'chooseShippingType']);
            Route::post('partial-pay/{order_id}', [PublicOrderController::class, 'partialPay']);
            Route::post('vendorGetOrderReady/{order_id}', [PublicOrderController::class, 'vendorGetOrderReady']);
            Route::post('full-pay/{order_id}', [PublicOrderController::class, 'fullPay']);
            Route::post('ready-to-ship/{order_id}', [PublicOrderController::class, 'readToShip']);
            Route::post('delivered/{order_id}', [PublicOrderController::class, 'delivered']);
            Route::post('shipping-done/{order_id}', [PublicOrderController::class, 'shippingDone']);
            //////////////////////////// public orders ///////////////////////////////
            Route::get('orders', [PublicOrderController::class, 'orders']);
            ////////////////////////// public order details /////////////////////////
            Route::get('details/{id}',[PublicOrderController::class,'getPublicOrderDetails']);
            Route::group(['prefix' => 'shippingQuotations'],function(){
                // shipping send quotation to user
                Route::post('shippingMethod/send/quotation',[ShippingQuotationController::class,'shippingSendQuotationPublic']);
                // shipping quotation public order
                Route::get('/{order_id}',[ShippingQuotationController::class,'getShippingQuotationPublicOrder']);
                // shipping quotation public order details
                Route::get('{id}',[ShippingQuotationController::class,'getShippingQuotationPublicOrderDetails']);
                // client accept shipping quotation
                Route::post('{id}/accept/{order_id}',[ShippingQuotationController::class,'acceptShippingQuotationPublicOrder']);
                // client refused shipping quotation
                Route::post('{id}/refused/{order_id}',[ShippingQuotationController::class,'refusedShippingQuotationPublicOrder']);
            });
        });
        Route::prefix('special-order')->group(function () {
            //////////////////////////// special-order ///////////////////////////////
            Route::post('create', [SpecialOrderController::class, 'registerOrder']);
            Route::post('vendor-accept/{order_id}', [SpecialOrderController::class, 'vendorAccept']);
            Route::post('chooseShippingType/{order_id}', [SpecialOrderController::class, 'chooseShippingType']);
            Route::post('partial-pay/{order_id}', [SpecialOrderController::class, 'partialPay']);
            Route::post('vendorGetOrderReady/{order_id}', [SpecialOrderController::class, 'vendorGetOrderReady']);
            Route::post('full-pay/{order_id}', [SpecialOrderController::class, 'fullPay']);
            Route::get('orders', [SpecialOrderController::class, 'orders']);
            // get special order details
            Route::get('details/{id}',[SpecialOrderController::class,'orderDetails']);
            // get all vendor quotation for sp order
            Route::get('{id}/vendor-quotation',[SpecialOrderController::class,'getVendorQuotation']);
            // user send quotation to vendor
            Route::post('user/send-quotation',[QuotationController::class,'store']);
            // vendor send quotation to user
            Route::post('vendor/send-quotation',[QuotationController::class,'VendorSend']);
            // user accepted or rejected quotation
            Route::post('user/acceptOrReject/quotation',[QuotationController::class,'update']);
            Route::get('orders/in-progress', [SpecialOrderController::class, 'ordersInProgress']);
            Route::get('orders/completed', [SpecialOrderController::class, 'ordersCompleted']);
            Route::get('orders/rejected', [SpecialOrderController::class, 'ordersRejected']);
            Route::get('shipping-special-offers/{specialOrder}',[SpecialOrderController::class,'shippingSpecialOffers']);
        });
        // notifications
        Route::get('get/notifications',[NotificationController::class,'index']);
        // shipping quotation special order
        Route::get('shippingQuotations/special-order/{special_order_id}',[ShippingQuotationController::class,'getShippingQuotationSpecialOrder']);
        // shipping quotation special order details
        Route::get('shippingQuotations/special-order/{id}',[ShippingQuotationController::class,'getShippingQuotationSpecialOrderDetails']);
        // client accept shipping quotation
        Route::post('shippingQuotations/{id}/special-order/{sp_id}/accept',[ShippingQuotationController::class,'acceptShippingQuotation']);
        // client refused shipping quotation
        Route::post('shippingQuotations/{id}/special-order/{sp_id}/refused',[ShippingQuotationController::class,'refusedShippingQuotation']);
        // send shipping method quotation to user
        Route::post('shippingMethod/send/quotation',[ShippingQuotationController::class,'shippingSendQuotation']);
        // public order
        /////////////////////////////////// draft /////////////////////////
        Route::get('draft',[DraftController::class,'index']);
        //////////////////////////// address ///////////////////////////////
        Route::post('address/store', [AddressController::class, 'store']);
        Route::post('address/update/{address}', [AddressController::class, 'update']);
        Route::post('address/delete/{address}', [AddressController::class, 'delete']);
        Route::post('address/set-default/{address}', [AddressController::class, 'setDefault']);
        Route::get('address/get-all', [AddressController::class, 'getCurrentUserAddresses']);
        // user accept offer
        Route::post('client/special-orders/shipping/accept',[SpecialShippingOfferController::class,'acceptOffer']);
    });


});
