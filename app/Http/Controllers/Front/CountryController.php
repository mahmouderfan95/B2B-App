<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\CountryService;
use Illuminate\Http\Request;


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
     *  best seller
     */
    public function index(Request $request)
    {
        return $this->countryService->index($request);
    }

}
