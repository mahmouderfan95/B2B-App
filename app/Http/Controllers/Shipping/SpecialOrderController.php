<?php

namespace App\Http\Controllers\Shipping;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shipping\AddOffer;
use App\Models\SpecialOrder;
use App\Services\Shipping\SpecialOrderService;
use Illuminate\Http\Request;

class SpecialOrderController extends Controller
{
    public $orderService;
    public function __construct(SpecialOrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        return $this->orderService->index();
    }

    public function show($id)
    {
        return $this->orderService->show($id);
    }

    public function addOffer(AddOffer $request)
    {
        return $this->orderService->addOffer($request);
    }
}
