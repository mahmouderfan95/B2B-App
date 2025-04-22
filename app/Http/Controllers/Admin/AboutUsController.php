<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AboutUsRequest;
use App\Services\Admin\AboutUsService;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public $aboutUsService;

    /**
     * AboutUs  Constructor.
     */
    public function __construct(AboutUsService $aboutUsService)
    {
        $this->aboutUsService = $aboutUsService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->aboutUsService->getAllAboutUss($request);
    }

    /**
     * create aboutUs page
     */
    public function create()
    {
        return $this->aboutUsService->create();
    }

    /**
     *  Store AboutUs
     */
    public function store(AboutUsRequest $request)
    {
        return $this->aboutUsService->storeAboutUs($request);
    }

    /**
     * show the aboutUs..
     *
     */
    public function show( $id)
    {
    }

    /**
     * edit the aboutUs..
     *
     */
    public function edit(int $id)
    {
        return $this->aboutUsService->edit($id);

    }

    /**
     * Update the aboutUs..
     *
     */
    public function update(AboutUsRequest $request, int $id)
    {
        return $this->aboutUsService->updateAboutUs($request,$id);
    }
    /**
     *
     * Delete AboutUs Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->aboutUsService->deleteAboutUs($id);

    }

}
