<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UnitRequest;
use App\Services\Admin\UnitService;

class UnitController extends Controller
{
    public $unitService;

    /**
     * Unit  Constructor.
     */
    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->unitService->getAllUnits($request);
    }

    /**
     * create unit page
     */
    public function create()
    {
        return $this->unitService->create();
    }

    /**
     *  Store Unit
     */
    public function store(UnitRequest $request)
    {
        return $this->unitService->storeUnit($request);
    }

    /**
     * show the unit..
     *
     */
    public function show( $id)
    {
    }

    /**
     * edit the unit..
     *
     */
    public function edit(int $id)
    {
        return $this->unitService->edit($id);

    }

    /**
     * Update the unit..
     *
     */
    public function update(UnitRequest $request, int $id)
    {
        return $this->unitService->updateUnit($request,$id);
    }
    /**
     *
     * Delete Unit Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->unitService->deleteUnit($id);

    }

}
