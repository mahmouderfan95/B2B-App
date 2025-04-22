<?php

namespace App\Services\Front;

use App\Enums\OrderStatus;
use App\Events\SpecialOrders\Created;
use App\Exceptions\Cart\cartBadUse;
use App\Http\Requests\Admin\LanguageRequest;
use App\Http\Resources\Front\Orders\SingleOrder;
use App\Http\Resources\Front\QualityResource;
use App\Http\Resources\Front\SpecialOrder\ShippingSpecialOfferResource;
use App\Repositories\Front\QualityRepository;
use Exception;
use App\Helpers\FileUpload;
use App\Http\Resources\Front\SpecialOrder\OrderResource;
use App\Http\Resources\Front\SpecialOrder\SingleSpecialOrderResource;
use App\Http\Resources\Front\SpecialOrder\SpecialOrderResource;
use App\Http\Resources\Front\SpecialOrder\VendorQuotationResource;
use App\Models\ClientAddress;
use App\Models\Order;
use App\Models\OrderQuotation;
use App\Models\OrderQuotationHistories;
use App\Models\Product;
use App\Models\Quality;
use App\Models\ShippingSpecialOffer;
use App\Models\SpecialOrder as ModelsSpecialOrder;
use App\Models\Transaction;
use App\Repositories\Front\CartRepository;
use App\Repositories\Front\TransactionRepository;
use App\Services\Front\Order\PublicOrder;
use App\Services\Front\Order\SpecialOrder;
use App\Services\Payments\Urway\SpecialOrder\UrwayServices;
use App\Traits\ApiResponseAble;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SpecialOrderService
{
    use FileUpload, ApiResponseAble;

    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function registerSpecialOrder($request)
    {
        $order = new SpecialOrder($request);
        // try{
            $order =  $order->orderProcess();
            $latestSpecialOrder = \App\Models\SpecialOrder::latest()->first();
            if($latestSpecialOrder){
                // send notification to admin after create public order
                event(new Created($latestSpecialOrder));
                return setResponseApi(true,200,'success message',$latestSpecialOrder);
            }
            return $this->listResponse([]);
        // } catch(\Exception $e) {
        //     return setResponseApi(false,500,$e->getMessage(),[]);
        // }
    }


    public function specialOrders(Request $request)
    {
        $orders = SpecialOrder::getSpecialOrders($request);
        if (isset($orders)) {
            $orders =  new SingleSpecialOrderResource($orders);
            return $this->listResponse($orders);
        } else {
            return $this->notFoundResponse();
        }
    }
    public function orderDetails($id)
    {
        $order = ModelsSpecialOrder::where('id',$id)
        ->with(['products','shipping_quotation','order_quotations' => function($q){
            $q->where('status','accepted');
        }])
        ->first();
        if($order)
            return setResponseApi(true,200,'success message',new SpecialOrderResource($order));
        return setResponseApi(false,400,'orders not found',[]);
    }
    public function getVendorQuotation($id)
    {
        $quotation = OrderQuotation::where('special_order_id',$id)
        ->where('client_id',auth('client')->user()->id)
        ->IsNotExpired()
        ->first();
        $histories = OrderQuotationHistories::where('order_quotation_id',$quotation->id)->where('special_order_id',$id)
        ->orderBy('id','desc')
        ->get();
        if($histories->count() > 0)
            return setResponseApi(true,200,'success message',VendorQuotationResource::collection($histories));
        return setResponseApi(false,400,'data not found',[]);
    }

    public function ordersInProgress()
    {
        $orders = SpecialOrder::getSpecialOrdersInProgress();
        if (isset($orders) ) {
            $result =  OrderResource::collection($orders);
            return $this->listResponse($result);
        } else {
            return $this->notFoundResponse();
        }
    }

    public function ordersCompleted()
    {
        $orders = SpecialOrder::getSpecialOrdersInCompleted();
        if (isset($orders) ) {
            $orders =  OrderResource::collection($orders);
            return $this->listResponse($orders);
        } else {
            return $this->notFoundResponse();
        }
    }

    public function ordersRejected()
    {
        $orders = SpecialOrder::getSpecialOrdersInRejected();
        if (isset($orders) ) {
            $orders =  OrderResource::collection($orders);
            return $this->listResponse($orders);
        } else {
            return $this->notFoundResponse();
        }
    }

    //to be removed
    public function vendorAccept($order_id)
    {
        $order = \App\Models\SpecialOrder::find($order_id);
        $order->status = OrderStatus::ACCEPTED;
        $order->save();
        $orders =  new OrderResource($order);
        return $this->listResponse($order);
    }

    public function chooseShippingType($data, $order_id)
    {
        $order = SpecialOrder::chooseShippingMethod($order_id, $data['method']);

        if (isset($order) ) {
            $orders =  new OrderResource($order);
            return $this->listResponse($order);
        } else {
            return $this->listResponse([]);
        }
    }

    public function partialPay($order_id)
    {
        $order = SpecialOrder::partialPay($order_id);
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
        $order = \App\Models\SpecialOrder::find($order_id);
        $order->status = OrderStatus::READY_TO_SHIP;
        $order->save();
        $order =  new OrderResource($order);
        return $this->listResponse($order);
    }

    public function fullPay($order_id)
    {
        $order = SpecialOrder::fullPay($order_id);
        $order =  new OrderResource($order);
        // create payment generate url
        $payment = new UrwayServices();
        $pay = $payment->generatePaymentUrl($order);
        $paymentUrl = $pay->targetUrl . '?paymentid=' . $pay->payid;
        return setResponseApi(true,200,'success message',['link' => $paymentUrl]);
    }

    public function ValidateCart($cart)
    {

        return true;
    }

    public function orders()
    {

    }

    public function shippingSpecialOffers($specialOrderId)
    {
        $shippingSpecialOrder = ShippingSpecialOffer::where('special_order_id',$specialOrderId)
        ->with('special_order',function($q){
            $q->where('status','ready_to_ship')->with('products');
        })
        ->get();
        if($shippingSpecialOrder->count() > 0){
            return $this->listResponse(ShippingSpecialOfferResource::collection($shippingSpecialOrder));
        }
        return $this->listResponse([]);
    }


}
