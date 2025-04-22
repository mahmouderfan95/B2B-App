<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\VendorWalletService;
use App\Http\Resources\Admin\WalletsResource;
use App\Enums\WalletStatus;
use RealRashid\SweetAlert\Facades\Alert;

class WalletController extends Controller
{
    public function __construct(public VendorWalletService $service){}

    public function show(Request $request)
    {
        $wallet=auth()->user()->vendor;
        
        $vendorWallet = $this->service->getVendorWalletUsingVendorID($wallet->id);
        
        if (!$vendorWallet) {

            Alert::error( __('translation.error') , __('translation.your_account_not_have_wallet') );
            return back();
            
        }

        $transactions = $this->service->getVendorWalletTransactionsWithPagination($vendorWallet->id, 5, "DESC", $request);

        return view("vendor.wallet.show", compact('vendorWallet', 'transactions','request'));
    }
}
