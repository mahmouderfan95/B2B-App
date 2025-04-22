<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CityRequest;
use App\Services\Admin\CityService;

class CityController extends Controller
{
    public $cityService;

    /**
     * City  Constructor.
     */
    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->cityService->getAllCities($request);
    }

    /**
     * create city page
     */
    public function create()
    {
        return $this->cityService->create();
    }

    /**
     *  Store City
     */
    public function store(CityRequest $request)
    {
        return $this->cityService->storeCity($request);
    }

    /**
     * show the city..
     *
     */
    public function show( $id)
    {
    }

    /**
     * edit the city..
     *
     */
    public function edit(int $id)
    {
        return $this->cityService->edit($id);

    }

    /**
     * Update the city..
     *
     */
    public function update(CityRequest $request, int $id)
    {
        return $this->cityService->updateCity($request,$id);
    }
    /**
     *
     * Delete City Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->cityService->deleteCity($id);

    }

}
