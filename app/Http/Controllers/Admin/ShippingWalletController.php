<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ShippingWalletService;
use Illuminate\Http\Request;

class ShippingWalletController extends Controller
{
    public $shippingWalletService;

    /**
     * ShippingWallet  Constructor.
     */
    public function __construct(ShippingWalletService $shippingWalletService)
    {
        $this->shippingWalletService = $shippingWalletService;
    }


    /**
     * All ShippingWallets
     */
    public function index(Request $request)
    {
        return $this->shippingWalletService->getAllShippingWallets($request);
    }

    /**
     * All ShippingWallets
     */
    public function show($id)
    {
        return $this->shippingWalletService->show($id);
    }
    /**
     * All ShippingWallets
     */
    public function add_balance(Request $request)
    {
        return $this->shippingWalletService->add_balance($request);
    }
    /**
     * All ShippingWallets
     */
    public function balance_deduction(Request $request)
    {
        return $this->shippingWalletService->balance_deduction($request);
    }


}
