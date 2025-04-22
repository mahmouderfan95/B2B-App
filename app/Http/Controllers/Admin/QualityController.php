<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\QualityRequest;
use App\Services\Admin\QualityService;

class QualityController extends Controller
{
    public $qualityService;

    /**
     * Quality  Constructor.
     */
    public function __construct(QualityService $qualityService)
    {
        $this->qualityService = $qualityService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->qualityService->getAllQualitys($request);
    }

    /**
     * create quality page
     */
    public function create()
    {
        return $this->qualityService->create();
    }

    /**
     *  Store Quality
     */
    public function store(QualityRequest $request)
    {
        return $this->qualityService->storeQuality($request);
    }

    /**
     * show the quality..
     *
     */
    public function show( $id)
    {
    }

    /**
     * edit the quality..
     *
     */
    public function edit(int $id)
    {
        return $this->qualityService->edit($id);

    }

    /**
     * Update the quality..
     *
     */
    public function update(QualityRequest $request, int $id)
    {
        return $this->qualityService->updateQuality($request,$id);
    }
    /**
     *
     * Delete Quality Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->qualityService->deleteQuality($id);

    }

}
