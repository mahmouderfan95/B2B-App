<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SizeRequest;
use App\Services\Admin\SizeService;

class SizeController extends Controller
{
    public $sizeService;

    /**
     * Size  Constructor.
     */
    public function __construct(SizeService $sizeService)
    {
        $this->sizeService = $sizeService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->sizeService->getAllSizes($request);
    }

    /**
     * create size page
     */
    public function create()
    {
        return $this->sizeService->create();
    }

    /**
     *  Store Size
     */
    public function store(SizeRequest $request)
    {
        return $this->sizeService->storeSize($request);
    }

    /**
     * show the size..
     *
     */
    public function show( $id)
    {
    }

    /**
     * edit the size..
     *
     */
    public function edit(int $id)
    {
        return $this->sizeService->edit($id);

    }

    /**
     * Update the size..
     *
     */
    public function update(SizeRequest $request, int $id)
    {
        return $this->sizeService->updateSize($request,$id);
    }
    /**
     *
     * Delete Size Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->sizeService->deleteSize($id);

    }

}
