<?php

namespace App\Http\Controllers\Shipping;

use App\Http\Controllers\Controller;
use App\Services\Shipping\ShippingWalletService;
use Illuminate\Http\Request;

class WalletController extends Controller
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
    public function show()
    {
        return $this->shippingWalletService->show();
    }


}
