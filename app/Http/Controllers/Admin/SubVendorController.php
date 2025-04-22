<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubVendorRequest;
use Illuminate\Http\Request;
use App\Services\Admin\SubVendorService;

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

    public function update (Request $request, $id) {
        return  $this->subVendorService->updateSubVendor($request, $id);
    }

    public function destroy ($id) {
        return  $this->subVendorService->deleteSubVendor($id);
    }
}
