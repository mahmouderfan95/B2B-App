<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\SubVendorRequest;
use Illuminate\Http\Request;
use App\Services\Vendor\SubVendorService;

class SubVendorController extends Controller
{

    private $subVendorService;

    public function __construct(SubVendorService $subVendorService)
    {
        $this->subVendorService = $subVendorService;
    }

    public function index () {
       return  $this->subVendorService->getSubVendors();
    }

    public function create () {
        return  $this->subVendorService->create();
    }

    public function store (SubVendorRequest $request) {
        return  $this->subVendorService->store($request);
    }

    public function edit ($id) {
        return  $this->subVendorService->editSubVendor($id);
    }

    public function editProfile () {
        return  $this->subVendorService->SubVendorProfile();
    }

    public function updateProfile (SubVendorRequest $request) {
        return  $this->subVendorService->updateSubVendor($request, auth()->user()->id);
    }

    public function update (Request $request, $id) {
        return  $this->subVendorService->updateSubVendor($request, $id);
    }

    public function delete ($id) {
        return  $this->subVendorService->deleteSubVendor($id);
    }
}
