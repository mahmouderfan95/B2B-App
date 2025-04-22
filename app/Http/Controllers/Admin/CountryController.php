<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CountryRequest;
use App\Services\Admin\CountryService;

class CountryController extends Controller
{
    public $countryService;

    /**
     * Country  Constructor.
     */
    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->countryService->getAllCountries($request);
    }

    /**
     * create country page
     */
    public function create()
    {
        return $this->countryService->create();
    }

    /**
     *  Store Country
     */
    public function store(CountryRequest $request)
    {

        return $this->countryService->storeCountry($request);
    }

    /**
     * show the country..
     *
     */
    public function show( $id)
    {
        return'dd';
    }

    /**
     * edit the country..
     *
     */
    public function edit(int $id)
    {
        return $this->countryService->edit($id);

    }

    /**
     * Update the country..
     *
     */
    public function update(CountryRequest $request, int $id)
    {
        return $this->countryService->updateCountry($request,$id);
    }
    /**
     *
     * Delete Country Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->countryService->deleteCountry($id);

    }

}
