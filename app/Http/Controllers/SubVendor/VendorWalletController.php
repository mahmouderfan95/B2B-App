<?php

namespace App\Http\Controllers\SubVendor;

use App\Http\Controllers\Controller;
use App\Services\SubVendor\VendorWalletService;
use Illuminate\Http\Request;

class VendorWalletController extends Controller
{
    public function __construct(public VendorWalletService $vendorWalletService)
    {
    }

    /**
     * All VendorWallets
     */
    public function show()
    {
        return $this->vendorWalletService->show();
    }
}
