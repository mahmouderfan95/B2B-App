<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\SpecialShippingOfferService;
use Illuminate\Http\Request;

class SpecialShippingOfferController extends Controller
{
    public $specialShippingOfferService;
    public function __construct(SpecialShippingOfferService $specialShippingOfferService)
    {
        $this->middleware("auth:client");
        $this->specialShippingOfferService = $specialShippingOfferService;
    }

    public function acceptOffer(Request $request)
    {
        return $this->specialShippingOfferService->acceptOffer($request);
    }
}
