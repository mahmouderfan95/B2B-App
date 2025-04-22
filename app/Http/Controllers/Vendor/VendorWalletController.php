<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Services\Vendor\VendorWalletService;
use Illuminate\Http\Request;

class VendorWalletController extends Controller
{
    public $vendorWalletService;

    /**
     * VendorWallet  Constructor.
     */
    public function __construct(VendorWalletService $vendorWalletService)
    {
        $this->vendorWalletService = $vendorWalletService;
    }


    /**
     * All VendorWallets
     */
    public function index(Request $request)
    {
        return $this->vendorWalletService->getAllVendorWallets($request);
    }

    /**
     * All VendorWallets
     */
    public function show()
    {
        return $this->vendorWalletService->show();
    }


}
