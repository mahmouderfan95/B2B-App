<?php

namespace App\Http\Controllers\Shipping;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shipping\AddOffer;
use App\Services\Shipping\SpecialOfferServices;
use Illuminate\Http\Request;

class SpecialOfferController extends Controller
{
    public function __construct(public SpecialOfferServices $offerServices){}
    public function index()
    {
        return $this->offerServices->index();
    }

    public function create()
    {
        return $this->offerServices->create();
    }

    public function store(AddOffer $request)
    {
        return $this->offerServices->store($request);
    }
}
