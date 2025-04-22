<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\PackageRequest;
use App\Services\Admin\PackageService;

class PackageController extends Controller
{
    public $packageService;

    /**
     * Package  Constructor.
     */
    public function __construct(PackageService $packageService)
    {
        $this->packageService = $packageService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->packageService->getAllPackages($request);
    }

    /**
     * create package page
     */
    public function create()
    {
        return $this->packageService->create();
    }

    /**
     *  Store Package
     */
    public function store(PackageRequest $request)
    {
        return $this->packageService->storePackage($request);
    }

    /**
     * show the package..
     *
     */
    public function show( $id)
    {
    }

    /**
     * edit the package..
     *
     */
    public function edit(int $id)
    {
        return $this->packageService->edit($id);

    }

    /**
     * Update the package..
     *
     */
    public function update(PackageRequest $request, int $id)
    {
        return $this->packageService->updatePackage($request,$id);
    }
    /**
     *
     * Delete Package Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->packageService->deletePackage($id);

    }

}
