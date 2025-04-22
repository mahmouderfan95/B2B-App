<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\CountryService;
use App\Services\Front\TransactionService;
use Illuminate\Http\Request;


class TransactionController extends Controller
{
    public $countryService;

    /**
     * Country  Constructor.
     */
    public function __construct( private TransactionService $service)
    {
//        $this->middleware('auth:client');

    }



    public function checkout(Request $request)
    {
        return $this->service->checkout($request);
    }



    public function orders(Request $request)
    {
        return $this->service->sampleOrders($request);
    }

    public function getSampleOrderDetails($id)
    {
        return $this->service->sampleOrderDetails($id);
    }

    public function pay_callback(Request $request)
    {
        return $this->service->paymentCallback($request);
    }

    public function special_order_callback(Request $request)
    {
        return $this->service->specialPaymentCallback($request);
    }

}
