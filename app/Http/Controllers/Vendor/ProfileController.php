<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VendorRequest;
use App\Services\Admin\VendorService;
use App\Services\Vendor\VendorDashService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public VendorDashService $VendorDashService;

    /**
     * Vendor  Constructor.
     */
    public function __construct(VendorDashService $VendorDashService)
    {
        $this->VendorDashService = $VendorDashService;
    }

    /**
     * create vendor page
     */
    public function edit()
    {
        return $this->VendorDashService->editVendor();
    }

    /**
     * create vendor page
     */
    public function update(VendorRequest $request)
    {
        return $this->VendorDashService->updateVendor($request, auth()->user()->id, 'vendor.profile.edit');
    }
}
