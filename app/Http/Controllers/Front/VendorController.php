<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\VendorRequest;
use App\Services\Front\VendorService;
use Illuminate\Http\Request;


class VendorController extends Controller
{
    public $vendorService;

    /**
     * Vendor  Constructor.
     */
    public function __construct(VendorService $vendorService)
    {
        $this->vendorService = $vendorService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->vendorService->getAllVendors($request);
    }


    public function details(Request $request, $id)
    {
        return $this->vendorService->details($request, $id);
    }

    public function products(Request $request, $id)
    {
        return $this->vendorService->products($request, $id);
    }

    /**
     * register vendor
     *
     */
    public function register(VendorRequest $request)
    {
        return $this->vendorService->register($request);

    }

}
