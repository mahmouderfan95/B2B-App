<?php

namespace App\Services\Vendor;

use App\Helpers\FileUpload;
use App\Models\Vendor;
use App\Models\VendorWallet;
use App\Repositories\Vendor\VendorWalletRepository;
use Exception;

class VendorWalletService
{

    use FileUpload;

    private $vendorWalletRepository;

    public function __construct(VendorWalletRepository $vendorWalletRepository)
    {
        $this->vendorWalletRepository = $vendorWalletRepository;
    }


    /**
     *
     * All  VendorWallets.
     *
     */
    public function show(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $vendor = Vendor::with('vendorWallet')->find(auth('vendor')->user()->id);
            $vendorWallet = VendorWallet::where('vendor_id',$vendor->id)
                ->with('vendor_wallet_transactions')
                ->first();
            return view("vendor.vendorWallets.show", compact('vendorWallet','vendor'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }


}
