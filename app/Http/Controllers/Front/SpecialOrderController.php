<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Order\CreateSpecialOrder;
use App\Http\Requests\Front\Order\Public\ChooseShipping;
use App\Http\Requests\Front\Order\Public\CreatePublicOrder;
use App\Models\SpecialOrder;
use App\Services\Front\PublicOrderService;
use App\Services\Front\SpecialOrderService;
use App\Services\Front\TransactionService;
use Illuminate\Http\Request;


class SpecialOrderController extends Controller
{

    public function __construct( private SpecialOrderService $service)
    {
        $this->middleware('auth:client');

    }

    public function registerOrder(CreateSpecialOrder $request)
    {
        return $this->service->registerSpecialOrder($request->validated());
    }

    public function orders(Request $request)
    {
        return $this->service->specialOrders($request);
    }
    public function orderDetails($id)
    {
        return $this->service->orderDetails($id);
    }
    public function getVendorQuotation($id)
    {
        return $this->service->getVendorQuotation($id);
    }

    public function ordersInProgress(Request $request)
    {
        return $this->service->ordersInProgress($request);
    }

    public function ordersCompleted(Request $request)
    {
        return $this->service->ordersCompleted($request);
    }

    public function ordersRejected(Request $request)
    {
        return $this->service->ordersRejected($request);
    }

    //this will be removed (just for testing)
    public function vendorAccept(Request $request, $order_id)
    {
        return $this->service->vendorAccept($order_id);
    }

    public function chooseShippingType(ChooseShipping $request, $order_id)
    {
        return $this->service->chooseShippingType($request->validated(), $order_id);
    }

    public function partialPay(Request $request, $order_id)
    {
        return $this->service->partialPay($order_id);
    }

    //this will be removed (just for testing)
    public function vendorGetOrderReady(Request $request,$order_id)
    {
        return $this->service->vendorGetOrderReady($order_id);
    }

    public function fullPay(Request $request,$order_id)
    {
        return $this->service->fullPay($order_id);
    }

    public function shippingSpecialOffers($specialOrderId)
    {
        return $this->service->shippingSpecialOffers($specialOrderId);
    }

}
