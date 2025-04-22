<?php
namespace App\Services\SubVendor;
use App\Models\Vendor;
use App\Models\VendorWallet;
use Exception;
class VendorWalletService{
    public function show(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $vendor = Vendor::with('vendorWallet')->find(auth('sub_vendor')->user()->vendor_id);
            $vendorWallet = VendorWallet::where('vendor_id',$vendor->id)
                ->with('vendor_wallet_transactions')
                ->first();
            return view("sub-vendor.vendorWallets.show", compact('vendorWallet','vendor'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }
}
