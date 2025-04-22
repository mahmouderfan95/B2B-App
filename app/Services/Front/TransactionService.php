<?php

namespace App\Services\Front;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethods;
use App\Events\Orders\Created;
use App\Exceptions\Cart\cartBadUse;
use App\Http\Requests\Admin\LanguageRequest;
use App\Http\Resources\Front\Checkout;
use App\Http\Resources\Front\Orders\SingleOrder;
use App\Http\Resources\Front\QualityResource;
use App\Models\SpecialOrder;
use App\Models\VendorWallet;
use App\Models\VendorWalletTransaction;
use App\Repositories\Front\QualityRepository;
use Exception;
use App\Helpers\FileUpload;
use App\Http\Resources\Front\OrderResource;
use App\Models\OnlinePayment;
use App\Models\Quality;
use App\Models\Transaction;
use App\Repositories\Front\CartRepository;
use App\Repositories\Front\TransactionRepository;
use App\Services\Front\Order\PublicOrder;
use App\Services\Front\Order\SampleOrder;
use App\Services\Payments\Urway\UrwayServices;
use App\Traits\ApiResponseAble;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Events\Transaction as TransactionEvents;
use App\Models\Order;
use App\Models\User;
use App\Notifications\Admin\CreateSampleOrderNotification;
use App\Services\Payments\Urway\Constants;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class TransactionService
{
    use FileUpload, ApiResponseAble;

    private $cartRepository;
    private $transactionRepository;

    public function __construct(
        CartRepository $cartRepository, TransactionRepository $transactionRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     *
     * All  Languages.
     *
     */
    public function checkout($request)
    {
       try {
               $cart = $this->cartRepository->getCartByClient(auth('client')->id());
               if (!$cart) return $this->ApiErrorResponse(null, __("api.cart.cart_is_empty"));
                $order = new SampleOrder($cart,$request);
                $order =  $order->orderProcess();
                // send notification to admin
                event(new Created($order));
                if (isset($order) ) {
                    $payment = new UrwayServices();
                    $pay = $payment->generatePaymentUrl($order);
                    $paymentUrl = $pay->targetUrl . '?paymentid=' . $pay->payid;
                    $order =  new OrderResource($order);
                    return setResponseApi(true,200,'success message',['link' => $paymentUrl]);
                }
            return $this->listResponse([]);
        } catch(\Exception $e) {
            return $this->ApiErrorResponse('',$e->getMessage());
        }
    }


    public function registerPublicOrder($request)
    {
        $order = new PublicOrder($request);
        try {
            DB::beginTransaction();
            $orderResponse =  $order->orderProcess();
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            throw ($e);
        }

        return $this->publicOrders();
    }


    public function publicOrders()
    {
        $orders = $this->transactionRepository->currentClinetSampleOrders();

        if (isset($orders) ) {
            $orders =  OrderResource::collection($orders);
            return $this->listResponse($orders);
        } else {
            return $this->listResponse([]);
        }
    }

    public function sampleOrders(Request $request)
    {
        $orders = $this->transactionRepository->currentClinetSampleOrders($request);

        if (isset($orders) ) {
            $orders =  new SingleOrder($orders);
            return $this->listResponse($orders);
        } else {
            return $this->listResponse([]);
        }
    }

    public function sampleOrderDetails($id)
    {
        try{
            $order = Order::Sample()->where('id',$id)->first();
            if($order)
                return setResponseApi(true,200,'success message',new OrderResource($order));
            return setResponseApi(true,200,'orders not found',[]);
        }catch(\Exception $ex){
            return setResponseApi(false,500,$ex->getMessage(),[]);
        }
    }

    public function ValidateCart($cart)
    {
        return true;
    }

    public function paymentCallback(Request $request)
    {
        if (isset($request->Result)) {
            //success
            if ($request->Result == 'Successful' && $request->ResponseCode == '000') {
                $order = Order::find($request->TrackId);
                return $this->successPayment($order, $request);
            }elseif($request->Result == 'Failure' && $request->ResponseCode == '624'){
                $order = Order::find($request->TrackId);
                return $this->failPayment($order,$request);
            }
        }
    }

    public function specialPaymentCallback(Request $request)
    {
        if(isset($request->Result)){
            // success
            if ($request->Result == 'Successful' && $request->ResponseCode == '000') {
                $order = SpecialOrder::find($request->TrackId);
                return $this->specialSuccessPayment($order, $request);
            }elseif($request->Result == 'Failure' && $request->ResponseCode == '624'){
                $order = SpecialOrder::find($request->TrackId);
                return $this->specialFailPayment($order,$request);
            }
        }
    }

    private function successPayment(Order $order,Request $request)
    {
        if ($order->status == OrderStatus::READY_FOR30) {
            // update order status
            $order->update(['status' => OrderStatus::PAID30]);
            // create online payment
            OnlinePayment::create([
                'client_id' => $order->client_id,
                'amount' => $request->amount,
                'currency' => Constants::currency,
                'payment_method' => $request->cardBrand,
                'payment_id' => $request->PaymentId,
                'order_id' => $order->id,
            ]);
            // get vendor wallet ballance
            $ballance = VendorWallet::where('vendor_id',$order->vendor_id)->select('id','balance')->first();
            if($ballance){
                // update vendor wallet balance
                $ballance->balance = ($ballance->balance + $request->amount);
                $ballance->save();
                // create vendor wallet transaction
                $vendorWalletTransaction = VendorWalletTransaction::create([
                    'vendor_wallet_id' => $ballance->id,
                    'amount' => $request->amount,
                    'operation_type' => 'in'
                ]);
            }else{
                $vendorWallet = VendorWallet::create([
                    'vendor_id' => $order->vendor_id,
                    'balance' => $request->amount,
                ]);
                $vendorWalletTransaction = VendorWalletTransaction::create([
                    'vendor_wallet_id' => $vendorWallet->id,
                    'amount' => $request->amount,
                    'operation_type' => 'in'
                ]);
            }
        } else {
            $order->update(['status' => OrderStatus::PAID]);
            OnlinePayment::create([
                'client_id' => $order->client_id,
                'amount' => $request->amount,
                'currency' => Constants::currency,
                'payment_method' => $request->cardBrand,
                'payment_id' => $request->PaymentId,
                'order_id' => $order->id,
            ]);
            // get vendor wallet ballance
            $ballance = VendorWallet::where('vendor_id',$order->vendor_id)->select('id','balance')->first();
            if($ballance){
                // update vendor wallet balance
                $ballance->balance = ($ballance->balance + $request->amount);
                $ballance->save();
                // create vendor wallet transaction
                $vendorWalletTransaction = VendorWalletTransaction::create([
                    'vendor_wallet_id' => $ballance->id,
                    'amount' => $request->amount,
                    'operation_type' => 'in'
                ]);
            }else{
                $vendorWallet = VendorWallet::create([
                    'vendor_id' => $order->vendor_id,
                    'balance' => $request->amount,
                ]);
                $vendorWalletTransaction = VendorWalletTransaction::create([
                    'vendor_wallet_id' => $vendorWallet->id,
                    'amount' => $request->amount,
                    'operation_type' => 'in'
                ]);
            }
        }
        return $this->afterPaymentSuccessRedirectUrl($order,$request);
    }

    private function failPayment(Order $order,Request $request){
        // error payment
        if($order && $order->status == OrderStatus::READY_FOR30){
            $order->update(['status' => OrderStatus::CANCELED]);
            Log::channel('urway')->info('canceled according to visa payment failure');
            return $this->afterPaymentFailRedirectUrl($order,$request);
        }elseif($order && $order->status == OrderStatus::READY_TO_SHIP){
            $order->update(['status' => OrderStatus::CANCELED]);
            Log::channel('urway')->info('canceled according to visa payment failure');
            return $this->afterPaymentFailRedirectUrl($order,$request);
        }else{
            $order->update(['status' => OrderStatus::CANCELED]);
            Log::channel('urway')->info('canceled according to visa payment failure');
            return $this->afterPaymentFailRedirectUrl($order,$request);
        }
    }
    private function specialSuccessPayment(SpecialOrder $specialOrder,Request $request)
    {
        if ($specialOrder->status == OrderStatus::READY_FOR30) {
            // update order status
            $specialOrder->update(['status' => OrderStatus::PAID30]);
            // create online payment
            OnlinePayment::create([
                'client_id' => $specialOrder->client_id,
                'amount' => $request->amount,
                'currency' => Constants::currency,
                'payment_method' => $request->cardBrand,
                'payment_id' => $request->PaymentId,
                'special_order_id' => $specialOrder->id,
            ]);
             // get vendor wallet ballance
             $ballance = VendorWallet::where('vendor_id',$specialOrder->vendor_id)->select('id','balance')->first();
             if($ballance){
                 // update vendor wallet balance
                 $ballance->balance = ($ballance->balance + $request->amount);
                 $ballance->save();
                 // create vendor wallet transaction
                 $vendorWalletTransaction = VendorWalletTransaction::create([
                     'vendor_wallet_id' => $ballance->id,
                     'amount' => $request->amount,
                     'operation_type' => 'in'
                 ]);
             }else{
                 $vendorWallet = VendorWallet::create([
                     'vendor_id' => $specialOrder->vendor_id,
                     'balance' => $request->amount,
                 ]);
                 $vendorWalletTransaction = VendorWalletTransaction::create([
                     'vendor_wallet_id' => $vendorWallet->id,
                     'amount' => $request->amount,
                     'operation_type' => 'in'
                 ]);
             }
        } else {
            $specialOrder->update(['status' => OrderStatus::PAID]);
            OnlinePayment::create([
                'client_id' => $specialOrder->client_id,
                'amount' => $request->amount,
                'currency' => Constants::currency,
                'payment_method' => $request->cardBrand,
                'payment_id' => $request->PaymentId,
                'special_order_id' => $specialOrder->id,
            ]);
            // get vendor wallet ballance
            $ballance = VendorWallet::where('vendor_id',$specialOrder->vendor_id)->select('id','balance')->first();
            if($ballance){
                // update vendor wallet balance
                $ballance->balance = ($ballance->balance + $request->amount);
                $ballance->save();
                // create vendor wallet transaction
                $vendorWalletTransaction = VendorWalletTransaction::create([
                    'vendor_wallet_id' => $ballance->id,
                    'amount' => $request->amount,
                    'operation_type' => 'in'
                ]);
            }else{
                $vendorWallet = VendorWallet::create([
                    'vendor_id' => $specialOrder->vendor_id,
                    'balance' => $request->amount,
                ]);
                $vendorWalletTransaction = VendorWalletTransaction::create([
                    'vendor_wallet_id' => $vendorWallet->id,
                    'amount' => $request->amount,
                    'operation_type' => 'in'
                ]);
            }

        }
        return $this->specialAfterPaymentSuccessRedirectUrl($specialOrder,$request);
    }

    private function specialFailPayment(SpecialOrder $specialOrder,Request $request){
        // error payment
        if($specialOrder && $specialOrder->status == OrderStatus::READY_FOR30){
            $specialOrder->update(['status' => OrderStatus::CANCELED]);
            Log::channel('urway')->info('canceled according to visa payment failure');
            return $this->specialAfterPaymentFailRedirectUrl($request);
        }elseif($specialOrder && $specialOrder->status == OrderStatus::READY_TO_SHIP){
            $specialOrder->update(['status' => OrderStatus::CANCELED]);
            Log::channel('urway')->info('canceled according to visa payment failure');
            return $this->specialAfterPaymentFailRedirectUrl($request);
        }
    }

    private function afterPaymentSuccessRedirectUrl($order,$request){
        $lang = $request->UserField3 ? '/' . $request->UserField3 : '';
        if($order->type == 'sample'){
            return redirect()->away('https://b2b.tasksa.dev/'.$lang.'/cart/success/' . $request->TrackId);
        }else{
            if($order->status == OrderStatus::PAID30){
                return redirect()->away('https://b2b.tasksa.dev/'.$lang.'/profile/public-orders/' . $request->TrackId .'/success-partial-pay');
            }elseif($order->status == OrderStatus::PAID){
                return redirect()->away('https://b2b.tasksa.dev/'.$lang.'/profile/public-orders/' . $request->TrackId .'/success-full-pay');
            }
        }
    }
    private function afterPaymentFailRedirectUrl($order,$request){
        $lang = $request->UserField3 ? '/' . $request->UserField3 : '';
        if($order->type == 'sample'){
            return redirect()->away('https://b2b.tasksa.dev/'.$lang.'/cart/failed/' . $request->TrackId);
        }else{
            return redirect()->away('https://b2b.tasksa.dev/'.$lang.'/profile/public-orders/' . $request->TrackId . '/failed');
        }
        // return redirect(route('payment.test.fail'));
    }

    // sp order after payment succ - fail
    private function specialAfterPaymentSuccessRedirectUrl($order,$request){
        $lang = $request->UserField3 ? '/' . $request->UserField3 : '';
        if($order->status == OrderStatus::PAID30){
            return redirect()->away('https://b2b.tasksa.dev/'.$lang.'/profile/special-orders/' . $request->TrackId .'/success-partial-pay');
        }elseif($order->status == OrderStatus::PAID){
            return redirect()->away('https://b2b.tasksa.dev/'.$lang.'/profile/special-orders/' . $request->TrackId .'/success-full-pay');
        }
    }
    private function specialAfterPaymentFailRedirectUrl($request){
        $lang = $request->UserField3 ? '/' . $request->UserField3 : '';
        return redirect()->away('https://b2b.tasksa.dev/'.$lang.'/profile/special-orders/' . $request->TrackId . '/failed');
        // return redirect(route('payment.test.fail'));
    }

    private function VendorAndShippingWallet($order)
    {
        // add order total cost to vendor wallet
        if(VendorWallet::where('vendor_id',$order->vendor_id)->exists()){
            $vendorWallet = VendorWallet::where('vendor_id',$order->vendor_id)->first();
            // update vendor wallet data
            $vendorWallet->update(['balance' => $vendorWallet->balance + $order->total]);
            // create vendor wallet transaction
            VendorWalletTransaction::create([
                'vendor_wallet_id' => $vendorWallet->id,
                'amount' => $order->total,
                'operation_type' => 'in',
            ]);
        }else{
            // create vendor wallet
            VendorWallet::create([
                'vendor_id' => $order->vendor_id,
                'balance' => $order->total
            ]);
            // create vendor wallet transaction
            VendorWalletTransaction::create([
                'vendor_wallet_id' => $order->id,
                'amount' => $order->total,
                'operation_type' => 'in',
            ]);
        }
    }

}
