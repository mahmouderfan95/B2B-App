<?php

namespace App\Http\Controllers\Shipping;

use App\Http\Controllers\Controller;
use App\Services\Shipping\OfferService;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public $offerService;

    /**
     * Offer  Constructor.
     */
    public function __construct(OfferService $offerService)
    {
        $this->offerService = $offerService;
    }

    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->offerService->index($request);
    }

    public function create()
    {
        return $this->offerService->create();
    }

    public function store(Request $request)
    {
        return $this->offerService->store($request);
    }
}
