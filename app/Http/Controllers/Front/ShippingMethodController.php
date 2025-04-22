<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\ShippingMethodService;
use Illuminate\Http\Request;


class ShippingMethodController extends Controller
{
    public $shippingMethodService;

    /**
     * ShippingMethod  Constructor.
     */
    public function __construct(ShippingMethodService $shippingMethodService)
    {
        $this->shippingMethodService = $shippingMethodService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->shippingMethodService->getAllShippingMethods($request);
    }


    public function details(Request $request,$id)
    {
        return $this->shippingMethodService->details($request,$id);
    }
    public function offer(Request $request,$id)
    {
        return $this->shippingMethodService->offer($request,$id);
    }
    public function special_offer(Request $request,$id)
    {
        return $this->shippingMethodService->special_offer($request,$id);
    }

}
