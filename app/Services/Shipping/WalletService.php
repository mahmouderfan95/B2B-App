<?php

namespace App\Services\Shipping;

use App\Helpers\FileUpload;
use App\Models\ShippingMethod;
use App\Models\ShippingWallet;
use App\Repositories\Shipping\ShippingWalletRepository;
use Exception;
use Illuminate\Http\Request;

class ShippingWalletService
{

    use FileUpload;

    private $shippingWalletRepository;

    public function __construct(ShippingWalletRepository $shippingWalletRepository)
    {
        $this->shippingWalletRepository = $shippingWalletRepository;
    }

    /**
     *
     * All  ShippingWallets.
     *
     */
    public function getAllShippingWallets(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $shippingWallets = $this->shippingWalletRepository->getAllShippingWallets();
            return view("shipping.shippingWallets.index", compact('shippingWallets'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * All  ShippingWallets.
     *
     */
    public function show(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            // $shippingWallet = $this->shippingWalletRepository->show();
            $shipping = ShippingMethod::with('shippingWallet')->find(auth('shipping')->user()->id);
            $shippingWallet = ShippingWallet::with('shipping_wallet_transactions')->where('shipping_method_id',$shipping->id)
            ->first();
            return view("shipping.shippingWallets.show", compact('shipping','shippingWallet'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }
}
