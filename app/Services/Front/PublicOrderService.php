<?php

namespace App\Services\Front;

use App\Enums\OrderStatus;
use App\Events\Orders\Created;
use App\Exceptions\Cart\cartBadUse;
use App\Http\Requests\Admin\LanguageRequest;
use App\Http\Resources\Front\QualityResource;
use App\Models\VendorWallet;
use App\Models\VendorWalletTransaction;
use App\Repositories\Front\QualityRepository;
use Exception;
use App\Helpers\FileUpload;
use App\Http\Resources\Front\PublicOrder\OrderResource;
use App\Http\Resources\Front\Orders\SingleOrder;
use App\Models\Order;
use App\Models\Quality;
use App\Models\Transaction;
use App\Repositories\Front\CartRepository;
use App\Repositories\Front\TransactionRepository;
use App\Services\Front\Order\PublicOrder;
use App\Services\Payments\Urway\UrwayServices;
use App\Traits\ApiResponseAble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicOrderService
{
    use FileUpload, ApiResponseAble;

    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {

        $this->transactionRepository = $transactionRepository;
    }

    public function registerPublicOrder($request)
    {
        try{
            $publicOrder = new PublicOrder($request);
            $publicOrder = $publicOrder->orderProcess();
            $latestPublicOrder = Order::where('type','public')->latest()->first();
            // append vendor balance in wallet and shipping
            // $this->VendorAndShippingWallet($latestPublicOrder);
            if(isset($latestPublicOrder)){
                // send notification to admin after create public order
                event(new Created($latestPublicOrder));
                return $this->listResponse($latestPublicOrder);
            }
            return $this->listResponse([]);
        }catch(\Exception $ex){
            return setResponseApi(false,500,$ex->getMessage(),[]);
        }
    }


    public function publicOrders(Request $request)
    {
        $orders = PublicOrder::getPublicOrders($request);
        if (isset($orders) ) {
            $orders =  new SingleOrder($orders);
            return $this->listResponse($orders);
        } else {
            return $this->listResponse([]);
        }
    }
    public function publicOrderDetails($id)
    {
        try{
            $order = Order::Public()->where('id',$id)
            ->with(['products','shipping_quotation'])
            ->first();
            if($order)
                return setResponseApi(true,200,'success message',new OrderResource($order));
            return setResponseApi(false,400,'orders not found',[]);
        }catch(\Exception $ex){
            return setResponseApi(false,500,$ex->getMessage(),[]);
        }
    }

    //to be removed
    public function vendorAccept($order_id)
    {
        $order = Order::find($order_id);
        if($order){
            $order->status = OrderStatus::ACCEPTED;
            $order->save();
            return setResponseApi(true,200,'success message',$order);
        }
        else{
            return setResponseApi([],'order not found',400,false);

        }
    }

    public function chooseShippingType($data, $order_id)
    {
        $order = PublicOrder::chooseShippingMethod($order_id, $data['method']);

        if (isset($order) ) {
            $orders =  new OrderResource($order);
            return $this->listResponse($order);
        } else {
            return $this->listResponse([]);
        }
    }

    public function partialPay($order_id)
    {
        $order = PublicOrder::partialPay($order_id);
        $order =  new OrderResource($order);
        // create payment generate url
        $payment = new UrwayServices();
        $pay = $payment->generatePaymentUrl($order);
        $paymentUrl = $pay->targetUrl . '?paymentid=' . $pay->payid;
        return setResponseApi(true,200,'success message',['link' => $paymentUrl]);
    }

    //to be removed
    public function vendorGetOrderReady($order_id)
    {
        $order = Order::find($order_id);
        $order->status = OrderStatus::READY_TO_SHIP;
        $order->save();
        return $this->listResponse($order);
    }

    public function fullPay($order_id)
    {
        $order = PublicOrder::fullPay($order_id);
        $order =  new OrderResource($order);
        // create payment generate url
        $payment = new UrwayServices();
        $pay = $payment->generatePaymentUrl($order);
        $paymentUrl = $pay->targetUrl . '?paymentid=' . $pay->payid;
        // run event update transaction status
        return setResponseApi(true,200,'success message',['link' => $paymentUrl]);
    }
    public function readToShip($order_id)
    {
        $order = PublicOrder::readyToShip($order_id);
        $order =  new OrderResource($order);
        return $this->listResponse($order);
    }

    public function delivered($order_id)
    {
        $order = PublicOrder::delivered($order_id);
        $order =  new OrderResource($order);
        return $this->listResponse($order);
    }
    public function shippingDone($order_id)
    {
        $order = PublicOrder::shippingDone($order_id);
        $order =  new OrderResource($order);
        return $this->listResponse($order);
    }

    public function ValidateCart($cart)
    {

        return true;
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
