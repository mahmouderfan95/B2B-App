<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Order\Public\SendShippingQuotationRequest;
use App\Http\Requests\Front\Order\Special\SendShippingQuotationRequest as SpecialSendShippingQuotationRequest;
use App\Services\Front\ShippingQuotationServices;
use Illuminate\Http\Request;

class ShippingQuotationController extends Controller
{
    public function __construct(public ShippingQuotationServices $shippingQuotationServices)
    {

    }

    public function getShippingQuotationSpecialOrder($id)
    {
        return $this->shippingQuotationServices->getShippingQuotationSpecialOrder($id);
    }
    public function getShippingQuotationSpecialOrderDetails($id)
    {
        return $this->shippingQuotationServices->getShippingQuotationSpecialOrderDetails($id);
    }
    public function acceptShippingQuotation($id,$sp_id)
    {
        return $this->shippingQuotationServices->acceptShippingQuotation($id,$sp_id);
    }
    public function refusedShippingQuotation($id,$sp_id)
    {
        return $this->shippingQuotationServices->refusedShippingQuotation($id,$sp_id);
    }
    public function getShippingQuotationPublicOrder($order_id)
    {
        return $this->shippingQuotationServices->getShippingQuotationPublicOrder($order_id);
    }
    public function getShippingQuotationPublicOrderDetails($id)
    {
        return $this->shippingQuotationServices->getShippingQuotationPublicOrderDetails($id);
    }
    public function acceptShippingQuotationPublicOrder($id,$order_id)
    {
        return $this->shippingQuotationServices->acceptShippingQuotationPublicOrder($id,$order_id);
    }
    public function refusedShippingQuotationPublicOrder($id,$order_id)
    {
        return $this->shippingQuotationServices->refusedShippingQuotationPublicOrder($id,$order_id);
    }
    public function shippingSendQuotation(SpecialSendShippingQuotationRequest $request)
    {
        return $this->shippingQuotationServices->shippingSendQuotation($request);
    }
    public function shippingSendQuotationPublic(SendShippingQuotationRequest $request)
    {
        return $this->shippingQuotationServices->shippingSendQuotationPublic($request);
    }
}
