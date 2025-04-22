<?php

namespace App\Services\Admin;

use App\Helpers\FileUpload;
use App\Repositories\Admin\ShippingWalletRepository;
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
            return view("admin.shippingWallets.index", compact('shippingWallets'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * All  ShippingWallets.
     *
     */
    public function show($id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $shippingWallet = $this->shippingWalletRepository->show($id);
            return view("admin.shippingWallets.show", compact('shippingWallet'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * All  ShippingWallets.
     *
     */
    public function add_balance(Request $request): \Illuminate\Http\RedirectResponse
    {
        $amount = $request->amount;
        $id = $request->shipping_wallet_id;
        try {
            $shippingWallet = $this->shippingWalletRepository->add_balance($amount, $id);
            return redirect()->route('dashboard.shipping-wallets.show',$shippingWallet->id)->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * All  ShippingWallets.
     *
     */
    public function balance_deduction(Request $request): \Illuminate\Http\RedirectResponse
    {
        $amount = $request->amount;
        $id = $request->shipping_wallet_id;
        try {
            $shippingWallet = $this->shippingWalletRepository->balance_deduction($amount, $id);
            return redirect()->route('dashboard.shipping-wallets.show',$shippingWallet->id)->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }


}
