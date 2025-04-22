<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\RegionRequest;
use App\Services\Admin\RegionService;

class RegionController extends Controller
{
    public $regionService;

    /**
     * Region  Constructor.
     */
    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->regionService->getAllRegions($request);
    }

    /**
     * create region page
     */
    public function create()
    {
        return $this->regionService->create();
    }

    /**
     *  Store Region
     */
    public function store(RegionRequest $request)
    {
        return $this->regionService->storeRegion($request);
    }

    /**
     * show the region..
     *
     */
    public function show( $id)
    {
    }

    /**
     * edit the region..
     *
     */
    public function edit(int $id)
    {
        return $this->regionService->edit($id);

    }

    /**
     * Update the region..
     *
     */
    public function update(RegionRequest $request, int $id)
    {
        return $this->regionService->updateRegion($request,$id);
    }
    /**
     *
     * Delete Region Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->regionService->deleteRegion($id);

    }

}
