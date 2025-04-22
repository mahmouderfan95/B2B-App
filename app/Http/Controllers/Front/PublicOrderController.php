<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Order\Public\ChooseShipping;
use App\Http\Requests\Front\Order\Public\CreatePublicOrder;
use App\Services\Front\PublicOrderService;
use App\Services\Front\TransactionService;
use Illuminate\Http\Request;


class PublicOrderController extends Controller
{

    public function __construct( private PublicOrderService $service)
    {
        $this->middleware('auth:client');

    }

    public function registerOrder(CreatePublicOrder $request)
    {
        return $this->service->registerPublicOrder($request->validated());
    }

    public function orders(Request $request)
    {
        return $this->service->publicOrders($request);
    }

    public function getPublicOrderDetails($id)
    {
        return $this->service->publicOrderDetails($id);
    }

    //this will be removed (just for testing)
    public function vendorAccept(Request $request, $order_id)
    {
        return $this->service->vendorAccept($order_id);
    }

    public function chooseShippingType(ChooseShipping $request, $order_id)
    {
        // dd($request->all());
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
    public function readToShip(Request $request,$order_id)
    {
        return $this->service->readToShip($order_id);
    }

    public function delivered($order_id)
    {
        return $this->service->delivered($order_id);
    }

    public function shippingDone($order_id)
    {
        return $this->service->shippingDone($order_id);
    }

}
