<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\CurrencyService;
use Illuminate\Http\Request;


class CurrencyController extends Controller
{
    public $currencyService;

    /**
     * Currency  Constructor.
     */
    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->currencyService->getAllCurrencies($request);
    }

    /**
     * show the currency..
     *
     */
    public function show(int $id)
    {
        return $this->currencyService->show($id);

    }

}
