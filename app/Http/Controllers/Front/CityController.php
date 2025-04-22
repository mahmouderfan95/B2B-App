<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\CountryService;
use App\Services\Front\CityService;
use Illuminate\Http\Request;


class CityController extends Controller
{
    public $cityService;

    /**
     * Country  Constructor.
     */
    public function __construct(CityService $countryService)
    {
        $this->cityService = $countryService;
    }


    /**
     *  best seller
     */
    public function index(Request $request)
    {
        return $this->cityService->index($request);
    }

}
