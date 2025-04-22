<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\VendorWalletService;
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
    public function show($vendor_id)
    {
        return $this->vendorWalletService->show($vendor_id);
    }


}
