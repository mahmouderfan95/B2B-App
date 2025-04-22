<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VendorRequest;
use App\Http\Requests\Admin\VendorWallet\Ballance;
use App\Models\Vendor;
use App\Services\Admin\VendorService;
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

    /**
     * create vendor page
     */
    public function create()
    {
        return $this->vendorService->create();
    }

    /**
     *  Store Vendor
     */
    public function store(VendorRequest $request)
    {

        return $this->vendorService->storeVendor($request);
    }

    /**
     * show the vendor
     *
     */
    public function show($id)
    {
        return 'dd';
    }

    /**
     * edit the vendor..
     *
     */
    public function edit(int $id)
    {
        return $this->vendorService->edit($id);

    }

    /**
     * banned the vendor..
     *
     */
    public function banned(int $id)
    {
        return $this->vendorService->banned($id);

    }

    /**
     * Update the vendor
     *
     */
    public function update(VendorRequest $request, int $id)
    {
        return $this->vendorService->updateVendor($request, $id);
    }

    /**
     *
     * Delete Vendor Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->vendorService->deleteVendor($id);

    }


    public function addBalance(Ballance $request)
    {
        return $this->vendorService->addBalance($request);
    }

    public function deductionBalance(Ballance $request)
    {
        return $this->vendorService->deductionBalance($request);
    }

}
