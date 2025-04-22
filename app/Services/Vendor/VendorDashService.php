<?php

namespace App\Services\Vendor;

use App\Services\Admin\VendorService;
use Exception;

class VendorDashService extends VendorService

{
    /**
     * edit  vendor
     */
    public function editVendor()
    {
        try {
            $banks = $this->getBanksForm();
            $countries = $this->getAllCountriesForm();
            $vendor = auth()->user();
            return view("vendor.profile.edit", compact('vendor', 'banks', 'countries'));
        } catch (Exception $e) {
            return $e->getMessage();
            return redirect()->route('dashboard.vendors.index');
        }
    }
}
