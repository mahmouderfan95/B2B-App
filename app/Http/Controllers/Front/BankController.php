<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\BankService;
use Illuminate\Http\Request;


class BankController extends Controller
{
    public $bankService;

    /**
     * Bank  Constructor.
     */
    public function __construct(BankService $bankService)
    {
        $this->bankService = $bankService;
    }


    /**
     *  best seller
     */
    public function index(Request $request)
    {
        return $this->bankService->index($request);
    }

}
