<?php

namespace App\Services\Admin;

use App\Helpers\FileUpload;
use App\Repositories\Admin\VendorWalletRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
    public function getAllVendorWallets(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $vendorWallets = $this->vendorWalletRepository->getAllVendorWallets();
            return view("admin.vendorWallets.index", compact('vendorWallets'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * All  VendorWallets.
     *
     */
    public function show($id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $vendorWallet = $this->vendorWalletRepository->show($id);
            return view("admin.vendorWallets.show", compact('vendorWallet'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }



}
