<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\TypeRequest;
use App\Services\Admin\TypeService;

class TypeController extends Controller
{
    public $typeService;

    /**
     * Type  Constructor.
     */
    public function __construct(TypeService $typeService)
    {
        $this->typeService = $typeService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->typeService->getAllTypes($request);
    }

    /**
     * create type page
     */
    public function create()
    {
        return $this->typeService->create();
    }

    /**
     *  Store Type
     */
    public function store(TypeRequest $request)
    {

        return $this->typeService->storeType($request);
    }

    /**
     * show the type..
     *
     */
    public function show( $id)
    {
    }

    /**
     * edit the type..
     *
     */
    public function edit(int $id)
    {
        return $this->typeService->edit($id);

    }

    /**
     * Update the type..
     *
     */
    public function update(TypeRequest $request, int $id)
    {
        return $this->typeService->updateType($request,$id);
    }
    /**
     *
     * Delete Type Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->typeService->deleteType($id);

    }

}
